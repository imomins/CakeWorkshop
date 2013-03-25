<div class="page-header">
    <h4><?php  echo __('Semesterkurse'); ?></h4>
</div>

<?php echo $this->Form->create('Term', array('class' => 'form-inline')); ?>
<?php echo $this->Form->input('term_id', array('label' => __('Semester Filtern:'), 'style' => 'margin-left:5px;')); ?>
<?php echo $this->Form->end(); ?>

<table class="table table-striped table-bordered">
    <tr>
        <th><?php echo $this->Paginator->sort('term_id', __('Semester')); ?></th>
        <th><?php echo $this->Paginator->sort('course_id', __('Kurs')); ?></th>
        <th><?php echo $this->Paginator->sort('start_date', __('Am')); ?></th>
        <th><?php echo $this->Paginator->sort('start_time', __('Von')); ?></th>
        <th><?php echo $this->Paginator->sort('end_time', __('Bis')); ?></th>
        <th><?php echo $this->Paginator->sort('attendees', __('Teilnehmer')); ?></th>
        <th><?php echo $this->Paginator->sort('max', __('Maximal')); ?></th>
        <th class="actions" style="min-width: 180px;"><?php echo __('Optionen'); ?></th>
    </tr>
    <?php
    foreach ($coursesTerms as $coursesTerm): ?>
        <tr class="<?php echo ($coursesTerm['CoursesTerm']['attendees'] > $coursesTerm['CoursesTerm']['max'] ? 'error' : '') ?>">
            <td>
                <?php echo $this->Html->link($coursesTerm['Term']['name'], array('controller' => 'terms', 'action' => 'view', $coursesTerm['Term']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link($coursesTerm['Course']['name'], array('controller' => 'courses', 'action' => 'view', $coursesTerm['Course']['id'])); ?>
            </td>
            <!-- days -->
            <td colspan="3" class="days">
                <?php foreach ($coursesTerm['Day'] as $day): ?>
                    <p><?php echo h(date('d.m.Y', strtotime($day['start_date']))) . ', ' . h(substr($day['start_time'], 0, 5) . ' ' . __('Uhr')) . ', ' . h(substr($day['end_time'], 0, 5) . ' ' . __('Uhr')); ?></p>
                <?php endforeach; ?>
            </td>
            <!-- end days -->
            <td><?php echo h($coursesTerm['CoursesTerm']['attendees']); ?>&nbsp;</td>
            <td><?php echo h($coursesTerm['CoursesTerm']['max']); ?>&nbsp;</td>
            <td class="actions">
                <?php echo $this->Html->link(__('View'), array('action' => 'view', $coursesTerm['CoursesTerm']['id'])); ?>
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $coursesTerm['CoursesTerm']['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $coursesTerm['CoursesTerm']['id']), null, __('Are you sure you want to delete # %s?', $coursesTerm['Course']['name'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>    </p>

<div class="paging">
    <?php
    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>

<style>
td.days { min-width: 230px; }
.page-header {
    margin: 20px 0 20px;
}
</style>