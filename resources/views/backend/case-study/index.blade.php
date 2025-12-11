@extends('backend.master')

@section('title')
    All Case Studies
@endsection

@section('content')
    <div class="main-container container-fluid">                   
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">All Services</h1>
            </div>
            <div class="ms-auto pageheader-btn">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Services</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">Services DataTable</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom w-100" id="responsive-datatable">
                                <thead>
                                    <tr>
                                        <th class="wd-15p border-bottom-0">SL</th>
                                        <th class="wd-20p border-bottom-0">Service image</th>
                                        <th class="wd-20p border-bottom-0">Service description</th>
                                        <th class="wd-15p border-bottom-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($caseStudies as $caseStudy)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset($caseStudy->caseStudyImage) }}" alt="image" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">
                                            </td>
                                            <td>{{ Str::limit(strip_tags($caseStudy->caseStudyDetails), 30, '...') }}</td>
                                            <td>
                                                <a href="{{ route('admin.case-studies.view', ['id' => $caseStudy->id]) }}" class="btn btn-primary" data-bs-toggle="tooltip" title="Show"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('admin.case-studies.edit', ['id' => $caseStudy->id]) }}" class="btn btn-secondary" data-bs-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                {{-- <a href="{{ route('admin.delete-service', ['id' => $service]) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a> --}}
                                                <form action="{{ route('admin.case-studies.delete', ['id' => $caseStudy->id]) }}" method="POST" onsubmit="return confirm('Confirm deleting case study?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
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