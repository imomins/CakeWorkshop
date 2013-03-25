<div class="page-header">
    <h4><?php  echo __('Neuen Teilnehmer/Benutzer anlegen'); ?></h4>
</div>

<div class="well">
    <br/>
    <?php echo $this->Form->create('User', array('class' => 'row')); ?>

    <div class="span3">
        <div class="control-group">
            <label class="control-label"><?php echo __('Anrede'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('gender_id', array('required' => true, 'label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Vorname'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('firstname', array('required' => true, 'label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Nachname'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('lastname', array('required' => true, 'label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Titel'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('title', array('label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Email'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('email', array('required' => true, 'label' => false, 'class' => 'span3')); ?>
            </div>
        </div>
    </div>

    <div class="span4">
        <div class="control-group">
            <label class="control-label"><?php echo __('Fachbereich'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('department_id', array('showEmpty' => true, 'label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Beschäftigt als'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('occupation', array('label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Hrz-Id'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('hrz', array('label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Telefonnummer'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('phone', array('label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Benutzergruppe'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('group_id', array('required' => true, 'label' => false, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label pull-left"><?php echo __('Konto-Aktivieren'); ?></label>

            <div class="controls">
                <?php echo $this->Form->checkbox('active', array('label' => false, 'class' => 'span3 pull-right')); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="span12">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </div>

    <?php echo $this->Form->end(); ?>
</div>

</div>

