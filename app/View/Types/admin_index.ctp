<div class="page-header">
    <h3><?php echo __('Rechnungsarten'); ?></h3>
</div>

<table class="table table-bordered table-striped">
    <tr>
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    <?php
    foreach ($types as $type): ?>
        <tr>
            <td><?php echo h($type['Type']['display']); ?>&nbsp;</td>
            <td class="actions">
                <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $type['Type']['name'])); ?>
                <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $type['Type']['name']), null, __('Are you sure you want to delete # %s?', $type['Type']['name'])); ?>
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
