<div class="invoiceTypes view">
<h2><?php  echo __('Invoice Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($invoiceType['InvoiceType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($invoiceType['InvoiceType']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Invoice Type'), array('action' => 'edit', $invoiceType['InvoiceType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Invoice Type'), array('action' => 'delete', $invoiceType['InvoiceType']['id']), null, __('Are you sure you want to delete # %s?', $invoiceType['InvoiceType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoice Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice Type'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice'), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Invoices'); ?></h3>
	<?php if (!empty($invoiceType['Invoice'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Invoice Type Id'); ?></th>
		<th><?php echo __('Institution'); ?></th>
		<th><?php echo __('Department'); ?></th>
		<th><?php echo __('Postbox'); ?></th>
		<th><?php echo __('To Person'); ?></th>
		<th><?php echo __('Street'); ?></th>
		<th><?php echo __('Zip'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($invoiceType['Invoice'] as $invoice): ?>
		<tr>
			<td><?php echo $invoice['id']; ?></td>
			<td><?php echo $invoice['invoice_type_id']; ?></td>
			<td><?php echo $invoice['institution']; ?></td>
			<td><?php echo $invoice['department']; ?></td>
			<td><?php echo $invoice['postbox']; ?></td>
			<td><?php echo $invoice['to_person']; ?></td>
			<td><?php echo $invoice['street']; ?></td>
			<td><?php echo $invoice['zip']; ?></td>
			<td><?php echo $invoice['location']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'invoices', 'action' => 'view', $invoice['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'invoices', 'action' => 'edit', $invoice['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'invoices', 'action' => 'delete', $invoice['id']), null, __('Are you sure you want to delete # %s?', $invoice['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Invoice'), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
