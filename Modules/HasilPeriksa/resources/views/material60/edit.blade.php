@extends('backend::material60.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material/assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <style>
        iframe{
            width:100%;
            height: 100vh;
        }
    </style>
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
                            <h4 class="header-title">Form</h4>
                            <p class="text-muted font-14">

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

                            <form action="{{route('form.hasil.update',['id'=>encrypt($hasil->id)])}}" class="parsley-examples" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Keterangan File<span class="text-danger">*</span></label>
                                    <input autofocus type="text" name="name" parsley-trigger="change" required class="form-control" id="name" value="{{$hasil->name}}"/>
                                </div>

                                @if (auth()->user()->hasRole('administrator'))
                                <div class="mb-3">
                                    <label for="receiver" class="form-label">Penerima File<span class="text-danger">*</span></label>
                                    <select name="receiver" id="receiver" class="form-control">
                                        <option value="">--- Pilih User Penerima ---</option>
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="file_attach" class="form-label">File attach</label>
                                            <input type="file" id="file_attach" name="file_attach" class="form-control" />
                                        </div>
                                    </div>
                                </div> <!-- end row -->

                                <div class="text-end">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        Simpan
                                    </button>
                                    {{--<button type="reset" class="btn btn-secondary waves-effect" onclick="window.location='{{route('users')}}'">Batal</button>--}}
                                </div>
                            </form>
                        </div>
                    </div> <!-- end card -->
                </div>
                <!-- end col -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->

                                </div>
                            </div>

                            <h4 class="header-title mb-3">Preview Old File</h4>

                            <iframe src="{{ Storage::url($hasil->file_attach) }}#zoom=FitH" frameborder="0" width="100%"></iframe>
                        </div>
                    </div> <!-- end card-->
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Plugins js-->
    <script src="{{asset('')}}assets/themes/material/assets/libs/parsleyjs/parsley.min.js"></script>

    <!-- Validation init js-->
    <script src="{{asset('')}}assets/themes/material/assets/libs/mohithg-switchery/switchery.min.js"></script>
    <script src="{{asset('')}}modules/num-users/app.js?v=1.2"></script>
    <script src="{{asset('')}}modules/num-users/form-advanced.init.js?v=0.6"></script>
    <script src="{{asset('')}}modules/num-users/form-validation.init.js?v=0.6"></script>
    <script>
        $('a.delete-data-pemeriksaan').click(function (e) {
            e.preventDefault();
            var uid = $(this).data("pid");
            Swal.fire({
                title: "Yakin akan menghapus data?",
                text: "Data akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#28bb4b",
                cancelButtonColor: "#f34e4e",
                confirmButtonText: "Hapus!",
                cancelButtonText: 'Batal',
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "post",
                        url: "{{route('form.hasil.delete')}}",
                        data: {pid: uid, "_token": csrf_token},
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == 'success') {
                                Swal.fire(data.judul, data.pesan, data.status);
                                window.location.reload();
                            } else {
                                Swal.fire(data.judul, data.pesan, data.status);
                            }
                            return false;
                        },
                        error:function(jqXHR,textStatus){
                            Swal.fire(jqXHR.status, textStatus);
                        }
                    });
                }
            });
        });
    </script>
@endsection
