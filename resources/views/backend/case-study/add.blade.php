@extends('backend.master')

@section('title')
    Add Case Study
@endsection

@section('content')
    <div class="main-container container-fluid">
                      
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Case Study</h1>
            </div>
            <div class="ms-auto pageheader-btn">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Case Study</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Case Study</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">Add Your Case Study</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.case-studies.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                    <label for="case-study-image" class="form-label">Case Study Image</label>
                                    <input name="caseStudyImage" type="file" class="dropify" accept="image/*" value="{{ old('caseStudyImage') }}" id="case-study-image" data-height="200" />
                                    @error('caseStudyImage')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label for="case-study-details">Case Study</label>
                                    <textarea name="caseStudyDetails" id="summernote" class="form-control @error('caseStudyDetails') is-invalid @enderror">{{ old('caseStudyDetails') }}</textarea>
                                    @error('caseStudyDetails')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary mt-2" type="submit">Add Case Study</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW CLOSED -->

        
    </div>
@endsection