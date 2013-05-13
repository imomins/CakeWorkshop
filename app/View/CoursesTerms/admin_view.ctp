<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header"><?php echo __('Semester-Kurs Übersicht'); ?></h3>
    </div>
</div>

<div class="row-fluid">
    <div class="span7">
        <h4><?php echo __('Kursdaten'); ?></h4>
        <dl class="dl-horizontal well">
            <dt><?php echo __('Kurs-Nr.'); ?></dt>
            <dd>
                <?php echo h($coursesTerm['CoursesTerm']['id']); ?>
                &nbsp;
            </dd>

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

            <dt><?php echo __('Ort'); ?></dt>
            <dd>
                <?php echo h($coursesTerm['CoursesTerm']['location']); ?>
                &nbsp;
            </dd>

            <dt><?php echo __('Angemeldet'); ?></dt>
            <dd id="attendeesCount">
                <?php echo h($coursesTerm['CoursesTerm']['attendees']); ?>
                &nbsp;
            </dd>

            <dt><?php echo __('Maximal'); ?></dt>
            <dd>
                <?php echo h($coursesTerm['CoursesTerm']['max']); ?>
                &nbsp;
            </dd>

            <dt><?php echo __('Anmelden sperren?'); ?></dt>
            <dd>
                <?php echo $this->Frontend->YesNo($coursesTerm['CoursesTerm']['locked']); ?>
                &nbsp;
            </dd>
        </dl>
    </div>
    <div class="span5">
        <h4><?php echo __('Angesetzte Kurstage'); ?></h4>
        <table class="table-condensed table table-bordered table-striped table-hover">
            <thead>
            <th><?php echo __('Am'); ?></th>
            <th><?php echo __('Von'); ?></th>
            <th><?php echo __('Bis'); ?></th>
            <th style="min-width:50px;"><strong>Löschen</strong></th>
            </thead>
            <tbody>
            <?php if (empty($coursesTerm['Day'])): ?>
                <tr>
                    <td colspan="4"><?php echo __('Keine Tage bisher angesetzt'); ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($coursesTerm['Day'] as $day): ?>
                    <tr>
                        <td><?php echo date('d.m.Y', strtotime($day['start_date'])); ?></td>
                        <td><?php echo date('H:i', strtotime($day['start_time'])); ?> Uhr</td>
                        <td><?php echo date('H:i', strtotime($day['end_time'])); ?> Uhr</td>
                        <td><i class="icon-trash" style="margin-right:5px;"></i><?php echo $this->Form->postLink(
                                __('Löschen'),
                                '/admin/days/delete/' . $day['id'],
                                null,
                                __("Soll der Tag gelöscht werden?")
                            ); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <?php echo $this->Html->link(__('Neuer Tag'), array('controller' => 'days', 'action' => 'add', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-primary btn-small btn-primary', 'style' => 'margin:0;margin-top:-10px;')); ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span12" style="margin-top: -10px;">
        <?php echo $this->Html->link(__('Kursdaten bearbeiten'), array('controller' => 'courses_terms', 'action' => 'edit', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-small btn-primary')); ?>
        <?php echo $this->Html->link(__('Namensschilder Drucken'), array('controller' => 'courses_terms', 'action' => 'nameplates', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-small')); ?>
        <div class="btn-group">
            <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
                <?php echo __('Unterschriftenliste generieren'); ?>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><?php echo $this->Html->link(__('HTML'), array('controller' => 'courses_terms', 'action' => 'list', $coursesTerm['CoursesTerm']['id'], 'default')); ?></li>
                <li><?php echo $this->Html->link(__('PDF'), array('controller' => 'courses_terms', 'action' => 'list', $coursesTerm['CoursesTerm']['id'], 'ext' => 'pdf')); ?></li>
            </ul>
        </div>
        <?php echo $this->Html->link(__('Kurs absagen und neu ansetzen'), array('controller' => 'courses_terms', 'action' => 'nameplates', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-small btn-danger')); ?>
    </div>
</div>

<hr/>

<div class="row-fluid">
    <div class="span12">
        <div id="booking">
            <input id="CoursesTermId" value="<?php echo $coursesTerm['CoursesTerm']['id']; ?>" type="hidden"/>

            <div class="type flat-ui-sun-flower"><?php echo __('Unbestätigte Anmeldungen'); ?></div>
            <table class="table-condensed table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Bestätigen'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: (bookings.unconfirmed().length > 0) -->
                <tbody>
                <tr>
                    <td colspan="5">Leer</td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: (bookings.unconfirmed().length > 0) -->
                <tbody data-bind="foreach: { data: bookings.unconfirmed, as: 'unconfirmed' }">
                <tr data-bind="attr: { 'data-id' : unconfirmed.Booking.id, 'data-type': 'unconfirmed' }">
                    <td><span data-bind="text: unconfirmed['0'].User_name"></span></td>
                    <td><span data-bind="text: unconfirmed['0'].Booking_created + ' Uhr'"></span></td>
                    <td><a class="btn-link" data-bind="click: $parent.confirm"><?php echo __('Bestätigen'); ?></a>
                    </td>
                    <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
                    <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
                </tr>
                </tbody>
                <!-- /ko -->
            </table>

            <div class="type flat-ui-carrot"><?php echo __('Selbst abgemeldet'); ?></div>
            <table class="table-condensed table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Abgemeldet am'); ?></th>
                <th><?php echo __('Anmelden'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: (bookings.self_unsubscribed().length > 0) -->
                <tbody>
                <tr>
                    <td colspan="6"><?php echo __('Leer'); ?></td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: (bookings.unconfirmed().length > 0) -->
                <tbody data-bind="foreach: { data: bookings.self_unsubscribed, as: 'self_unsubscribed' }">
                <tr data-bind="attr: { 'data-id' : self_unsubscribed.Booking.id, 'data-type': 'self_unsubscribed' }">
                    <td><span data-bind="text: self_unsubscribed['0'].User_name"></span></td>
                    <td><span data-bind="text: self_unsubscribed['0'].Booking_created + ' Uhr'"></span></td>
                    <td><span data-bind="text: self_unsubscribed['0'].Booking_unsubscribed_at + ' Uhr'"></span></td>
                    <td><a class="btn-link" data-bind="click: $parent.confirm"><?php echo __('Anmelden'); ?></a>
                    </td>
                    <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
                    <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
                </tr>
                </tbody>
                <!-- /ko -->
            </table>

            <div class="type flat-ui-alizarin"><?php echo __('Wurde abgemeldet'); ?></div>
            <table class="table-condensed table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Anmelden'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: (bookings.admin_unsubscribed().length > 0) -->
                <tbody>
                <tr>
                    <td colspan="6"><?php echo __('Leer'); ?></td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: (bookings.admin_unsubscribed().length > 0) -->
                <tbody data-bind="foreach: { data: bookings.admin_unsubscribed, as: 'admin_unsubscribed' }">
                <tr data-bind="attr: { 'data-id' : admin_unsubscribed.Booking.id, 'data-type': 'admin_unsubscribed' }">
                    <td><span data-bind="text: admin_unsubscribed['0'].User_name"></span></td>
                    <td><span data-bind="text: admin_unsubscribed['0'].Booking_created + ' Uhr'"></span></td>
                    <td><a class="btn-link" data-bind="click: $parent.confirm"><?php echo __('Anmelden'); ?></a>
                    </td>
                    <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
                    <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
                </tr>
                </tbody>
                <!-- /ko -->
            </table>

            <div class="type flat-ui-peter-river"><?php echo __('Bestätigt'); ?></div>

            <table class="table-condensed table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Abgerechnet'); ?></th>
                <th><?php echo __('Abmelden'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: (bookings.confirmed().length > 0) -->
                <tbody>
                <tr>
                    <td colspan="5"><?php echo __('Leer'); ?></td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: (bookings.confirmed().length > 0) -->
                <tbody data-bind="foreach: { data: bookings.confirmed, as: 'confirmed' }">
                <tr data-bind="attr: { 'data-id' : confirmed.Booking.id, 'data-type': 'confirmed' }">
                    <td><span data-bind="text: confirmed['0'].User_name"></span></td>
                    <td><span data-bind="text: confirmed['0'].Booking_created + ' Uhr'"></span></td>
                    <td><a class="btn-link" data-bind="click: $parent.cleared"><?php echo __('Abgerechnet'); ?></a></td>
                    <td><a class="btn-link" data-bind="click: $parent.unsubscribe"><?php echo __('Abmelden'); ?></a>
                    </td>
                    <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
                    <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
                </tr>
                </tbody>
                <!-- /ko -->
            </table>

            <div class="type flat-ui-green-see"><?php echo __('Abgerechnet'); ?></div>

            <table class="table-condensed table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Anmelden'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: (bookings.cleared().length > 0) -->
                <tbody>
                <tr>
                    <td colspan="6"><?php echo __('Leer'); ?></td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: (bookings.cleared().length > 0) -->
                <tbody data-bind="foreach: { data: bookings.cleared, as: 'cleared' }">
                <tr data-bind="attr: { 'data-id' : cleared.Booking.id, 'data-type': 'cleared' }">
                    <td><span data-bind="text: cleared['0'].User_name"></span></td>
                    <td><span data-bind="text: cleared['0'].Booking_created + ' Uhr'"></span></td>
                    <td><a class="btn-link" data-bind="click: $parent.confirm"><?php echo __('Anmelden'); ?></a>
                    </td>
                    <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
                    <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
                </tr>
                </tbody>
                <!-- /ko -->
            </table>
        </div>
    </div>
</div>

<?php echo $this->Html->script('courses_terms/view'); ?>