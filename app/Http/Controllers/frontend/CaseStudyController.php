<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;

class CaseStudyController extends Controller
{
    public function index(){
        $caseStudies = CaseStudy::all();
        return view('frontend.case-study.index', [
            'caseStudies' => $caseStudies
        ]);
    }

    public function show($id)
    {
        $caseStudy = CaseStudy::findOrFail($id);
        // compute 1-based sequential position among case studies (ordered by id asc)
        $ids = CaseStudy::orderBy('id', 'asc')->pluck('id')->toArray();
        $pos = array_search($caseStudy->id, $ids);
        $position = $pos === false ? 1 : $pos + 1;
        return view('frontend.case-study.show', compact('caseStudy', 'position'));
    }
}
