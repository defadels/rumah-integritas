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
    return {
        //main function to initiate the module
        init: function () {
            handleView();
        }
    };
}();

jQuery(document).ready(function() {
    Module.init();
});
