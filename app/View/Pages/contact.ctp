<?php echo $this->Session->read('Auth.name'); ?>

<h3 class="page-header"><?php echo __('Kontaktformular'); ?></h3>

<div class="well">
    <blockquote>
        <?php echo __('Falls Sie irgendwelche Fragen haben, dann füllen Sie bitte das folgende Forumlar aus und wir werden uns bei Ihnen melden.'); ?>
    </blockquote>
    <hr/>

    <?php echo $this->Form->create('Page', array('class' => 'form-horizontal validate', 'action' => 'contact')); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Betreff'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('subject', array('required' => true, 'type' => 'text', 'class' => 'span8  ', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Ihre Nachricht'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('message', array('required' => true, 'type' => 'textarea', 'rows' => 12, 'class' => 'span9', 'label' => false)); ?>
        </div>
    </div>
    <hr/>

    <div class="controls">
        <input type="submit" class="btn btn-primary" value="<?php echo __('Absenden'); ?>"/>
    </div>

    <?php echo $this->Form->end(); ?>
</div>
