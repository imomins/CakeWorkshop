define(['ko', 'errorHandler', 'jquery', 'block-ui'], function (ko, errorHandler, $, blockui) {
    "use strict";

    $(document).ajaxStop($.unblockUI);

    function CoursesTermViewModel(id) {
        var self = this;
        this.id = id;

        this.bookings = {
            unconfirmed:        ko.observableArray(),
            self_unsubscribed:  ko.observableArray(),
            admin_unsubscribed: ko.observableArray(),
            confirmed:          ko.observableArray(),
            cleared:            ko.observableArray()
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
            $.blockUI({ message: 'Speichere...' });

            var trData = getData(event);
            var id = getId(event);

            $.post(CAKEWORKSHOP.webroot + 'admin/bookings/status/' + status + '/' + trData.id)
                .success(function (response) {
                    // Old status position, returns an Array with one element
                    var item = self.bookings[trData.type].remove(function (item) {
                        return parseInt(item.Booking.id, 10) === id;
                    });
                    item = item[0];

                    // New Status
                    item.BookingState.name = status;

                    // Target status position
                    self.bookings[status].push(item);

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
                        self.bookings[trData.type].remove(function (item) {
                            return parseInt(item.Booking.id, 10) === trData.id;
                        });
                        console.log('Buchung gelöscht, Id: ' + trData.id);
                    })
                    .error(function (response) {
                        errorHandler.showAjaxError(response);
                    });
            }
        };

        this.fetch = (function () {
            $.blockUI({ message: 'Lade, bitte warten...' });

            $.getJSON(CAKEWORKSHOP.webroot + 'admin/courses_terms/view/' + self.id)
                .success(function (data) {
                    var i,
                        key;

                    for (i = 0; i < data.length; i += 1) {
                        self.bookings[data[i].BookingState.name].push(data[i]);
                    }

                    $.unblockUI();
                });
        }());
    }

    return CoursesTermViewModel;
});