<div class="page-header">
    <h3><?php  echo __('Fachbereiche'); ?></h3>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
        <th><?php echo $this->Paginator->sort('number', __('Fachbereich Nummer')); ?></th>
        <th class="actions" style="width: 0%;"><?php echo __('Optionen'); ?></th>
    </thead>

    <tbody>
        <?php
        foreach ($departments as $department): ?>
            <tr>
                <td><?php echo $this->Html->link($department['Department']['name'], array('action' => 'view', $department['Department']['id'])); ?></td>
                <td><?php echo h($department['Department']['number']); ?></td>
                <td>
                    <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $department['Department']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $department['Department']['id']), null, __('Are you sure you want to delete # %s?', $department['Department']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
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
