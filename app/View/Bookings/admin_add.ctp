<div class="page-header">
    <h3><?php  echo __('Anmeldung bearbeiten'); ?></h3>
</div>

<div class="well">
    <?php echo $this->Form->create('Booking'); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Teilnehmer'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('user_id'); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Rechnungsvorlage'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('invoice_id'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <?php echo $this->Form->input('commitment', array('label' => __('Zusage'))); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <?php echo $this->Form->input('completed', array('label' => __('Abgeschlossen'))); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <?php echo $this->Form->input('certificate', array('label' => __('Zertifikat'))); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Semesterkurs'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('courses_term_id', array('label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo __('Speichern'); ?></button>

    <?php echo $this->Form->end(); ?>
</div>