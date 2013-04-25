require([
    'domReady',
    'ko',
    'viewmodel/InvoiceViewModel',
    'viewmodel/BookingViewModel',
    'bootstrap-tab',
    'bootstrap-modal',
    'bootstrap-button',
    'bootstrap-alert'
], function (domReady, ko, InvoiceViewModel, BookingViewModel) {
    "use strict";

    domReady(function () {
        ko.applyBindings(new InvoiceViewModel(), document.getElementById('invoice'));
        ko.applyBindings(new BookingViewModel(), document.getElementById('course'));
    });
});