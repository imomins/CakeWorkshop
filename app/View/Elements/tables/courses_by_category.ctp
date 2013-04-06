<?php
foreach ($coursesByCategory as $categories): ?>
    <div>
        <h5><?php echo $categories['Category']['name']; ?></h5>
        <table class="table table-bordered table-condensed table-striped">
            <thead>
            <tr>
                <?php if ($form): ?>
                    <th width="5%"><?php echo __('Wählen'); ?></th>
                <?php endif; ?>
                <th width="50%"><?php echo __('Kurs'); ?></th>
                <th width="10%"><?php echo __('Semester'); ?></th>
                <th><?php echo __('Am'); ?></th>
                <th><?php echo __('Von'); ?></th>
                <th><?php echo __('Bis'); ?></th>
                <th width="5%"><?php echo __('Aktuelle Belegung'); ?></th>
                <th width="5%"><?php echo __('Maximale Teilnehmer'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php $i = 1; ?>
            <?php if (!isset($categories['Category']['CoursesTerm'])): ?>
                <tr>
                    <td colspan="8"><?php echo __('Keine Kurse'); ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories['Category']['CoursesTerm'] as $coursesTerm): ?>
                    <tr class="check <?php echo ($coursesTerm['attendees'] > $coursesTerm['max']) ? 'error' : ''; ?>">
                        <?php if ($form): ?>
                            <td><?php echo $this->Form->input('CourseTerm.' . $i, array('class' => 'booking', 'label' => false, 'type' => 'checkbox', 'value' => $coursesTerm['id'])); ?></td>
                        <?php endif; ?>
                        <td><?php echo h($coursesTerm['Course']['name']); ?></td>
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
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

<style>
    table.inner-table {
        width: 100%;
        font-size: 15px;
    }

    table.inner-table td {
        background: transparent !important;
    }

    table.inner-table td {
        border: none;
        margin: -5px;
    }

    table.inner-table tr+tr {
        border-top: 1px solid lightgrey;
    }

    table.table tbody td.table-center {
        text-align: center;
        vertical-align: middle;
    }
</style>