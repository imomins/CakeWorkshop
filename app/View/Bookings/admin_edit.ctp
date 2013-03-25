<div class="page-header">
    <h3><?php  echo __('Anmeldung bearbeiten'); ?></h3>
</div>

<div class="well">
    <?php echo $this->Form->create('Booking'); ?>

    <?php echo $this->Form->input('id'); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Teilnehmer'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('user_id'); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Rechnungsvorlage'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('invoice_id'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <?php echo $this->Form->input('commitment', array('label' => __('Zusage'))); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <?php echo $this->Form->input('completed', array('label' => __('Abgeschlossen'))); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <?php echo $this->Form->input('certificate', array('label' => __('Zertifikat'))); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Semesterkurs'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('courses_term_id', array('label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo __('Speichern'); ?></button>

    <?php echo $this->Form->end(); ?>
</div>

<div class="actions">
    <ul>

        <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Booking.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Booking.id'))); ?></li>
        <li><?php echo $this->Html->link(__('List Bookings'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Invoices'), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Invoice'), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Courses Terms'), array('controller' => 'courses_terms', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Courses Term'), array('controller' => 'courses_terms', 'action' => 'add')); ?> </li>
    </ul>
</div>
