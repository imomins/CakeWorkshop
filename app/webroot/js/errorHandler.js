define(['jquery'], function ($) {
    "use strict";

    var expose = {},
        $modal = $('#modalError'),
        $body = $modal.find('modal-body');

    function getError() {
        return $body.text();
    }

    function setError(message) {
        $body.text(message);
    }

    expose.showError = function (message) {
        setError(message);
        $modal.modal('show');
    };

    expose.submitError = function (message, callback) {
        $.ajax({
            type:    'POST',
            url:     CAKEWORKSHOP.webroot + 'users/error',
            data:    {message: message},
            success: function (response) {
                if (typeof callback === 'function') {
                    callback(response);
                }
            },
            error:   function (error) {
                expose.showError(error.name);
            }
        });
    };

    expose.showAjaxError = function (response) {
        expose.showError($.parseJSON(response.responseText).name);
    };

    return expose;
});