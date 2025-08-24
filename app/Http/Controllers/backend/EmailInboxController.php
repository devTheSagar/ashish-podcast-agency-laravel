<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailInboxController extends Controller
{
    /* =========================
     * CONNECTION
     * ========================= */
    protected function connect()
    {
        $imapBox = '{'.env('MAIL_IMAP_HOST').':'.env('MAIL_IMAP_PORT').'/imap/ssl/novalidate-cert}INBOX';
        $pop3Box = '{'.env('MAIL_POP3_HOST').':'.env('MAIL_POP3_PORT').'/pop3/ssl/novalidate-cert}INBOX';

        $user = env('MAIL_IMAP_USER') ?: env('MAIL_POP3_USER');
        $pass = env('MAIL_IMAP_PASS') ?: env('MAIL_POP3_PASS');

        if (function_exists('imap_open')) {
            // Try IMAP first
            $inbox = @imap_open($imapBox, $user, $pass, 0, 1);
            if ($inbox) return $inbox;

            // Fallback POP3
            $inbox = @imap_open($pop3Box, $user, $pass, 0, 1);
            if ($inbox) return $inbox;
        }

        $err = imap_last_error();
        throw new \RuntimeException('POP3/IMAP connect failed: '.$err);
    }

    /* =========================
     * DECODERS & HELPERS
     * ========================= */

    protected function decodePart(string $data, int $encoding, ?string $charset): string
    {
        switch ($encoding) {
            case ENCBASE64:
                $data = base64_decode($data);
                break;
            case ENCQUOTEDPRINTABLE:
                $data = quoted_printable_decode($data);
                break;
            default:
                // 0=7BIT, 1=8BIT, 2=BINARY
                break;
        }

        $charset = $charset ? strtoupper($charset) : null;
        if ($charset && $charset !== 'UTF-8' && function_exists('iconv')) {
            $converted = @iconv($charset, 'UTF-8//TRANSLIT', $data);
            if ($converted !== false) {
                $data = $converted;
            }
        }

        return is_string($data) ? $data : '';
    }

    protected function getCharsetFromPart($part): ?string
    {
        $charset = null;
        if (!empty($part->parameters)) {
            foreach ($part->parameters as $p) {
                if (strtolower($p->attribute) === 'charset') {
                    $charset = $p->value;
                    break;
                }
            }
        }
        if (!$charset && !empty($part->dparameters)) {
            foreach ($part->dparameters as $p) {
                if (strtolower($p->attribute) === 'charset') {
                    $charset = $p->value;
                    break;
                }
            }
        }
        return $charset;
    }

    /* =========================
     * UID-BASED FETCHERS
     * ========================= */

    /** Get all UIDs (newest first) */
    protected function getAllUids($inbox): array
    {
        $uids = imap_search($inbox, 'ALL', SE_UID) ?: [];
        rsort($uids);
        return $uids;
    }

    /** Parse header using UID (replacement for imap_headerinfo on seqno) */
    protected function fetchHeaderByUid($inbox, int $uid)
    {
        $raw = @imap_fetchheader($inbox, (string)$uid, FT_UID);
        if (!$raw) return null;
        return imap_rfc822_parse_headers($raw);
    }

    /** Tree walker (UID version): prefers text/html > text/plain */
    protected function findBestBodyUid($inbox, int $uid, $part, string $sectionPrefix = '')
    {
        $best = ['html' => null, 'plain' => null];

        if (isset($part->type) && $part->type == TYPETEXT) {
            $subtype = strtolower($part->subtype ?? '');
            if ($subtype === 'plain' || $subtype === 'html') {
                $section = $sectionPrefix !== '' ? $sectionPrefix : '1';
                $raw     = @imap_fetchbody($inbox, (string)$uid, $section, FT_UID);
                $charset = $this->getCharsetFromPart($part);
                $decoded = $this->decodePart($raw, (int)($part->encoding ?? 0), $charset);
                if ($subtype === 'html') $best['html'] = $decoded; else $best['plain'] = $decoded;
            }
        }

        if (isset($part->type) && $part->type == TYPEMULTIPART && !empty($part->parts)) {
            foreach ($part->parts as $idx => $child) {
                $section   = $sectionPrefix === '' ? (string)($idx + 1) : ($sectionPrefix.'.'.($idx + 1));
                $childBest = $this->findBestBodyUid($inbox, $uid, $child, $section);

                if ($childBest['html']  && !$best['html'])  $best['html']  = $childBest['html'];
                if ($childBest['plain'] && !$best['plain']) $best['plain'] = $childBest['plain'];

                if ($best['html']) break;
            }
        }

        return $best;
    }

    /** Body by UID (returns ['body'=>string, 'is_html'=>bool]) */
    protected function fetchBodyByUid($inbox, int $uid): array
    {
        $structure = @imap_fetchstructure($inbox, (string)$uid, FT_UID);

        if (!$structure) {
            $raw = @imap_body($inbox, (string)$uid, FT_UID);
            return ['body' => $this->decodePart($raw, 0, null), 'is_html' => false];
        }

        if (!isset($structure->parts)) {
            $raw     = @imap_body($inbox, (string)$uid, FT_UID);
            $charset = $this->getCharsetFromPart($structure);
            $decoded = $this->decodePart($raw, (int)($structure->encoding ?? 0), $charset);
            $isHtml  = (isset($structure->type) && $structure->type == TYPETEXT && strtolower($structure->subtype ?? '') === 'html');
            return ['body' => $decoded, 'is_html' => $isHtml];
        }

        $best = $this->findBestBodyUid($inbox, $uid, $structure, '');
        if (!empty($best['html']))  return ['body' => $best['html'],  'is_html' => true];
        if (!empty($best['plain'])) return ['body' => $best['plain'], 'is_html' => false];

        $raw     = @imap_fetchbody($inbox, (string)$uid, '1', FT_UID);
        $first   = $structure->parts[0] ?? null;
        $charset = $first ? $this->getCharsetFromPart($first) : null;
        $decoded = $this->decodePart($raw, (int)($first->encoding ?? 0), $charset);
        return ['body' => $decoded, 'is_html' => (strtolower($first->subtype ?? '') === 'html')];
    }

    /** Attachments by UID */
    protected function fetchAttachmentsByUid($inbox, int $uid): array
    {
        $structure = @imap_fetchstructure($inbox, (string)$uid, FT_UID);
        $attachments = [];
        if ($structure) {
            $this->collectAttachmentsUid($inbox, $uid, $structure, '', $attachments);
        }
        return $attachments;
    }

    protected function collectAttachmentsUid($inbox, int $uid, $part, string $sectionPrefix = '', array &$out = [])
    {
        if (isset($part->type) && $part->type == TYPEMULTIPART && !empty($part->parts)) {
            foreach ($part->parts as $idx => $child) {
                $section = $sectionPrefix === '' ? (string)($idx + 1) : ($sectionPrefix.'.'.($idx + 1));
                $this->collectAttachmentsUid($inbox, $uid, $child, $section, $out);
            }
            return;
        }

        $disposition  = strtolower($part->disposition ?? '');
        $isAttachment = in_array($disposition, ['attachment', 'inline'], true);

        $filename = null; $name = null; $charset = $this->getCharsetFromPart($part);

        if (!empty($part->dparameters)) {
            foreach ($part->dparameters as $p) {
                if (strtolower($p->attribute) === 'filename') $filename = $p->value;
            }
        }
        if (!empty($part->parameters)) {
            foreach ($part->parameters as $p) {
                if (strtolower($p->attribute) === 'name') $name = $p->value;
            }
        }
        if (!$isAttachment && ($filename || $name)) $isAttachment = true;

        if ($isAttachment) {
            $section = $sectionPrefix !== '' ? $sectionPrefix : '1';
            $raw     = @imap_fetchbody($inbox, (string)$uid, $section, FT_UID);
            $data    = $this->decodePart($raw, (int)($part->encoding ?? 0), $charset);
            $fname   = $filename ?: $name ?: ('attachment-'.$section);
            $fname   = imap_utf8($fname);

            $mimePrimary = isset($part->type) ? $part->type : null;
            $mimeSubtype = strtolower($part->subtype ?? '');
            $mime = $mimePrimary === TYPETEXT ? "text/$mimeSubtype"
                  : ($mimePrimary === TYPEIMAGE ? "image/$mimeSubtype"
                  : ($mimePrimary === TYPEAUDIO ? "audio/$mimeSubtype"
                  : ($mimePrimary === TYPEVIDEO ? "video/$mimeSubtype"
                  : "application/$mimeSubtype")));

            $out[] = ['filename' => $fname, 'data' => $data, 'mime' => $mime];
        }
    }

    /* =========================
     * CONTROLLER ACTIONS (routes use {id}, value = UID)
     * ========================= */

    public function index(Request $request)
    {
        $inbox = $this->connect();

        $uids  = $this->getAllUids($inbox);
        $total = count($uids);

        $perPage = 20;
        $page    = max(1, (int)$request->query('page', 1));
        $offset  = ($page - 1) * $perPage;
        $chunk   = array_slice($uids, $offset, $perPage);

        $items = [];
        foreach ($chunk as $uid) {
            $h = $this->fetchHeaderByUid($inbox, (int)$uid);
            if (!$h) continue;

            $from    = isset($h->from) ? ($h->from[0]->mailbox.'@'.$h->from[0]->host) : '';
            $to      = isset($h->to)   ? ($h->to[0]->mailbox.'@'.$h->to[0]->host)     : '';
            $subject = isset($h->subject) ? imap_utf8($h->subject) : '(no subject)';
            $dateRaw = $h->date ?? '';

            $ov = @imap_fetch_overview($inbox, (string)$uid, FT_UID);
            $o  = $ov[0] ?? null;
            $seen   = (bool)($o->seen   ?? false);
            $recent = (bool)($o->recent ?? false);

            $bodyInfo = $this->fetchBodyByUid($inbox, (int)$uid);
            $body   = $bodyInfo['body'] ?? '';
            $isHtml = (bool)($bodyInfo['is_html'] ?? false);

            $previewText = $isHtml ? trim(strip_tags($body)) : trim($body);
            $previewText = html_entity_decode($previewText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $previewText = str_replace(["\xC2\xA0", chr(160)], ' ', $previewText);
            $previewText = preg_replace('/\s+/u', ' ', $previewText);
            $previewText = trim($previewText);
            $preview     = mb_strimwidth($previewText, 0, 140, '…', 'UTF-8');

            try {
                $dateBD = $dateRaw ? Carbon::parse($dateRaw)->timezone('Asia/Dhaka')->format('j F Y g:i a') : '';
            } catch (\Throwable $e) {
                $dateBD = $dateRaw;
            }

            $items[] = [
                'id'        => (int)$uid, // <-- কী নাম 'id', কিন্তু ভ্যালু UID
                'from'      => $from,
                'to'        => $to,
                'subject'   => $subject,
                'date'      => $dateBD,
                'preview'   => $preview,
                'is_seen'   => $seen,
                'is_recent' => $recent,
            ];
        }

        imap_close($inbox);

        usort($items, function ($a, $b) {
            $ta = strtotime($a['date']) ?: 0;
            $tb = strtotime($b['date']) ?: 0;
            return $tb <=> $ta;
        });

        $totalPages = max(1, (int)ceil($total / $perPage));

        return view('backend.custom-email.inbox', [
            'items'      => $items,
            'page'       => $page,
            'totalPages' => $totalPages,
            'total'      => $total,
        ]);
    }

    public function show($id)
    {
        $inbox = $this->connect();

        // এখানে $id = UID
        $h = $this->fetchHeaderByUid($inbox, (int)$id);
        if (!$h) { imap_close($inbox); abort(404); }

        $from    = isset($h->from) ? ($h->from[0]->mailbox.'@'.$h->from[0]->host) : '';
        $to      = isset($h->to)   ? ($h->to[0]->mailbox.'@'.$h->from[0]->host ?? $h->to[0]->host) : '';
        $subject = isset($h->subject) ? imap_utf8($h->subject) : '(no subject)';
        $date    = $h->date ?? '';
        $dateBD  = Carbon::parse($date)->timezone('Asia/Dhaka')->format('j F Y g:i a');

        $bodyInfo    = $this->fetchBodyByUid($inbox, (int)$id);
        $body        = $bodyInfo['body'];
        $isHtml      = $bodyInfo['is_html'];
        $attachments = $this->fetchAttachmentsByUid($inbox, (int)$id);

        imap_close($inbox);

        return view('backend.custom-email.view-email', [
            'id'          => (int)$id,   // Blade-এ একই নাম ব্যবহার
            'from'        => $from,
            'to'          => $to,
            'subject'     => $subject,
            'dateBD'      => $dateBD,
            'body'        => $body,
            'isHtml'      => $isHtml,
            'attachments' => $attachments,
        ]);
    }

    public function downloadAttachment($id, $index)
    {
        $inbox = $this->connect();
        $attachments = $this->fetchAttachmentsByUid($inbox, (int)$id);
        imap_close($inbox);

        if (!isset($attachments[$index])) {
            abort(404, 'Attachment not found');
        }

        $att = $attachments[$index];
        return response($att['data'])
            ->header('Content-Type', $att['mime'] ?? 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="'.$att['filename'].'"');
    }

    public function replyForm($id)
    {
        $inbox = $this->connect();

        $h = $this->fetchHeaderByUid($inbox, (int)$id);
        if (!$h) { imap_close($inbox); abort(404); }

        $fromEmail = isset($h->from) ? ($h->from[0]->mailbox.'@'.$h->from[0]->host) : '';
        $toEmail   = isset($h->to)   ? ($h->to[0]->mailbox.'@'.$h->to[0]->host)     : '';
        $subject   = isset($h->subject) ? imap_utf8($h->subject) : '(no subject)';
        $messageId = $h->message_id ?? null;

        $bodyInfo = $this->fetchBodyByUid($inbox, (int)$id);
        $origBody = $bodyInfo['is_html'] ? strip_tags($bodyInfo['body']) : $bodyInfo['body'];
        $origBody = trim(preg_replace('/\s+/u', ' ', $origBody));
        $origBodyShort = Str::limit($origBody, 800, "\n...");

        imap_close($inbox);

        return view('backend.custom-email.reply-email', [
            'id'           => (int)$id,
            'to'           => $fromEmail, // reply to sender
            'fromHeaderTo' => $toEmail,
            'subject'      => Str::startsWith($subject, 'Re:') ? $subject : 'Re: '.$subject,
            'inReplyTo'    => $messageId,
            'quoted'       => "> ".str_replace("\n", "\n> ", $origBodyShort),
        ]);
    }

    public function sendReply(Request $request, $id)
    {
        $data = $request->validate([
            'to'            => 'required|email',
            'subject'       => 'required|string|max:255',
            'body'          => 'required|string',
            'in_reply_to'   => 'nullable|string',
            'references'    => 'nullable|string',
            'attachments.*' => 'file|max:5120',
        ]);

        $isHtml = true;

        Mail::send([], [], function (\Illuminate\Mail\Message $message) use ($data, $request, $isHtml) {
            $message->to($data['to'])
                    ->subject($data['subject']);

            if ($isHtml) {
                $message->html($data['body']);
            } else {
                $message->text($data['body']);
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file->isValid()) {
                        $message->attach(
                            $file->getRealPath(),
                            [
                                'as'   => $file->getClientOriginalName(),
                                'mime' => $file->getMimeType(),
                            ]
                        );
                    }
                }
            }

            // Threading headers
            $symfony = $message->getSymfonyMessage()->getHeaders();
            if (!empty($data['in_reply_to'])) {
                $symfony->addTextHeader('In-Reply-To', $data['in_reply_to']);
            }
            if (!empty($data['references'])) {
                $symfony->addTextHeader('References', $data['references']);
            }
        });

        // $id = UID; show পেজে ফিরে যান
        return redirect()->route('inbox.show', $id)->with('success', 'Reply sent successfully.');
    }
}
