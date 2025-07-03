@extends('backend::material60.layouts.master')

@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Kartu Kendali Kegiatan</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Daftar Kartu Kendali</h4>
                            <p class="text-muted mb-4">
                                Halaman untuk mengelola kartu kendali kegiatan.
                            </p>

                            <div class="mb-3">
                                <a href="{{route('form.kartu.kendali.create')}}" class="btn btn-primary">
                                    <i class="mdi mdi-plus"></i> Tambah Data
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Pekerjaan</th>
                                            <th>Rekanan</th>
                                            <th>Pagu Dana</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kartu_kendali as $index => $row)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $row->pekerjaan }}</td>
                                                <td>{{ $row->rekanan ?: '-' }}</td>
                                                <td>{{ $row->pagu_dana ? 'Rp ' . number_format($row->pagu_dana, 0, ',', '.') : '-' }}</td>
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
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{route('form.kartu.kendali.edit',['id'=>encrypt($row->id)])}}" class="btn btn-warning">
                                                            <i class="mdi mdi-pencil"></i> Edit
                                                        </a>
                                                        <button class="btn btn-danger delete-btn" data-id="{{encrypt($row->id)}}">
                                                            <i class="mdi mdi-delete"></i> Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
@endsection

@section('script')
<!-- Sweet Alerts js -->
<script src="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    $('.delete-btn').click(function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        Swal.fire({
            title: "Yakin akan menghapus data?",
            text: "Data akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28bb4b",
            cancelButtonColor: "#f34e4e",
            confirmButtonText: "Hapus!",
            cancelButtonText: 'Batal',
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "{{route('form.kartu.kendali.delete')}}",
                    data: {pid: id, "_token": "{{csrf_token()}}"},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 'success') {
                            Swal.fire("Berhasil!", data.pesan, "success").then(function() {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire("Error!", data.pesan, "error");
                        }
                    },
                    error: function(jqXHR, textStatus) {
                        Swal.fire("Error!", "Terjadi kesalahan: " + textStatus, "error");
                    }
                });
            }
        });
    });
});
</script>
@endsection
