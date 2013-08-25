require(['jquery', 'datepicker'], function ($) {
    'use strict';

    $(function () {
        $('#start,#end').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
});
