<div class="well span6 offset3">
    <p class="lead"><?php echo __('Neues Passwort erhalten'); ?></p>

    <p><?php echo __('Sie bekommen eine Email zugesandt mit weiteren Anweisungen.'); ?></p>
    <hr/>
    <?php
    echo $this->Form->create('User', array('class' => 'validate', 'action' => 'reset'));
    echo $this->Form->input('email', array('required' => true, 'type' => 'email', 'class' => 'span10'));
    ?>
    <hr/>
    <input type="submit" class="btn btn-primary btn-medium" value="<?php echo __('Ok, bitte Mir eine E-Mail senden'); ?>"/>
    <?php echo $this->Form->end(); ?>
</div>
