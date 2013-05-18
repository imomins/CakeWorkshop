<h3 class="page-header"><?php echo __('Einen Semester-Kurs neu ansetzen'); ?></h3>

<?php $this->Form->create('Booking'); ?>

<?php echo $this->Form->input('id'); ?>

<div class="alert bg-blue">
    <?php echo __('Die Kursdetails können dann nach dem Speichern eingestellt werden'); ?>
</div>

<h4 class="page-header"><?php echo __('Dieser Kurs wird abgesagt und neu angesetzt'); ?></h4>

<dl class="dl-horizontal well">
    <dt><?php echo __('Kurs-Nr.'); ?></dt>
    <dd>
        <?php echo h($this->request->data['CoursesTerm']['id']); ?>
        &nbsp;
    </dd>

    <dt><?php echo __('Semester-Kurs'); ?></dt>
    <dd>
        <?php echo $this->Html->link($this->request->data['Course']['name'], array('controller' => 'courses_terms', 'action' => 'view', $this->request->data['CoursesTerm']['id'])); ?>
        &nbsp;
    </dd>

    <dt><?php echo __('Semester'); ?></dt>
    <dd>
        <?php echo $this->Html->link($this->request->data['Term']['name'], array('controller' => 'terms', 'action' => 'view', $this->request->data['Term']['id'])); ?>
        &nbsp;
    </dd>
</dl>

<h4 class="page-header"><?php echo __('Optionen zum neu angesetzten Semester-Kurs'); ?></h4>

<div class="well">
    <div class="controls">
        <label class="checkbox">
            <?php echo $this->Form->checkbox('copy_users', array('checked' => true)); ?> <?php echo __('Alle Teilnehmer mitkopieren'); ?>
        </label>
    </div>

    <div class="controls">
        <label class="checkbox">
            <?php echo $this->Form->checkbox('close_courses_term', array('checked' => false)); ?> <?php echo __('Den alten Semester-Kurs absagen'); ?>
        </label>
    </div>

    <div class="controls">
        <label class="checkbox">
            <?php echo $this->Form->checkbox('reset_attendance_state', array('checked' => false)); ?> <?php echo __('Den Status aller Teilnehmer wieder auf "Unbestätigt" setzen'); ?>
        </label>
    </div>
</div>

<h4 class="page-header"><?php echo __('Momentane Teilnehmer'); ?></h4>

<table class="table table-condensed table-bordered table-hover table-striped">
    <thead>
    <th><?php echo __('Titel'); ?></th>
    <th><?php echo __('Vorname'); ?></th>
    <th><?php echo __('Nachname'); ?></th>
    <th><?php echo __('Anmeldestatus'); ?></th>
    <th><?php echo __('Teilnamestatus'); ?></th>
    </thead>
    <tbody>
    <?php foreach ($this->request->data['Bookings'] as $booking): ?>
        <tr>
            <td style="display: none;">
                <?php echo $this->Form->hidden('Booking.id.' . $booking['Booking']['id']); ?>
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
    <button type="submit" class="btn btn-primary">
        <?php echo __('Ok, in den Ausgewählen Semester-Kurs verschieben'); ?>
    </button>
</div>

<?php $this->Form->end(); ?>
