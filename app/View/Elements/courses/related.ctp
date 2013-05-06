<h3><?php echo __('Übersicht angesetzter Schulungen für diesen Kurs'); ?></h3>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th width="5%"><?php echo __('Kurs-Nr.'); ?></th>
        <th><?php echo __('Kursstatus'); ?></th>
        <th><?php echo __('Semester'); ?></th>
        <th width="5%"><?php echo __('Teilnehmerzahl'); ?></th>
        <th width="5%"><?php echo __('Maximal'); ?></th>
        <th width="5%"><?php echo __('Beabeiten'); ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($courses_terms as $ct): ?>
        <tr>
            <td style="text-align: right;"><?php echo $ct['CoursesTerm']['id']; ?></td>
            <td><?php echo $ct['Schedule']['display']; ?></td>
            <td><?php echo $ct['Term']['name']; ?></td>
            <td><?php echo $ct['CoursesTerm']['attendees']; ?></td>
            <td><?php echo $ct['CoursesTerm']['max']; ?></td>
            <td><a class="btn-link" href="<?php echo Router::url('/admin/courses_terms/edit/') . $ct['CoursesTerm']['id']; ?>"><?php echo __('Bearbeiten'); ?></a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
