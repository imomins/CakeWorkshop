<div class="well">
    <?php echo $this->Form->create('Setting'); ?>
    <legend><?php echo __('Einstellungen'); ?></legend>

    <div class="control-group">
        <div class="control-label"><?php echo $settings['current_term']['title']; ?></div>
        <?php echo $this->Form->select('Setting.current_term', $terms, array('empty' => false, 'value' => $settings['current_term']['value'], 'label' => false, 'div' => false, 'class' => 'span3')); ?>
    </div>
    <hr />

    <div class="control-group">
        <div class="control-label"><?php echo $settings['contact_emails']['title']; ?></div>
        <?php echo $this->Form->input('Setting.contact_emails', array('value' => $settings['contact_emails']['value'], 'label' => false, 'div' => false, 'class' => 'span8')); ?>
    </div>
    <hr />

    <div class="control-group">
        <div class="control-label"><?php echo $settings['alert_startpage']['title']; ?></div>
        <?php echo $this->Form->textarea('Setting.alert_startpage', array('value' => $settings['alert_startpage']['value'], 'label' => false, 'div' => false, 'class' => 'span12', 'rows'  => 7)); ?>
    </div>
    <hr />

    <div class="control-group">
        <div class="control-label"><?php echo $settings['alert_register_workshop']['title']; ?></div>
        <?php echo $this->Form->textarea('Setting.alert_register_workshop', array('value' => $settings['alert_register_workshop']['value'], 'label' => false, 'div' => false, 'class' => 'span12', 'rows'  => 7)); ?>
    </div>
    <hr />

    <button type="submit" class="btn btn-primary btn-medium"><?php echo __('Speichern'); ?></button>
    <?php echo $this->Form->end(); ?>
</div>