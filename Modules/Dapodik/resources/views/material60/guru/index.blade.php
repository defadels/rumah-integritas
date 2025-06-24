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
                                    <form class="d-flex flex-wrap align-items-center" action="{{route('dapodik.guru')}}">
                                        <label for="inputPassword2" class="visually-hidden">Cari</label>
                                        <div class="me-3">
                                            <input type="search" name="s" value="{{ $s }}" class="form-control my-1 my-lg-0" id="inputPassword2" placeholder="Cari...">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-lg-end">
                                        @can('create guru')
                                            <button type="button"
                                                    class="btn btn-info waves-effect waves-light mb-2 me-2"
                                                    onclick="window.location='{{route('dapodik.guru.import')}}'">
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
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>NUPTK</th>
                                        <th>NIP</th>
                                        <th>L/P</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Status Tugas</th>
                                        <th>Tempat Tugas</th>
                                        <th>NPSN</th>
                                        <th>Kecamatan</th>
                                        <th>Kab/Kota</th>
                                        <th>Nomor HP</th>
                                        <th>SK CPNS</th>
                                        <th>Tanggal CPNS</th>
                                        <th>SK Pengangkatan</th>
                                        <th>TMT Pengangkatan</th>
                                        <th>Jenis PTK</th>
                                        <th>Pendidikan</th>
                                        <th>Bidang Studi Pendidikan</th>
                                        <th>Bidang Studi Sertifikasi</th>
                                        <th>Status Kepegawaian</th>
                                        <th>Pangkat/Gol</th>
                                        <th>TMT Pangkat</th>
                                        <th>Masa Kerja Tahun</th>
                                        <th>Masa Kerja Bulan</th>
                                        <th>Mata Pelajaran Diajarkan</th>
                                        <th>Jam Mengajar Per Minggu</th>
                                        <th>Jabatan Kepsek</th>
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
                                                        <a class="dropdown-item delete_row" href="#"
                                                           data-uid="{{ $id }}"><i
                                                                class="mdi mdi-trash-can"></i> Hapus</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="table-user">
                                                {{--<img src="assets/images/users/user-2.jpg" alt="table-user" class="me-2 rounded-circle">--}}
                                                <a href="javascript:void(0);"
                                                   class="text-body fw-semibold">{{$row->nama_lengkap}}</a>
                                            </td>
                                            <td>{{$row->nik}}</td>
                                            <td>{{$row->nuptk}}</td>
                                            <td>{{$row->nip}}</td>
                                            <td>{{$row->jk}}</td>
                                            <td>{{$row->tmp_lahir}}</td>
                                            <td>{{$row->tgl_lahir->format('d M Y')}}</td>
                                            <td>{{$row->status_tugas}}</td>
                                            <td>{{$row->tmp_tugas}}</td>
                                            <td>{{$row->npsn}}</td>
                                            <td>{{$row->kecamatan}}</td>
                                            <td>{{$row->kabupaten}}</td>
                                            <td>{{$row->no_hp}}</td>
                                            <td>{{$row->sk_cpns}}</td>
                                            <td>{{$row->tgl_cpns->format('d M Y')}}</td>
                                            <td>{{$row->sk_pengangkatan}}</td>
                                            <td>{{$row->tmt_pengangkatan->format('d M Y')}}</td>
                                            <td>{{$row->jenis_ptk}}</td>
                                            <td>{{$row->pendidikan}}</td>
                                            <td>{{$row->bidang_studi_pendidikan}}</td>
                                            <td>{{$row->bidang_studi_sertifikasi}}</td>
                                            <td>{{$row->status_kepegawaian}}</td>
                                            <td>{{$row->pangkat_gol}}</td>
                                            <td>{{$row->tmt_pangkat->format('d M Y')}}</td>
                                            <td>{{$row->masa_kerja_tahun}}</td>
                                            <td>{{$row->masa_kerja_bulan}}</td>
                                            <td>{{$row->mata_pelajaran_diajarkan}}</td>
                                            <td>{{$row->jam_mengajar}}</td>
                                            <td>{{$row->jabatan_kepsek}}</td>
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

    <script src="{{asset('')}}modules/num-dapodik/guru/app.js?v=1.4"></script>
@endsection
