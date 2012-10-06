/**
 * Show a boostrap alert message at the page top.
 * The params must be passed in as an object literal.
 *
 * @param params.type can be: 'error', 'success', 'info'. Everthing else will be interpreted as defaul message.
 * @param params.message The actual message that is visible to thse user.
 */
eLearning.showMessage = function (params) {
    var $alerts = $('#messages');
    var className = '';

    switch(params.type) {
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

    var message = ich.alert({
        "className": className,
        "message": params.message
    });
    $alerts.append(message);

    // Show and hide the message
    message.slideDown('fast', function () {
        setTimeout(function () {
            message.slideUp('fast', function () {
                message.remove();
            });
        }, 2000);
    });
};

/**
 * Please only use one glaobel object "eLearning",
 * it is anyway stupid enought to use it at all.
 */
$(function () {
    // This code uses the navigation li's data property
    // to highlight the current menu item.

    eLearning = eLearning || {};

    eLearning.refs = {
        $nav: $('.navbar')
    };

    eLearning.highlightCurrentNav = function () {
        eLearning.refs.$nav.find('li').each(function () {
            var $this = $(this);

            if ($this.data('controller') === eLearning.controller && $this.data('view') === eLearning.view) {
                this.className = 'active';
            }
        });
    };

    eLearning.init = function () {
        this.highlightCurrentNav();
    };

    eLearning.init();

});