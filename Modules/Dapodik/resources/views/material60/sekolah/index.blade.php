@extends('backend::material60.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            @include('backend::material60.partial.breadcrumb')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-lg-8">
                                    <form class="d-flex flex-wrap align-items-center" action="{{route('dapodik.sekolah')}}">
                                        <label for="inputPassword2" class="visually-hidden">Cari</label>
                                        <div class="me-3">
                                            <input type="search" name="s" value="{{ $s }}" class="form-control my-1 my-lg-0" id="inputPassword2" placeholder="Cari...">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-lg-end">
                                        @can('create sekolah')
                                            <button type="button"
                                                    class="btn btn-info waves-effect waves-light mb-2 me-2"
                                                    onclick="window.location='{{route('dapodik.sekolah.import')}}'">
                                                <i
                                                    class="mdi mdi-file-excel me-1"></i> Import CSV
                                            </button>
                                        @endcan
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table id="listdata" class="table table-centered table-nowrap mb-0">
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
                                        <th>Status</th>
                                        <th>Bentuk</th>
                                        <th>Alamat</th>
                                        <th>Kecamatan</th>
                                        <th>Kode Registrasi</th>
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
                                                        @can('view sekolah')
                                                            <a class="dropdown-item" href="{{route('dapodik.sekolah.siswa',['npsn' => $row->npsn])}}"><i
                                                                    class="mdi mdi-account-group"></i> Peserta Didik</a>
                                                        @endcan
                                                        @can('delete sekolah')
                                                        <a class="dropdown-item delete_row" href="#"
                                                           data-uid="{{ $id }}"><i
                                                                class="mdi mdi-trash-can"></i> Hapus</a>
                                                            @endcan
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="table-user">
                                                {{--<img src="assets/images/users/user-2.jpg" alt="table-user" class="me-2 rounded-circle">--}}
                                                <a href="javascript:void(0);"
                                                   class="text-body fw-semibold">{{$row->nama_sekolah}}</a>
                                            </td>
                                            <td>{{$row->npsn}}</td>
                                            <td>{{$row->status}}</td>
                                            <td>{{$row->bentuk}}</td>
                                            <td>{{$row->alamat}}</td>
                                            <td>{{$row->kecamatan}}</td>
                                            <td>{{$row->kode_reg}}</td>
                                            <td>
                                                {{$row->created_at->format('d/m/Y @H:i')}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
@endsection
@section('script')
    <!-- Plugins js-->
    <!-- Sweet Alerts js -->
    <script src="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <script src="{{asset('')}}modules/num-dapodik/sekolah/app.js?v=1.5"></script>
@endsection
