<?php echo $this->Form->create('Address'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Address'); ?></legend>
	<?php
		echo $this->Form->input('type_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('institution');
		echo $this->Form->input('department');
		echo $this->Form->input('postbox');
		echo $this->Form->input('to_person');
		echo $this->Form->input('street');
		echo $this->Form->input('zip');
		echo $this->Form->input('location');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
