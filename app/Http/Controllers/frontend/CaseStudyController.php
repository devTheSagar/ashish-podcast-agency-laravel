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
        return view('frontend.case-study.show', compact('caseStudy'));
    }
}
