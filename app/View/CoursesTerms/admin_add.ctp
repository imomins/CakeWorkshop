<?php echo $this->Html->css('vendor/jquery-ui-timepicker-addon'); ?>
<?php echo $this->Html->script('vendor/jquery-ui-timepicker-addon'); ?>

<div class="coursesTerms form">
    <?php echo $this->Form->create('CoursesTerm', array('id' => 'formCourseTerm')); ?>
    <fieldset>
        <legend><?php echo __('Kurs für ein bestimmtes Semester anlegen'); ?></legend>
        <?php
        echo $this->Form->input('term_id', array('label' => 'Semester', 'required' => true));
        echo $this->Form->input('course_id', array('required' => true));
        echo $this->Form->input('max', array('required' => true, 'label' => __('Maximale Teilnehmerzahl')));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Speichern')); ?>
</div>