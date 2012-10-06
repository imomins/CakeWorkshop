<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		echo $this->Form->input('title');
		echo $this->Form->input('gender_id');
		echo $this->Form->input('department_id');
		echo $this->Form->input('occupation_id');
		echo $this->Form->input('hrz');
		echo $this->Form->input('phone');
		echo $this->Form->input('group_id');
		echo $this->Form->input('active');
		echo $this->Form->input('hash');
		echo $this->Form->input('CoursesTerm');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>