<div class="page-header">
    <h3><?php  echo __('Rechnungsdaten'); ?></h3>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('Rechnungsart'); ?></dt>
        <dd>
            <?php echo h($invoice['Type']['name']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('User'); ?></dt>
        <dd>
            <?php echo $this->Html->link($invoice['User']['name'], array('controller' => 'users', 'action' => 'view', $invoice['User']['id'])); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Teilnehmer'); ?></dt>
        <dd>
            <?php echo h($invoice['Invoice']['name']); ?>
            &nbsp;
        </dd>

        <?php if (!empty($invoice['Invoice']['institution'])): ?>
            <dt><?php echo __('Einrichtung'); ?></dt>
            <dd>
                <?php echo h($invoice['Invoice']['institution']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($invoice['Invoice']['department'])): ?>
            <dt><?php echo __('Fachbereich'); ?></dt>
            <dd>
                <?php echo h($invoice['Invoice']['department']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($invoice['Invoice']['postbox'])): ?>
            <dt><?php echo __('Postfach'); ?></dt>
            <dd>
                <?php echo h($invoice['Invoice']['postbox']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($invoice['Invoice']['to_person'])): ?>
            <dt><?php echo __('Zu Händen von'); ?></dt>
            <dd>
                <?php echo h($invoice['Invoice']['to_person']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <dt><?php echo __('Straße'); ?></dt>
        <dd>
            <?php echo h($invoice['Invoice']['street']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('PLZ'); ?></dt>
        <dd>
            <?php echo h($invoice['Invoice']['zip']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Ort'); ?></dt>
        <dd>
            <?php echo h($invoice['Invoice']['location']); ?>
            &nbsp;
        </dd>
    </dl>
</div>

<div class="btn-group">
    <?php echo $this->Html->link(__('Edit Invoice'), array('action' => 'edit', $invoice['Invoice']['id']), array('class' => 'btn')); ?>
    <?php echo $this->Form->postLink(__('Delete Invoice'), array('action' => 'delete', $invoice['Invoice']['id']), array('class' => 'btn'), __('Are you sure you want to delete # %s?', $invoice['Invoice']['id'])); ?>
    <?php echo $this->Html->link(__('New Invoice'), array('action' => 'add'), array('class' => 'btn')); ?>
</div>

<br/>
<br/>

<div class="page-header">
    <h3><?php  echo __('Gebuchte Kurse unter dieser Rechnung'); ?></h3>
</div>

<?php if (!empty($invoice['Booking'])): ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th><?php echo __('Kurs'); ?></th>
            <th><?php echo __('Semester'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($invoice['Booking'] as $booking): ?>
            <tr>
                <td><?php echo $booking['CoursesTerm']['Course']['name']; ?></td>
                <td><?php echo $booking['CoursesTerm']['Term']['name']; ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('controller' => 'bookings', 'action' => 'view', $booking['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('controller' => 'bookings', 'action' => 'edit', $booking['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'bookings', 'action' => 'delete', $booking['id']), null, __('Are you sure you want to delete # %s?', $booking['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<div class="actions">
    <ul>
        <?php echo $this->Html->link(__('New Booking'), array('controller' => 'bookings', 'action' => 'add')); ?>
    </ul>
</div>
