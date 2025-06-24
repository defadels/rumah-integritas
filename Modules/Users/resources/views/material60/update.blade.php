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
                            <h4 class="header-title">Form User</h4>
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

                            <form action="{{route('users.update',['id' => $id])}}" class="parsley-examples" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                                    <input autofocus type="text" name="name" parsley-trigger="change" required class="form-control" id="name" value="{{$name}}"/>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input readonly type="email" name="email" parsley-trigger="change" required class="form-control bg-light" id="email" value="{{$email}}"/>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Akses</label>
                                    @foreach($role as $row)
                                        <div class="form-check">
                                            <input {!! $row['checked'] !!}  name="checkbox_role[]"
                                                   id="checkbox_role[]" type="checkbox"
                                                   class="checkbox form-check-input"
                                                   value="{{$row['name']}}">
                                            <label class="form-check-label"
                                                   for="checkmeout0">{{$row['name']}}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <input type="checkbox" {!! $isactive_checked !!} data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" data-size="small" id="isactive" name="isactive" value="1"/>
                                    <label for="isactive" class="col-form-label">Aktif</label>
                                </div>

                                <div class="text-end">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        Simpan
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect" onclick="window.location='{{route('users')}}'">Batal</button>
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
    <script src="{{asset('')}}modules/num-users/app.js?v=1.2"></script>
    <script src="{{asset('')}}modules/num-users/form-advanced.init.js?v=0.6"></script>
    <script src="{{asset('')}}modules/num-users/form-validation.init.js?v=0.6"></script>
@endsection
