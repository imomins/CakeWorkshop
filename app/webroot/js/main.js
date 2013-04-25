require([/*'base', */'jquery', 'bootstrap-collapse', 'bootstrap-dropdown'], function ($, _a, _b) {
    "use strict";

    $('.confirm').click(function () {
        var $this = $(this);
        if (confirm($this.data('confirm'))) {
            var form =
                '<form action="' + $this.data('url') + '" method="POST">' +
                    '<input type="hidden" name="id" value="' + $this.data('id') + '">' +
                '</form>';

            $(form)
                .appendTo($(document.body))
                .submit();
        }
    });
    //
    //    $(function () {
    //        base.highlightCurrentNav();
    //    });
});