require([
    'domReady',
    'ko',
    'InvoiceViewModel',
    'bootstrap-tab',
    'bootstrap-modal',
    'bootstrap-button',
    'bootstrap-alert'
], function (domReady, ko, InvoiceViewModel) {
    "use strict";

    domReady(function () {
        ko.applyBindings(new InvoiceViewModel(), document.getElementById('invoice'));
    });
});