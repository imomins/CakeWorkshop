<div class="page-header">
    <h3><?php echo __('Rechnungsadresse'); ?></h3>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('An'); ?></dt>
        <dd>
            <?php echo h($address['Type']['display']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Teilnehmer'); ?></dt>
        <dd>
            <?php echo $this->Html->link($address['User']['firstname'] . ' ' . $address['User']['lastname'], array('controller' => 'users', 'action' => 'view', $address['User']['id'])); ?>
            &nbsp;
        </dd>

        <?php if (!empty($address['Address']['institution'])): ?>
            <dt><?php echo __('Einrichtung'); ?></dt>
            <dd>
                <?php echo h($address['Address']['institution']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($address['Address']['department'])): ?>
            <dt><?php echo __('Fachbereich'); ?></dt>
            <dd>
                <?php echo h($address['Address']['department']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($address['Address']['postbox'])): ?>
            <dt><?php echo __('Postfach'); ?></dt>
            <dd>
                <?php echo h($address['Address']['postbox']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($address['Address']['to_person'])): ?>
            <dt><?php echo __('Zu Händen von'); ?></dt>
            <dd>
                <?php echo h($address['Address']['to_person']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <dt><?php echo __('Straße'); ?></dt>
        <dd>
            <?php echo h($address['Address']['street']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('PLZ'); ?></dt>
        <dd>
            <?php echo h($address['Address']['zip']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Ort'); ?></dt>
        <dd>
            <?php echo h($address['Address']['location']); ?>
            &nbsp;
        </dd>
    </dl>
</div>

<div class="btn-group">
    <?php echo $this->Html->link(__('Rechnungsadresse bearbeiten'), array('action' => 'edit', $address['Address']['id']), array('class' => 'btn btn-primary')); ?>
    <?php echo $this->Html->link(__('Neue Rechnungsadresse anlegen'), array('action' => 'add'), array('class' => 'btn')); ?>
    <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $address['Address']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $address['Address']['id'])); ?>
</div>

<br/>
<br/>

<div class="page-header">
    <h3><?php echo __('Gebuchte Kurse unter dieser Adresse'); ?></h3>
</div>

<?php if (!empty($related_bookings)): ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th><?php echo __('Kurs-Nr.'); ?></th>
            <th><?php echo __('Kurs'); ?></th>
            <th><?php echo __('Semester'); ?></th>
            <th><?php echo __('Anzeigen'); ?></th>
            <th><?php echo __('Bearbeiten'); ?></th>

        </tr>
        <?php foreach ($related_bookings as $booking): ?>
            <tr>
                <td><?php echo $booking['Booking']['id']; ?></td>
                <td><?php echo $booking['Course']['name']; ?></td>
                <td><?php echo $booking['Term']['name']; ?></td>
                <td><?php echo $this->Html->link(__('Anzeigen'), array('controller' => 'bookings', 'action' => 'view', $booking['Booking']['id'])); ?></td>
                <td><?php echo $this->Html->link(__('Bearbeiten'), array('controller' => 'bookings', 'action' => 'edit', $booking['Booking']['id'])); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<div class="actions">
    <ul>
        <?php echo $this->Html->link(__('New Booking'), array('controller' => 'bookings', 'action' => 'add')); ?>
    </ul>
</div>
