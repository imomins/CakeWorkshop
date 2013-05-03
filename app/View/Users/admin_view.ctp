<div class="page-header">
    <h3><?php echo __('Daten des Benutzers: ' . h($user['User']['firstname']) . ' ' . h($user['User']['lastname'])); ?></h3>
</div>

<div class="row">
    <div class="span12">
        <?php echo $this->Html->link(__('Daten bearbeiten'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->postLink(__('Benutzer löschen'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger'), __('Soll dieser Benutzer wirklich gelöscht werden')); ?>
        <br/>
        <br/>
    </div>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('Anrede'); ?></dt>
        <dd>
            <?php echo $this->Html->link($user['Gender']['name'], array('controller' => 'genders', 'action' => 'view', $user['Gender']['id'])); ?>
            &nbsp;
        </dd>

        <?php if (!empty($user['User']['title'])): ?>
            <dt><?php echo __('Titel'); ?></dt>
            <dd>
                <?php echo $user['User']['title']; ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($user['User']['name']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Email'); ?></dt>
        <dd>
            <?php echo h($user['User']['email']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Fachbereich'); ?></dt>
        <dd>
            <?php echo $this->Html->link($user['Department']['name'], array('controller' => 'departments', 'action' => 'view', $user['Department']['id'])); ?>
            &nbsp;
        </dd>

        <?php if (!empty($user['User']['occupation'])): ?>
            <dt><?php echo __('Beschäftigung'); ?></dt>
            <dd>
                <?php echo h($user['User']['occupation']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($user['User']['hrz'])): ?>
            <dt><?php echo __('Hrz-Id'); ?></dt>
            <dd>
                <?php echo h($user['User']['hrz']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <dt><?php echo __('Tel.'); ?></dt>
        <dd>
            <?php echo h($user['User']['phone']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Benutzer-Gruppe'); ?></dt>
        <dd>
            <?php echo $this->Html->link($user['Group']['display'], array('controller' => 'groups', 'action' => 'view', $user['Group']['name'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Konto-Aktiviert'); ?></dt>
        <dd>
            <?php echo h($user['User']['active'] === '1' ? __('Ja') : __('Nein')); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Konto-Erstellt am'); ?></dt>
        <dd>
            <?php echo date('d.m.Y, H:i ', strtotime($user['User']['created'])) . ' ' . __('Uhr'); ?>
            &nbsp;
        </dd>

    </dl>
</div>

<div class="page-header">
    <h3><?php echo __('Belegte Semesterkurse'); ?></h3>
</div>

<?php if (!empty($user['Booking'])): ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th><?php echo __('Semester'); ?></th>
            <th><?php echo __('Kurs'); ?></th>
            <th><?php echo __('Anzeigen'); ?></th>
            <th><?php echo __('Bearbeiten'); ?></th>
            <th><?php echo __('Löschen'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($user['Booking'] as $booking): ?>
            <tr>
                <td><?php echo $booking['CoursesTerm']['Term']['name']; ?></td>
                <td><?php echo $booking['CoursesTerm']['Course']['name']; ?></td>
                <td>
                    <?php echo $this->Html->link(__('Anzeigen'), array('controller' => 'bookings', 'action' => 'view', $booking['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link(__('Bearbeiten'), array('controller' => 'bookings', 'action' => 'edit', $booking['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Form->postLink(__('Löschen'), array('controller' => 'bookings', 'action' => 'delete', $booking['id']), null, __('Soll die Buchung gelöscht werden?')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
