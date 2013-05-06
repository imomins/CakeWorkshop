require(['domReady', 'jquery', 'bootstrap-collapse', 'bootstrap-dropdown'], function (domReady, $) {
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

    domReady(function () {
        $('.navbar').find('li').each(function () {
            var $this = $(this);
            var controllers = $this.data('controller') ? $this.data('controller').split('|') : [];

            if ($.inArray(CAKEWORKSHOP.controller, controllers) !== -1) {
                $this.addClass('active');
            }
        });
    });
});