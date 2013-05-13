require(['domReady', 'jquery', 'datepicker'], function (domReady, $) {
    'use strict';

    domReady(function () {
        $('#start,#end').each(function () {
            $(this)
                .datepicker()
                .datepicker('option', 'dateFormat', 'yy-mm-dd');
        });
    });
});
