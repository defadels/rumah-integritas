@extends('backend::material.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('')}}assets/themes/material/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
          type="text/css"/>
@endsection

@section('content')

    <div id="wrapper">
        @include('backend::material.partial.left-menu')
        <div class="content-page">
            @include('backend::material.partial.topbar')
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    @include('backend::material.partial.breadcrumb')
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Form Edit Permission</h4>
                                    <p class="text-muted font-14">
                                        &nbsp;
                                    </p>

                                    @if(Session::has('messages'))
                                        <div
                                            class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                                            role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                            {{ Session::get('messages') }}
                                        </div>
                                    @endif
                                    @if (count($errors) > 0)
                                        <div
                                            class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                                            role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br>
                                            @endforeach
                                        </div>
                                    @endif

                                    <form action="{{route('users.roles.permission',['id' => $id])}}"
                                          class="parsley-examples" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Role<span
                                                    class="text-danger">*</span></label>
                                            <input autofocus readonly type="text" name="name"
                                                   class="form-control bg-light" id="name" value="{{$name}}"/>
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Role Permissions<span
                                                    class="text-danger">*</span></label>
                                            <div class="table-responsive">
                                                <table id="listdata"
                                                       class="table table-centered table-nowrap table-hover mb-0">
                                                    <tr>
                                                        <td class="text-body fw-semibold">Administrator Access</td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input id="remember-1" class="group-checkable form-check-input"
                                                                       data-set="#listdata .checkbox" type="checkbox">
                                                                <label class="form-check-label"
                                                                       for="checkmeout0">Select All</label>
                                                            </div>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    @foreach($arr_permissions as $group => $permissions)
                                                        <tr>
                                                            <td class="text-body fw-semibold">{{ ucwords($group) }}</td>
                                                            <td>
                                                                @if(isset($permissions['view']))
                                                                    <div class="form-check">
                                                                        <input
                                                                            {!! $permissions['view']['checked'] !!}  name="checkbox[]"
                                                                            id="checkbox[]" type="checkbox"
                                                                            class="checkbox form-check-input"
                                                                            value="{{ $permissions['view']['name'] }}">
                                                                        <label class="form-check-label"
                                                                               for="checkmeout0">View</label>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(isset($permissions['create']))
                                                                    <div class="form-check">
                                                                        <input
                                                                            {!! $permissions['create']['checked'] !!}  name="checkbox[]"
                                                                            id="checkbox[]" type="checkbox"
                                                                            class="checkbox form-check-input"
                                                                            value="{{ $permissions['create']['name'] }}">
                                                                        <label class="form-check-label"
                                                                               for="checkmeout0">Create</label>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(isset($permissions['update']))
                                                                    <div class="form-check">
                                                                        <input
                                                                            {!! $permissions['update']['checked'] !!}  name="checkbox[]"
                                                                            id="checkbox[]" type="checkbox"
                                                                            class="checkbox form-check-input"
                                                                            value="{{ $permissions['update']['name'] }}">
                                                                        <label class="form-check-label"
                                                                               for="checkmeout0">Update</label>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(isset($permissions['delete']))
                                                                    <div class="form-check">
                                                                        <input
                                                                            {!! $permissions['delete']['checked'] !!}  name="checkbox[]"
                                                                            id="checkbox[]" type="checkbox"
                                                                            class="checkbox form-check-input"
                                                                            value="{{ $permissions['delete']['name'] }}">
                                                                        <label class="form-check-label"
                                                                               for="checkmeout0">Delete</label>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Update
                                            </button>
                                            <button type="reset" class="btn btn-secondary waves-effect"
                                                    onclick="window.location='{{route('users.roles')}}'">Batal
                                            </button>
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
            @include('backend::material.partial.footer')
        </div>
    </div>
    <!-- END wrapper -->
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{asset('')}}assets/themes/material/assets/libs/parsleyjs/parsley.min.js"></script>

    <!-- Validation init js-->
    <script src="{{asset('')}}assets/themes/material/assets/js/pages/form-validation.init.js"></script>
    <script src="{{asset('')}}modules/num-users/permissions/app.js?v=1.2"></script>
@endsection
