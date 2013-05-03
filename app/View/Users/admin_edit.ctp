<div class="page-header">
    <h3><?php echo __('Benutzerdaten bearbeiten'); ?></h3>
</div>

<div class="well">
    <?php echo $this->Form->create('User', array('class' => 'form form-horizontal')); ?>
    <fieldset>
        <legend><?php echo __('Benutzerdaten'); ?></legend>
        <?php echo $this->Form->input('id'); ?>

        <div class="control-group">
            <label class="control-label"><?php echo __('Anrede'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('gender_id', array('label' => false, 'div' => false, 'class' => 'span2')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Titel'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('title', array('label' => false, 'div' => false, 'class' => 'span2')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Vorname'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('firstname', array('label' => false, 'div' => false, 'class' => 'span4')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Nachname'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('lastname', array('label' => false, 'div' => false, 'class' => 'span4')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('E-Mail'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('email', array('label' => false, 'div' => false, 'class' => 'span4')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Fachbereich'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('department_id', array('label' => false, 'div' => false, 'class' => 'span4')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Hrz-Id'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('hrz', array('label' => false, 'div' => false, 'class' => 'span2')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Tel.'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('phone', array('label' => false, 'div' => false, 'class' => 'span2')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Benutzergruppe'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('group_id', array('label' => false, 'div' => false, 'class' => 'span2')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Konto aktiviert?'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('active', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'span2')); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Notizen zu diesem Benutzer?'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('notes', array('label' => false, 'div' => false, 'class' => 'span10')); ?>
            </div>
        </div>
    </fieldset>

    <hr />
    <button type="submit" class="btn btn-primary"><?php echo __('Speichern'); ?></button>
    <?php echo $this->Form->end(); ?>
</div>