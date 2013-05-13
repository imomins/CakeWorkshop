require(['domReady', 'bookings/admin/ViewModel', 'ko', 'jquery', 'jquery-ui', 'block-ui'], function (domReady, ViewModel, ko, $) {
    "use strict";

    $(document).ajaxStop($.unblockUI);

    domReady(function () {
        // Autocomplete for user and coursesTerm
        $("#user_name").autocomplete({
            minLength: 3,
            source:    function (request, response) {
                $.blockUI({ message: 'Suche...' });

                $.ajax({
                    url:      CAKEWORKSHOP.webroot + 'admin/users/find',
                    data:     { name: $("#user_name").val().trim() },
                    type:     'POST',
                    dataType: 'JSON',
                    success:  function (data) {
                        response($.map(data, function (item) {
                            return {
                                label: item.User.name + ' (' + item.User.email + ')',
                                value: item.User.name,
                                id:    item.User.id
                            };
                        }));
                    }
                });
            },
            select:    function (event, ui) {
                $("#user_id").val(ui.item.id);
                ko.applyBindings(new ViewModel(ui.item.id), document.getElementById('addresses'));
            }
        });

        $("#courses_term_name").autocomplete({
            minLength: 3,
            source:    function (request, response) {
                $.blockUI({ message: 'Suche...' });

                $.ajax({
                    url:      CAKEWORKSHOP.webroot + 'admin/courses_terms/find',
                    data:     { name: $("#courses_term_name").val().trim() },
                    type:     'POST',
                    dataType: 'JSON',
                    success:  function (data) {
                        response($.map(data, function (item) {
                            return {
                                label: 'Kurs-Nr. ' + item.CoursesTerm.id + ', ' + item.Course.name + ', ' + item.Term.name,
                                value: 'Kurs-Nr. ' + item.CoursesTerm.id + ', ' + item.Course.name + ', ' + item.Term.name,
                                id:    item.CoursesTerm.id
                            };
                        }));
                    }
                });
            },
            select:    function (event, ui) {
                $("#courses_term_id").val(ui.item.id);
            }
        });
    });
});