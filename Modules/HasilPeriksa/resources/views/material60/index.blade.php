@extends('backend::material60.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material/assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <style>
        .document-card {
            transition: all 0.3s ease;
            border-left: 4px solid #e3eaef;
        }
        .document-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-left-color: #1abc9c;
        }
        .status-badge {
            font-size: 0.75rem;
        }
        .reply-counter {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            font-weight: bold;
        }
        .action-buttons .btn {
            margin: 2px;
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
                                    <i class="mdi mdi-file-document-multiple-outline me-2"></i>
                                    Daftar Hasil Pemeriksaan Awal Tim
                                </h4>
                                <div>
                                    <a href="{{ route('form.hasil.create') }}" class="btn btn-primary">
                                        <i class="mdi mdi-plus me-1"></i>
                                        Tambah Dokumen Baru
                                    </a>
                                </div>
                            </div>

                            @if(Session::has('messages'))
                                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    {{ Session::get('messages') }}
                                </div>
                            @endif

                            @if(count($hasil) > 0)
                                <div class="row">
                                    @foreach($hasil as $row)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card document-card h-100">
                                                <div class="card-header bg-light">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1 fw-bold text-truncate" title="{{ $row->name }}">
                                                                <i class="mdi mdi-file-document me-1"></i>
                                                                {{ $row->name }}
                                                            </h6>
                                                            <small class="text-muted">
                                                                <i class="mdi mdi-clock-outline me-1"></i>
                                                                {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y, H:i') }}
                                                            </small>
                                                        </div>
                                                        <div class="ms-2">
                                                            @if($row->status_approval == 'pending' || is_null($row->status_approval))
                                                                <span class="badge bg-warning status-badge">Pending</span>
                                                            @elseif($row->status_approval == 'approved')
                                                                <span class="badge bg-success status-badge">Approved</span>
                                                            @elseif($row->status_approval == 'rejected')
                                                                <span class="badge bg-danger status-badge">Rejected</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small class="text-muted">Pengirim:</small>
                                                                <p class="mb-1 fw-semibold">{{ $row->fullname ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted">Penerima:</small>
                                                                <p class="mb-1 fw-semibold">{{ $row->receiver_name ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($row->file_attach)
                                                        <div class="mb-3">
                                                            <a href="{{ Storage::url($row->file_attach) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                                                <i class="mdi mdi-file-document me-1"></i>
                                                                Lihat File Lampiran
                                                            </a>
                                                        </div>
                                                    @endif

                                                    @if(isset($row->reply_count) && $row->reply_count > 0)
                                                        <div class="mb-3">
                                                            <span class="badge reply-counter">
                                                                <i class="mdi mdi-message-reply-text me-1"></i>
                                                                {{ $row->reply_count }} Balasan
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($row->approval_notes)
                                                        <div class="alert alert-info alert-sm">
                                                            <small><strong>Catatan:</strong> {{ Str::limit($row->approval_notes, 100) }}</small>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="card-footer bg-light">
                                                    <div class="action-buttons text-center">
                                                        <div class="btn-group-vertical btn-group-sm w-100" role="group">
                                                            <div class="d-flex gap-1 mb-2">
                                                                <button class="btn btn-info detail-btn flex-fill" data-id="{{encrypt($row->id)}}" data-type="hasil">
                                                                    <i class="mdi mdi-eye"></i> Detail
                                                                </button>
                                                                <a href="{{route('form.hasil.conversation',['id'=>encrypt($row->id)])}}" class="btn btn-success flex-fill">
                                                                    <i class="mdi mdi-message-text-outline"></i> 
                                                                    Percakapan
                                                                    @if(isset($row->reply_count) && $row->reply_count > 0)
                                                                        <span class="badge bg-white text-success ms-1">{{$row->reply_count}}</span>
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="d-flex gap-1">
                                                                <a href="{{route('form.hasil.reply',['id'=>encrypt($row->id)])}}" class="btn btn-primary flex-fill">
                                                                    <i class="mdi mdi-reply"></i> Balas
                                                                </a>
                                                                @if($row->users_id == auth()->user()->id || auth()->user()->hasRole('administrator'))
                                                                    <a href="{{route('form.hasil.edit',['id'=>encrypt($row->id)])}}" class="btn btn-warning flex-fill">
                                                                        <i class="mdi mdi-pencil"></i> Edit
                                                                    </a>
                                                                    <button class="btn btn-danger delete-data-pemeriksaan flex-fill" data-pid="{{encrypt($row->id)}}">
                                                                        <i class="mdi mdi-delete"></i> Delete
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination would go here if needed -->
                                <div class="text-center mt-4">
                                    <p class="text-muted">
                                        <i class="mdi mdi-information-outline me-1"></i>
                                        Menampilkan {{ count($hasil) }} dokumen. 
                                        @if(auth()->user()->hasRole('administrator'))
                                            Semua dokumen ditampilkan.
                                        @else
                                            Hanya dokumen yang Anda kirim atau terima.
                                        @endif
                                    </p>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="mdi mdi-file-document-outline" style="font-size: 4rem; opacity: 0.3;"></i>
                                        <h5 class="mt-3">Belum Ada Dokumen</h5>
                                        <p>Belum ada hasil pemeriksaan yang tersedia.</p>
                                        <a href="{{ route('form.hasil.create') }}" class="btn btn-primary">
                                            <i class="mdi mdi-plus me-1"></i>
                                            Tambah Dokumen Pertama
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div> <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Dokumen</h5>
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
    
    <script>
        // Delete functionality
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
                        data: {pid: uid, "_token": "{{csrf_token()}}"},
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == 'success') {
                                Swal.fire("Berhasil!", data.pesan, data.status);
                                window.location.reload();
                            } else {
                                Swal.fire("Error!", data.pesan, data.status);
                            }
                            return false;
                        },
                        error:function(jqXHR,textStatus){
                            Swal.fire("Error!", "Terjadi kesalahan: " + textStatus, "error");
                        }
                    });
                }
            });
        });

        // Detail Modal Functionality (same as dashboard)
        $('.detail-btn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var type = $(this).data('type');
            
            var url = "{{route('form.hasil.detail', ':id')}}".replace(':id', id);
            
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
                $('#approvalModalLabel').text('Reject Dokumen');
                $('#submitApproval').removeClass('btn-success').addClass('btn-danger').text('Reject');
                $('#requiredStar').show();
                $('#approvalNotes').attr('required', true);
            } else {
                $('#approvalModalLabel').text('Approve Dokumen');
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
            
            // Validate required notes for rejection
            if (action === 'reject' && !notes.trim()) {
                Swal.fire('Error', 'Catatan wajib diisi untuk penolakan', 'error');
                return;
            }
            
            var url = action === 'approve' ? "{{route('form.hasil.approve')}}" : "{{route('form.hasil.reject')}}";
            
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
            
            // Document specific fields
            html += '<div class="row">';
            html += '<div class="col-md-6"><strong>Nama Dokumen:</strong> ' + (data.name || '-') + '</div>';
            if (data.file_attach) {
                html += '<div class="col-md-6"><strong>File:</strong> <a href="/storage/' + data.file_attach + '" target="_blank" class="btn btn-sm btn-primary">Lihat File</a></div>';
            }
            html += '</div>';
            
            return html;
        }

        // Success message auto hide
        setTimeout(function() {
            $('.alert-success').fadeOut();
        }, 5000);
    </script>
@endsection 