define(['ko', 'jquery'], function (ko, $) {
    "use strict";

    function ViewModel(user_id) {
        var self = this;

        this.invoices = ko.observableArray([]);
        this.invoice_id = ko.observable('');
        this.hasInvoice = ko.observable(false);
        this.allowAdd = ko.observable(true);

        this.selectedItem = function () {
            var self = this;
            return ko.utils.arrayFirst(self.invoices(), function (item) {
                return self.invoice_id() === item.value;
            });
        }.bind(this);

        this.add = function () {
            window.location = CAKEWORKSHOP.webroot + 'admin/invoices/add/' + user_id;
        };

        this.edit = function () {
            window.location = CAKEWORKSHOP.webroot + 'admin/invoices/edit/' + self.selectedItem().value;
        };

        function Invoice(invoice) {
            var name = invoice.Type.display,
                key;

            // Build the label for the select box
            if (invoice.Invoice.type_name === 'private') {
                for (key in invoice.Invoice) {
                    if ($.inArray(key, ['street', 'location', 'zip', 'id']) === -1) {
                        delete invoice.Invoice[key];
                    }
                }
            } else if (invoice.Invoice.type_name === 'business') {
                for (key in invoice.Invoice) {
                    if ($.inArray(key, ['id', 'institution', 'department', 'street', 'postbox', 'to_person', 'location', 'zip']) === -1) {
                        delete invoice.Invoice[key];
                    }
                }
            }

            for (key in invoice.Invoice) {
                if ($.trim(invoice.Invoice[key]) !== '') {
                    name += ', ' + invoice.Invoice[key];
                }
            }

            this.name = name;
            this.value = invoice.Invoice.id;
        }

        $.getJSON(CAKEWORKSHOP.webroot + 'admin/invoices/index/' + user_id)
            .success(function (invoices) {
                var i;

                self.invoices.removeAll();

                for (i = 0; i < invoices.length; i += 1) {
                    var invoice = invoices[i];

                    self.invoices.push(new Invoice(invoice));
                }
                self.hasInvoice(invoices.length > 0);
            });
    }

    return ViewModel;
});