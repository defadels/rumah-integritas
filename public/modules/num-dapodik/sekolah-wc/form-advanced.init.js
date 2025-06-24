!function ($) {
    "use strict";

    var FormAdvanced = function FormAdvanced() {
    };

    //initializing Slimscroll
    FormAdvanced.prototype.initSwitchery = function () {
        $('[data-plugin="switchery"]').each(function (idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
    },

        //initilizing
        FormAdvanced.prototype.init = function () {
            var $this = this;
            this.initSwitchery();
        },
        $.FormAdvanced = new FormAdvanced(), $.FormAdvanced.Constructor = FormAdvanced;
}(window.jQuery), //initializing main application module
    function ($) {
        "use strict";

        $.FormAdvanced.init();
    }(window.jQuery);
