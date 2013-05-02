<div class="page-header">
    <h3><?php echo __('Semester bearbeiten'); ?></h3>
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
        <input type="submit" class="btn btn-darkblue btn-medium" value="<?php echo __('Speichern'); ?>"/>
        <input type="button" class="btn btn-orange btn-medium" value="<?php echo __('Löschen'); ?>"
               data-id=""
               data-confirm="<?php echo __('Wirklich löschen?'); ?>"
               data-url="<?php echo Router::url('/admin/terms/delete/') . $this->Form->value('Term.id'); ?>"/>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<div class="row">
    <div class="span12">
        <?php echo $this->Html->link(__('All Semester anzeigen'), array('action' => 'index'), array('class' => 'btn btn-medium')); ?>
        <?php echo $this->Html->link(__('Kurs für dieses Semester anlegen'), array('controller' => 'courses', 'action' => 'add'), array('class' => 'btn btn-medium')); ?>
    </div>
</div>


