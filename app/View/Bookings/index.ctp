<div class="page-header">
    <h4><?php  echo __('Kursverwaltung'); ?></h4>
</div>

<div class="alert alert-info">
    <button data-dismiss="alert" class="close" type="button">×</button>

    <p>
        <strong>Hinweis zur Anmeldung bei ausgebuchten Kursen:</strong> Falls Kurse ausgebucht sind, dann melden Sie sich bitte trotzdem an. Oft werden noch Plätze über die Warteliste frei bzw. bei großem Interesse bieten wir auch Wiederholungstermine für einzelne Kurse an.
    </p>
</div>

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
<br/>

<?php echo $this->Form->create(array('id' => 'formBooking', 'action' => 'confirm')); ?>
<?php echo $this->element('tables/courses_by_category', array($coursesByCategory, 'form' => true)); ?>
<div class="form-actions">
    <button type="submit" class="btn btn-primary"><?php echo __('Ausgewählte Kurse Belegen'); ?></button>
</div>
<?php echo $this->Form->end(); ?>

<div id="invalid" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3><?php echo __('Ungültige Auswahl'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo __('Sie haben keinen Kurs ausgewählt, wählen Sie bitte mindestens einen.'); ?></p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><?php echo __('Ok'); ?></button>
    </div>
</div>

<div id="confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3><?php echo __('Ihre gewählten Kurse'); ?></h3>
        <small><?php echo __('Bitte Überprüfen Sie Ihre Ihre Auswahl vor der Belegung'); ?></small>
    </div>
    <div class="modal-body">
        <p><?php echo __('Sie haben folgende Kurse belegt:'); ?></p>
        <br/>
        <ol></ol>

        <hr/>
        <p><?php echo __('Sie erhalten eine Bestätigung per Email mit einer Übersicht Ihrer gebuchten Kurse'); ?></p>
    </div>
    <div class="modal-footer">
        <button onclick="$('#formBooking').submit();" class="btn btn-success"
                aria-hidden="true"><?php echo __('Auswahl bestätigen'); ?></button>
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><?php echo __('Abbrechen'); ?></button>
    </div>
</div>

<script>
    require(['bookings/index', 'jquery'], function (bookings, $) {
        "use strict";

        $(function () {
            bookings.initialize();
        });
    });
</script>