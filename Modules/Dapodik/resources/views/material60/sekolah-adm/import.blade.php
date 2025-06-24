@extends('backend::material60.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material/assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            @include('backend::material60.partial.breadcrumb')
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Form Import</h4>
                            <p class="text-muted font-14">
                                &nbsp;
                            </p>

                            @if(Session::has('messages'))
                                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    {{ Session::get('messages') }}
                                </div>
                            @endif
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                            <form action="{{route('dapodik.sekolah-adm.import')}}" enctype="multipart/form-data" class="parsley-examples" method="post">
                                @csrf

                                <div class="mb-3">
                                    <label for="file_attach" class="form-label">File Excel<span class="text-danger">*</span></label>
                                    <input type="file" name="file_attach" id="file_attach" class="form-control" required data-parsley-filemaxmegabytes="10" data-parsley-trigger="change" data-parsley-filemimetypes="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                                </div>

                                <div class="text-end">
                                    <button class="btn btn-info waves-effect waves-light" type="submit">
                                        Import
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect" onclick="window.location='{{route('dapodik.sekolah-adm')}}'">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{asset('')}}assets/themes/material/assets/libs/parsleyjs/parsley.min.js"></script>

    <!-- Validation init js-->
    <script src="{{asset('')}}assets/themes/material/assets/libs/mohithg-switchery/switchery.min.js"></script>
    <script src="{{asset('')}}modules/num-dapodik/kepala-sekolah/app.js?v=1.2"></script>
    <script src="{{asset('')}}modules/num-dapodik/kepala-sekolah/form-advanced.init.js?v=0.6"></script>
    <script src="{{asset('')}}modules/num-dapodik/kepala-sekolah/form-validation.init.js?v=0.4"></script>
@endsection
