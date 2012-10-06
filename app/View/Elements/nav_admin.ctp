<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Buchungen <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/bookings'); ?></li>
        <li><?php echo $this->Html->link(__('Jemanden buchen'), '/admin/bookings/add'); ?></li>
    </ul>
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kurse <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li class="nav-header">Allgemeine-Kurse</li>
        <li><?php echo $this->Html->link(__('Allgemeine Kurs Übersicht'), '/admin/courses'); ?></li>
        <li><?php echo $this->Html->link(__('Kurs Anlegen'), '/admin/courses/add'); ?></li>
        <li class="divider"></li>
        <li class="nav-header">Semester-Kurse</li>
        <li><?php echo $this->Html->link(__('Semester-Kurse Übersicht'), '/admin/courses_terms'); ?></li>
        <li><?php echo $this->Html->link(__('Kurs für Semester festlegen'), '/admin/courses_terms/add'); ?></li>
    </ul>
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Benutzerverwaltung'); ?> <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/users'); ?></li>
        <li><?php echo $this->Html->link(__('Benutzer anlegen'), '/admin/users/add'); ?></li>
    </ul>
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Weiteres'); ?> <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li class="nav-header"><?php echo __('Semester'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/terms'); ?></li>
        <li><?php echo $this->Html->link(__('Anlegen'), '/admin/terms/add'); ?></li>

        <li class="divider"></li>
        <li class="nav-header"><?php echo __('Kategorien'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/categories'); ?></li>
        <li><?php echo $this->Html->link(__('Anlegen'), '/admin/categories/add'); ?></li>

        <li class="divider"></li>
        <li class="nav-header"><?php echo __('Rechnungsarten'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/types'); ?></li>
        <li><?php echo $this->Html->link(__('Anlegen'), '/admin/types/add'); ?></li>

        <li class="divider"></li>
        <li class="nav-header"><?php echo __('Formulardetails'); ?></li>
        <li class="divider"></li>

        <li class="nav-header"><?php echo __('Beschäftigungen'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/occupations'); ?></li>
        <li><?php echo $this->Html->link(__('Anlegen'), '/admin/occupations/add'); ?></li>

        <li class="nav-header"><?php echo __('Fachbereiche'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/departments'); ?></li>
        <li><?php echo $this->Html->link(__('Anlegen'), '/admin/departments/add'); ?></li>

        <li class="nav-header"><?php echo __('Anreden'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/genders'); ?></li>
        <li><?php echo $this->Html->link(__('Anlegen'), '/admin/genders/add'); ?></li>
    </ul>
</li>