<div class="page-header">
    <h3><?php echo __('Gruppenübersicht'); ?></h3>
</div>

<table class="table table-striped table-bordered">
    <tr>
        <th><?php echo $this->Paginator->sort('display', __('Name')); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    <?php
    foreach ($groups as $group): ?>
        <tr>
            <td><?php echo h($group['Group']['display']); ?>&nbsp;</td>
            <td class="actions">
                <?php echo $this->Html->link(__('View'), array('action' => 'view', $group['Group']['name'])); ?>
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $group['Group']['name'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $group['Group']['name']), null, __('Are you sure you want to delete # %s?', $group['Group']['name'])); ?>
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
