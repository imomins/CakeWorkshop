<div class="page-header">
    <h3><?php echo __('Rechnungsadressen'); ?></h3>
</div>

<table class="table table-bordered table-striped table-condensed table-hover">
    <tr>
        <th><?php echo $this->Paginator->sort('user_id', __('Teilnehmer')); ?></th>
        <th><?php echo $this->Paginator->sort('institution', __('Einrichtung')); ?></th>
        <th><?php echo $this->Paginator->sort('department', __('Fachbereich')); ?></th>
        <th><?php echo $this->Paginator->sort('postbox', __('Postfach')); ?></th>
        <th><?php echo $this->Paginator->sort('to_person', __('z. Hd.')); ?></th>
        <th><?php echo $this->Paginator->sort('street', __('Straße')); ?></th>
        <th><?php echo $this->Paginator->sort('zip', __('PLZ')); ?></th>
        <th><?php echo $this->Paginator->sort('location', __('Ort')); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    <?php foreach ($invoices as $invoice): ?>
        <tr>
            <td>
                <?php echo $this->Html->link($invoice['User']['name'], array('controller' => 'users', 'action' => 'view', $invoice['User']['id'])); ?>
            </td>
            <td><?php echo h($invoice['Invoice']['institution']); ?>&nbsp;</td>
            <td><?php echo h($invoice['Invoice']['department']); ?>&nbsp;</td>
            <td><?php echo h($invoice['Invoice']['postbox']); ?>&nbsp;</td>
            <td><?php echo h($invoice['Invoice']['to_person']); ?>&nbsp;</td>
            <td><?php echo h($invoice['Invoice']['street']); ?>&nbsp;</td>
            <td><?php echo h($invoice['Invoice']['zip']); ?>&nbsp;</td>
            <td><?php echo h($invoice['Invoice']['location']); ?>&nbsp;</td>
            <td class="actions">
                <?php echo $this->Html->link(__('View'), array('action' => 'view', $invoice['Invoice']['id'])); ?>
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $invoice['Invoice']['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $invoice['Invoice']['id']), null, __('Are you sure you want to delete # %s?', $invoice['Invoice']['id'])); ?>
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