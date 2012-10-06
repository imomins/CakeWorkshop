<div class="occupations index">
	<h2><?php echo __('Occupations'); ?></h2>
	<table class="table table-condensed table-bordered table-striped">
	<tr>
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($occupations as $occupation): ?>
	<tr>
		<td><?php echo h($occupation['Occupation']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $occupation['Occupation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $occupation['Occupation']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $occupation['Occupation']['id']), null, __('Are you sure you want to delete # %s?', $occupation['Occupation']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>