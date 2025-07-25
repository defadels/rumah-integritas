@extends('backend::material.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('')}}assets/themes/material/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('')}}assets/themes/material/assets/libs/admin-resources/rwd-table/rwd-table.min.css"
          rel="stylesheet" type="text/css"/>
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row justify-content-between mb-2">
                                        <div class="col-auto">
                                            <form class="search-bar position-relative mb-sm-0 mb-2" method="get"
                                                  action="{{route('users.roles')}}">
                                                <input id="s" name="s" value="{{ $s }}" type="text" class="form-control"
                                                       placeholder="Cari...">
                                                <span class="mdi mdi-magnify"></span>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-md-end">
                                                @can('create users')
                                                    <button type="button"
                                                            class="btn btn-info waves-effect waves-light mb-2 me-2"
                                                            onclick="window.location='{{route('dapodik.kepala-sekolah.import')}}'">
                                                        <i
                                                            class="mdi mdi-file-excel me-1"></i> Import Excel
                                                    </button>
                                                @endcan
                                            </div>
                                        </div><!-- end col-->
                                    </div>
                                    <div class="responsive-table-plugin">
                                        <div class="table-rep-plugin">

                                            <div class="table-responsive">
                                                <table id="listdata" class="table  table-nowrap table-hover mb-0">
                                                    <thead class="table-light">
                                                    <tr>
                                                        <th style="width:2%">
                                                            <div class="form-check">
                                                                <input id="remember-1"
                                                                       class="group-checkable form-check-input"
                                                                       data-set="#listdata .checkbox" type="checkbox"
                                                                       data-parsley-multiple="remember-1">
                                                            </div>
                                                        </th>
                                                        <th style="width: 5%;">Opsi</th>
                                                        <th>Nama Sekolah</th>
                                                        <th>NPSN</th>
                                                        <th>Kecamatan</th>
                                                        <th>Kab/Kota</th>
                                                        <th>Nama Kepsek</th>
                                                        <th>L/P</th>
                                                        <th>NIK</th>
                                                        <th>NUPTK</th>
                                                        <th>NIP</th>
                                                        <th>Nomor SK</th>
                                                        <th>TMT Kepala Sekolah</th>
                                                        <th>No Handphone</th>
                                                        <th>Email</th>
                                                        <th>Status Kepsek</th>
                                                        <th>Created At</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($listdata as $row)
                                                        @php
                                                            $id = $row->id;
                                                        @endphp
                                                        <tr id="data_{{ $row->id }}">
                                                            <td>
                                                                <div class="form-check">
                                                                    <input name="checkbox[]" id="checkbox[]"
                                                                           type="checkbox"
                                                                           class="checkbox form-check-input"
                                                                           value="{{ $row->id }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                            class="btn btn-xs btn-outline-primary dropdown-toggle"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                        Opsi <i class="mdi mdi-chevron-down"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item"
                                                                           href="{{route('users.update',['id' => $id])}}"><i
                                                                                class="mdi mdi-file-edit"></i> Edit</a>
                                                                        <a class="dropdown-item delete_row" href="#"
                                                                           data-uid="{{ $id }}"><i
                                                                                class="mdi mdi-trash-can"></i> Hapus</a>
                                                                        <a class="dropdown-item"
                                                                           href="{{route('users.password',['id' => $id])}}"><i
                                                                                class="mdi mdi-key"></i> Ganti Password</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$row->nama_sekolah}}
                                                            </td>
                                                            <td>{{$row->npsn}}</td>
                                                            <td>{{$row->kecamatan}}</td>
                                                            <td>{{$row->kabupaten}}</td>
                                                            <td class="table-user">
                                                                {{--<img src="assets/images/users/user-2.jpg" alt="table-user" class="me-2 rounded-circle">--}}
                                                                <a href="javascript:void(0);"
                                                                   class="text-body fw-semibold">{{$row->nama_lengkap}}</a>
                                                            </td>
                                                            <td>{{$row->jk}}</td>
                                                            <td>{{$row->nik}}</td>
                                                            <td>{{$row->nuptk}}</td>
                                                            <td>{{$row->nip}}</td>
                                                            <td>{{$row->no_sk}}</td>
                                                            <td>{{$row->tmt_kepala}}</td>
                                                            <td>{{$row->no_hp}}</td>
                                                            <td>{{$row->email}}</td>
                                                            <td>{{$row->status_kepsek}}</td>
                                                            <td>
                                                                {{$row->created_at->format('d/m/Y @H:i')}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-12">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false"> With Selected
                                                    <i class="mdi mdi-chevron-down"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" id="delete_all" href="#"><i
                                                            class="mdi mdi-trash-can"></i> Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {!! $listdata->appends($append_src)->links() !!}
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
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
    <!-- Sweet Alerts js -->
    <script src="{{asset('')}}assets/themes/material/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <script src="{{asset('')}}modules/num-users/app.js?v=1.3"></script>
@endsection
