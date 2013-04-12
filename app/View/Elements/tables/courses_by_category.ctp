<?php
foreach ($coursesByCategory as $categories): ?>
    <div>
        <h5><?php echo $categories['Category']['name']; ?></h5>
        <table class="table-courses table table-bordered table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th rowspan="2" width="5%"><?php echo __('Kurs-Nr.'); ?></th>
                    <th rowspan="2" width="50%"><?php echo __('Kurs-Titel'); ?></th>
                    <th rowspan="2" width="10%"><?php echo __('Semester'); ?></th>
                    <th colspan="3"><?php echo __('Verantstaltungstag(e)'); ?></th>
                    <th rowspan="2" width="5%"><?php echo __('Aktuelle Belegung'); ?></th>
                    <th rowspan="2" width="5%"><?php echo __('Maximale Teilnehmer'); ?></th>
                    <?php if ($form): ?>
                        <th rowspan="2" width="5%">
                            <?php echo __('Auswahl'); ?>
                        </th>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?php echo __('Am'); ?></th>
                    <th><?php echo __('Von'); ?></th>
                    <th><?php echo __('Bis'); ?></th>
                </tr>
            </thead>

            <tbody>
            <?php if (!isset($categories['Category']['CoursesTerm'])): ?>
                <tr>
                    <td colspan="8"><?php echo __('Momentan stehen keine Kurse zur Auswahl'); ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories['Category']['CoursesTerm'] as $coursesTerm): ?>
                    <tr class="choice <?php echo ($coursesTerm['attendees'] > $coursesTerm['max']) ? 'error' : ''; ?>">
                        <td><?php echo $coursesTerm['id']; ?></td>
                        <td class="course-name"><?php echo h($coursesTerm['Course']['name']); ?></td>
                        <td><?php echo h($coursesTerm['Term']['name']); ?></td>
                        <!-- days -->
                        <td colspan="3" style="min-width: 230px;">
                            <?php if (empty($coursesTerm['days'])): ?>
                                <?php echo __('Noch kein Termin festgelegt'); ?>
                            <?php else: ?>
                                <?php foreach ($coursesTerm['days'] as $day): ?>
                                    <?php echo h(date('d.m.Y', strtotime($day['start_date']))) . ', ' . h(substr($day['start_time'], 0, 5) . ' ' . __('Uhr')) . ', ' . h(substr($day['end_time'], 0, 5) . ' ' . __('Uhr')); ?>
                                    <br/>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        <!-- end days -->
                        <td class="table-center"><?php echo h($coursesTerm['attendees']); ?></td>
                        <td class="table-center"><?php echo h($coursesTerm['max']); ?></td>
                        <?php if ($form): ?>
                            <td class="check">
                                <?php if ($coursesTerm['Booking']['booking_state_name'] === null): ?>
                                    <a class="btn btn-info btn-mini" data-toggle="button"><?php echo __('Auswählen'); ?></a>
                                    <?php echo $this->Form->input('CoursesTerm.id.' . $coursesTerm['id'], array('hidden' => true, 'type' => 'checkbox', 'label' => false, 'div' => false)); ?>
                                <?php else: ?>
                                    <?php
                                    switch ($coursesTerm['Booking']['booking_state_name']):
                                        case 'self_unsubscribed':
                                        case 'confirmed':
                                        case 'unconfirmed':
                                            echo $this->Form->postLink(__('Abmelden'), array('action' => 'delete'), array('class' => 'btn btn-inverse btn-mini'), __('Wollen Sie sich abmelden?'));
                                            break;
                                        case 'admin_unsubscribed':
                                            echo '<span class="label label-warning">' . __('Abgemeldet') . '</span>';
                                            break;
                                        default:
                                            echo $this->Form->input('CoursesTerm.id.' . $coursesTerm['id'], array('label' => false, 'class' => 'attend', 'type' => 'checkbox'));
                                    endswitch;
                                    ?>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>