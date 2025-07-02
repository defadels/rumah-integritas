@extends('backend::material60.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material/assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <style>
        .conversation-item {
            border-left: 4px solid #e3eaef;
            margin-bottom: 20px;
            position: relative;
        }
        .conversation-item.main-document {
            border-left-color: #1abc9c;
        }
        .conversation-item.reply {
            border-left-color: #3498db;
            margin-left: 20px;
        }
        .conversation-header {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px 5px 0 0;
        }
        .conversation-body {
            padding: 15px;
            background-color: #fff;
            border-radius: 0 0 5px 5px;
            border: 1px solid #e3eaef;
            border-top: none;
        }
        .conversation-meta {
            font-size: 0.875rem;
            color: #6c757d;
        }
        .status-badge {
            font-size: 0.75rem;
        }
        .reply-level-indicator {
            position: absolute;
            left: -10px;
            top: 15px;
            width: 20px;
            height: 20px;
            background-color: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .main-document .reply-level-indicator {
            background-color: #1abc9c;
        }
    </style>
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
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="header-title mb-0">
                                    <i class="mdi mdi-message-text-outline me-2"></i>
                                    Percakapan Dokumen
                                </h4>
                                <div>
                                    <a href="{{ route('form.hasil.reply', ['id' => encrypt($document->id)]) }}" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-reply me-1"></i>
                                        Balas Dokumen
                                    </a>
                                    <a href="{{ route('form.hasil.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="mdi mdi-arrow-left me-1"></i>
                                        Daftar Dokumen
                                    </a>
                                    <a href="{{ route('form.hasil.create') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="mdi mdi-plus me-1"></i>
                                        Tambah Baru
                                    </a>
                                </div>
                            </div>

                            @if(Session::has('messages'))
                                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    {{ Session::get('messages') }}
                                </div>
                            @endif

                            <!-- Main Document -->
                            <div class="conversation-item main-document">
                                <div class="reply-level-indicator">1</div>
                                <div class="conversation-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1">
                                                <i class="mdi mdi-file-document me-1"></i>
                                                {{ $document->name }}
                                                <span class="badge bg-success ms-2">Dokumen Utama</span>
                                            </h5>
                                            <div class="conversation-meta">
                                                <span><strong>Pengirim:</strong> {{ $document->sender->name ?? 'N/A' }}</span> |
                                                <span><strong>Penerima:</strong> {{ $document->receiver->name ?? 'N/A' }}</span> |
                                                <span><strong>Tanggal:</strong> {{ $document->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            @if($document->status_approval == 'pending')
                                                <span class="badge bg-warning status-badge">Pending</span>
                                            @elseif($document->status_approval == 'approved')
                                                <span class="badge bg-success status-badge">Approved</span>
                                            @elseif($document->status_approval == 'rejected')
                                                <span class="badge bg-danger status-badge">Rejected</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="conversation-body">
                                    @if($document->file_attach)
                                        <div class="mb-3">
                                            <strong>File Lampiran:</strong>
                                            <a href="{{ Storage::url($document->file_attach) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                <i class="mdi mdi-download me-1"></i>
                                                Lihat File
                                            </a>
                                        </div>
                                    @endif
                                    
                                    @if($document->approval_notes)
                                        <div class="alert alert-info">
                                            <strong>Catatan Approval:</strong><br>
                                            {{ $document->approval_notes }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Replies -->
                            @if($document->replies->count() > 0)
                                @foreach($document->replies as $index => $reply)
                                    <div class="conversation-item reply">
                                        <div class="reply-level-indicator">{{ $index + 2 }}</div>
                                        <div class="conversation-header">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <i class="mdi mdi-reply me-1"></i>
                                                        {{ $reply->name }}
                                                        <span class="badge bg-info ms-2">Balasan #{{ $index + 1 }}</span>
                                                    </h6>
                                                    <div class="conversation-meta">
                                                        <span><strong>Pengirim:</strong> {{ $reply->sender->name ?? 'N/A' }}</span> |
                                                        <span><strong>Penerima:</strong> {{ $reply->receiver->name ?? 'N/A' }}</span> |
                                                        <span><strong>Tanggal:</strong> {{ $reply->created_at->format('d M Y, H:i') }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    @if($reply->status_approval == 'pending')
                                                        <span class="badge bg-warning status-badge">Pending</span>
                                                    @elseif($reply->status_approval == 'approved')
                                                        <span class="badge bg-success status-badge">Approved</span>
                                                    @elseif($reply->status_approval == 'rejected')
                                                        <span class="badge bg-danger status-badge">Rejected</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="conversation-body">
                                            @if($reply->reply_message)
                                                <div class="mb-3">
                                                    <strong>Pesan:</strong>
                                                    <p class="mt-2 mb-0">{{ $reply->reply_message }}</p>
                                                </div>
                                            @endif
                                            
                                            @if($reply->file_attach)
                                                <div class="mb-3">
                                                    <strong>File Lampiran:</strong>
                                                    <a href="{{ Storage::url($reply->file_attach) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                        <i class="mdi mdi-download me-1"></i>
                                                        Lihat File
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            @if($reply->approval_notes)
                                                <div class="alert alert-info">
                                                    <strong>Catatan Approval:</strong><br>
                                                    {{ $reply->approval_notes }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="mdi mdi-message-outline" style="font-size: 3rem;"></i>
                                        <p class="mt-2">Belum ada balasan untuk dokumen ini</p>
                                        <a href="{{ route('form.hasil.reply', ['id' => encrypt($document->id)]) }}" class="btn btn-primary btn-sm">
                                            <i class="mdi mdi-reply me-1"></i>
                                            Buat Balasan Pertama
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Quick Reply Section -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-message-plus me-1"></i>
                                        Balas Cepat
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('form.hasil.reply.store') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $document->id }}">
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="quick_name" class="form-label">Nama Balasan<span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="quick_name" class="form-control" required placeholder="Nama dokumen balasan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="quick_message" class="form-label">Pesan<span class="text-danger">*</span></label>
                                                    <textarea name="reply_message" id="quick_message" rows="3" class="form-control" required placeholder="Pesan balasan..."></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="quick_file" class="form-label">File</label>
                                                    <input type="file" name="file_attach" id="quick_file" class="form-control">
                                                    <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">
                                                        <i class="mdi mdi-send me-1"></i>
                                                        Kirim
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

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
    <!-- Sweet Alerts js -->
    <script src="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    
    <script>
        // Auto scroll to bottom when page loads
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 1000);
        });
        
        // Success message auto hide
        setTimeout(function() {
            $('.alert-success').fadeOut();
        }, 5000);
    </script>
@endsection 