<div class="row">
    <div class="span12">
        <h4><?php echo __('Semester-Kurs Übersicht'); ?></h4>
        <br/>
    </div>
</div>

<div class="row dl-big">
    <div class="span7">
        <h5 class="page-header"><?php echo __('Kursdaten'); ?></h5>
        <dl class="well dl-horizontal">
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
            <dd>
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
        <h5 class="page-header"><?php echo __('Angesetzte Kurstage'); ?></h5>
        <table class="table table-bordered table-striped table-hover">
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
        <?php echo $this->Html->link(__('Neuer Tag'), array('controller' => 'days', 'action' => 'add', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-small btn-primary', 'style' => 'margin:0;margin-top:-10px;')); ?>
    </div>
</div>

<div class="row">
    <div class="btn-toolbar span12">
        <div class="btn-group" style="margin-top: -30px;">
            <?php echo $this->Html->link(__('Kursdaten bearbeiten'), array('controller' => 'courses_terms', 'action' => 'edit', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-small btn-primary')); ?>
            <?php echo $this->Html->link(__('Namensschilder Drucken'), array('controller' => 'courses_terms', 'action' => 'nameplates', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-small')); ?>
            <?php echo $this->Html->link(__('Unterschriftenliste Drucken'), array('controller' => 'courses_terms', 'action' => 'nameplates', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-small')); ?>
            <?php echo $this->Html->link(__('Kurs absagen und neu ansetzen'), array('controller' => 'courses_terms', 'action' => 'nameplates', $coursesTerm['CoursesTerm']['id']), array('class' => 'btn btn-small btn-danger')); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="span12">
        <div id="booking">
            <input id="CoursesTermId" value="<?php echo $coursesTerm['CoursesTerm']['id']; ?>" type="hidden"/>

            <h4><?php echo __('Unbestätigte Anmeldungen'); ?></h4>
            <hr/>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Bestätigen'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: bookings.unconfirmed.hasChildren -->
                <tbody>
                <tr>
                    <td colspan="5">Leer</td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: bookings.unconfirmed.hasChildren -->
                <tbody data-bind="foreach: { data: bookings.unconfirmed.data, as: 'unconfirmed' }">
                <tr data-bind="attr: { 'data-id' : unconfirmed.Booking.id }">
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

            <h4><?php echo __('Selbst abgemeldet'); ?></h4>
            <hr/>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Abgemeldet am'); ?></th>
                <th><?php echo __('Anmelden'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: bookings.self_unsubscribed.hasChildren -->
                <tbody>
                <tr>
                    <td colspan="6"><?php echo __('Leer'); ?></td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: bookings.unconfirmed.hasChildren -->
                <tbody data-bind="foreach: { data: bookings.self_unsubscribed.data, as: 'self_unsubscribed' }">
                <tr data-bind="attr: { 'data-id' : self_unsubscribed.Booking.id }">
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

            <h4><?php echo __('Wurde abgemeldet'); ?></h4>
            <hr/>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Anmelden'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: bookings.admin_unsubscribed.hasChildren -->
                <tbody>
                <tr>
                    <td colspan="6"><?php echo __('Leer'); ?></td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: bookings.admin_unsubscribed.hasChildren -->
                <tbody data-bind="foreach: { data: bookings.admin_unsubscribed.data, as: 'admin_unsubscribed' }">
                <tr data-bind="attr: { 'data-id' : admin_unsubscribed.Booking.id }">
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

            <h4><?php echo __('Bestätigt'); ?></h4>
            <hr/>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Anmelden'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: bookings.confirmed.hasChildren -->
                <tbody>
                <tr>
                    <td colspan="5"><?php echo __('Leer'); ?></td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: bookings.confirmed.hasChildren -->
                <tbody data-bind="foreach: { data: bookings.confirmed.data, as: 'confirmed' }">
                <tr data-bind="attr: { 'data-id' : confirmed.Booking.id }">
                    <td><span data-bind="text: confirmed['0'].User_name"></span></td>
                    <td><span data-bind="text: confirmed['0'].Booking_created + ' Uhr'"></span></td>
                    <td><a class="btn-link" data-bind="click: $parent.confirm"><?php echo __('Anmelden'); ?></a>
                    </td>
                    <td><a class="btn-link" data-bind="click: $parent.edit"><?php echo __('Bearbeiten'); ?></a></td>
                    <td><a class="btn-link" data-bind="click: $parent.remove"><?php echo __('Löschen'); ?></a></td>
                </tr>
                </tbody>
                <!-- /ko -->
            </table>

            <h4><?php echo __('Abgerechnet'); ?></h4>
            <hr/>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Gebucht am'); ?></th>
                <th><?php echo __('Anmelden'); ?></th>
                <th><?php echo __('Bearbeiten'); ?></th>
                <th><?php echo __('Löschen'); ?></th>
                </thead>
                <!-- ko ifnot: bookings.cleared.hasChildren -->
                <tbody>
                <tr>
                    <td colspan="6"><?php echo __('Leer'); ?></td>
                </tr>
                </tbody>
                <!-- /ko -->
                <!-- ko if: bookings.cleared.hasChildren -->
                <tbody data-bind="foreach: { data: bookings.cleared.data, as: 'cleared' }">
                <tr data-bind="attr: { 'data-id' : cleared.Booking.id }">
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