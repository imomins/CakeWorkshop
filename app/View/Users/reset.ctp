<br />
<div class="row">
    <div class="well span4">
        <p class="lead"><?php echo __('Passwort zurücksetzen'); ?></p>

        <p><?php echo __('Sie bekommen eine Email zugesandt mit weiteren Anweisungen.'); ?></p>
        <hr/>
        <?php
        echo $this->Form->create('User', array('class' => 'validate', 'action' => 'reset'));
        echo $this->Form->input('email', array('required' => true, 'class' => 'span4'));
        ?>
        <hr/>
        <input type="submit" class="btn" value="<?php echo __('Zurücksetzen'); ?>"/>
        <?php echo $this->Form->end(); ?>
    </div>
</div>