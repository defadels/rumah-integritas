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
                                    <form class="d-flex flex-wrap align-items-center" action="{{route('users')}}">
                                        <label for="inputPassword2" class="visually-hidden">Cari</label>
                                        <div class="me-3">
                                            <input type="search" name="s" value="{{ $s }}" class="form-control my-1 my-lg-0" id="inputPassword2" placeholder="Cari...">
                                        </div>
                                        <label for="status-select" class="me-2">Status</label>
                                        <div class="me-sm-3">
                                            <select id="aktif" name="aktif" class="form-select form-select my-1 my-lg-0" id="status-select">
                                                <option selected>Pilih...</option>
                                                @php echo \App\Helpers\NumesaHelper::comboAktif($aktif); @endphp
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-lg-end">
                                        @can('create users')
                                        <button onclick="window.location='{{route('users.create')}}'" type="button" class="btn btn-success waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus-box me-1"></i> Tambah</button>
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
                                                <input id="remember-1" class="group-checkable form-check-input"
                                                       data-set="#listdata .checkbox" type="checkbox"
                                                       data-parsley-multiple="remember-1">
                                            </div>
                                        </th>
                                        <th style="width: 5%;">Opsi</th>
                                        <th style="width: 5%;">Status</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listdata as $row)
                                        @php
                                            $id = $row->id;
                                            $active = ($row->is_active == 1) ? '<h5><span class="badge bg-success">Aktif</span></h5>' : '<h5><span class="badge bg-danger">Suspend</span></h5>';
                                        @endphp
                                        <tr id="data_{{ $row->id }}">
                                            <td>
                                                <div class="form-check">
                                                    <input name="checkbox[]" id="checkbox[]" type="checkbox"
                                                           class="checkbox form-check-input"
                                                           value="{{ $row->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button"
                                                            class="btn btn-xs btn-outline-primary dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        Opsi <i class="mdi mdi-chevron-down"></i></button>
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
                                                {!! $active !!}
                                            </td>
                                            <td class="table-user">
                                                {{--<img src="assets/images/users/user-2.jpg" alt="table-user" class="me-2 rounded-circle">--}}
                                                <a href="javascript:void(0);"
                                                   class="text-body fw-semibold">{{$row->name}}</a>
                                            </td>
                                            <td>
                                                {{$row->email}}
                                            </td>
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

    <script src="{{asset('')}}modules/num-users/app.js?v=1.3"></script>
    <script>
        $(document).on('click','a.delete_row',function (e) {
            e.preventDefault();
            var uid = $(this).attr("data-uid");
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
                        url: "{{route('users.delete')}}",
                        data: {pid: uid, "_token": csrf_token},
                        success: function (data) {
                            if (data.status == 'success') {
                                $('#data_' + uid).remove();
                                Swal.fire(data.judul, data.pesan, data.status);
                            } else {
                                Swal.fire(data.judul, data.pesan, data.status);
                            }
                            return false;
                        },
                        dataType: 'json'
                    });
                }
            });
        });

        $(document).on('click','#delete_all',function (e) {
            e.preventDefault();
            var checkValues = $('.checkbox:checked').map(function()
            {
                return $(this).val();
            }).get();
            console.log(checkValues);
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
                        url: "{{route('users.delete.all')}}",
                        data: {'ids[]': checkValues, "_token": csrf_token},
                        success: function (data) {
                            if (data.status == 'success') {
                                hasil = data.array_pid_sukses;
                                for (var i = 0; i < hasil.length; i++) {
                                    $('#data_' + hasil[i].pid).remove();
                                }
                                Swal.fire(data.judul, data.pesan, data.status);
                            } else {
                                Swal.fire(data.judul, data.pesan, data.status);
                            }
                            return false;
                        },
                        dataType: 'json'
                    });
                }
            });
        });
    </script>
@endsection
