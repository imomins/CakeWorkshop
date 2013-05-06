<div class="well span6 offset3">
    <p class="lead"><?php echo __('Passwort zurücksetzen'); ?></p>

    <p><?php echo __('Wählen Sie bitte ein neues Passwort.'); ?></p>
    <hr/>
    <?php
    echo $this->Form->create('User', array('class' => 'validate', 'action' => 'password/' . $hash));
    echo $this->Form->input('hash', array('type' => 'hidden', 'value' => $hash));
    echo $this->Form->input('password', array('label' => __('Passwort'), 'required' => true, 'class' => 'span10'));
    echo $this->Form->input('password_confirm', array('type' => 'password', 'label' => __('Passwort wiederholen'), 'required' => true, 'class' => 'span10'));
    ?>
    <hr/>
    <input type="submit" class="btn btn-primary btn-medium" value="<?php echo __('Zurücksetzen'); ?>"/>
    <?php echo $this->Form->end(); ?>
</div>