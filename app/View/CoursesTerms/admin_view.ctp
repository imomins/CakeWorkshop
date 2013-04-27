<div class="page-header">
    <h4><?php echo __('Kurs-Übersicht'); ?></h4>
</div>

<div class="btn-toolbar">
    <div class="btn-group" style="margin-top: -30px;">
        <?php echo $this->Html->link(__('Namensschilder Drucken'), array('controller' => 'courses_terms', 'action' => 'nameplates', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn')); ?>
        <?php echo $this->Html->link(__('Kursdaten bearbeiten'), array('controller' => 'courses_terms', 'action' => 'edit', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn')); ?>
    </div>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('Kurs'); ?></dt>
        <dd>
            <?php echo $this->Html->link($coursesTerm['Course']['name'], array('controller' => 'courses', 'action' => 'view', $coursesTerm['Course']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Status'); ?></dt>
        <dd>
            <?php echo $coursesTerm['Schedule']['display']; ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Semester'); ?></dt>
        <dd>
            <?php echo $this->Html->link($coursesTerm['Term']['name'], array('controller' => 'terms', 'action' => 'view', $coursesTerm['Term']['id'])); ?>
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
        <dt><?php echo __('Gesperrt?'); ?></dt>
        <dd>
            <?php echo ($coursesTerm['CoursesTerm']['locked']) ? __('Ja') : __('Nein'); ?>
            &nbsp;
        </dd>
    </dl>
</div>

<div id="booking">
    <input id="CoursesTermId" value="<?php echo $coursesTerm['CoursesTerm']['id']; ?>" type="hidden"/>

    <div class="page-header">
        <h4><?php echo __('Unbestätigte Anmeldungen'); ?></h4>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <th><?php echo __('Name'); ?></th>
            <th><?php echo __('Gebucht am'); ?></th>
            <th><?php echo __('Bestätigen'); ?></th>
            <th><?php echo __('Bearbeiten'); ?></th>
            <th><?php echo __('Löschen'); ?></th>
        </thead>
        <tbody data-bind="foreach: { data: bookings.unconfirmed.data, as: 'unconfirmed' }">
            <tr data-bind="attr: { 'data-id' : unconfirmed.Booking.id }">
                <td><span data-bind="text: unconfirmed['0'].User_name"></span></td>
                <td><span data-bind="text: unconfirmed['0'].Booking_created + ' Uhr'"></span></td>
                <td><a class="btn-link" data-bind="click: $parent.confirm"><?php echo __('Bestätigen'); ?></a></td>
                <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
                <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
            </tr>
        </tbody>
    </table>

    <div class="page-header">
        <h4><?php echo __('Selbst abgemeldet'); ?></h4>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <th><?php echo __('Name'); ?></th>
            <th><?php echo __('Gebucht am'); ?></th>
            <th><?php echo __('Abgemeldet am'); ?></th>
            <th><?php echo __('Anmelden'); ?></th>
            <th><?php echo __('Bearbeiten'); ?></th>
            <th><?php echo __('Löschen'); ?></th>
        </thead>
        <tbody data-bind="foreach: { data: bookings.self_unsubscribed.data, as: 'self_unsubscribed' }">
            <tr data-bind="attr: { 'data-id' : self_unsubscribed.Booking.id }">
                <td><span data-bind="text: self_unsubscribed['0'].User_name"></span></td>
                <td><span data-bind="text: self_unsubscribed['0'].Booking_created + ' Uhr'"></span></td>
                <td><span data-bind="text: self_unsubscribed['0'].Booking_unsubscribed_at + ' Uhr'"></span></td>
                <td><a class="btn-link" data-bind="click: $parent.confirm"><?php echo __('Anmelden'); ?></a></td>
                <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
                <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
            </tr>
        </tbody>
    </table>

    <div class="page-header">
        <h4><?php echo __('Wurde abgemeldet'); ?></h4>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <th><?php echo __('Name'); ?></th>
        <th><?php echo __('Gebucht am'); ?></th>
        <th><?php echo __('Anmelden'); ?></th>
        <th><?php echo __('Bearbeiten'); ?></th>
        <th><?php echo __('Löschen'); ?></th>
        </thead>
        <tbody data-bind="foreach: { data: bookings.admin_unsubscribed.data, as: 'admin_unsubscribed' }">
        <tr data-bind="attr: { 'data-id' : admin_unsubscribed.Booking.id }">
            <td><span data-bind="text: admin_unsubscribed['0'].User_name"></span></td>
            <td><span data-bind="text: admin_unsubscribed['0'].Booking_created + ' Uhr'"></span></td>
            <td><a class="btn-link" data-bind="click: $parent.confirm"><?php echo __('Anmelden'); ?></a></td>
            <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
            <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
        </tr>
        </tbody>
    </table>

    <div class="page-header">
        <h4><?php echo __('Bestätigt'); ?></h4>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <th><?php echo __('Name'); ?></th>
        <th><?php echo __('Gebucht am'); ?></th>
        <th><?php echo __('Abmelden'); ?></th>
        </thead>
        <tr data-bind="foreach: { data: bookings.confirmed, as: 'confirmed' }">
            <td></td>
            <td></td>
            <td></td>
            <td class="actions">
            </td>
        </tr>
    </table>
</div>

<?php echo $this->Html->script('courses_terms/view'); ?>