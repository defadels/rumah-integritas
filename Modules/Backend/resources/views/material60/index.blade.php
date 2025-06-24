@extends('backend::material60.layouts.master')
@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material60/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/themes/material60/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border-0" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                                    <i class="mdi mdi-calendar-range"></i>
                                                </span>
                                </div>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                    <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-1">
                                    <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="col-xl-6">
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
                                    <a href="{{route('reportservices.index',['type'=>encrypt(1)])}}" target="_blank" class="dropdown-item">Export Report</a>
                                    <!-- item-->

                                </div>
                            </div>

                            <h4 class="header-title mb-3">Pengajuan Makan Minum</h4>

                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                    <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($konsumsi as $row)
                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{$row->name}}</h5>
                                            </td>

                                            <td>
                                                {{$row->email}}
                                            </td>

                                            <td>
                                                {{$row->judul_rapat}}
                                            </td>
                                            <td>
                                                <a href="{{route('form.makan.edit',['id'=>encrypt($row->id)])}}" class="badge badge-outline-warning">Edit</a>
                                                <a href="#" class="delete-data-makan badge badge-outline-danger" data-pid="{{encrypt($row->id)}}">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

                <div class="col-xl-6">
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
                                    <a href="{{route('reportservices.index',['type'=>encrypt(2)])}}" target="_blank" class="dropdown-item">Export Report</a>
                                    <!-- item-->

                                </div>
                            </div>

                            <h4 class="header-title mb-3">Hasil Pemeriksaan Awal Tim</h4>

                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                    <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Dokumen</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($hasil as $row)
                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{$row->fullname}}</h5>
                                            </td>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{$row->name}}</h5>
                                            </td>
                                            <td>
                                                <a href="{{asset('hasil').'/'.$row->file_attach}}" target="_blank">{{$row->file_attach}}</a>
                                            </td>
                                            <td>
                                                @if ($row->users_id == auth()->user()->id)
                                                    <a href="{{route('form.hasil.edit',['id'=>encrypt($row->id)])}}" class="badge badge-outline-warning">Edit</a>
                                                    <a href="#" class="delete-data-pemeriksaan badge badge-outline-danger" data-pid="{{encrypt($row->id)}}">Delete</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

            </div>
            <!-- end row -->

            <div class="row">

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
                                    <a href="{{route('reportservices.index',['type'=>encrypt(3)])}}" target="_blank" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                </div>
                            </div>

                            <h4 class="header-title mb-3">Pengajuan Pemeliharaan BMD</h4>

                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                    <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Keluhan</th>
                                        <th>Sub Bagian</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pemeliharaan as $row)
                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{$row->name}}</h5>
                                            </td>

                                            <td>
                                                {{$row->email}}
                                            </td>

                                            <td>
                                                {{$row->jenis_keluhan}}
                                            </td>

                                            <td>
                                                {{$row->sub_bag}}
                                            </td>
                                            <td>
                                                <a href="{{route('form.pelihara.edit',['id'=>encrypt($row->id)])}}" class="badge badge-outline-warning">Edit</a>
                                                <a href="#" class="delete-data-pelihara badge badge-outline-danger" data-pid="{{encrypt($row->id)}}">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

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
                                    <a href="{{route('reportservices.index',['type'=>encrypt(4)])}}" target="_blank" class="dropdown-item">Export Report</a>
                                    <!-- item-->

                                </div>
                            </div>

                            <h4 class="header-title mb-3">Agenda Inspektorat</h4>

                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                    <thead class="table-light">
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Waktu Pelaksanaan</th>
                                        <th>Jam Pelaksanaan</th>
                                        <th>Lokasi Kegiatan</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Email</th>
                                        <th>Konfirmasi Kegiatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($barang_pakai_habis as $row)
                                        <tr>
                                            <td>
                                                {{$row->created_at}}
                                            </td>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{$row->namakegiatan}}</h5>
                                            </td>

                                            <td>
                                                {{$row->tanggalpelaksanaan}}
                                            </td>
                                            <td>
                                                {{$row->waktupelaksanaan}}
                                            </td>

                                            <td>
                                                {{$row->lokasikegiatan}}
                                            </td>
                                            <td>
                                                {{$row->penanggungjawab}}
                                            </td>
                                            <td>
                                                {{$row->email}}
                                            </td>
                                            <td>
                                                @if ($row->setuju)
                                                    YA
                                                @else
                                                    Tidak
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('form.barang.pakai.habis.edit',['id'=>encrypt($row->id)])}}" class="badge badge-outline-warning">Edit</a>
                                                <a href="#" class="delete-data-barang badge badge-outline-danger" data-pid="{{encrypt($row->id)}}">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

            </div>
            <!-- end row -->

            <div class="row">

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
                                    <a href="{{route('reportservices.index',['type'=>encrypt(5)])}}" target="_blank" class="dropdown-item">Export Report</a>
                                    <!-- item-->

                                </div>
                            </div>

                            <h4 class="header-title mb-3">Kartu Kendali</h4>

                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                    <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Pekerjaan</th>
                                        <th>Rekanan</th>
                                        <th>Pagu Dana</th>
                                        <th>No SPK</th>
                                        <th>BAP Tanggal</th>
                                        <th>BAP No</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=0; @endphp
                                    @foreach($kartu_kendali as $row)
                                        @php $i++; @endphp
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{$row->pekerjaan}}</h5>
                                            </td>
                                            <td>{{$row->rekanan}}</td>
                                            <td>{{number_format($row->pagu_dana,0,',','.')}}</td>
                                            <td>{{$row->spk_no}}</td>
                                            <td>{{$row->bap_tgl}}</td>
                                            <td>{{$row->bap_no}}</td>
                                            <td>
                                                <a href="{{route('form.kartu.kendali.edit',['id'=>encrypt($row->id)])}}" class="badge badge-outline-warning">Edit</a>
                                                <a href="#" class="delete-data-kartu badge badge-outline-danger" data-pid="{{encrypt($row->id)}}">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Plugins js-->
    <script src="{{asset('')}}assets/themes/material60/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="{{asset('')}}assets/themes/material60/assets/libs/apexcharts/apexcharts.min.js"></script>

    <script src="{{asset('')}}assets/themes/material60/assets/libs/selectize/js/standalone/selectize.min.js"></script>

    <!-- Dashboar 1 init js-->
    <script src="{{asset('')}}assets/themes/material60/assets/js/pages/dashboard-1.init.js"></script>

    <script>
        $('a.delete-data-makan').click(function (e) {
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
                        url: "{{route('form.makan.delete')}}",
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
        $('a.delete-data-barang').click(function (e) {
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
                        url: "{{route('form.barang.pakai.habis.delete')}}",
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
        $('a.delete-data-pelihara').click(function (e) {
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
                        url: "{{route('form.pelihara.delete')}}",
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
        $('a.delete-data-kartu').click(function (e) {
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
                        url: "{{route('form.kartu.kendali.delete')}}",
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
