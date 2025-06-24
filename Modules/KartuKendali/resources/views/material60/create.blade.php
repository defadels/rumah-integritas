@extends('backend::material60.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material/assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/themes/material/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
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

                            <form action="{{route('form.kartu.kendali.create')}}" class="parsley-examples" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="kode_sub" class="form-label">Kode Sub Kegiatan<span class="text-danger">*</span></label>
                                    <input autofocus type="text" name="kode_sub" parsley-trigger="change" required class="form-control" id="kode_sub"/>
                                </div>

                                <div class="mb-3">
                                    <label for="sub_kegiatan" class="form-label">Sub Kegiatan<span class="text-danger">*</span></label>
                                    <input name="sub_kegiatan" parsley-trigger="change" required class="form-control" id="sub_kegiatan"/>
                                </div>

                                <div class="mb-3">
                                    <label for="sub_bidang" class="form-label">Sub Bidang<span class="text-danger">*</span></label>
                                    <input type="text" name="sub_bidang" parsley-trigger="change" required class="form-control" id="sub_bidang"/>
                                </div>

                                <div class="mb-3">
                                    <label for="pekerjaan" class="form-label">Pekerjaan<span class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan" parsley-trigger="change" required class="form-control" id="pekerjaan"/>
                                </div>

                                <div class="mb-3">
                                    <label for="rekanan" class="form-label">Rekanan</label>
                                    <input type="text" name="rekanan" parsley-trigger="change" class="form-control" id="rekanan"/>
                                </div>

                                <div class="mb-3">
                                    <label for="pagu_dana" class="form-label">Pagu Dana</label>
                                    <input type="text" name="pagu_dana" parsley-trigger="change" class="form-control autonumber" data-digit-group-separator="." data-decimal-character="," data-decimal-places="0" id="pagu_dana"/>
                                </div>

                                <div class="mb-3">
                                    <label for="spk_no" class="form-label">No SPK</label>
                                    <input type="text" name="spk_no" parsley-trigger="change"  class="form-control" id="spk_no"/>
                                </div>

                                <div class="mb-3">
                                    <label for="bap_tgl" class="form-label">BAP Tanggal</label>
                                    <input type="text" name="bap_tgl" parsley-trigger="change" class="form-control" id="bap_tgl" data-provide="datepicker" data-date-format="dd/mm/yyyy"/>
                                </div>

                                <div class="mb-3">
                                    <label for="bap_no" class="form-label">BAP No</label>
                                    <input type="text" name="bap_no" parsley-trigger="change" class="form-control" id="bap_no"/>
                                </div>

                                <div class="mb-3">
                                    <label for="bast_tgl" class="form-label">BAST Tanggal</label>
                                    <input type="text" name="bast_tgl" parsley-trigger="change"  class="form-control" id="bast_tgl" data-provide="datepicker" data-date-format="dd/mm/yyyy"/>
                                </div>

                                <div class="mb-3">
                                    <label for="bast_no" class="form-label">BAST No</label>
                                    <input type="text" name="bast_no" parsley-trigger="change"  class="form-control" id="bast_no"/>
                                </div>

                                <div class="mb-3">
                                    <label for="bapem_tgl" class="form-label">Berita Acara Pembayaran Tanggal</label>
                                    <input type="text" name="bapem_tgl" parsley-trigger="change"  class="form-control" id="bapem_tgl" data-provide="datepicker" data-date-format="dd/mm/yyyy"/>
                                </div>

                                <div class="mb-3">
                                    <label for="bapem_no" class="form-label">Berita Acata Pembayaran No</label>
                                    <input type="text" name="bapem_no" parsley-trigger="change"  class="form-control" id="bapem_no"/>
                                </div>

                                <div class="mb-3">
                                    <label for="spp_no" class="form-label">SPP No</label>
                                    <input type="text" name="spp_no" parsley-trigger="change"  class="form-control" id="spp_no"/>
                                </div>

                                <div class="mb-3">
                                    <label for="spp_nilai" class="form-label">SPP Nilai</label>
                                    <input type="text" name="spp_nilai" parsley-trigger="change"  class="form-control autonumber" data-digit-group-separator="." data-decimal-character="," data-decimal-places="0" id="spp_nilai"/>
                                </div>

                                <div class="mb-3">
                                    <label for="sisa_anggaran" class="form-label">Sisa Anggaran</label>
                                    <input type="text" name="sisa_anggaran" parsley-trigger="change"  class="form-control" id="sisa_anggaran"/>
                                </div>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan" parsley-trigger="change" class="form-control" id="keterangan"/>
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
    <script src="{{asset('')}}assets/themes/material/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('')}}assets/themes/material/assets/libs/autonumeric/autoNumeric.min.js"></script>

    <!-- Validation init js-->
    <script src="{{asset('')}}assets/themes/material/assets/libs/mohithg-switchery/switchery.min.js"></script>
    <script src="{{asset('')}}modules/num-users/app.js?v=1.2"></script>
    <script src="{{asset('')}}modules/num-users/form-advanced.init.js?v=0.6"></script>
    <script src="{{asset('')}}modules/num-users/form-validation.init.js?v=0.6"></script>
    <script src="{{asset('')}}modules/num-users/form-masks.init.js?v=0.2"></script>
    {{--<script src="{{asset('')}}modules/num-users/form-pickers.init.js"></script>--}}
@endsection
