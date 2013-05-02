define(['ko', 'errorHandler', 'jquery', 'block-ui'], function (ko, errorHandler, $, blockui) {
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

        function getElement(event) {
            return $(event.target).closest('tr');
        }

        function getId(event) {
            return getElement(event).data('id');
        }

        /**
         * Returns the current tr's data-id and data-type attributes as object.
         * @param event
         * @returns {{id: *, type: *}}
         */
        function getData(event) {
            var $el = getElement(event);

            return {
                id:   $el.data('id'),
                type: $el.data('type')
            };
        }

        /**
         * Does three things:
         * 1. Changes the status as specified.
         * 2. Removes the element from the original status array.
         * 3. Add the removed item to the new status array.
         * @param event
         * @param status
         */
        function changeStatus(event, status) {
            var trData = getData(event);

            $.post(CAKEWORKSHOP.webroot + 'admin/bookings/status/' + status + '/' + trData.id)
                .success(function () {
                    // Old status position
                    var item = self.bookings[trData.type].data.remove(function (item) {
                        return parseInt(item.Booking.id, 10) === id;
                    });
                    // Target status position
                    self.bookings[status].data.push(item);

                    console.log('Status der Buchung mit Id "' + trData.id + '" gesetzt auf "' + status + '"');
                })
                .error(function (response) {
                    errorHandler.showAjaxError(response);
                });
        }

        this.cleared = function (data, event) {
            changeStatus(event, 'cleared');
        };

        this.unsubscribe = function (data, event) {
            changeStatus(event, 'admin_unsubscribed');
        };

        this.confirm = function (data, event) {
            changeStatus(event, 'confirmed');
        };

        this.edit = function (data, event) {
            window.location = CAKEWORKSHOP.webroot + 'admin/bookings/edit/' + getId(event);
        };

        this.remove = function (data, event) {
            var trData = getData(event);

            if (confirm('Soll die Buchung komplett gelöscht werden?')) {
                $.post(CAKEWORKSHOP.webroot + 'admin/bookings/delete/' + trData.id)
                    .success(function (response) {
                        self.bookings[trData.type].data.remove(function (item) {
                            return parseInt(item.Booking.id, 10) === trData.id;
                        });
                        console.log('Buchung gelöscht, Id: ' + trData.id);
                    })
                    .error(function (response) {
                        errorHandler.showAjaxError(response);
                    });
            }
        };

        this.removeAll = function () {
            var name;

            for (name in self.bookings) {
                self.bookings[name].data.removeAll();
                self.bookings[name].hasChildren(false);
            }
        };

        this.fetch = (function () {
            $.blockUI({ message: 'Lade, bitte warten...' });

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

                    $.unblockUI();
                });
        }());
    }

    return CoursesTermViewModel;
});