require([
    'domReady',
    'ko',
    'viewmodel/AddressViewModel',
    'viewmodel/BookingViewModel',
    'bootstrap-tab',
    'bootstrap-modal',
    'bootstrap-button',
    'bootstrap-alert'
], function (domReady, ko, AddressViewModel, BookingViewModel) {
    "use strict";

    domReady(function () {
        ko.applyBindings(new AddressViewModel(), document.getElementById('address'));
        ko.applyBindings(new BookingViewModel(), document.getElementById('course'));
    });
});