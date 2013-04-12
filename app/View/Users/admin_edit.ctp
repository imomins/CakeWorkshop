<div class="well">
    <?php echo $this->Form->create('User', array('class' => 'form-large')); ?>
    <fieldset>
        <legend><?php echo __('Berabeitung der Daten'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('gender_id', array('label' => __('Anrede'), 'class' => 'span2'));
        echo $this->Form->input('title', array('label' => __('Titel')));
        echo $this->Form->input('firstname', array('label' => __('Vorname')));
        echo $this->Form->input('lastname', array('label' => __('Nachname')));
        echo $this->Form->input('email', array('label' => __('Email'), 'class' => 'span4'));
        echo $this->Form->input('department_id', array('label' => __('Fachbereich'), 'class' => 'span4'));
        echo $this->Form->input('hrz', array('label' => __('Hrz-Id')));
        echo $this->Form->input('phone', array('label' => __('Tel.')));
        echo $this->Form->input('group_id', array('label' => __('Benutzergruppe')));
        echo $this->Form->input('active', array('type' => 'checkbox', 'label' => __('Konto aktiviert?')));
        echo $this->Form->input('notes', array('rows' => '12', 'class' => 'span10', 'label' => __('Notizen zu diesem Benutzer')));
        ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn-large btn-primary"><?php echo __('Speichern'); ?></button>
    </div>
    <?php echo $this->Form->end(); ?>
</div>