<div class="days form">
<?php echo $this->Form->create('Day'); ?>
	<fieldset>
		<legend><?php echo __('Add Day'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Days'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Courses Terms'), array('controller' => 'courses_terms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Courses Term'), array('controller' => 'courses_terms', 'action' => 'add')); ?> </li>
	</ul>
</div>
