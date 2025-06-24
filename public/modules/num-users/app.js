/**
 * Min Jul 23 17:11:18 WITA 2017
 * Author: Nizar
 * keperluan js untuk manage user module
 */

var Module = function () {
    var handleView = function () {
        var table = $('#listdata');
        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                checked ? $(this).prop("checked", true) : $(this).prop("checked", false);
            });
            var checkValues = $('.checkbox:checked').map(function()
            {
                return $(this).val();
            }).get();
            console.log(checkValues);
            //jQuery.uniform.update(set); //TODO ini bug di versi jquery atas
        });

        // // $('a.delete_row').click(function (e) {
        // //     e.preventDefault();
        // //     var uid = $(this).attr("data-uid");
        // //     Swal.fire({
        // //         title: "Yakin akan menghapus data?",
        // //         text: "Data akan dihapus secara permanen!",
        // //         icon: "warning",
        // //         showCancelButton: !0,
        // //         confirmButtonColor: "#28bb4b",
        // //         cancelButtonColor: "#f34e4e",
        // //         confirmButtonText: "Hapus!",
        // //         cancelButtonText: 'Batal',
        // //     }).then(function (result) {
        // //         if (result.value) {
        // //             $.ajax({
        // //                 type: "post",
        // //                 url: site_backend + '/users/delete',
        // //                 data: {pid: uid, "_token": csrf_token},
        // //                 success: function (data) {
        // //                     if (data.status == 'success') {
        // //                         $('#data_' + uid).remove();
        // //                         Swal.fire(data.judul, data.pesan, data.status);
        // //                     } else {
        // //                         Swal.fire(data.judul, data.pesan, data.status);
        // //                     }
        // //                     return false;
        // //                 },
        // //                 dataType: 'json'
        // //             });
        // //         }
        // //     });
        // // }); //Parameter

        // $('#delete_all').click(function (e) {
        //     e.preventDefault();
        //     var checkValues = $('.checkbox:checked').map(function()
        //     {
        //         return $(this).val();
        //     }).get();
        //     console.log(checkValues);
        //     Swal.fire({
        //         title: "Yakin akan menghapus data?",
        //         text: "Data akan dihapus secara permanen!",
        //         icon: "warning",
        //         showCancelButton: !0,
        //         confirmButtonColor: "#28bb4b",
        //         cancelButtonColor: "#f34e4e",
        //         confirmButtonText: "Hapus!",
        //         cancelButtonText: 'Batal',
        //     }).then(function (result) {
        //         if (result.value) {
        //             $.ajax({
        //                 type: "post",
        //                 url: site_backend + '/users/delete-all',
        //                 data: {'ids[]': checkValues, "_token": csrf_token},
        //                 success: function (data) {
        //                     if (data.status == 'success') {
        //                         hasil = data.array_pid_sukses;
        //                         for (var i = 0; i < hasil.length; i++) {
        //                             $('#data_' + hasil[i].pid).remove();
        //                         }
        //                         Swal.fire(data.judul, data.pesan, data.status);
        //                     } else {
        //                         Swal.fire(data.judul, data.pesan, data.status);
        //                     }
        //                     return false;
        //                 },
        //                 dataType: 'json'
        //             });
        //         }
        //     });
        // }); //Parameter

        $('a.show_detail').click(function (e) {
            e.preventDefault();
            var uid = $(this).attr("data-uid");
            $.ajax({
                type: "post",
                url: site_backend + '/users/show',
                data: {pid: uid, "_token": csrf_token },
                success: function (data) {
                    if(data.status == 'success'){
                        $('#detail-title').html(data.title);
                        $('#detail-name').val(data.name);
                        $('#detail-email').val(data.email);
                        $('#detail-personil').val(data.personil);
                        $('#detail-role-akses').val(data.role_akses);
                        $('#detail-created-by').val(data.created_by);
                        $('#detail-created-at').val(data.created_at);
                        $('#detail-updated-by').val(data.updated_by);
                        $('#detail-updated-at').val(data.updated_at);
                        $('#detail-is-active').html(data.is_active);
                        $('#detail-is-owner').html(data.is_owner);
                        $('#detail-is-admin-kantor').html(data.is_admin_kantor);
                        $('#detail-is-marketer').html(data.is_marketer);
                        $('#detail-role-personil').html(data.role_personil);
                    }
                    return false;
                },
                dataType: 'json'
            });
            return false;
        }); //Parameter



    };
    var handleAdd = function () {
        $(document).on('click', '#btn-cari-personil', function (e) {
            e.preventDefault();
            var modalCariPersonil = new Custombox.modal({
                content: {
                    effect: 'fadein',
                    target: '#custom-modal'
                }
            });
            modalCariPersonil.open();
            return false;
        });

        $(document).on('click', '#btn-insert-personil', function (e) {
            e.preventDefault();
            var vpersonil = $('#search_personil').val();
            var vnama_lengkap = $('#search_nama_lengkap').val();
            var vno_hp = $('#search_no_hp').val();
            var vemail = $('#search_email').val();

            $('#personil').val(vpersonil);
            $('#nama_personil').val(vnama_lengkap);
            $('#name').val(vnama_lengkap);
            $('#phone').val(vno_hp);
            $('#email').val(vemail);
            $('#div-btn-cari-personil').html('<button id="btn-clear" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can"></i></button>');
            Custombox.modal.close();
            return false;
        });

        document.addEventListener('custombox:overlay:close', function () {
            $('#search_nama_lengkap').val('');
            $('#search_personil').val('');
            $('#search_no_hp').val('');
            $('#search_email').val('');
        });

        $(document).on('click', '#btn-clear', function (e) {
            e.preventDefault();
            $('#personil').val('');
            $('#nama_personil').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#email').val('');
            $('#div-btn-cari-personil').html('<button id="btn-cari-personil" class="btn btn-blue waves-effect waves-light"><i class="mdi mdi-mouse"></i></button>');
            return false;
        });

        document.addEventListener('custombox:overlay:close', function () {
            $('#search_personil').val('');
            $('#search_nama_lengkap').val('');
            $('#search_no_hp').val('');
            $('#search_email').val('');
        });


    };
    return {
        //main function to initiate the module
        init: function () {
            handleView();
            handleAdd();
        }
    };
}();

jQuery(document).ready(function() {
    Module.init();
});
