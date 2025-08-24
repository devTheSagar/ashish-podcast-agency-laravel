@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url ?? config('app.url') }}" style="display:inline-block; font-size:18px; font-weight:bold; color:#333; text-decoration:none;">
            {{ config('app.name') }}
        </a>
    </td>
</tr>
