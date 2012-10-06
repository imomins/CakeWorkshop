<div class="days view">
<h2><?php  echo __('Day'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($day['Day']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Courses Term'); ?></dt>
		<dd>
			<?php echo $this->Html->link($day['CoursesTerm']['id'], array('controller' => 'courses_terms', 'action' => 'view', $day['CoursesTerm']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($day['Day']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Time'); ?></dt>
		<dd>
			<?php echo h($day['Day']['start_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End Time'); ?></dt>
		<dd>
			<?php echo h($day['Day']['end_time']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Day'), array('action' => 'edit', $day['Day']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Day'), array('action' => 'delete', $day['Day']['id']), null, __('Are you sure you want to delete # %s?', $day['Day']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Days'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Day'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses Terms'), array('controller' => 'courses_terms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Courses Term'), array('controller' => 'courses_terms', 'action' => 'add')); ?> </li>
	</ul>
</div>
