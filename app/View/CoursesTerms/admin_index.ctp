<div class="coursesTerms index">
    <h3><?php echo __('Festgelegte Kurse für Semester'); ?></h3>

    <table class="table table-striped table-bordered table-condensed">
        <tr>
            <th><?php echo $this->Paginator->sort('term_id', __('Semester')); ?></th>
            <th><?php echo $this->Paginator->sort('course_id', __('Kurs')); ?></th>
            <th><?php echo $this->Paginator->sort('start_date', __('Am')); ?></th>
            <th><?php echo $this->Paginator->sort('start_time', __('Von')); ?></th>
            <th><?php echo $this->Paginator->sort('end_time', __('Bis')); ?></th>
            <th><?php echo $this->Paginator->sort('attendees', __('Teilnehmer')); ?></th>
            <th><?php echo $this->Paginator->sort('max', __('Maximal')); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo __('Drucken'); ?></th>
        </tr>
        <?php
        foreach ($coursesTerms as $coursesTerm): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($coursesTerm['Term']['name'], array('controller' => 'terms', 'action' => 'view', $coursesTerm['Term']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($coursesTerm['Course']['label'], array('controller' => 'courses', 'action' => 'view', $coursesTerm['Course']['id'])); ?>
                </td>
                <!-- days -->
                <td colspan="3">
                    <table class="inner-table">
                        <tbody>
                            <?php foreach($coursesTerm['Day'] as $day): ?>
                            <tr>
                                <td width="33%"><?php echo h(date('d.m.Y', strtotime($day['start_date']))); ?></td>
                                <td width="33%"><?php echo h(substr($day['start_time'], 0, 5) . ' ' . __('Uhr')); ?></td>
                                <td width="33%"><?php echo h(substr($day['end_time'], 0, 5) . ' ' . __('Uhr')); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </td>
                <!-- end days -->
                <td><?php echo h($coursesTerm['CoursesTerm']['attendees']); ?>&nbsp;</td>
                <td><?php echo h($coursesTerm['CoursesTerm']['max']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $coursesTerm['CoursesTerm']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $coursesTerm['CoursesTerm']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $coursesTerm['CoursesTerm']['id']), null, __('Are you sure you want to delete # %s?', $coursesTerm['Course']['label'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link(__('PDF'), array('action' => 'view', 'ext'=>'pdf', $coursesTerm['CoursesTerm']['id'], $coursesTerm['Course']['label'])); ?>
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
</div>