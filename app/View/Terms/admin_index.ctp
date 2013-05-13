<div class="page-header">
    <h3><?php  echo __('Semester-Übersicht'); ?></h3>
</div>

<table class="table table-bordered table-striped">
    <tr>
        <th><?php echo $this->Paginator->sort('name', __('Bezeichnung')); ?></th>
        <th><?php echo $this->Paginator->sort('start', __('Von')); ?></th>
        <th><?php echo $this->Paginator->sort('end', __('Bis')); ?></th>
        <th><?php echo __('Bearbeiten'); ?></th>
        <th><?php echo __('Löschen'); ?></th>
    </tr>
    <?php
    foreach ($terms as $terms): ?>
        <tr>
            <td><?php echo $this->Html->link($terms['Term']['name'], array('action' => 'view', $terms['Term']['id'])); ?></td>
            <td><?php echo h($terms['Term']['start']); ?></td>
            <td><?php echo h($terms['Term']['end']); ?></td>
            <td>
                <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $terms['Term']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $terms['Term']['id']), null, __('Are you sure you want to delete # %s?', $terms['Term']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>
</p>

<div class="paging">
    <?php
    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>
