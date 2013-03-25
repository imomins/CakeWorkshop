<div class="page-header">
    <h4><?php  echo __('Kurs-Übersicht'); ?></h4>
</div>

<div class="btn-toolbar">
    <div class="btn-group" style="margin-top: -30px;">
        <?php echo $this->Html->link(__('Namensschilder Drucken'), array('controller' => 'courses_terms', 'action' => 'nameplates', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn')); ?>
        <?php echo $this->Html->link(__('Kursdaten bearbeiten'), array('controller' => 'courses_terms', 'action' => 'edit', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn')); ?>
    </div>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('Semester'); ?></dt>
        <dd>
            <?php echo $this->Html->link($coursesTerm['Term']['name'], array('controller' => 'terms', 'action' => 'view', $coursesTerm['Term']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Kurs'); ?></dt>
        <dd>
            <?php echo $this->Html->link($coursesTerm['Course']['name'], array('controller' => 'courses', 'action' => 'view', $coursesTerm['Course']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Angemeldet'); ?></dt>
        <dd>
            <?php echo h($coursesTerm['CoursesTerm']['attendees']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Maximal'); ?></dt>
        <dd>
            <?php echo h($coursesTerm['CoursesTerm']['max']); ?>
            &nbsp;
        </dd>
    </dl>
</div>

<div class="page-header">
    <h4><?php  echo __('Teilnehmer'); ?></h4>
</div>

<?php if (!empty($coursesTerm['User'])): ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th><?php echo __('Name'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Gebucht am'); ?></th>
            <th class="actions"><?php echo __('Optionen zur Buchung'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($coursesTerm['User'] as $user): ?>
            <tr>
                <td><?php echo $this->Html->link($user['name'], array('controller' => 'users', 'action' => 'view', $user['id'])); ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo date('d.m.Y, h:i', strtotime($user['created'])); ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Anzeigen'), array('controller' => 'bookings', 'action' => 'view', $user['Booking']['id'])); ?>
                    <?php echo $this->Html->link(__('Bearbeiten'), array('controller' => 'bookings', 'action' => 'edit', $user['Booking']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Löschen'), array('controller' => 'bookings', 'action' => 'delete', $user['Booking']['id']), null, __('Are you sure you want to delete # %s?', $user['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p><?php echo __('Keine Buchungen'); ?></p>
<?php endif; ?>
