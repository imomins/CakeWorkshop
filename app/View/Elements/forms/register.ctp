<div class="well span6 offset1">
    <p class="lead"><?php echo __('Registrieren'); ?></p>

    <p><?php echo __('Falls Sie zum ersten mal einen Kurs bei uns besuchen'); ?></p>
    <hr/>
    <?php echo $this->Form->create('User', array('class' => 'form-horizontal validate', 'action' => 'register')); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Anrede'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('gender_id', array('required' => true, 'class' => 'span5', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Titel'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('title', array('empty' => true, 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Vorname'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('firstname', array('required' => true, 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Nachname'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('lastname', array('required' => true, 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Passwort'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('password', array('required' => true, 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Passwort bestätigen'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('password_confirm', array('required' => true, 'type' => 'password', 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Email'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('email', array('required' => true, 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Fachbereich'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('department_id', array('empty' => true, 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Beschäftigt als'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('occupation_id', array('required' => true, 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Telefonnummer'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('phone', array('required' => true, 'class' => 'span11', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('HRZ-ID'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('hrz', array('class' => 'span11', 'label' => false)); ?>
        </div>
    </div>
    <hr/>

    <div class="form-controls">
        <input type="submit" class="btn btn-primary btn-medium" value="<?php echo __('Registrieren'); ?>"/>
    </div>

    <?php echo $this->Form->end(); ?>
</div>