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

        $('a.delete_row').click(function (e) {
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
                        url: site_backend + '/dapodik/sekolah-adm/delete',
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
        }); //Parameter

        $('#delete_all').click(function (e) {
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
                        url: site_backend + '/dapodik/sekolah-adm/delete-all',
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
        }); //Parameter

    };
    var handleAdd = function () {



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
