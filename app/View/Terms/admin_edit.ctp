<div class="page-header">
    <h4><?php echo __('Semester bearbeiten'); ?></h4>
</div>

<div class="well ">
    <?php echo $this->Form->create('Term', array('class' => 'form')); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Semester-Bezeichnung'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('name', array('required' => true, 'label' => false, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Von'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('start', array('label' => false, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Bis'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('end', array('label' => false, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <hr/>
        <div class="controls">
            <button type="submit" class="btn btn-primary">Speichern</button>
            <input type="button" class="btn btn-danger confirm" value="<?php echo __('Löschen'); ?>"
                   data-id=""
                   data-confirm="<?php echo __('Wirklich löschen?'); ?>"
                   data-url="<?php echo Router::url('/admin/terms/delete/') . $this->Form->value('Term.id'); ?>"/>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<div class="btn-group">
    <?php echo $this->Html->link(__('All Semester anzeigen'), array('action' => 'index'), array('class' => 'btn')); ?>
    <?php echo $this->Html->link(__('Kurs für dieses Semester anlegen'), array('controller' => 'courses', 'action' => 'add'), array('class' => 'btn')); ?>
</div>

