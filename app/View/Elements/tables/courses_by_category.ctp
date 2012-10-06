<?php foreach ($coursesByCategory as $category): ?>
<?php if (empty($category['Course'])) { continue; }; ?>

<div class="">
    <h5><?php echo $category['Category']['name']; ?></h5>
    <table class="table table-condensed table-bordered table-striped">

        <thead>
            <tr>
                <?php if ($form): ?>
                    <td width="5%"><?php echo __('Wählen'); ?></td>
                <?php endif; ?>
                <td width="50%"><?php echo __('Kurs'); ?></td>
                <td width="10%"><?php echo __('Semester'); ?></td>
                <td width="100px"><?php echo __('Begin am'); ?></td>
                <td width="100px"><?php echo __('Von'); ?></td>
                <td width="100px"><?php echo __('Bis'); ?></td>
                <td width="5%"><?php echo __('Aktuelle Belegung'); ?></td>
                <td width="5%"><?php echo __('Maximale Teilnehmer'); ?></td>
            </tr>
        </thead>

        <tbody>
            <?php $i = 1; ?>
            <?php if (empty($category['Course'])): ?>
        <tr>
            <td colspan="8"><?php echo __('Keine Kurse'); ?></td>
        </tr>
            <?php else: ?>
                <?php foreach ($category['Course'] as $course): ?>
                    <?php foreach ($course['CoursesTerm'] as $courseByTerm): ?>
                        <tr class="check <?php echo ($courseByTerm['attendees'] > $courseByTerm['max']) ? 'error' : ''; ?>">
                            <?php if ($form): ?>
                                <td><?php echo $this->Form->input('CourseTerm.' . $i, array('class' => 'booking', 'label' => false, 'type' => 'checkbox', 'value' => $courseByTerm['id'])); ?></td>
                            <?php endif; ?>
                            <td><?php echo h($course['label']); ?></td>
                            <td><?php echo h($courseByTerm['Term']['name']); ?></td>
                            <!-- days -->
                            <td colspan="3">
                                <?php if (empty($courseByTerm['Day'])): ?>
                                    <?php echo __('Noch kein Termin festgelegt'); ?>
                                <?php else: ?>
                                <table class="inner-table">
                                    <tbody>
                                        <?php foreach($courseByTerm['Day'] as $day): ?>
                                        <tr>
                                            <td width="100px"><?php echo h(date('d.m.Y', strtotime($day['start_date']))); ?></td>
                                            <td width="100px"><?php echo h(substr($day['start_time'], 0, 5) . ' ' . __('Uhr')); ?></td>
                                            <td width="100px"><?php echo h(substr($day['end_time'], 0, 5) . ' ' . __('Uhr')); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                            </td>
                            <!-- end days -->
                            <td class="table-center"><?php echo h($courseByTerm['attendees']); ?></td>
                            <td class="table-center"><?php echo h($courseByTerm['max']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endforeach; ?>

<style>
table.inner-table {
    width:100%;
    font-size: 15px;
}
table.inner-table td {
    background: transparent !important;
}
table.inner-table td {
    border:none;
    margin: -5px;
}
table.inner-table tr+tr {
    border-top:1px solid lightgrey;
}
table.table tbody td.table-center {
    text-align: center;
    vertical-align: middle;
}
</style>