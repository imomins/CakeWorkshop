<div class="page-header">
    <h3><?php  echo __('Neuen Kurs anlegen'); ?></h3>
</div>

<div class="alert bg-light-blue">
    <?php echo __('Hinweis: Dieser Kurs wird unabhängig vom einem Semester angelegt und kann zu beliebigen Semestern angesetzt werden.'); ?>
</div>

<div class="well">
    <?php echo $this->Form->create('Course'); ?>

    <legend><?php echo __('Kursdaten'); ?></legend>

    <div class="control-group">
        <label class="control-label"><?php echo __('Kategorie'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('category_id', array('label' => false, 'class' => 'span6')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Kurtitel'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('name', array('label' => false, 'class' => 'span6')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Kürzel'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('code', array('label' => false, 'class' => 'span2')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Kursbeschreibung'); ?></label>

        <div class="controls">
            <?php echo $this->Form->textarea('description', array('rows' => 5, 'label' => false, 'class' => 'span6')); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </div>

    <?php echo $this->Form->end(); ?>
</div>
