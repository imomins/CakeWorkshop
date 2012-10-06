<br />
<div class="row">
    <div class="well span4">
        <p class="lead"><?php echo __('Passwort zurücksetzen'); ?></p>

        <p><?php echo __('Sie bekommen eine Email zugesandt mit weiteren Anweisungen.'); ?></p>
        <hr/>
        <?php
        echo $this->Form->create('User', array('class' => 'validate', 'action' => 'password/'.$hash));
        echo $this->Form->input('hash', array('type' => 'hidden', 'value' => $hash));
        echo $this->Form->input('password', array('label' => __('Passwort'), 'required' => true, 'class' => 'span4'));
        echo $this->Form->input('password_confirm', array('type' => 'password', 'label' => __('Passwort wiederholen'), 'required' => true, 'class' => 'span4'));
        ?>
        <hr/>
        <input type="submit" class="btn" value="<?php echo __('Zurücksetzen'); ?>"/>
        <?php echo $this->Form->end(); ?>
    </div>
</div>