require(['ko', 'viewmodel/BookingViewModel', 'jquery', 'bootstrap-tab'], function (ko, BookingViewModel, $) {
    "use strict";

    var loaded = false;

    $('#tabCourse').click(function (event) {
        if (loaded) {
            return;
        }
        event.preventDefault();
        ko.applyBindings(new BookingViewModel(), document.getElementById('course'));

        $(this).tab('show');

        loaded = true;
    });
});