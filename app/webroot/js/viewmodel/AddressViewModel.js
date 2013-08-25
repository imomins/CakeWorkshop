define(['ko', 'jquery'], function (ko, $) {
    "use strict";

    function AddressViewModel() {
        var self = this;

        var $address = $('#address');

        this.working = ko.observable(false);
        this.saveCaption = ko.observable('Speichern');

        // List of existing addresses
        this.addresses = ko.observableArray([]);

        // Form
        this.to_person = ko.observable();
        this.address_id = ko.observable();
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
        this.showAddressControls = ko.observable(false);

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
            $.getJSON('addresses/types.json')
                .success(function (data) {
                    var i;
                    for (i = 0; i < data.length; i += 1) {
                        self.types.push(new Type(data[i].Type.display, data[i].Type.name));
                    }
                })
                .error(function (response) {
                    alert($.parseJSON(response.responseText).name);
                });

            $.getJSON('addresses.json')
                .success(function (data) {
                    var i;

                    for (i = 0; i < data.length; i += 1) {
                        self.addresses.push(data[i].Address);
                        self.showAddressControls(data.length > 0);
                    }
                    // Just load the first address as default if is exists
                    if (data.length > 0) {
                        self.load(undefined, undefined, data[0].Address.id);
                    }
                })
                .error(function (response) {
                    alert($.parseJSON(response.responseText).name);
                });
        };

        this.add = function () {
            form.clear();
            $address.first('.existing-address').find('button').removeClass('active');
            $address.find('.add-address').addClass('active');
            self.show(true);
            self.loaded(false);
        };

        /**
         * Loads an address.
         * @param data
         * @param event
         * @param address_id
         */
        this.load = function (data, event, address_id) {
            self.working(true);
            var id = address_id || $(event.target).data('id');

            $.getJSON('addresses/view/' + id)
                .success(function (response) {
                    self.address_id(response.Address.id);
                    self.institution(response.Address.institution);
                    self.department(response.Address.department);
                    self.postbox(response.Address.postbox);
                    self.to_person(response.Address.to_person);
                    self.zip(response.Address.zip);
                    self.street(response.Address.street);
                    self.location(response.Address.location);
                    self.type_name(response.Address.type_name);

                    self.loaded(true);
                    self.show(true);

                    self.toggleType();
                    $address.find('.add-address').removeClass('active');
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

            var url = 'addresses/add.json';
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
                url = 'addresses/edit.json';
                postData.address_id = self.address_id();
            }

            $.post(url, postData)
                .success(function (data) {
                    var address = $.parseJSON(data).Address;

                    // If it's new
                    if (!self.loaded()) {
                        self.addresses.push(address);
                        self.loaded(true);
                        self.address_id(address.id);
                    }
                    self.saveCaption('Gespeichert');
                    setTimeout(function () {
                        self.saveCaption('Speichern');
                        self.working(false);
                    }, 2000);
                    self.showAddressControls(true);
                })
                .error(function (response) {
                    alert($.parseJSON(response.responseText).name);
                });
        };

        this.destroy = function () {
            self.working(true);
            $.post('addresses/delete.json', { id: self.address_id() })
                .success(function (data) {
                    self.addresses.remove(function (address) {
                        return address.id === self.address_id();
                    });
                    self.show(false);
                    self.working(false);
                })
                .error(function (response) {
                    // A constraint prevents deleting associated addresses, we catch that
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

    return AddressViewModel;
});