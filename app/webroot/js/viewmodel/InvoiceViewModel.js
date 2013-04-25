define(['ko', 'jquery'], function (ko, $) {
    "use strict";

    function InvoiceViewModel() {
        var self = this;

        this.working = ko.observable(false);
        this.saveCaption = ko.observable('Speichern');

        // List of existing invoices
        this.invoices = ko.observableArray([]);

        // Form
        this.to_person = ko.observable();
        this.invoice_id = ko.observable();
        this.street = ko.observable();
        this.postbox = ko.observable();
        this.institution = ko.observable();
        this.department = ko.observable();
        this.zip = ko.observable();
        this.location = ko.observable();
        this.type_name = ko.observable();
        this.types = ko.observableArray([]);

        // Visibility
        this.show = ko.observable(true);
        this.loaded = ko.observable(false);
        this.business = ko.observable(true);
        this.private = ko.observable(true);
        this.showInvoiceControls = ko.observable(false);

        /**
         * Form specific methods.
         * @private
         */
        var form = {
            toggleVisibility: function () {
                self.show(!self.show());
            },
            clear:            function () {
                self.institution('');
                self.department('');
                self.postbox('');
                self.zip('');
                self.street('');
                self.location('');
                self.to_person('');
            }
        };

        function Type(name, value) {
            this.name = name;
            this.value = value;
        }

        this.fetch = function () {
            // Load form data
            $.getJSON('invoices/types.json')
                .success(function (data) {
                    var i;
                    for (i = 0; i < data.length; i += 1) {
                        self.types.push(new Type(data[i].Type.display, data[i].Type.name));
                    }
                })
                .error(function (response) {
                    alert($.parseJSON(response.responseText).name);
                });

            $.getJSON('invoices.json')
                .success(function (data) {
                    var i;
                    for (i = 0; i < data.length; i += 1) {
                        self.invoices.push(data[i].Invoice);
                        self.showInvoiceControls(data.length > 0);
                    }
                    // Just load the first invoice as default if is exists
                    if (data.length > 0) {
                        self.load(undefined, undefined, data[0].Invoice.id);
                    }
                })
                .error(function (response) {
                    alert($.parseJSON(response.responseText).name);
                });
        };

        this.add = function () {
            form.clear();
            self.show(true);
            self.loaded(false);
        };

        /**
         * Loads an invoice.
         * @param data
         * @param event
         * @param invoice_id
         */
        this.load = function (data, event, invoice_id) {
            self.working(true);
            var id = invoice_id || $(event.target).data('id');

            $.getJSON('invoices/view/' + id)
                .success(function (response) {
                    self.invoice_id(response.Invoice.id);
                    self.institution(response.Invoice.institution);
                    self.department(response.Invoice.department);
                    self.postbox(response.Invoice.postbox);
                    self.to_person(response.Invoice.to_person);
                    self.zip(response.Invoice.zip);
                    self.street(response.Invoice.street);
                    self.location(response.Invoice.location);
                    self.type_name(response.Invoice.type_name);

                    self.loaded(true);
                    self.show(true);

                    self.toggleType();
                    self.working(false);
                })
                .error(function (response) {
                    alert($.parseJSON(response.responseText).name);
                    self.working(false);
                });
        };

        /**
         * Start saving. There's a catch: This method saves new records
         * and updates existing records, to there is a case.
         * @param element
         */
        this.save = function (element) {
            this.working(true);
            this.saveCaption('Speichere, bitte warten...');

            var url = 'invoices/add.json';
            var postData = {
                type_name:   self.type_name(),
                institution: self.institution() || '',
                department:  self.department() || '',
                postbox:     self.postbox() || '',
                to_person:   self.to_person() || '',
                zip:         self.zip(),
                street:      self.street(),
                location:    self.location()
            };

            // Update if already loaded
            if (this.loaded()) {
                url = 'invoices/edit.json';
                postData.invoice_id = self.invoice_id();
            }

            $.post(url, postData)
                .success(function (data) {
                    var invoice = $.parseJSON(data).Invoice;

                    // If it's new
                    if (!self.loaded()) {
                        self.invoices.push(invoice);
                        self.loaded(true);
                        self.invoice_id(invoice.id);
                    }
                    self.saveCaption('Gespeichert');
                    setTimeout(function () {
                        self.saveCaption('Speichern');
                        self.working(false);
                    }, 2000);
                    self.showInvoiceControls(true);
                })
                .error(function (response) {
                    alert($.parseJSON(response.responseText).name);
                });
        };

        this.destroy = function () {
            self.working(true);
            $.post('invoices/delete.json', { id: self.invoice_id() })
                .success(function (data) {
                    self.invoices.remove(function (invoice) {
                        return invoice.id === self.invoice_id();
                    });
                    self.show(false);
                    self.working(false);
                })
                .error(function (response) {
                    // A constraint prevents deleting associated invoices, we catch that
                    var error = $.parseJSON(response.responseText).name;

                    if (error.indexOf('Integrity constraint') !== -1) {
                        alert('Diese Rechnung wurde bereits für Buchungen verwendet und kann daher nicht gelöscht werden.');
                    } else {
                        alert(error);
                    }
                    self.working(false);
                });
        };

        this.cancel = function () {
            form.toggleVisibility();
        };

        this.toggleType = function () {
            this.private(this.type_name() === 'private');
            this.business(this.type_name() === 'business');
        };

        // Go go Gadgeto form data...
        this.fetch();
    }

    return InvoiceViewModel;
});