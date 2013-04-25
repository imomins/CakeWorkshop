<div class="page-header">
    <h4><?php echo __('Semester bearbeiten'); ?></h4>
</div>

<div class="well ">
    <?php echo $this->Form->create('Term'); ?>

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
        </div>
    </div>
</div>