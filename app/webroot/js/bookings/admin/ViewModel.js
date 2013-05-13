define(['ko', 'jquery'], function (ko, $) {
    "use strict";

    function ViewModel(user_id) {
        var self = this;

        this.addresses = ko.observableArray([]);
        this.address_id = ko.observable('');
        this.hasAddress = ko.observable(false);
        this.allowAdd = ko.observable(true);

        this.selectedItem = function () {
            var self = this;
            return ko.utils.arrayFirst(self.addresses(), function (item) {
                return self.address_id() === item.value;
            });
        }.bind(this);

        this.add = function () {
            window.location = CAKEWORKSHOP.webroot + 'admin/addresses/add/' + user_id;
        };

        this.edit = function () {
            window.location = CAKEWORKSHOP.webroot + 'admin/addresses/edit/' + self.selectedItem().value;
        };

        function Address(address) {
            var name = address.Type.display,
                key;

            // Build the label for the select box
            if (address.Address.type_name === 'private') {
                for (key in address.Address) {
                    if ($.inArray(key, ['street', 'location', 'zip', 'id']) === -1) {
                        delete address.Address[key];
                    }
                }
            } else if (address.Address.type_name === 'business') {
                for (key in address.Address) {
                    if ($.inArray(key, ['id', 'institution', 'department', 'street', 'postbox', 'to_person', 'location', 'zip']) === -1) {
                        delete address.Address[key];
                    }
                }
            }

            for (key in address.Address) {
                if ($.trim(address.Address[key]) !== '') {
                    name += ', ' + address.Address[key];
                }
            }

            this.name = name;
            this.value = address.Address.id;
        }

        $.getJSON(CAKEWORKSHOP.webroot + 'admin/addresses/index/' + user_id)
            .success(function (addresses) {
                var i;

                self.addresses.removeAll();

                for (i = 0; i < addresses.length; i += 1) {
                    var address = addresses[i];

                    self.addresses.push(new Address(address));
                }
                self.hasAddress(addresses.length > 0);
            });
    }

    return ViewModel;
});