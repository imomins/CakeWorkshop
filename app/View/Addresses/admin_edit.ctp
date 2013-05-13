<div class="page-header">
    <h3><?php echo __('Rechnungsadresse bearbeiten'); ?></h3>
    <small><?php echo __('Bitte beachten, dass mehrere Kurse unter Rechungsadresse gruppiert sein könnten'); ?></small>
</div>

<div class="well">
    <?php echo $this->Form->create('Invoice', array('class' => 'form-horizontal')); ?>
    <?php echo $this->Form->input('id'); ?>

    <legend><?php echo __('Anmeldungsdaten'); ?></legend>

    <div class="control-group">
        <label class="control-label"><?php echo __('Benutzer'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('User.name', array('disabled' => true, 'empty' => false, 'div' => false, 'label' => false, 'required' => true, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Rechnung an'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('type_name', $types, array('empty' => false, 'div' => false, 'label' => false, 'required' => true, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Institution'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('institution', array('div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Einrichtung'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('department', array('div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Hauspostfach'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('postbox', array('div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Straße'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('street', array('div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Zu Händen von'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('to_person', array('div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('PLZ'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('zip', array('div' => false, 'label' => false, 'class' => 'span2')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Ort'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('location', array('div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <hr/>
    <button type="submit" class="btn btn-primary"><?php echo __('Speichern'); ?></button>
    <button type="button" class="btn btn-danger confirm"
            data-url="<?php echo Router::url('/admin/invoices/delete/') . $this->request->data['Invoice']['id']; ?>"
            data-confirm="<?php echo __('Rechnungsadresse löschen?'); ?>"><?php echo __('Löschen'); ?></button>

    <?php echo $this->Form->end(); ?>
</div>

<div class="page-header">
    <h3><?php echo __('Kurse die unter dieser Adresse, von dieser Person, gebucht wurden'); ?></h3>
</div>

<table class="table table-bordered table-hover table-striped">
    <thead>
        <th><?php echo __('Kurs'); ?></th>
        <th><?php echo __('Kategorie'); ?></th>
        <th><?php echo __('Semester'); ?></th>
        <th><?php echo __('Status'); ?></th>
        <th><?php echo __('Bearbeiten'); ?></th>
    </thead>
    <tbody>
    <?php foreach ($related_courses_terms as $booking): ?>
        <tr>
            <td><?php echo $booking['Course']['name']; ?></td>
            <td><?php echo substr($booking['Category']['name'], 0, 40) . '...'; ?></td>
            <td><?php echo $booking['Term']['name']; ?></td>
            <td><?php echo $booking['Schedule']['display']; ?></td>
            <td><a class="btn-link" href="<?php echo Router::url('/admin/bookings/edit/') . $booking['Booking']['id']; ?>"><?php echo __('Berarbeiten'); ?></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>