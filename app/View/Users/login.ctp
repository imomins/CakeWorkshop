<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#register" data-toggle="tab"><?php echo __('Anmeldung'); ?></a></li>
        <li><a id="tabCourse" href="#courses"
               data-toggle="tab"><?php echo __('Kurs Übersicht für dieses Semester'); ?></a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="register">

            <div class="row-fluid">
                <div class="alert bg-light-blue"><?php echo $settings['alert_startpage']['value']; ?></div>
            </div>

            <div class="row-fluid">
                <?php echo $this->element('forms/register'); ?>
                <?php echo $this->element('forms/login'); ?>
            </div>

        </div>

        <div class="tab-pane" id="courses">
            <div class="alert bg-light-blue"><?php echo $settings['alert_register_workshop']['value']; ?></div>

            <div id="course">
                <div data-bind="foreach: { data: categories, as: 'category' }">
                    <h4 data-bind="text: category.Category.name"></h4>
                    <table class="table table-bordered table-condensed table-striped table-hover">
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
                            <th style="width: 40px;">Am</th>
                            <th style="width: 40px;">Von</th>
                            <th style="width: 40px;">Bis</th>
                        </tr>
                        </thead>

                        <tbody data-bind="foreach: { data: category.Category.CoursesTerm, as: 'CoursesTerm' }">
                        <tr data-bind="visible: category.Category.isEmpty">
                            <td colspan="6">Momentan stehen keine Kurse zur Auswahl</td>
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
                                <span data-bind="if: (CoursesTerm.days.length === 0)">Noch kein Termin festgelegt</span>

                                <table class="table-embedded">
                                    <tbody data-bind="foreach: { data: CoursesTerm.days, as: 'day' }">
                                    <tr>
                                        <td data-bind="text: day.start_date"></td>
                                        <td data-bind="text: day.start_time + ' Uhr'"></td>
                                        <td data-bind="text: day.end_time + ' Uhr'"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <!-- end days -->
                            <td class="center table-center" data-bind="text: CoursesTerm.attendees"></td>
                            <td class="center table-center" data-bind="text: CoursesTerm.max"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php echo $this->Html->css('users/login'); ?>
<?php echo $this->Html->script('users/login'); ?>