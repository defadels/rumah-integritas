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

                            <form action="{{route('form.hasil.create')}}" class="parsley-examples" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Dokumen<span class="text-danger">*</span></label>
                                    <input autofocus type="text" name="name" parsley-trigger="change" required class="form-control" id="name"/>
                                </div>
                                @if (auth()->user()->hasRole('administrator'))
                                <div class="mb-3">
                                    <label for="receiver" class="form-label">OPD Penerima<span class="text-danger">*</span></label>
                                    <select name="receiver" id="receiver" class="form-control" required>
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
                                            <label for="file_attach" class="form-label">File attach<span class="text-danger">*</span></label>
                                            <input type="file" id="file_attach" name="file_attach" class="form-control" required>
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
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->

                                </div>
                            </div>

                            <h4 class="header-title mb-3">Hasil Pemeriksaan Awal Tim</h4>

                            @if (auth()->user()->hasRole('administrator'))
                                <div class="mb-3">
                                    <label for="pengirim" class="form-label">User Pengirim<span class="text-danger">*</span></label>
                                    <select name="pengirim" id="pengirim" class="form-control">
                                        <option value="">--- Pilih User ---</option>
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabelperiksa" class="table table-borderless table-nowrap table-hover table-centered m-0">

                                        <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Dokumen</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody id="body-history">


                                        </tbody>
                                    </table>
                                </div> <!-- end .table-responsive-->
                                @else
                                <div class="table-responsive">
                                    <table id="tabelperiksa" class="table table-borderless table-nowrap table-hover table-centered m-0">

                                        <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Dokumen</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hasil as $row)
                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">{{$row->fullname}}</h5>
                                                </td>
                                                <td>
                                                    <h5 class="m-0 fw-normal">{{$row->name}}</h5>
                                                </td>
                                                <td>
                                                    <a href="{{asset('hasil/'.$row->file_attach)}}" target="_blank">{{$row->file_attach}}</a>
                                                </td>
                                                @if ($row->users_id == auth()->user()->id)
                                                    <td>
                                                        <a href="{{route('form.hasil.edit',['id'=>encrypt($row->id)])}}" class="badge badge-outline-warning">Edit</a>
                                                        <a href="#" class="delete-data-pemeriksaan badge badge-outline-danger" data-pid="{{encrypt($row->id)}}">Delete</a>
                                                    </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end .table-responsive-->
                                @endif

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
        $(document).on('click','a.delete-data-pemeriksaan',function (e) {
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
        $('select[name="pengirim"]').on('change',function(){
            const pid = $(this).val();
            $('#body-history').html('');
            $.ajax({
                type: "get",
                url: "{{route('form.hasil.history')}}",
                data: {pid},
                dataType: 'json',
                success:function(res){
                    const items = res.result;
                    console.log(items);

                    const currentId = res.current_id;
                    let row = '';
                    items.forEach(element => {
                        let el = `
                        <tr>
                            <td>
                                <h5 class="m-0 fw-normal">${element.fullname}</h5>
                            </td>
                            <td>
                                <h5 class="m-0 fw-normal">${element.name}</h5>
                            </td>
                            <td>
                                <a href="{{asset('hasil')}}/${element.file_attach}" target="_blank">${element.file_attach}</a>
                            </td>
                        `;
                        if(element.users_id == currentId){
                            el += `
                                <td>
                                    <a href="${element.url}" class="badge badge-outline-warning">Edit</a>
                                    <a href="#" class="delete-data-pemeriksaan badge badge-outline-danger" data-pid="${element.id}">Delete</a>
                                </td>
                            `;
                        }
                        el += `</tr>`;
                        row += el;
                    });
                    $('#body-history').html(row);
                },
                error:function(jqXHR,textStatus){
                    console.log({status:jqXHR.status,textStatus});
                }
            })
        })
    </script>
@endsection
