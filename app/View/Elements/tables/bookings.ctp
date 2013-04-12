<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <td width="29%"><?php echo __('Kurs'); ?></td>
        <td width="10%"><?php echo __('Semester'); ?></td>
        <td width="100px"><?php echo __('Schulungstag(e)'); ?></td>
        <td width="100px"><?php echo __('Von'); ?></td>
        <td width="100px"><?php echo __('Bis'); ?></td>
        <td width="8%"><?php echo __('Abmelden'); ?></td>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($bookings as $booking): ?>
        <tr class="<?php echo ($booking['CoursesTerm']['attendees'] > $booking['CoursesTerm']['max']) ? 'error' : ''; ?>">
            <td><?php echo h($booking['CoursesTerm']['Course']['name']); ?></td>
            <td><?php echo h($booking['CoursesTerm']['Term']['name']); ?></td>
            <!-- days -->
            <td colspan="3">
                <?php if (empty($booking['CoursesTerm']['Day'])): ?>
                    <?php echo __('Noch kein Termin festgelegt'); ?>
                <?php else: ?>
                    <table class="inner-table">
                        <tbody>
                        <?php foreach ($booking['CoursesTerm']['Day'] as $day): ?>
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
            <td>
                <a id="booking_<?php echo $booking['Booking']['id']; ?>" class="btn btn-small btn-danger"><?php echo __('Abmelden'); ?></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<style>
    table.inner-table tbody tr td {
        padding: 2px 5px;
    }

    table.inner-table {
        margin: 0px;
    }
</style>