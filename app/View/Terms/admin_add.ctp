<div class="terms form">
<?php echo $this->Form->create('Term'); ?>
	<fieldset>
		<legend><?php echo __('Add Term'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('start', array('class' => 'date','type' => 'text'));
		echo $this->Form->input('end', array('class' => 'date','type' => 'text'));
		echo $this->Form->input('Course', array('label' => __('Kurse für dieses Semester')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Speichern')); ?>

<script>
$('.date').datepicker({ dateFormat: "yy-mm-dd" });
</script>