<div class="well">
    <?php echo $this->Form->create('Invoice', array('action' => 'add', 'class' => 'form-horizontal form-invoice')); ?>
    <p class="lead"><?php echo __('Rechnungsdaten'); ?></p>
    <hr />

    <div class="control-group">
        <label class="control-label"><?php echo __('Rechnung an'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('Invoice.type_id', array('default' => 2,'id' => 'inputType', 'required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Bezeichnung'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('Invoice.name', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="business">
        <div class="control-group">
            <label class="control-label"><?php echo __('Institution'); ?></label>
            <div class="controls">
                <?php echo $this->Form->input('Invoice.institution', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Abteilung'); ?></label>
            <div class="controls">
                <?php echo $this->Form->input('Invoice.department', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Hauspostfach'); ?></label>
            <div class="controls">
                <?php echo $this->Form->input('Invoice.postbox', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Zu Händen'); ?></label>
            <div class="controls">
                <?php echo $this->Form->input('Invoice.to_person', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Straße'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('Invoice.street', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('PLZ'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('Invoice.zip', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Ort'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('Invoice.location', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>
    <hr />
    <div class="control-group">
        <div class="controls">
            <input class="btn" type="submit" value="<?php echo __('Speichern'); ?>"/>
            <input id="btnCancelInvoice" class="btn btn-danger" type="button" value="<?php echo __('Abbrechen'); ?>"/>
        </div>
    </div>

    <?php echo $this->Form->end(); ?>
</div>

<style>
.radio input[type="radio"], .checkbox input[type="checkbox"] {
    float: left;
    margin: 3px 0;
    text-align: center;
}
</style>

<script>
$(function () {
    var Booking = {
        Invoice: {
            // Element refs
            $inputType: $('#inputType'),
            $businessGroup: $('.business'),
            $termId: $('#term_id'),

            // Methods
            toggleInvoiceType: function () {
                var group = Booking.Invoice.$businessGroup;

                group.toggle();
                // The business group doesn't need validation if is hidden
                group.find('input').attr('required', group.is(':visible'));
            }
        },

        // Bootstrap function
        init: function () {
            Booking.Invoice.$inputType.change(function (event) {
                Booking.Invoice.toggleInvoiceType();
            });

            Booking.Invoice.$termId.change(function (event) {
                window.location = CakeWorkshop.webroot + CakeWorkshop.controller + '/' + CakeWorkshop.action + '/' + this.value;
            });
        }
    };
    Booking.init();
});
</script>