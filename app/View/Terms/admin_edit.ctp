<div class="page-header">
    <h4><?php  echo __('Semester bearbeiten'); ?></h4>
</div>

<div class="well ">
    <?php echo $this->Form->create('Term', array('class' => 'form')); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Anrede'); ?></label>

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

    <button type="submit" class="btn btn-primary">Speichern</button>
</div>

<div class="btn-group">
    <?php echo $this->Html->link(__('All Semester anzeigen'), array('action' => 'index'), array('class' => 'btn')); ?>
    <?php echo $this->Html->link(__('Kurs für dieses Semester anlegen'), array('controller' => 'courses', 'action' => 'add'), array('class' => 'btn')); ?>
    <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $this->Form->value('Term.id')), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $this->Form->value('Term.id'))); ?>
</div>

