<div class="page-header">
    <h4><?php echo __('Kategorie anlegen'); ?></h4>
</div>

<div class="well">
    <?php echo $this->Form->create('Category'); ?>
    <fieldset>
        <div class="control-group">
            <label class="control-label"><?php echo __('Name der Kategorie'); ?></label>

            <div class="controls">
                <?php echo $this->Form->input('name', array('required' => true, 'label' => false, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary"><?php echo __('Speichern'); ?></button>
            </div>
        </div>
    </fieldset>
</div>