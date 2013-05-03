<div class="page-header">
    <h3><?php echo __('Neue Anmeldung'); ?></h3>
</div>

<div class="well">
    <?php echo $this->Form->create('Booking', array('class' => 'form form-horizontal')); ?>

    <legend><?php echo __('Daten für die Anmeldung'); ?></legend>

    <div class="control-group">
        <label class="control-label"><?php echo __('Teilnehmer'); ?></label>

        <div class="controls">
            <?php echo $this->Form->hidden('user_id', array('id' => 'user_id', 'div' => false, 'label' => false)); ?>
            <?php echo $this->Form->input('user_name', array('type' => 'text', 'id' => 'user_name', 'div' => false, 'label' => false, 'class' => 'span6')); ?>
            <span class="help-block">
                    <?php echo __('Beim Eingeben wird der Name gesucht'); ?>
            </span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Semesterkurs'); ?></label>

        <div class="controls">
            <?php echo $this->Form->hidden('courses_term_id', array('required' => true, 'id' => 'courses_term_id', 'div' => false, 'label' => false)); ?>
            <?php echo $this->Form->input('courses_term_name', array('required' => true, 'type' => 'text', 'id' => 'courses_term_name', 'div' => false, 'label' => false, 'class' => 'span6')); ?>
            <span class="help-block">
                <?php echo __('Beim Eingeben wird nach Kurs-Titel und Semester gesucht'); ?>
            </span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Anmeldestatus'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('booking_state_name', $booking_state, array('default' => 'unconfirmed', 'empty' => false, 'required' => true, 'div' => false, 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Teilnahmestatus'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('attendance_state_name', $attendance_state, array('div' => false, 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Rechnungsvorlage'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('invoice_id', array('div' => false, 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Zertifikat'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('certificate', array('div' => false, 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Notizen zu dieser Anmeldung'); ?></label>

        <div class="controls">
            <?php echo $this->Form->textarea('notes', array('rows' => 7, 'class' => 'span7', 'div' => false, 'label' => false)); ?>
        </div>
    </div>

    <hr/>
    <button type="submit" class="btn btn-primary"><?php echo __('Speichern'); ?></button>

    <?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Html->css('jquery-ui-custom/css/flick/jquery-ui-1.10.2.custom.min'); ?>
<?php echo $this->Html->script('bookings/add'); ?>