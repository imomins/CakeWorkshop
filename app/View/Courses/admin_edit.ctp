<?php echo $this->Form->create('Course', array('id' => 'formCourse', 'class' => 'form-horizontal')); ?>
    <legend><?php echo __('Kurs bearbeiten'); ?></legend>

    <?php echo $this->Form->input('id'); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Kategorie'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('category_id', array('required' => true, 'class' => 'span7', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Name'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('name', array('required' => true, 'class' => 'span5', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Abkürzung'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('code', array('required' => true, 'class' => 'span5', 'label' => false)); ?>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label"><?php echo __('Beschreibung (optional)'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('description', array('required' => true, 'class' => 'span5', 'label' => false)); ?>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label"><?php echo __('Für folgende Semester schon festlegen'); ?></label>
        <div class="controls">
            <?php echo $this->Form->input('Term', array('required' => true, 'class' => 'span3', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <hr />
        <div class="controls">
            <input type="submit" class="btn" value="<?php echo __('Speichern'); ?>"/>
        </div>
    </div>

<?php echo $this->Form->end(); ?>

<script>
$('#formCourse').validate();
</script>