<div class="coursesTerms view">
    <h3><?php  echo __('Semester-Kurs'); ?></h3>
    <hr/>

    <dl>
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

<div class="related">
    <h3><?php echo __('Teilnehmer'); ?></h3>

    <?php if (!empty($coursesTerm['User'])): ?>
    <table class="table table-condensed table-bordered table-striped">
        <tr>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Name'); ?></th>
            <th><?php echo __('Gebucht am'); ?></th>
            <th class="actions"><?php echo __('Buchung bearbeiten'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($coursesTerm['User'] as $user): ?>
            <tr>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo date('d.m.Y, h:i', strtotime($user['created'])); ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Anzeigen'), array('controller' => 'bookings', 'action' => 'view', $user['id'])); ?>
                    <?php echo $this->Html->link(__('Bearbeiten'), array('controller' => 'bookings', 'action' => 'edit', $user['id'])); ?>
                    <?php echo $this->Form->postLink(__('Löschen'), array('controller' => 'bookings', 'action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p><?php echo __('Keine Buchungen'); ?></p>
    <?php endif; ?>
</div>
