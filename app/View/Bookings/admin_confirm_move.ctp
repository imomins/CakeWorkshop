<h3 class="page-header"><?php echo __('Verschieben von Anmeldungen auf einen Anderen Kurs'); ?></h3>

<dl class="dl-horizontal well">
    <legend><?php echo __('Die Teilnehmer befinden sich momentan in diesem Kurs'); ?></legend>
    <dt><?php echo __('Kurs-Nr.'); ?></dt>
    <dd>
        <?php echo h($coursesTerm['CoursesTerm']['id']); ?>
        &nbsp;
    </dd>

    <dt><?php echo __('Kurs'); ?></dt>
    <dd>
        <?php echo $this->Html->link($coursesTerm['Course']['name'], array('controller' => 'courses_terms', 'action' => 'view', $coursesTerm['CoursesTerm']['id'])); ?>
        &nbsp;
    </dd>

    <dt><?php echo __('Senester-Kurs Status'); ?></dt>
    <dd>
        <?php echo h($coursesTerm['Schedule']['display']); ?>
        &nbsp;
    </dd>

    <dt><?php echo __('Semester'); ?></dt>
    <dd>
        <?php echo $this->Html->link($coursesTerm['Term']['name'], array('controller' => 'terms', 'action' => 'view', $coursesTerm['Term']['id'])); ?>
        &nbsp;
    </dd>
</dl>

<?php echo $this->Form->create(null, array(
    'url' => array('controller' => 'bookings', 'action' => 'move')
)); ?>
<div class="well">
    <legend><?php echo __('Verschiebe die Teilnehmer in den folgenden Semester-Kurs'); ?></legend>

    <div class="control-group">
        <label class="control-label"><?php echo __('Semesterkurs'); ?></label>

        <div class="controls">
            <?php echo $this->Form->hidden('courses_term_id', array('required' => true, 'id' => 'courses_term_id', 'div' => false, 'label' => false)); ?>
            <?php echo $this->Form->input('courses_term_name', array('required' => true, 'type' => 'text', 'id' => 'courses_term_name', 'div' => false, 'label' => false, 'class' => 'span8')); ?>
            <span class="help-block">
                <?php echo __('Beim Eingeben wird nach Kurs-Titel und Semester gesucht'); ?>
            </span>
        </div>
    </div>
</div>

<h4 class="page-header"><?php echo __('Die gewählten Teilnehmer'); ?></h4>

<table class="table table-condensed table-bordered table-hover table-striped">
    <thead>
    <th><?php echo __('Titel'); ?></th>
    <th><?php echo __('Vorname'); ?></th>
    <th><?php echo __('Nachname'); ?></th>
    <th><?php echo __('Anmeldestatus'); ?></th>
    <th><?php echo __('Teilnamestatus'); ?></th>
    </thead>
    <tbody>
    <?php foreach ($bookings as $booking): ?>
        <tr>
            <td style="display: none;">
                <?php echo $this->Form->hidden('Booking.id.'. $booking['Booking']['id']); ?>
            </td>
            <td><?php echo h($booking['User']['title']); ?></td>
            <td><?php echo h($booking['User']['firstname']); ?></td>
            <td><?php echo h($booking['User']['lastname']); ?></td>
            <td><?php echo h($booking['BookingState']['display']); ?></td>
            <td><?php echo h($booking['AttendanceState']['display']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="form-actions">
    <button type="submit"
            class="btn btn-primary"><?php echo __('Ok, in den Ausgewählen Semester-Kurs verschieben'); ?>
    </button>
</div>
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->css('jquery-ui-custom/css/flick/jquery-ui-1.10.2.custom.min'); ?>
<?php echo $this->Html->script('bookings/admin/add'); ?>