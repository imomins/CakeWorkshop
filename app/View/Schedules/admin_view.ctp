<h3 class="page-header"><?php echo __('Semester-Kurse mit dem Status "%s"', $schedule['Schedule']['display']); ?></h3>
<?php if ($count > 0): ?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Semester-Kurs-Nr.'); ?></th>
            <th><?php echo __('Kurs-Titel'); ?></th>
            <th><?php echo __('Semester'); ?></th>
            <th><?php echo __('Teilnehmer'); ?></th>
            <th><?php echo __('Maximal'); ?></th>
            <th><?php echo __('Gesperrt?'); ?></th>
        </tr>
        <?php foreach ($schedule['CoursesTerm'] as $course): ?>
            <tr>
                <td><?php echo $course['CoursesTerm']['id']; ?></td>
                <td>
                    <?php echo $this->Html->link($course['Course']['name'], array('controller' => 'courses_terms', 'action' => 'view', $course['CoursesTerm']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($course['Term']['name'], array('controller' => 'terms', 'action' => 'view', $course['Term']['id'])); ?>
                </td>
                <td><?php echo $course['CoursesTerm']['attendees']; ?></td>
                <td><?php echo $course['CoursesTerm']['max']; ?></td>
                <td><?php echo $this->Frontend->YesNo($course['CoursesTerm']['locked']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <ul class="pager">
        <?php echo __('Seite %s von %s', $page + 1, $pages); ?>
        <?php if ($page > 0): ?>
            <li class="previous">
                <?php echo $this->Html->link(
                    __('<<< Zurück'),
                    array('controller' => 'schedules', 'action' => 'view', $schedule['Schedule']['name'], $page - 1)
                ); ?>
            </li>
        <?php endif; ?>

        <?php if ($page < $pages - 1): ?>
            <li class="next">
                <?php echo $this->Html->link(
                    __('Weiter >>>'),
                    array('controller' => 'schedules', 'action' => 'view', $schedule['Schedule']['name'], $page + 1)
                ); ?>
            </li>
        <?php endif; ?>
    </ul>
<?php else: ?>
    <div class="alert alert-info">
        <?php echo __('Keine Ergebnisse'); ?>
    </div>
<?php endif; ?>
