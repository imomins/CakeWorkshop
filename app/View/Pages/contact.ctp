<?php echo $this->Session->read('Auth.name'); ?>

<p class="lead"><?php echo __('Kontaktformular'); ?></p>
<hr />

<blockquote>
    <?php echo __('Falls Sie irgendwelche Fragen haben, dann füllen Sie bitte das folgende Forumlar aus und wir werden uns bei Ihnen melden.'); ?>
</blockquote>

<?php echo $this->Form->create('Page', array('class' => 'form-horizontal validate', 'action' => 'contact')); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Name'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('name', array('required' => true, 'type' => 'text', 'class' => 'span4', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Betreff'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('subject', array('required' => true, 'type' => 'text', 'class' => 'span4', 'label' => false)); ?>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label"><?php echo __('Email'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('email', array('required' => true, 'type' => 'text', 'class' => 'span4', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Nachricht'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('message', array('required' => true, 'type' => 'textarea', 'rows' => 8, 'class' => 'span6', 'label' => false)); ?>
        </div>
    </div>

    <div class="controls">
        <input type="submit" class="btn" value="<?php echo __('Absenden'); ?>"/>
    </div>

<?php echo $this->Form->end(); ?>