<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#register" data-toggle="tab"><?php echo __('Anmeldung'); ?></a></li>
        <li><a href="#courses" data-toggle="tab"><?php echo __('Kurs Übersicht für dieses Semester'); ?></a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="register">

            <div class="row-fluid">
                <div class="alert bg-light-blue">
                    <button data-dismiss="alert" class="close" type="button">×</button>

                    <?php echo __('Bitte registrieren Sie sich oder melden Sie sich an, um Kurse zu belegen. Eine aktuelle Übersicht der Kurse können Sie auch ohne anmeldung einsehen.'); ?>
                    <br/>
                    <?php echo __('Falls Sie schon mal teilgenommen haben und ihre E-Mail angegeben hatten, dann klicken Sie <b><a href="users/reset">hier</a></b>, um ein Passwort zu erhalten.'); ?>
                </div>
            </div>

            <div class="row-fluid">
                <?php echo $this->element('forms/register'); ?>
                <?php echo $this->element('forms/login'); ?>
            </div>

        </div>

        <div class="tab-pane" id="courses">
            <div class="alert bg-light-blue">
                <button data-dismiss="alert" class="close" type="button">×</button>

                <p><strong>Hinweis zur Anmeldung bei ausgebuchten Workshops</strong></p>
                <br/>

                <p>Vielen Dank für Ihr Interesse an unserem Workshopangebot. Auch wenn Workshops ausgebucht sind, melden Sie sich bitte trotzdem an. Oft werden noch Plätze über die Warteliste frei bzw. bei großem Interesse bieten wir auch Wiederholungstermine für einzelne Workshops an.</p>
            </div>

            <div id="tableCourses">Lade...</div>
        </div>

    </div>
</div>

<?php echo $this->Html->css('users/login'); ?>
<?php echo $this->Html->script('users/login'); ?>