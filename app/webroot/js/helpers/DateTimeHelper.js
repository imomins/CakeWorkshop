define(function () {
    "use strict";

    return {
        prettifySqlTimestamp: function (sqlDatetime) {
            // 2009-08-20 15:22:31
            var parts = sqlDatetime.split(' ');
            var date = parts[0].split('-');

            var dateTime = date[2] + '.' + date[1] + '.' + date[0];

            if (parts.length > 1 && parts[1] !== '00:00:00') {
                var time = parts[1].split(':');
                dateTime += ', ' + time[0] + ':' + time[1] + ' Uhr';
            }
            return dateTime;
        }
    };
});
