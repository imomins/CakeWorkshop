<div class="page-header">
    <h3><?php echo __('Kursdaten'); ?></h3>
</div>

<div id="courses-admin-edit" class="well">
    <legend><?php echo __('Kursdaten bearbeiten'); ?></legend>

    <?php echo $this->Form->create('Course', array('id' => 'formCourse', 'class' => 'form-horizontal')); ?>

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
            <?php echo $this->Form->input('name', array('required' => true, 'class' => 'span7', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Abkürzung'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('code', array('class' => 'span7', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Beschreibung (optional)'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('description', array('class' => 'span7', 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <hr/>
        <div class="controls">
            <input type="submit" class="btn btn-primary btn-medium" value="<?php echo __('Speichern'); ?>"/>
            <input type="button" class="btn btn-orange btn-medium" value="<?php echo __('Löschen'); ?>"
                   data-id=""
                   data-confirm="<?php echo __('Soll der Kurs wirklich gelöscht werden?'); ?>"
                   data-url="<?php echo Router::url('/admin/courses/delete/') . $this->request->data['Course']['id']; ?>"/>
        </div>
    </div>

    <?php echo $this->Form->end(); ?>

</div>

<?php echo $this->Element('courses/related', array(compact('courses_terms'))); ?>
