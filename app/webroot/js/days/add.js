require(['domReady', 'jquery', 'datepicker'], function (domReady, $) {
    "use strict";

    domReady(function () {
        $("#date").datepicker();
        $("#date").datepicker("option", "dateFormat", 'yy-mm-dd');
    });
});