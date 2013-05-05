<div class="well span4">
    <p class="lead"><?php echo __('Anmelden'); ?></p>

    <p><?php echo __('Falls Sie bereits hier ein Konto haben'); ?></p>
    <hr/>
    <?php
    echo $this->Form->create('User', array('class' => 'validate', 'action' => 'login'));
    echo $this->Form->input('email', array('required' => true, 'class' => 'span12'));
    echo $this->Form->input('password', array('required' => true, 'class' => 'span12'));
    ?>
    <?php echo $this->Html->link(__('Passwort vergessen?'), array('controller' => 'users', 'action' => 'reset')); ?>
    <hr/>
    <input type="submit" class="btn btn-primary btn-medium" value="<?php echo __('Anmelden'); ?>"/>
    <?php echo $this->Form->end(); ?>
</div>