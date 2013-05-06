<div class="well">
    <?php echo $this->Form->create('Booking', array('class' => 'form-horizontal')); ?>
    <?php echo $this->Form->input('id'); ?>

    <legend><?php echo __('Anmeldung bearbeiten'); ?></legend>

    <div class="control-group">
        <label class="control-label"><?php echo __('Belegter Kurs'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('courses_term_id', $courses_terms, array('label' => false, 'class' => 'span10')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Teilnehmer'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('user_id', array('disabled' => true, 'required' => true, 'div' => false, 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Buchungsstatus'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('booking_state_name', $booking_state, array('empty' => false, 'required' => true, 'div' => false, 'label' => false)); ?>
        </div>
    </div>

    <?php if ($this->request->data['Booking']['booking_state_name'] === 'self_unsubscribed'): ?>
        <div class="control-group">
            <label class="control-label"><?php echo __('Abgemeldet am'); ?></label>

            <div class="controls">
                <?php echo $this->Form->text('unsubscribed_at', array('disabled' => true, 'div' => false, 'label' => false)); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Teilnahmestatus'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('attendance_state_name', $attendance_state, array('div' => false, 'label' => false)); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Zertifikat'); ?></label>

        <div class="controls">
            <label class="checkbox">
                <?php echo $this->Form->input('certificate', array('div' => false, 'label' => false)); ?>
            </label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Notizen zu dieser Buchung'); ?></label>

        <div class="controls">
            <?php echo $this->Form->textarea('notes', array('rows' => 7, 'class' => 'span7', 'div' => false, 'label' => false)); ?>
        </div>
    </div>

    <legend><?php echo __('Rechnungsdaten'); ?></legend>

    <?php echo $this->Form->hidden('invoice_id', array('empty' => false, 'div' => false, 'label' => false, 'required' => true, 'class' => 'span3')); ?>

    <div class="control-group">
        <label class="control-label"><?php echo __('Rechnung an'); ?></label>

        <div class="controls">
            <?php echo $this->Form->select('Invoice.type_name', $types, array('disabled' => true, 'empty' => false, 'div' => false, 'label' => false, 'required' => true, 'class' => 'span3')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Institution'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('Invoice.institution', array('disabled' => true, 'div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Einrichtung'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('Invoice.department', array('disabled' => true, 'div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Hauspostfach'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('Invoice.postbox', array('disabled' => true, 'div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Zu Händen von'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('Invoice.to_person', array('disabled' => true, 'div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Straße'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('Invoice.street', array('disabled' => true, 'div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('PLZ'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('Invoice.zip', array('disabled' => true, 'div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"><?php echo __('Ort'); ?></label>

        <div class="controls">
            <?php echo $this->Form->input('Invoice.location', array('disabled' => true, 'div' => false, 'label' => false, 'class' => 'span5')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"></label>

        <div class="controls">
            <a
                href="<?php echo Router::url('/admin/invoices/edit/') . $this->request->data['Booking']['invoice_id']; ?>"
                class="btn"><?php echo __('Rechnungsdaten berabeiten'); ?></a>
        </div>
    </div>

    <div class="">
        <hr />
        <button type="submit" class="btn btn-primary"><?php echo __('Speichern'); ?></button>
        <button type="button" class="btn btn-danger confirm"
                data-url="<?php echo Router::url('/admin/bookings/delete/') . $this->request->data['Booking']['id']; ?>"
                data-confirm="<?php echo __('Buchung löschen?'); ?>"><?php echo __('Löschen'); ?></button>
        <button type="button"
                class="pull-right btn"><?php echo __('Anmeldung bestätigen und per Email benachnachrichten'); ?></button>
    </div>

    <?php echo $this->Form->end(); ?>
</div>