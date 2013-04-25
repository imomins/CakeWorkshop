<div class="page-header">
    <h4><?php echo __('Rechnungart Anlegen'); ?></h4>
</div>

<div class="well ">
    <?php echo $this->Form->create('Type', array('class' => 'form')); ?>


    <div class="control-group">
        <label class="control-label"><?php echo __('Anzeigename'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('display', array('required' => true, 'label' => false, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <hr/>
        <div class="controls">
            <button type="submit" class="btn btn-primary">Speichern</button>
            <input type="button" class="btn btn-danger confirm" value="<?php echo __('Löschen'); ?>"
                   data-id=""
                   data-confirm="<?php echo __('Wirklich löschen?'); ?>"
                   data-url="<?php echo Router::url('/admin/types/delete/') . $this->Form->value('Type.name'); ?>"/>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>