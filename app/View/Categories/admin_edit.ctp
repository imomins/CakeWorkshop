<div class="page-header">
    <h4><?php echo __('Kategorie Bearbeiten'); ?></h4>
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
                <input type="button" class="btn btn-danger confirm" value="<?php echo __('Löschen'); ?>"
                       data-id=""
                       data-confirm="<?php echo __('Wirklich löschen?'); ?>"
                       data-url="<?php echo Router::url('/admin/categories/delete/') . $this->Form->value('Category.id'); ?>"/>
            </div>
        </div>
    </fieldset>
</div>