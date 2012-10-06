<p class="lead"><?php echo __('Kursverwaltung'); ?></p>
<br />

<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo __('Meine belegten Kurse'); ?></a></li>
        <li><a href="#tab2" data-toggle="tab"><?php echo __('Noch verfügbare Kurse'); ?></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <!--
            <?php
            echo $this->Form->create('Booking', array('action' => 'index', 'class' => 'form-inline'));
            echo $this->Form->input('term_id', array('value' => $term_id,'id' => 'term_id', 'empty' => true, 'label' => __('Nach Semester filtern'), 'style' => 'margin-left:5px;'));
            echo $this->Form->end();
            ?>
            -->
            <?php echo $this->element('tables/bookings'); ?>
        </div>

        <div class="tab-pane" id="tab2">
            <div class="alert alert-info">
                <button data-dismiss="alert" class="close" type="button">×</button>

                <p><strong>Hinweis zur Anmeldung bei ausgebuchten Workshops</strong></p>
                <br/>

                <p>Vielen Dank für Ihr Interesse an unserem Workshopangebot. Auch wenn Workshops ausgebucht sind, melden Sie sich
                    bitte trotzdem an. Oft werden noch Plätze über die Warteliste frei bzw. bei großem Interesse bieten wir auch
                    Wiederholungstermine für einzelne Workshops an.</p>
            </div>
            <hr />

            <?php echo $this->Form->create('Booking', array('action' => 'index', 'class' => 'form-inline formInvoice')); ?>
            <label class="input">
                <?php echo __('Rechnung für diese Buchung'); ?>
                <?php echo $this->Form->input('invoice_id', array('div' => false, 'id' => 'invoice', 'label' => false, 'style' => 'margin-left:5px;')); ?>
            </label>
            <?php echo $this->Form->input(__('Rechnungsvorlage anlegen'), array('type' => 'button', 'div' => false, 'id' => 'btnInvoice', 'class' => 'btn btn-small', 'label' => false, 'style' => 'margin-left:5px;')); ?>
            <?php echo $this->Form->end(); ?>

            <div class="groupInvoice" style="display:none;">
                <?php echo $this->element('forms/invoice'); ?>
            </div>
            <hr />

            <?php echo $this->element('tables/courses_by_category', array($coursesByCategory, 'form' => true)); ?>
        </div><!-- tab-content -->

    </div><!-- tab-content -->

</div><!-- tabbable -->

<style>
.formInvoice label, .formInvoice form {
    margin:0 !important;
}
</style>

<script>
$(function () {
    'use strict';

    var Booking = Booking || {};

    // REFERENCES
    Booking.refs = {
        $btnInvoice: $('#btnInvoice'),
        $groupInvoice: $('.groupInvoice'),
        $btnCancelInvoice: $('#btnCancelInvoice'),
        $formInvoice: $('.form-invoice'),
        $businessGroup: $('.business'),
        $invoiceType: $('#invoice')
    };

    // METHODS
    Booking.toggleInvoiceForm = function () {
        Booking.refs.$groupInvoice.toggle();
    };

    Booking.addInvoice = function(params, callback) {
        Booking.refs.$invoiceType.append(
            $('<option></option>').val(params.value).html(params.name)
        );
        callback();
    };

    Booking.selectInvoice = function (val) {
        $("#invoid_id option[value='" + val + "']").attr('selected', 'selected');
    };

    Booking.resetForm = function () {
        Booking.refs.$formInvoice[0].reset();
        Booking.refs.$businessGroup.show();
    };

    // BOOSTRAP
    Booking.init = function () {

        function toggle(event) {
            event.preventDefault();
            Booking.toggleInvoiceForm();
            return false;
        }

        Booking.refs.$btnInvoice.click(function (event) {
            return toggle(event);
        });

        Booking.refs.$btnCancelInvoice.click(function (event) {
            Booking.resetForm();
            return toggle(event);
        });

        // Booking checkboxes
        $('.check .booking').each(function () {
            $(this).change(function (event) {
                var $this = $(this);
                var self = this;

                $.ajax({
                    type: 'POST',
                    url: eLearning.webroot + 'bookings/add.json',
                    data: {
                        "course_term_id": self.value,
                        "invoice_id": Booking.refs.$invoiceType.val()
                    },
                    success: function (data) {
                        eLearning.showMessage({ type: 'success', message: data.message });
                    }
                });
            });
        });

        Booking.refs.$formInvoice.submit(function (event) {
            event.preventDefault();

            var $this = $(this);

            $.ajax({
                type: 'POST',
                url: this.action + '.json',
                data: $this.serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);

                    if (typeof obj === 'object') {
                        // Add and select new invoice type
                        Booking.addInvoice({value: obj.id, name: obj.name}, function () {
                            Booking.selectInvoice(obj.id);
                        });

                        eLearning.showMessage({ type: 'success', message: obj.message });

                        Booking.toggleInvoiceForm();
                        Booking.resetForm();
                    }
                }
            });

            return false;
        });

    };

    // LAUNCH
    Booking.init();
});
</script>