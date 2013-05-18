<h3><?php echo __('Semester-Kurs Status'); ?></h3>
<table class="table table-bordered table-hover table-striped">
    <tr>
        <th><?php echo $this->Paginator->sort('display'); ?></th>
        <th><?php echo __('Actions'); ?></th>
    </tr>
    <?php foreach ($schedules as $schedule): ?>
        <tr>
            <td>
                <?php echo $this->Html->link($schedule['Schedule']['display'], array('action' => 'view', $schedule['Schedule']['name'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $schedule['Schedule']['name'])); ?>
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
