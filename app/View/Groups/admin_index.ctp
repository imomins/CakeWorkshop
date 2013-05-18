<h3 class="page-header"><?php echo __('Groups'); ?></h3>
<table class="table table-bordered table-hover table-striped">
    <tr>
        <th><?php echo $this->Paginator->sort('display'); ?></th>
        <th colspan="3" class="actions"><?php echo __('Optionen'); ?></th>
    </tr>
    <?php foreach ($groups as $group): ?>
        <tr>
            <td><?php echo h($group['Group']['display']); ?>&nbsp;</td>
            <td>
                <?php echo $this->Html->link(__('Anzeigen'), array('action' => 'view', $group['Group']['name'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $group['Group']['name'])); ?>
            </td>
            <td>
                <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $group['Group']['name']), null, __('Are you sure you want to delete # %s?', $group['Group']['name'])); ?>
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
