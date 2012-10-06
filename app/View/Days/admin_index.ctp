<div class="days index">
	<h2><?php echo __('Days'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('courses_term_id'); ?></th>
			<th><?php echo $this->Paginator->sort('date'); ?></th>
			<th><?php echo $this->Paginator->sort('start_time'); ?></th>
			<th><?php echo $this->Paginator->sort('end_time'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($days as $day): ?>
	<tr>
		<td><?php echo h($day['Day']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($day['CoursesTerm']['id'], array('controller' => 'courses_terms', 'action' => 'view', $day['CoursesTerm']['id'])); ?>
		</td>
		<td><?php echo h($day['Day']['date']); ?>&nbsp;</td>
		<td><?php echo h($day['Day']['start_time']); ?>&nbsp;</td>
		<td><?php echo h($day['Day']['end_time']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $day['Day']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $day['Day']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $day['Day']['id']), null, __('Are you sure you want to delete # %s?', $day['Day']['id'])); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Day'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Courses Terms'), array('controller' => 'courses_terms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Courses Term'), array('controller' => 'courses_terms', 'action' => 'add')); ?> </li>
	</ul>
</div>
