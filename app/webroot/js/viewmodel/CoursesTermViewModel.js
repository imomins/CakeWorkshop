define(['ko', 'jquery'], function (ko, $) {
    "use strict";

    function CoursesTermViewModel(id) {
        var self = this;
        this.id = id;

        this.bookings = {
            unconfirmed:        { data: ko.observableArray(), hasChildren: ko.observable(false) },
            self_unsubscribed:  { data: ko.observableArray(), hasChildren: ko.observable(false) },
            admin_unsubscribed: { data: ko.observableArray(), hasChildren: ko.observable(false) },
            confirmed:          { data: ko.observableArray(), hasChildren: ko.observable(false) },
            cleared:            { data: ko.observableArray(), hasChildren: ko.observable(false) }
        };

        function getId(event) {
            return $(event.target).closest('tr').data('id');
        }

        this.cleared = function () {
            alert(getId(event));
        };

        this.unsubscribe = function (data, event) {
            alert(getId(event));
        };

        this.confirm = function (data, event) {
            alert(getId(event));
        };

        this.edit = function (data, event) {
            alert(getId(event));
        };

        this.remove = function (data, event) {
            alert(getId(event));
        };

        this.removeAll = function () {
            for (var name in self.bookings) {
                self.bookings[name].data.removeAll();
                self.bookings[name].hasChildren(false);
            }
        };

        this.fetch = (function () {
            $.getJSON(CAKEWORKSHOP.webroot + 'admin/courses_terms/view/' + self.id)
                .success(function (data) {
                    var i,
                        key;

                    self.removeAll();
                    for (i = 0; i < data.length; i += 1) {
                        self.bookings[data[i].BookingState.name].data.push(data[i]);
                    }
                    // For views to toggle empty areas
                    for (key in self.bookings) {
                        self.bookings[key].hasChildren(self.bookings[key].data().length > 0);
                    }
                });
        }());
    }

    return CoursesTermViewModel;
});