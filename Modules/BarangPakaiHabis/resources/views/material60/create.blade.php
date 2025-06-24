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

                            <form action="{{route('form.barang.pakai.habis.create')}}" class="parsley-examples" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="namakegiatan" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                                    <input autofocus type="text" name="namakegiatan" parsley-trigger="change" required class="form-control" id="namakegiatan"/>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggalpelaksanaan" class="form-label">Waktu Pelaksanaan (Hari, Tanggal/Bulan/Tahun) <span class="text-danger">*</span></label>
                                    <input type="text" name="tanggalpelaksanaan" parsley-trigger="change" required class="form-control" id="tanggalpelaksanaan" placeholder="Senin, 1/12/2024"/>
                                </div>

                                <div class="mb-3">
                                    <label for="waktupelaksanaan" class="form-label">Jam Pelaksanaan Kegiatan (08:00 s.d ...) <span class="text-danger">*</span></label>
                                    <input type="text" name="waktupelaksanaan" parsley-trigger="change" required class="form-control col-6" id="waktupelaksanaan" placeholder="08:00 s/d Selesai"/>
                                </div>

                                <div class="mb-3">
                                    <label for="lokasikegiatan" class="form-label">Lokasi Kegiatan <span class="text-danger">*</span></label>
                                    <input type="text" name="lokasikegiatan" parsley-trigger="change" required class="form-control" id="lokasikegiatan"/>
                                </div>

                                <div class="mb-3">
                                    <label for="penanggungjawab" class="form-label">Penanggung Jawab (Pelaksana Kegiatan) <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="penanggungjawab" parsley-trigger="change" required class="form-control" id="penanggungjawab"/>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input autofocus type="email" name="email" parsley-trigger="change" required class="form-control" id="email"/>
                                </div>

                                <div class="mb-3">
                                    <label for="setuju" class="form-label">Silahkan mengkonfirmasi agenda kegiatan
                                        <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input name="setuju"
                                               id="checkbox_setuju" type="checkbox"
                                               class="checkbox form-check-input"
                                               value="1">
                                        <label class="form-check-label"
                                               for="checkmeout0">Ya</label>
                                    </div>
                                </div>

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
