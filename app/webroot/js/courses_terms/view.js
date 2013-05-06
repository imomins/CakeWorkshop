require([
    'domReady',
    'ko',
    'viewmodel/CoursesTermViewModel',
    'bootstrap-button'
], function (domReady, ko, CoursesTermViewModel) {
    "use strict";

    domReady(function () {
        var id = +document.getElementById('CoursesTermId').value,
            coursesTerm = new CoursesTermViewModel(id),
            counter = document.getElementById('attendeesCount');

        ko.applyBindings(coursesTerm, document.getElementById('booking'));

        // Attendees counter update...
        coursesTerm.bookings.confirmed.subscribe(function (booking) {
            counter.innerHTML = coursesTerm.bookings.confirmed().length;
        });
    });
});