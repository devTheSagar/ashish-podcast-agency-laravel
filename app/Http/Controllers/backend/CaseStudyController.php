<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CaseStudyController extends Controller
{
    public function index(){
        $caseStudies = CaseStudy::orderBy('created_at', 'desc')->get();
        return view('backend.case-study.index', [
            'caseStudies' => $caseStudies
        ]);
    }
    public function create(){
        return view('backend.case-study.add');
    }

    public function store(Request $request){
        CaseStudy::addCaseStudy($request);
        Alert::success('Success', 'Case study added successfully');
        return back();
    }

    public function edit($id){
        $caseStudy = CaseStudy::findOrFail($id);
        return view('backend.case-study.edit', [
            'caseStudy' => $caseStudy
        ]);
    }

    public function update(Request $request, $id){
        CaseStudy::updateCaseStudy($request, $id);
        Alert::success('Success', 'Case study updated successfully');
        return redirect()->route('admin.all-case-studies');
    }

    public function view($id){
        $caseStudy = CaseStudy::findOrFail($id);
        return view('backend.case-study.view', [
            'caseStudy' => $caseStudy
        ]);
    }

    public function destroy($id){
        CaseStudy::deleteCaseStudy($id);
        Alert::success('Success', 'Case study deleted successfully');
        return back();
    }

}
