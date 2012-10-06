<?php echo $this->Form->create('Course'); ?>

    <legend><?php echo __('Kurs anlegen'); ?></legend>

    <?php
    echo $this->Form->input('category_id', array('class' => 'span6', 'label' => 'Kategorie'));
    echo $this->Form->input('name', array('class' => 'span6'));
    echo $this->Form->input('code', array('class' => 'span6', 'label' => 'Abkürzung'));
    echo $this->Form->input('description', array('class' => 'span6', 'label' => 'Beschreibung'));
    echo $this->Form->input('Term', array('class' => 'span3', 'label' => 'Für folgende Semester buchen'));
    ?>

    <input type="submit" value="<?php echo __('Speichern'); ?>" class="btn" />

<?php echo $this->Form->end(); ?>