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
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Form Balas Dokumen</h4>
                            <p class="text-muted font-14">
                                Anda sedang membalas dokumen: <strong>{{ $parent->name }}</strong>
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

                            <form action="{{route('form.hasil.reply.store')}}" class="parsley-examples" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Dokumen Balasan<span class="text-danger">*</span></label>
                                    <input autofocus type="text" name="name" value="{{ old('name') }}" parsley-trigger="change" required class="form-control" id="name" placeholder="Masukkan nama dokumen balasan"/>
                                </div>

                                <div class="mb-3">
                                    <label for="reply_message" class="form-label">Pesan Balasan<span class="text-danger">*</span></label>
                                    <textarea name="reply_message" id="reply_message" rows="5" class="form-control" required placeholder="Masukkan pesan balasan Anda...">{{ old('reply_message') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="file_attach" class="form-label">File Lampiran <small>(opsional)</small></label>
                                            <input type="file" id="file_attach" name="file_attach" class="form-control">
                                            <small class="text-muted">Upload file jika diperlukan untuk melengkapi balasan</small>
                                        </div>
                                    </div>
                                </div> <!-- end row -->

                                <div class="text-end">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        <i class="mdi mdi-send me-1"></i> Kirim Balasan
                                    </button>
                                    <a href="{{ route('form.hasil.conversation', ['id' => encrypt($parent->id)]) }}" class="btn btn-secondary waves-effect">
                                        <i class="mdi mdi-arrow-left me-1"></i> Kembali ke Percakapan
                                    </a>
                                    <a href="{{ route('form.hasil.index') }}" class="btn btn-outline-secondary waves-effect">
                                        <i class="mdi mdi-view-list me-1"></i> Daftar Dokumen
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end card -->
                </div>
                <!-- end col -->
                
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">
                                <i class="mdi mdi-file-document-outline me-1"></i>
                                Dokumen Asli
                            </h4>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Dokumen:</label>
                                <p class="text-muted">{{ $parent->name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pengirim:</label>
                                <p class="text-muted">{{ $parent->sender->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Penerima:</label>
                                <p class="text-muted">{{ $parent->receiver->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Dibuat:</label>
                                <p class="text-muted">{{ $parent->created_at->format('d M Y H:i') }}</p>
                            </div>
                            
                            @if($parent->file_attach)
                            <div class="mb-3">
                                <label class="form-label fw-bold">File Lampiran:</label>
                                <p>
                                    <a href="{{ Storage::url($parent->file_attach) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="mdi mdi-download me-1"></i>
                                        Lihat File
                                    </a>
                                </p>
                            </div>
                            @endif
                            
                            <div class="text-center">
                                <a href="{{ route('form.hasil.conversation', ['id' => encrypt($parent->id)]) }}" class="btn btn-info btn-sm">
                                    <i class="mdi mdi-message-text-outline me-1"></i>
                                    Lihat Semua Percakapan
                                </a>
                            </div>
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
    <script src="{{asset('')}}modules/num-users/form-validation.init.js?v=0.6"></script>
@endsection 