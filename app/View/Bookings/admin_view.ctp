<div class="page-header">
    <h3><?php echo __('Anmeldungsdetails'); ?></h3>
</div>

<div class="row">
    <div class="span12">
        <?php echo $this->Html->link(__('Anmeldung bearbeiten'), array('action' => 'edit', $booking['Booking']['id']), array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->postLink(__('Anmeldung löschen'), array('action' => 'delete', $booking['Booking']['id']), array('class' => 'btn btn-danger'), __('Soll diese Buchung wirklich gelöscht werden')); ?>
        <br />
        <br />
    </div>
</div>

<div class="well dl-big legend-medium">
    <dl class="dl-horizontal">
        <legend><?php echo __('Teilnehmer-Daten'); ?></legend>

        <dt><?php echo __('Teilnehmer'); ?></dt>
        <dd>
            <?php echo $this->Html->link($booking['User']['firstname'] . ' ' . $booking['User']['lastname'], array('controller' => 'users', 'action' => 'view', $booking['User']['id'])); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Notizen zum Teilnehmer'); ?></dt>
        <dd>
            <?php echo $this->Frontend->note($booking['User']['notes']); ?>
            &nbsp;
        </dd>
        <br />

        <legend><?php echo __('Daten zur Anmeldung'); ?></legend>

        <dt><?php echo __('Anwesendheit'); ?></dt>
        <dd>
            <?php echo ($booking['AttendanceStatus']['display']) === null ? __('(noch nicht eingestellt)'): $booking['AttendanceStatus']['display']; ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Angemeldet am'); ?></dt>
        <dd>
            <?php echo h($booking['Booking']['created'] . ' Uhr'); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Momentaner Status'); ?></dt>
        <dd>
            <?php echo $booking['BookingState']['display']; ?>
            &nbsp;
        </dd>

        <?php if ($booking['BookingState']['name'] === 'self_unsubscribed'): ?>
            <dt><?php echo __('Selbst abgemeldet am'); ?></dt>
            <dd>
                <?php echo h($booking['Booking']['unsubscribed_at'] . ' Uhr'); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <dt><?php echo __('Zertifikat'); ?></dt>
        <dd>
            <?php echo $this->Frontend->YesNo($booking['Booking']['certificate']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Notizen zur Anmeldung'); ?></dt>
        <dd>
            <?php echo $this->Frontend->note($booking['Booking']['notes']); ?>
            &nbsp;
        </dd>
        <br />

        <legend><?php echo __('Kursdaten'); ?></legend>

        <dt><?php echo __('Kurs-Nr.'); ?></dt>
        <dd>
            <?php echo $booking['CoursesTerm']['id']; ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Kurs'); ?></dt>
        <dd>
            <?php echo $this->Html->link($booking['Course']['name'], array('controller' => 'courses_terms', 'action' => 'view', $booking['CoursesTerm']['id'])); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Semester'); ?></dt>
        <dd>
            <?php echo $this->Html->link($booking['Term']['name'], array('controller' => 'terms', 'action' => 'view', $booking['Term']['id'])); ?>
            &nbsp;
        </dd>
        <br />

        <legend><?php echo __('Rechnungsadresse'); ?></legend>

        <?php if (!empty($booking['Invoice']['institution'])): ?>
            <dt><?php echo __('Einrichtung'); ?></dt>
            <dd>
                <?php echo h($booking['Invoice']['institution']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($booking['Invoice']['department'])): ?>
            <dt><?php echo __('Fachbereich'); ?></dt>
            <dd>
                <?php echo h($booking['Invoice']['department']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($booking['Invoice']['postbox'])): ?>
            <dt><?php echo __('Postfach'); ?></dt>
            <dd>
                <?php echo h($booking['Invoice']['postbox']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($booking['Invoice']['to_person'])): ?>
            <dt><?php echo __('Zu Händen von'); ?></dt>
            <dd>
                <?php echo h($booking['Invoice']['to_person']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <dt><?php echo __('Straße'); ?></dt>
        <dd>
            <?php echo h($booking['Invoice']['street']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('PLZ'); ?></dt>
        <dd>
            <?php echo h($booking['Invoice']['zip']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Ort'); ?></dt>
        <dd>
            <?php echo h($booking['Invoice']['location']); ?>
            &nbsp;
        </dd>
    </dl>
    <hr />
    <?php echo $this->Html->link(__('Rechnungsadresse bearbeiten'), array('controller' => 'invoices', 'action' => 'edit', $booking['Invoice']['id']), array('class' => 'btn')); ?>
</div>