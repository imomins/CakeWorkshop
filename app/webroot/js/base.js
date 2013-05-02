/**
 * @module base
 */
define(['jquery', 'handlebars'], function ($, Handlebars) {
    "use strict";

    var exporter = {};

    exporter.showError = function (message) {
        var $modal = $('#modalError');
        $modal.find('modal-body').text(message);
        $modal.modal('show');
    };

    /**
     * Show a boostrap alert message at the page top.
     * The params must be passed in as an object literal.
     *
     * @methode showMessage
     * @param params.type can be: 'error', 'success', 'info'. Everthing else will be interpreted as defaul message.
     * @param params.message The actual message that is visible to thse user.
     */
    exporter.showMessage = function (params) {
        var html = '<div ng-style="display:none;" class="alert {{className}}" style="display:none;"><button type="button" class="close" data-dismiss="alert">×</button><p>{{message}}</p></div>',
            template = Handlebars.compile(html),
            $alerts = $('#messages'),
            className = '',
            message;

        switch (params.type) {
        case 'error':
            className = 'alert-error';
            break;
        case 'success':
            className = 'alert-success';
            break;
        case 'info':
            className = 'alert-info';
            break;
        default:
            break;
        }

        message = template({
            "className": className,
            "message"  : params.message
        });
        $alerts.append(message);

        // Show and hide the message
        message.slideDown('fast', function () {
            setTimeout(function () {
                message.slideUp('slow', function () {
                    message.remove();
                });
            }, 2000);
        });
    };

    /**
     *
     * @method highlightCurrentNav
     */
    exporter.highlightCurrentNav = function () {
        $('.navbar').find('li').each(function () {
            var $this = $(this);

            if ($this.data('controller') === CAKEWORKSHOP.controller && $this.data('view') === CAKEWORKSHOP.view) {
                this.className = 'active';
            }
        });
    };

    return exporter;
});