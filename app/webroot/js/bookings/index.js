define(['jquery', 'base', 'bootstrap-modal', 'bootstrap-button', 'bootstrap-alert'], function ($, BASE, _a, _b, _c) {
    "use strict";

    var exporter = {};

    var $selector = {
            $btnInvoice      : $('#btnInvoice'),
            $groupInvoice    : $('.groupInvoice'),
            $btnCancelInvoice: $('#btnCancelInvoice'),
            $formInvoice     : $('.form-invoice'),
            $businessGroup   : $('.business'),
            $invoiceType     : $('#invoice'),
            Invoice          : {
                $inputType    : $('#inputType'),
                $businessGroup: $('.business'),
                $termId       : $('#term_id')
            }
        };

    function toggleInvoiceForm() {
        $selector.$groupInvoice.toggle();
    }

    function toggleInvoiceType() {
        var group = $selector.Invoice.$businessGroup;

        group.toggle();
        // The business group doesn't need validation if is hidden
        group.find('input').attr('required', group.is(':visible'));
    }

    function addInvoice(params, callback) {
        $selector.$invoiceType.append(
            $('<option></option>').val(params.value).html(params.name)
        );
        callback();
    }

    function selectInvoice(val) {
        $("#invoid_id option[value='" + val + "']").attr('selected', 'selected');
    }

    function resetForm() {
        $selector.$formInvoice[0].reset();
        $selector.$businessGroup.show();
    }

    function toggle(event) {
        event.preventDefault();
        toggleInvoiceForm();
        return false;
    }

    exporter.initialize = function () {

        $selector.$btnInvoice.click(function (event) {
            return toggle(event);
        });

        $selector.$btnCancelInvoice.click(function (event) {
            resetForm();
            return toggle(event);
        });

        $selector.Invoice.$inputType.change(function (event) {
            $selector.Invoice.toggleInvoiceType();
        });

        $selector.Invoice.$termId.change(function (event) {
            window.location = CAKEWORKSHOP.webroot + CAKEWORKSHOP.controller + '/' + CAKEWORKSHOP.action + '/' + this.value;
        });

        $('.table td.check a').click(function () {
            var $this = $(this),
                $tr = $this.closest('tr'),
                $checkbox = $this.parent('.check').find('input');

            if (!$this.hasClass('active')) {
                $tr.addClass('info');
                $checkbox.prop('checked', true);
            } else {
                $tr.removeClass('info');
                $checkbox.prop('checked', false);
            }
        });

        $('#formBooking').submit(function (event, confirmed) {
            if (!confirmed) {
                event.preventDefault();

                var $checked = $('table td.check a.active');
                if ($checked.length === 0) {
                    $('#invalid').modal('show');
                } else {
                    var $confirm = $('#confirm'),
                        html = '';

                    $checked.each(function () {
                        var name = $(this).closest('tr').find('td.course-name').html();
                        html += '<li>' + name + '</li>';
                    });
                    $confirm.find('.modal-body ol').html(html);
                    $confirm.modal('show');
                }
                return false;
            }
        });

        $selector.$formInvoice.submit(function (event) {
            event.preventDefault();

            var $this = $(this);

            $.ajax({
                type   : 'POST',
                url    : this.action + '.json',
                data   : $this.serialize(),
                success: function (data) {
                    var obj = JSON.parse(data);

                    if (typeof obj === 'object') {
                        // Add and select new invoice type
                        addInvoice({value: obj.id, name: obj.name}, function () {
                            selectInvoice(obj.id);
                        });

                        BASE.showMessage({ type: 'success', message: obj.message });

                        toggleInvoiceForm();
                        resetForm();
                    }
                }
            });

            return false;
        });

    };

    return exporter;
});