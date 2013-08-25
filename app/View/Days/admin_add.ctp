<div class="days form">
    <?php echo $this->Form->create('Day', array('action' => 'add/' . $coursesTerms['CoursesTerm']['id'], 'class' => 'well')); ?>
    <fieldset>
        <legend><?php echo __('Kurstag anlegen'); ?></legend>
        <?php echo $this->Form->input('Day.start_date', array('required' => true, 'type' => 'text', 'dateFormat' => 'DMY', 'id' => 'date', 'label' => __('Datum'))); ?>
        <?php echo $this->Form->input('Day.start_time', array(
            'type'       => 'time',
            'timeFormat' => 24,
            'default'    => '10:00',
            'label'      => __('Von'),
            'required'   => true
        )); ?>
        <?php echo $this->Form->input('Day.end_time', array(
            'type'       => 'time',
            'timeFormat' => 24,
            'default'    => '16:00',
            'label'      => __('Bis'),
            'required'   => true
        )); ?>
    </fieldset>
    <hr/>
    <input type="submit" class="btn btn-medium btn-primary" value="<?php echo __('Speichern'); ?>"/>
</div>

<?php echo $this->Html->css('jquery-ui-custom/css/flick/jquery-ui-1.10.2.custom.min'); ?>
<?php echo $this->Html->script('days/add'); ?>