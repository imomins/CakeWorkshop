<li class="dropdown" data-controller="bookings">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Buchungen <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/bookings/index/sort:created/direction:desc'); ?></li>
        <li><?php echo $this->Html->link(__('Jemanden buchen'), '/admin/bookings/add'); ?></li>
    </ul>
</li>

<li class="dropdown" data-controller="courses|courses_terms">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kurse <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li class="nav-header"><?php echo __('Semester-Kurse'); ?></li>
        <li><?php echo $this->Html->link(__('Semester-Kurse Übersicht'), '/admin/courses_terms'); ?></li>
        <li><?php echo $this->Html->link(__('Kurs für Semester festlegen'), '/admin/courses_terms/add'); ?></li>

        <li class="divider"></li>
        <li class="nav-header"><?php echo __('Allgemeine-Kurse'); ?></li>
        <li><?php echo $this->Html->link(__('Allgemeine Kurs Übersicht'), '/admin/courses'); ?></li>
        <li><?php echo $this->Html->link(__('Kurs Anlegen'), '/admin/courses/add'); ?></li>

        <li class="divider"></li>
        <li class="nav-header"><?php echo __('Kurse nach Status'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/schedules'); ?></li>
    </ul>
</li>

<li class="dropdown" data-controller="users">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Benutzerverwaltung'); ?> <b
            class="caret"></b></a>
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

        <li class="nav-header"><?php echo __('Fachbereiche'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/departments'); ?></li>
        <li><?php echo $this->Html->link(__('Anlegen'), '/admin/departments/add'); ?></li>

        <li class="nav-header"><?php echo __('Anreden'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/genders'); ?></li>
        <li><?php echo $this->Html->link(__('Anlegen'), '/admin/genders/add'); ?></li>

        <li class="divider"></li>
        <li class="nav-header"><?php echo __('Benutzergruppen'); ?></li>
        <li><?php echo $this->Html->link(__('Übersicht'), '/admin/groups'); ?></li>
    </ul>
</li>

<li data-controller="settings"><?php echo $this->Html->link(__('Einstellungen'), '/admin/settings/edit'); ?></li>