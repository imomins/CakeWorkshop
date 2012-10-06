<li data-controller="bookings" data-view=""><?php echo $this->Html->link(__('Kursverwaltung'), array('controller' => 'bookings', 'action' => 'index')); ?></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Rechnungen'); ?> <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><?php echo $this->Html->link(__('Meine Rechnungen'), '/invoices'); ?></li>
        <li><?php echo $this->Html->link(__('Rechnungsvorlage Anlegen'), '/invoices/add'); ?></li>
    </ul>
</li>