<?php echo $this->Html->css('vendor/jquery-ui-timepicker-addon'); ?>
<?php echo $this->Html->script('vendor/jquery-ui-timepicker-addon'); ?>

<div class="page-header">
    <h3><?php echo __('Neuen Kurs für ein Semester ansetzen'); ?></h3>
</div>

<div class="well">
    <?php echo $this->Form->create('CoursesTerm', array('class' => 'form-horizontal')); ?>
    <?php echo $this->Form->input('id'); ?>

    <legend><?php echo __('Kursdaten'); ?></legend>

    <div class="control-group">
        <label class="control-label"><?php echo __('Kurs'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('course_id', array('empty' => false, 'div' => false, 'label' => false, 'required' => true, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Semester'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('term_id', array('empty' => false, 'div' => false, 'label' => false, 'required' => true, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Kursstatus'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('schedule_name', $schedules, array('empty' => false, 'div' => false, 'label' => false, 'required' => true, 'class' => 'span3', 'default' => 'unknown')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Schulungsort'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('location', array('class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Maximale Teilnehmerzahl'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('max', array('type' => 'number', 'class' => 'span2', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Für Anmeldungen sperren'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('locked', array('class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <hr/>
    <button type="submit" class="btn btn-primary"><?php echo __('Speichern'); ?></button>
    <?php echo $this->Form->end(); ?>
</div>