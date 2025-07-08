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

                {{-- Pengajuan Makan Minum --}}

                @if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('Pengaju') || auth()->user()->hasRole('Supervisi'))

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
                                        <th>Status</th>
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
                                                @if($row->status_approval == 'pending' || is_null($row->status_approval))
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($row->status_approval == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($row->status_approval == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info detail-btn" data-id="{{encrypt($row->id)}}" data-type="makan">Detail</button>
                                                <a href="{{route('form.makan.edit',['id'=>encrypt($row->id)])}}" class="btn btn-sm btn-warning">Edit</a>
                                                <button class="btn btn-sm btn-danger delete-data-makan" data-pid="{{encrypt($row->id)}}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

                @endif


                {{-- Hasil Pemeriksaan Awal Tim --}}

                 @if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('OPD'))

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
                                        <th>Status</th>
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
                                                @if(isset($row->reply_count) && $row->reply_count > 0)
                                                    <span class="badge bg-info ms-2">{{$row->reply_count}} balasan</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->file_attach)
                                                    <a href="{{Storage::url($row->file_attach)}}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="mdi mdi-file-document"></i> File
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->status_approval == 'pending' || is_null($row->status_approval))
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($row->status_approval == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($row->status_approval == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group-vertical btn-group-sm" role="group">
                                                    <button class="btn btn-info detail-btn" data-id="{{encrypt($row->id)}}" data-type="hasil">
                                                        <i class="mdi mdi-eye"></i> Detail
                                                    </button>
                                                    <a href="{{route('form.hasil.conversation',['id'=>encrypt($row->id)])}}" class="btn btn-success">
                                                        <i class="mdi mdi-message-text-outline"></i> Percakapan
                                                        @if(isset($row->reply_count) && $row->reply_count > 0)
                                                            <span class="badge bg-white text-success ms-1">{{$row->reply_count}}</span>
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="btn-group-vertical btn-group-sm mt-1" role="group">
                                                    <a href="{{route('form.hasil.reply',['id'=>encrypt($row->id)])}}" class="btn btn-primary">
                                                        <i class="mdi mdi-reply"></i> Balas
                                                    </a>
                                                    @if ($row->users_id == auth()->user()->id)
                                                        <a href="{{route('form.hasil.edit',['id'=>encrypt($row->id)])}}" class="btn btn-warning">
                                                            <i class="mdi mdi-pencil"></i> Edit
                                                        </a>
                                                        <button class="btn btn-danger delete-data-pemeriksaan" data-pid="{{encrypt($row->id)}}">
                                                            <i class="mdi mdi-delete"></i> Delete
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

                @endif

            </div>
            <!-- end row -->

            <div class="row">

                {{-- Pengajuan Pemeliharaan BMD --}}

                @if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('Pengaju') || auth()->user()->hasRole('Supervisi'))

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
                                        <th>Status</th>
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
                                                @if($row->status_approval == 'pending' || is_null($row->status_approval))
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($row->status_approval == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($row->status_approval == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info detail-btn" data-id="{{encrypt($row->id)}}" data-type="pemeliharaan">Detail</button>
                                                <a href="{{route('form.pelihara.edit',['id'=>encrypt($row->id)])}}" class="btn btn-sm btn-warning">Edit</a>
                                                <button class="btn btn-sm btn-danger delete-data-pelihara" data-pid="{{encrypt($row->id)}}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

                @endif


                {{-- Agenda Inspektorat --}}

                @if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('Pengaju') || auth()->user()->hasRole('Supervisi'))

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
                                        <th>Status</th>
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
                                                @if($row->status_approval == 'pending' || is_null($row->status_approval))
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($row->status_approval == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($row->status_approval == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info detail-btn" data-id="{{encrypt($row->id)}}" data-type="barang">Detail</button>
                                                <a href="{{route('form.barang.pakai.habis.edit',['id'=>encrypt($row->id)])}}" class="btn btn-sm btn-warning">Edit</a>
                                                <button class="btn btn-sm btn-danger delete-data-barang" data-pid="{{encrypt($row->id)}}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

                @endif

            </div>
            <!-- end row -->

            <div class="row">

                {{-- Kartu Kendali --}}

                 @if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('Pengaju') || auth()->user()->hasRole('Supervisi'))

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
                                        <th>Status</th>
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
                                                @if($row->status_approval == 'pending' || is_null($row->status_approval))
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($row->status_approval == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($row->status_approval == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info detail-btn" data-id="{{encrypt($row->id)}}" data-type="kartu">Detail</button>
                                                <a href="{{route('form.kartu.kendali.edit',['id'=>encrypt($row->id)])}}" class="btn btn-sm btn-warning">Edit</a>
                                                <button class="btn btn-sm btn-danger delete-data-kartu" data-pid="{{encrypt($row->id)}}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->

                @endif
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- Detail content will be loaded here -->
                </div>
                <div class="modal-footer" id="detailModalFooter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Approval buttons will be added here if user has permission -->
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Notes Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">Approval Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="approvalForm">
                        <div class="mb-3">
                            <label for="approvalNotes" class="form-label">Catatan <span id="requiredStar" style="display:none;" class="text-danger">*</span></label>
                            <textarea class="form-control" id="approvalNotes" name="notes" rows="3" placeholder="Masukkan catatan..."></textarea>
                        </div>
                        <input type="hidden" id="approvalId" name="id">
                        <input type="hidden" id="approvalAction" name="action">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitApproval">Submit</button>
                </div>
            </div>
        </div>
    </div>
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
        $('.delete-data-makan').click(function (e) {
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
        $('.delete-data-barang').click(function (e) {
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
        $('.delete-data-pelihara').click(function (e) {
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
        $('.delete-data-kartu').click(function (e) {
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
        $('.delete-data-pemeriksaan').click(function (e) {
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

        // Detail Modal Functionality
        $('.detail-btn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var type = $(this).data('type');
            
            // Define route mappings
            var routes = {
                'hasil': '{{route("form.hasil.detail", ":id")}}',
                'pemeliharaan': '{{route("form.pelihara.detail", ":id")}}', 
                'barang': '{{route("form.barang.pakai.habis.detail", ":id")}}',
                'kartu': '{{route("form.kartu.kendali.detail", ":id")}}',
                'makan': '{{route("form.makan.detail", ":id")}}'
            };
            
            var url = routes[type].replace(':id', id);
            
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                beforeSend: function() {
                    $('#detailModalBody').html('<div class="text-center"><i class="mdi mdi-loading mdi-spin"></i> Loading...</div>');
                    $('#detailModal').modal('show');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var data = response.data;
                        var html = buildDetailHtml(data, type);
                        $('#detailModalBody').html(html);
                        
                        // Add approval buttons if user has permission and status is pending
                        var footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                        if (response.canApprove && (data.status_approval === 'pending' || data.status_approval === null || data.status_approval === undefined)) {
                            footer += '<button type="button" class="btn btn-success approve-btn" data-id="' + id + '" data-type="' + type + '">Approve</button>';
                            footer += '<button type="button" class="btn btn-danger reject-btn" data-id="' + id + '" data-type="' + type + '">Reject</button>';
                        }
                        $('#detailModalFooter').html(footer);
                    } else {
                        $('#detailModalBody').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#detailModalBody').html('<div class="alert alert-danger">Error loading data: ' + error + '</div>');
                }
            });
        });

        // Approval button handlers
        $(document).on('click', '.approve-btn', function() {
            var id = $(this).data('id');
            var type = $(this).data('type');
            openApprovalModal(id, type, 'approve');
        });

        $(document).on('click', '.reject-btn', function() {
            var id = $(this).data('id');
            var type = $(this).data('type');
            openApprovalModal(id, type, 'reject');
        });

        function openApprovalModal(id, type, action) {
            $('#approvalId').val(id);
            $('#approvalAction').val(action);
            $('#approvalNotes').val('');
            
            if (action === 'reject') {
                $('#approvalModalLabel').text('Reject Pengajuan');
                $('#submitApproval').removeClass('btn-success').addClass('btn-danger').text('Reject');
                $('#requiredStar').show();
                $('#approvalNotes').attr('required', true);
            } else {
                $('#approvalModalLabel').text('Approve Pengajuan');
                $('#submitApproval').removeClass('btn-danger').addClass('btn-success').text('Approve');
                $('#requiredStar').hide();
                $('#approvalNotes').removeAttr('required');
            }
            
            $('#detailModal').modal('hide');
            $('#approvalModal').modal('show');
        }

        // Submit approval
        $('#submitApproval').click(function() {
            var id = $('#approvalId').val();
            var action = $('#approvalAction').val();
            var notes = $('#approvalNotes').val();
            var type = $('.approve-btn, .reject-btn').data('type');
            
            // Validate required notes for rejection
            if (action === 'reject' && !notes.trim()) {
                Swal.fire('Error', 'Catatan wajib diisi untuk penolakan', 'error');
                return;
            }
            
            // Define route mappings for approval
            var approveRoutes = {
                'hasil': '{{route("form.hasil.approve")}}',
                'pemeliharaan': '{{route("form.pelihara.approve")}}',
                'barang': '{{route("form.barang.pakai.habis.approve")}}',
                'kartu': '{{route("form.kartu.kendali.approve")}}',
                'makan': '{{route("form.makan.approve")}}'
            };
            
            var rejectRoutes = {
                'hasil': '{{route("form.hasil.reject")}}',
                'pemeliharaan': '{{route("form.pelihara.reject")}}', 
                'barang': '{{route("form.barang.pakai.habis.reject")}}',
                'kartu': '{{route("form.kartu.kendali.reject")}}',
                'makan': '{{route("form.makan.reject")}}'
            };
            
            var url = action === 'approve' ? approveRoutes[type] : rejectRoutes[type];
            
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: id,
                    notes: notes,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#submitApproval').prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');
                },
                success: function(response) {
                    $('#approvalModal').modal('hide');
                    if (response.status === 'success') {
                        Swal.fire('Success', response.message, 'success').then(function() {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    $('#approvalModal').modal('hide');
                    var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Something went wrong';
                    Swal.fire('Error', message, 'error');
                },
                complete: function() {
                    $('#submitApproval').prop('disabled', false).html(action === 'approve' ? 'Approve' : 'Reject');
                }
            });
        });

        function buildDetailHtml(data, type) {
            var html = '<div class="row">';
            
            // Common fields
            html += '<div class="col-md-6"><strong>Status:</strong> ';
            if (data.status_approval === 'pending' || data.status_approval === null || data.status_approval === undefined) {
                html += '<span class="badge bg-warning">Pending</span>';
            } else if (data.status_approval === 'approved') {
                html += '<span class="badge bg-success">Approved</span>';
            } else if (data.status_approval === 'rejected') {
                html += '<span class="badge bg-danger">Rejected</span>';
            }
            html += '</div>';
            
            if (data.approved_at) {
                html += '<div class="col-md-6"><strong>Tanggal Approval:</strong> ' + new Date(data.approved_at).toLocaleString() + '</div>';
            }
            
            if (data.approver) {
                html += '<div class="col-md-6"><strong>Disetujui oleh:</strong> ' + data.approver.name + '</div>';
            }
            
            if (data.approval_notes) {
                html += '<div class="col-md-12"><strong>Catatan Approval:</strong> ' + data.approval_notes + '</div>';
            }
            
            html += '</div><hr>';
            
            // Type-specific fields
            if (type === 'hasil') {
                html += '<div class="row">';
                html += '<div class="col-md-6"><strong>Nama Dokumen:</strong> ' + (data.name || '-') + '</div>';
                html += '<div class="col-md-6"><strong>File:</strong> <a href="/storage/' + data.file_attach + '" target="_blank">' + data.file_attach + '</a></div>';
                html += '</div>';
            } else if (type === 'pemeliharaan') {
                html += '<div class="row">';
                html += '<div class="col-md-6"><strong>Nama:</strong> ' + (data.name || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Email:</strong> ' + (data.email || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Jenis Keluhan:</strong> ' + (data.jenis_keluhan || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Sub Bagian:</strong> ' + (data.sub_bag || '-') + '</div>';
                html += '</div>';
            } else if (type === 'barang') {
                html += '<div class="row">';
                html += '<div class="col-md-6"><strong>Nama Kegiatan:</strong> ' + (data.namakegiatan || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Email:</strong> ' + (data.email || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Tanggal Pelaksanaan:</strong> ' + (data.tanggalpelaksanaan || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Waktu Pelaksanaan:</strong> ' + (data.waktupelaksanaan || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Lokasi:</strong> ' + (data.lokasikegiatan || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Penanggung Jawab:</strong> ' + (data.penanggungjawab || '-') + '</div>';
                html += '</div>';
            } else if (type === 'kartu') {
                html += '<div class="row">';
                html += '<div class="col-md-6"><strong>Pekerjaan:</strong> ' + (data.pekerjaan || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Rekanan:</strong> ' + (data.rekanan || '-') + '</div>';
                html += '<div class="col-md-6"><strong>Pagu Dana:</strong> ' + (data.pagu_dana ? new Intl.NumberFormat('id-ID').format(data.pagu_dana) : '-') + '</div>';
                html += '<div class="col-md-6"><strong>No SPK:</strong> ' + (data.spk_no || '-') + '</div>';
                html += '</div>';
            }
            
            return html;
        }
    </script>
@endsection
