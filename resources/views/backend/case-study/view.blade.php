@extends('backend.master')

@section('title')
    View Case Study
@endsection

@section('content')
    <div class="main-container container-fluid">
                  
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">View Case Study</h1>
            </div>
            <div class="ms-auto pageheader-btn">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Case Study</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Case Study</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">View Case Study</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6 mb-3 ps-0">
                            <img src="{{ asset($caseStudy->caseStudyImage) }}" alt="image" class="img-fluid" style="width: 150px; height: 150px; border-radius: 5%;">
                        </div>
                        <div class="table-responsive">
                            <table class="table text-wrap text-md-nowrap table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Service Description</td>
                                        <td>{!! $caseStudy->caseStudyDetails !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection