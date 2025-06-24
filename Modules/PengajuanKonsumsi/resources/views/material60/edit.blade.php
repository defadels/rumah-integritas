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

                            <form action="{{route('form.makan.update',['id'=>encrypt($konsumsi[0]->id)])}}" class="parsley-examples" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Pemohon<span class="text-danger">*</span></label>
                                    <input autofocus type="text" name="name" parsley-trigger="change" required class="form-control" id="name" value="{{$konsumsi[0]->name}}"/>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" parsley-trigger="change" required class="form-control" id="email" value="{{$konsumsi[0]->email}}"/>
                                </div>

                                <div class="mb-3">
                                    <label for="judul_rapat" class="form-label">Judul Kegiatan Rapat<span class="text-danger">*</span></label>
                                    <input type="text" name="judul_rapat" parsley-trigger="change" required class="form-control" id="judul_rapat" value="{{$konsumsi[0]->judul_rapat}}"/>
                                </div>

                                <div class="mb-3">
                                    <label for="judul_rapat" class="form-label">Waktu Pelaksanaan Kegiatan Rapat (Hari, Tanggal, Bulan dan Tahun)<span class="text-danger">*</span></label>
                                    <input type="text" name="waktu" parsley-trigger="change" required class="form-control" id="waktu" value="{{$konsumsi[0]->waktu}}"/>
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_konsumsi" class="form-label">Jenis Konsumsi</label>
                                    @foreach($jenis_konsumsi as $row)
                                        <div class="form-check">
                                            <input name="checkbox_jenis_konsumsi[]"
                                                   id="checkbox_jenis_konsumsi[]" type="checkbox"
                                                   class="checkbox form-check-input"
                                                   value="{{$row->id}}" {{$konsumsi[0]->jenis_id == $row->id ? 'checked':''}}>
                                            <label class="form-check-label"
                                                   for="checkmeout0">{{$row->name}}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <label for="sub_bag" class="form-label">Sub Bagian</label>
                                    @foreach($sub_bag as $row)
                                        <div class="form-check">
                                            <input name="checkbox_sub_bag[]"
                                                   id="checkbox_sub_bag[]" type="checkbox"
                                                   class="checkbox form-check-input"
                                                   value="{{$row->id}}" {{$konsumsi[0]->sub_bag_id == $row->id ? 'checked':''}}>
                                            <label class="form-check-label"
                                                   for="checkmeout0">{{$row->name}}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <label for="jml_konsumsi" class="form-label">Jumlah Konsumsi (*Kotak/Orang/Kali)<span class="text-danger">*</span></label>
                                    <input type="text" name="jml_konsumsi" parsley-trigger="change" required class="form-control" id="name" value="{{$konsumsi[0]->jml_konsumsi}}"/>
                                </div>

                                <div class="mb-3">
                                    <label for="setuju" class="form-label">Setuju untuk mengajukan permohonan fasilitasi?</label>
                                    <div class="form-check">
                                        <input name="checkbox_setuju"
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
                                    <button type="reset" class="btn btn-secondary waves-effect" onclick="window.location='/manage'">Batal</button>
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
