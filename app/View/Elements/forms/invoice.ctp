<div class="well">
    <?php echo $this->Form->create('Invoice', array('action' => 'add', 'class' => 'form-horizontal form-invoice')); ?>
    <p class="lead"><?php echo __('Rechnungsdaten'); ?></p>
    <hr/>

    <div class="control-group">
        <label class="control-label"><?php echo __('Rechnung an'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('type', array('name' => 'data[Invoice][type_name]', 'default' => 'business', 'id' => 'inputType', 'required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Bezeichnung'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('name', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="business">
        <div class="control-group">
            <label class="control-label"><?php echo __('Institution'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('institution', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Abteilung'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('department', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Hauspostfach'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('postbox', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Zu Händen'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('to_person', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Straße'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('street', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('PLZ'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('zip', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Ort'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('location', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>
    <hr/>
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