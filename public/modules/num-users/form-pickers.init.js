!function (t) {
    "use strict";

    function e() {
    }

    e.prototype.init = function () {
        t("#basic-datepicker").flatpickr(), t("#datetime-datepicker").flatpickr({
            enableTime: !0,
            dateFormat: "Y-m-d H:i"
        }), t("#humanfd-datepicker").flatpickr({
            altInput: !0,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d"
        }), t("#minmax-datepicker").flatpickr({
            minDate: "2020-01",
            maxDate: "2020-03"
        }), t("#disable-datepicker").flatpickr({
            onReady: function () {
                this.jumpToDate("2025-01")
            }, disable: ["2025-01-10", "2025-01-21", "2025-01-30", new Date(2025, 4, 9)], dateFormat: "Y-m-d"
        }), t("#multiple-datepicker").flatpickr({
            mode: "multiple",
            dateFormat: "Y-m-d"
        }), t("#conjunction-datepicker").flatpickr({
            mode: "multiple",
            dateFormat: "Y-m-d",
            conjunction: " :: "
        }), t("#range-datepicker").flatpickr({mode: "range"}), t("#inline-datepicker").flatpickr({inline: !0}), t("#basic-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i"
        }), t("#24hours-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i",
            time_24hr: !0
        }), t("#minmax-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i",
            minDate: "16:00",
            maxDate: "22:30"
        }), t("#preloading-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i",
            defaultDate: "01:45"
        }), t("#colorpicker-default").spectrum(), t("#colorpicker-showalpha").spectrum({showAlpha: !0}), t("#colorpicker-showpaletteonly").spectrum({
            showPaletteOnly: !0,
            showPalette: !0,
            palette: [["#3bafda", "white", "#675aa9", "rgb(255, 128, 0);", "#f672a7"], ["red", "yellow", "green", "blue", "violet"]]
        }), t("#colorpicker-togglepaletteonly").spectrum({
            showPaletteOnly: !0,
            togglePaletteOnly: !0,
            togglePaletteMoreText: "more",
            togglePaletteLessText: "less",
            palette: [["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"], ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"], ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"], ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"], ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"], ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"], ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"], ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]]
        }), t("#colorpicker-showintial").spectrum({showInitial: !0}), t("#colorpicker-showinput-intial").spectrum({
            showInitial: !0,
            showInput: !0
        }), t(".clockpicker").clockpicker({donetext: "Done"}), t("#single-input").clockpicker({
            placement: "bottom",
            align: "left",
            autoclose: !0,
            default: "now"
        }), t("#check-minutes").click(function (e) {
            e.stopPropagation(), t("#single-input").clockpicker("show").clockpicker("toggleView", "minutes")
        })
    }, t.FormPickers = new e, t.FormPickers.Constructor = e
}(window.jQuery), function () {
    "use strict";
    window.jQuery.FormPickers.init()
}();
