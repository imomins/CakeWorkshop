<br/>
<br/>
<br/>
<div class="well span4 offset4">
    <p class="lead"><?php echo __('Neues Passwort erhalten'); ?></p>

    <p><?php echo __('Sie bekommen eine Email zugesandt mit weiteren Anweisungen.'); ?></p>
    <hr/>
    <?php
    echo $this->Form->create('User', array('class' => 'validate', 'action' => 'reset'));
    echo $this->Form->input('email', array('required' => true, 'class' => 'span4'));
    ?>
    <hr/>
    <input type="submit" class="btn btn-info" value="<?php echo __('Ok, bitte Mir eine E-Mail senden'); ?>"/>
    <?php echo $this->Form->end(); ?>
</div>
