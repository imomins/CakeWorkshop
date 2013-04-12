<div class="tabbable" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#register" data-toggle="tab"><?php echo __('Anmeldung'); ?></a></li>
        <li><a href="#courses" data-toggle="tab"><?php echo __('Kurs Übersicht für dieses Semester'); ?></a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="register">

            <div class="row">
                <div class="span12">
                    <div class="alert alert-info">
                        <button data-dismiss="alert" class="close" type="button">×</button>

                        <?php echo __('Bitte registrieren Sie sich oder melden Sie sich an, um Kurse zu belegen. Eine aktuelle Übersicht der Kurse können Sie auch ohne anmeldung einsehen.'); ?>
                        <br/>
                        <?php echo __('Falls Sie schon mal teilgenommen haben und ihre E-Mail angegeben hatten, dann klicken Sie <b><a href="users/reset">hier</a></b>, um ein Passwort zu erhalten.'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php echo $this->element('forms/register'); ?>
                <?php echo $this->element('forms/login'); ?>
            </div>

        </div>

        <div class="tab-pane" id="courses">
            <div class="alert alert-info">
                <button data-dismiss="alert" class="close" type="button">×</button>

                <p><strong>Hinweis zur Anmeldung bei ausgebuchten Workshops</strong></p>
                <br/>

                <p>Vielen Dank für Ihr Interesse an unserem Workshopangebot. Auch wenn Workshops ausgebucht sind, melden Sie sich bitte trotzdem an. Oft werden noch Plätze über die Warteliste frei bzw. bei großem Interesse bieten wir auch Wiederholungstermine für einzelne Workshops an.</p>
            </div>

            <?php echo $this->element('tables/courses_by_category', array($coursesByCategory, 'form' => false)); ?>
        </div>

    </div>
</div>

<?php echo $this->Html->css('users/login'); ?>
<script>
    require(['bootstrap-tab'], function (_tab) {
        "use strict";
    });
</script>