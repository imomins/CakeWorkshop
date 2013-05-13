<div class="page-header">
    <h3><?php echo __('Semesterkurse'); ?></h3>
</div>

<?php echo $this->Form->create('Term', array('class' => 'form-inline well')); ?>
<input type="text" name="query" class="span4 search-query"
       value="<?php echo isset($this->request->data['query']) ? $this->request->data['query'] : ''; ?>"
       placeholder="Kurs suchen">
<?php echo $this->Form->input('term_id',
    array(
        'empty'    => __('Semester Filtern'),
        'label'    => false,
        'class'    => 'span3',
        'value'    => $this->request->data['term_id'],
        'div'      => false,
        'style'    => 'margin-left:5px;',
        'onchange' => "window.location = '" . Router::url('/admin/courses_terms/index') . "/'+this.value"
    )
); ?>
<?php echo $this->Form->end(); ?>

<table class="table table-striped table-bordered table-hover">
    <tr>
        <th><?php echo $this->Paginator->sort('CoursesTerm.id', __('Kurs-Nr.')); ?></th>
        <th><?php echo $this->Paginator->sort('Course.name', __('Kurs')); ?></th>
        <th width="10%"><?php echo $this->Paginator->sort('schedule_name', __('Status')); ?></th>
        <th width="15%"><?php echo $this->Paginator->sort('term_id', __('Semester')); ?></th>

        <!--
        <th><?php echo $this->Paginator->sort('start_date', __('Am')); ?></th>
        <th><?php echo $this->Paginator->sort('start_time', __('Von')); ?></th>
        <th><?php echo $this->Paginator->sort('end_time', __('Bis')); ?></th>
        -->
        <th><?php echo $this->Paginator->sort('attendees', __('Teilnehmer')); ?></th>
        <th><?php echo $this->Paginator->sort('max', __('Maximal')); ?></th>
        <th colspan="3" style="min-width: 180px;"><?php echo __('Optionen'); ?></th>
    </tr>
    <?php
    foreach ($coursesTerms as $coursesTerm): ?>
        <tr class="<?php echo($coursesTerm['CoursesTerm']['attendees'] > $coursesTerm['CoursesTerm']['max'] ? 'error' : '') ?>">
            <td><?php echo $this->Html->link($coursesTerm['CoursesTerm']['id'], array('controller' => 'courses_terms', 'action' => 'view', $coursesTerm['CoursesTerm']['id'])); ?></td>
            <td><?php echo $this->Html->link($coursesTerm['Course']['name'], array('controller' => 'courses', 'action' => 'view', $coursesTerm['Course']['id'])); ?></td>
            <td><?php echo $this->Html->link($coursesTerm['Schedule']['display'], array('controller' => 'schedules', 'action' => 'view', $coursesTerm['CoursesTerm']['schedule_name'])); ?></td>
            <td><?php echo $this->Html->link($coursesTerm['Term']['name'], array('controller' => 'terms', 'action' => 'view', $coursesTerm['Term']['id'])); ?></td>
            <!-- days
            <td colspan="3" class="days">
                <?php foreach ($coursesTerm['Day'] as $day): ?>
                    <p><?php echo h(date('d.m.Y', strtotime($day['start_date']))) . ', ' . h(substr($day['start_time'], 0, 5) . ' ' . __('Uhr')) . ', ' . h(substr($day['end_time'], 0, 5) . ' ' . __('Uhr')); ?></p>
                <?php endforeach; ?>
            </td>
            end days -->
            <td class="center"><?php echo h($coursesTerm['CoursesTerm']['attendees']); ?>&nbsp;</td>
            <td class="center"><?php echo h($coursesTerm['CoursesTerm']['max']); ?>&nbsp;</td>
            <td>
                <?php echo $this->Html->link(__('Details'), array('action' => 'view', $coursesTerm['CoursesTerm']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $coursesTerm['CoursesTerm']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $coursesTerm['CoursesTerm']['id']), null, __('Soll der Kurs gelöscht werden?')); ?>
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