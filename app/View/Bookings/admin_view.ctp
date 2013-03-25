<div class="page-header">
    <h3><?php  echo __('Anmeldungsdetails'); ?></h3>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('User'); ?></dt>
        <dd>
            <?php echo $this->Html->link($booking['User']['name'], array('controller' => 'users', 'action' => 'view', $booking['User']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Rechnungsdaten'); ?></dt>
        <dd>
            <?php echo $this->Html->link($booking['Invoice']['name'] . __('(für Details anklicken)'), array('controller' => 'invoices', 'action' => 'view', $booking['Invoice']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Zusage'); ?></dt>
        <dd>
            <?php echo $this->Frontend->YesNo($booking['Booking']['commitment']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Abgeschlossen'); ?></dt>
        <dd>
            <?php echo $this->Frontend->YesNo($booking['Booking']['completed']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Zertifikat'); ?></dt>
        <dd>
            <?php echo $this->Frontend->YesNo($booking['Booking']['certificate']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Angemeldet am'); ?></dt>
        <dd>
            <?php echo h($booking['Booking']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Kurs'); ?></dt>
        <dd>
            <?php echo $this->Html->link($booking['CoursesTerm']['Course']['name'], array('controller' => 'courses_terms', 'action' => 'view', $booking['CoursesTerm']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Semester'); ?></dt>
        <dd>
            <?php echo $this->Html->link($booking['CoursesTerm']['Term']['name'], array('controller' => 'terms', 'action' => 'view', $booking['CoursesTerm']['Term']['id'])); ?>
            &nbsp;
        </dd>
    </dl>
</div>

<div class="btn-group">
    <?php echo $this->Html->link(__('Anmeldung bearbeiten'), array('action' => 'edit', $booking['Booking']['id']), array('class' => 'btn')); ?>
    <?php echo $this->Html->link(__('Jemanden anmelden'), array('action' => 'add'), array('class' => 'btn')); ?>
    <?php echo $this->Form->postLink(__('Anmeldung löschen'), array('action' => 'delete', $booking['Booking']['id']), array('class' => 'btn btn-warning'), __('Are you sure you want to delete # %s?', $booking['Booking']['id'])); ?>
</div>