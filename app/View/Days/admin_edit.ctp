<div class="days form">
<?php echo $this->Form->create('Day'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Day'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('courses_term_id');
		echo $this->Form->input('date');
		echo $this->Form->input('start_time');
		echo $this->Form->input('end_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Day.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Day.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Days'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Courses Terms'), array('controller' => 'courses_terms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Courses Term'), array('controller' => 'courses_terms', 'action' => 'add')); ?> </li>
	</ul>
</div>
