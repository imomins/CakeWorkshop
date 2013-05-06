<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#register" data-toggle="tab"><?php echo __('Anmeldung'); ?></a></li>
        <li><a id="tabCourse" href="#courses" data-toggle="tab"><?php echo __('Kurs Übersicht für dieses Semester'); ?></a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="register">

            <div class="row-fluid">
                <div class="alert bg-light-blue">
                    <button data-dismiss="alert" class="close" type="button">×</button>

                    <?php echo __('Bitte registrieren Sie sich oder melden Sie sich an, um Kurse zu belegen. Eine aktuelle Übersicht der Kurse können Sie auch ohne anmeldung einsehen.'); ?>
                    <br/>
                    <?php echo __('Falls Sie schon mal teilgenommen haben und ihre E-Mail angegeben hatten, dann klicken Sie <b><a href="%s">hier</a></b>, um ein Passwort zu erhalten.', Router::url('/users/reset')); ?>
                </div>
            </div>

            <div class="row-fluid">
                <?php echo $this->element('forms/register'); ?>
                <?php echo $this->element('forms/login'); ?>
            </div>

        </div>

        <div class="tab-pane" id="courses">
            <div class="alert bg-light-blue">
                <button data-dismiss="alert" class="close" type="button">×</button>

                <p><strong>Hinweis zur Anmeldung bei ausgebuchten Workshops</strong></p>
                <br/>

                <p>Vielen Dank für Ihr Interesse an unserem Workshopangebot. Auch wenn Workshops ausgebucht sind, melden Sie sich bitte trotzdem an. Oft werden noch Plätze über die Warteliste frei bzw. bei großem Interesse bieten wir auch Wiederholungstermine für einzelne Workshops an.</p>
            </div>

            <div id="course">
                <form id="formBooking" data-bind="submit: confirm">
                    <div data-bind="foreach: { data: categories, as: 'category' }">
                        <h4 data-bind="text: category.Category.name"></h4>
                        <table class="table-courses table table-bordered table-condensed table-striped table-hover">
                            <thead>
                            <tr>
                                <th rowspan="2" width="5%">Kurs-Nr.</th>
                                <th rowspan="2" width="50%">Kurs-Titel</th>
                                <th rowspan="2" width="15%">Semester</th>
                                <th colspan="3">Verantstaltungstag(e)</th>
                                <th rowspan="2" width="5%">Aktuelle Belegung</th>
                                <th rowspan="2" width="5%">Maximale Teilnehmer</th>
                            </tr>
                            <tr>
                                <th>Am</th>
                                <th>Von</th>
                                <th>Bis</th>
                            </tr>
                            </thead>

                            <tbody data-bind="foreach: { data: category.Category.CoursesTerm, as: 'CoursesTerm' }">
                            <tr data-bind="visible: category.Category.isEmpty">
                                <td colspan="8">Momentan stehen keine Kurse zur Auswahl</td>
                            </tr>
                            <tr data-bind="
                                    attr: {
                                        'data-id': CoursesTerm.id, 'data-status': CoursesTerm.booking_state,
                                        'class': 'choice ' + CoursesTerm.errorClass + ' ' + CoursesTerm.lockedClass + ' ' + CoursesTerm.confirmedClass
                                    }">
                                <td class="course-id" data-bind="text: CoursesTerm.id"></td>
                                <td data-bind="text: CoursesTerm.Course.name" class="course-name"></td>
                                <td data-bind="text: CoursesTerm.Term.name"></td>
                                <!-- days -->
                                <td colspan="3" style="min-width: 230px;">
                                    <span data-bind="if: CoursesTerm.noDays">Noch kein Termin festgelegt</span>
                                    <div data-bind="foreach: { data: CoursesTerm.days, as: 'day' }">
                                        <span data-bind="text: day.start_date + ', ' + day.start_time + ' Uhr, ' + day.end_time + ' Uhr'"></span>
                                        <br/>
                                    </div>
                                </td>
                                <!-- end days -->
                                <td class="table-center" data-bind="text: CoursesTerm.attendees"></td>
                                <td class="table-center" data-bind="text: CoursesTerm.max"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </form>

                <div id="confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><?php echo __('Ihre gewählten Kurse'); ?></h3>
                        <small><?php echo __('Bitte Überprüfen Sie Ihre Ihre Auswahl vor der Belegung'); ?></small>
                    </div>

                    <div class="modal-body">
                        <ol></ol>

                        <hr/>
                        <p class="text-info"><?php echo __('Sie erhalten eine Bestätigung per Email mit einer Übersicht Ihrer gebuchten Kurse'); ?></p>
                    </div>

                    <div class="modal-footer">
                        <button data-bind="click: save, text: saveBooking, disable: working" autocomplete="off" type="button" class="btn btn-primary"></button>
                        <button class="btn" data-bind="disable: working" data-dismiss="modal" aria-hidden="true"><?php echo __('Abbrechen'); ?></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php echo $this->Html->css('users/login'); ?>
<?php echo $this->Html->script('users/login'); ?>