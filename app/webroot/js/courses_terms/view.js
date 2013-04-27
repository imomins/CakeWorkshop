require([
    'domReady',
    'ko',
    'viewmodel/CoursesTermViewModel',
    'bootstrap-button'
], function (domReady, ko, CoursesTermViewModel) {
    "use strict";

    domReady(function () {
        var id = +document.getElementById('CoursesTermId').value;
        ko.applyBindings(new CoursesTermViewModel(id), document.getElementById('booking'));
    });
});