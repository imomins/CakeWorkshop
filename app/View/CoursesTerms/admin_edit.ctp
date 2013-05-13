<?php echo $this->Html->css('vendor/jquery-ui-timepicker-addon'); ?>
<?php echo $this->Html->script('vendor/jquery-ui-timepicker-addon'); ?>

<div class="well">
    <legend><?php echo __('Semester-Kurs Daten bearbeiten'); ?></legend>

    <?php echo $this->Form->create('CoursesTerm', array('class' => 'form-horizontal')); ?>
    <?php echo $this->Form->input('id'); ?>
    <div class="control-group">
        <label class="control-label"><?php echo __('Kurs'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('course_id', array('required' => true, 'class' => 'span8', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Kursstatus'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('schedule_name', $schedules, array('empty' => false, 'div' => false, 'label' => false, 'required' => true, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Semester'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('term_id', array('class' => 'span3', 'label' => false)); ?>
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

    <hr />
    <input type="submit" class="btn btn-medium btn-primary" value="<?php echo __('Speichern'); ?>"/>
    <input type="button" class="btn btn-medium btn-danger" value="<?php echo __('Löschen'); ?>"
           data-id=""
           data-confirm="<?php echo __('Soll der Semester-Kurs wirklich gelöscht werden?'); ?>"
           data-url="<?php echo Router::url('/admin/courses_terms/delete/') . $this->request->data['CoursesTerm']['id']; ?>"/>



    <?php echo $this->Form->end(); ?>

</div>