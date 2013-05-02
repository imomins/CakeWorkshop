require(['booking', 'domReady', 'bootstrap-tab'], function (Booking, domReady) {
    "use strict";

    domReady(function () {
        Booking.render({ id: 'tableCourses' });
    });
});