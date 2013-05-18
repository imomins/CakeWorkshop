define(function () {
    "use strict";

    return {
        log: function log() {
            // Convert arguments to an array
            var args = Array.prototype.slice.call(arguments),
                message = args[0];

            // Replace all %s by following arguments
            if (typeof message === 'string' && message.indexOf('%s') !== -1 && args.length > 1) {
                var i;
                for (i = 1; i < args.length; i += 1) {
                    message = message.replace(/%s/, args[i]);
                }
            }

            if (window.console) {
                console.log(message);
                /* Firebug */
            } else if (typeof Debug === 'object') {
                Debug.writeln(message);
                /* IE */
            } else if (typeof opera === 'opera') {
                opera.postError(message);
                /* Opera */
            }
        }
    };
});
