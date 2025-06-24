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


    };
    var handleUpdate = function () {

        $(document).on('change', '#kab', function(e) {
            e.preventDefault();
            var uid = $('#kab').val();
            $.ajax({
                type: "post",
                url: site+'/master/list',
                data: {pid: uid, tipe:'kec' },
                success: function (data) {
                    $('#kec').html(data.hasil);
                    return false;
                },
                dataType: 'json'
            });
            console.warn(uid);
            return false;
        });

        $(document).on('change', '#kec', function(e) {
            e.preventDefault();
            var uid = $('#kec').val();
            $.ajax({
                type: "post",
                url: site+'/master/list',
                data: {pid: uid, tipe:'kel' },
                success: function (data) {
                    $('#kel').html(data.hasil);
                    return false;
                },
                dataType: 'json'
            });
            console.warn(uid);
            return false;
        });

        $(document).on('change', '#kel', function(e) {
            e.preventDefault();
            var uid = $('#kel').val();
            $.ajax({
                type: "post",
                url: site+'/master/list',
                data: {pid: uid, tipe:'tps' },
                success: function (data) {
                    $('#tps').html(data.hasil);
                    return false;
                },
                dataType: 'json'
            });
            console.warn(uid);
            return false;
        });

    };
    return {
        //main function to initiate the module
        init: function () {
            handleView();
            handleUpdate();
        }
    };
}();

jQuery(document).ready(function() {
    Module.init();
});