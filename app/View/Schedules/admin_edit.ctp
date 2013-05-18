<?php echo $this->Form->create('Schedule', array('class' => 'form well')); ?>
<fieldset>
    <legend><?php echo __('Kurs-Status bearbeiten'); ?></legend>
    <?php
    echo $this->Form->input('name');
    echo $this->Form->input('display');
    ?>
</fieldset>
<input type="submit" value="<?php echo __('Speichern'); ?>" class="btn btn-primary"/>
<?php echo $this->Form->end(); ?>
