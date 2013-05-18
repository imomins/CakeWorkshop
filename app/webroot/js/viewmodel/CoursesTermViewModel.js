define(['ko', 'errorHandler', 'jquery', 'block-ui', 'logger'], function (ko, errorHandler, $, blockui, logger) {
    "use strict";

    $(document).ajaxStop($.unblockUI);

    function CoursesTermViewModel(id) {
        var self = this;
        this.id = id;

        // All booking types are represented in this
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
         * Traverses all element of bookings array and checks which one is selected.
         * @returns {Array}
         */
        function getSelectedIds() {
            var type,
                i,
                selected = [];

            for (type in self.bookings) {
                var bookings = self.bookings[type]();
                for (i = 0; i < bookings.length; i += 1) {
                    if (bookings[i].checked()) {
                        selected.push(bookings[i].Booking.id);
                    }
                }
            }

            return selected;
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

                    logger.log('Status der Buchung mit Id %s gesetzt auf %s', trData.id, status);
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
                        logger.log('Buchung gelöscht, Id: %s', trData.id);
                    })
                    .error(function (response) {
                        errorHandler.showAjaxError(response);
                    });
            }
        };

        /**
         * Selected a groups of bookings types.
         * @param type
         */
        function selectAll(type, checked) {
            var bookings = self.bookings[type](),
                i;

            for (i = 0; i < bookings.length; i += 1) {
                bookings[i].checked(checked);
            }
        }

        this.selectAllUnconfirmed = ko.observable(false);
        this.selectAllUnconfirmed.subscribe(function (checked) {
            selectAll('unconfirmed', checked);
        });

        this.selectAllSelfUnsubscribed = ko.observable(false);
        this.selectAllSelfUnsubscribed.subscribe(function (checked) {
            selectAll('self_unsubscribed', checked);
        });

        this.selectAllAdminUnsubscribed = ko.observable(false);
        this.selectAllAdminUnsubscribed.subscribe(function (checked) {
            selectAll('admin_unsubscribed', checked);
        });

        this.selectAllConfirmed = ko.observable(false);
        this.selectAllConfirmed.subscribe(function (checked) {
            selectAll('confirmed', checked);
        });

        this.selectAllCleared = ko.observable(false);
        this.selectAllCleared.subscribe(function (checked) {
            selectAll('cleared', checked);
        });

        /**
         * Moves a given list of booking ids to another CoursesTerm.
         * @param data
         * @param event
         */
        this.move = function (data, event) {
            var ids = getSelectedIds();

            if (ids.length > 0) {
                $.post(CAKEWORKSHOP.webroot + 'admin/bookings/move', { ids: ids });
            }
        };

        /**
         * Gets data from server.
         */
        this.fetch = (function () {
            $.blockUI({ message: 'Lade, bitte warten...' });

            $.getJSON(CAKEWORKSHOP.webroot + 'admin/courses_terms/view/' + self.id + '.json')
                .success(function (data) {
                    var i,
                        key;

                    data = data.bookings;

                    for (i = 0; i < data.length; i += 1) {
                        data[i].checked = ko.observable(false);
                        self.bookings[data[i].BookingState.name].push(data[i]);
                    }

                    $.unblockUI();
                });
        }());
    }

    return CoursesTermViewModel;
});