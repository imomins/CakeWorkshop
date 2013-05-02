<h3 class="page-header"><?php echo __('Meine Daten'); ?></h3>

<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo __('Email und Passwort'); ?></a></li>
        <li><a href="#tab2" data-toggle="tab"><?php echo __('Weitere Daten'); ?></a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="tab1">
            <div class="alert bg-blue">
                <p><?php echo __('Email-Änderungen müssen mit einer zugesandten Email an die neue Email-Adresse bestätigt werden.'); ?></p>
            </div>
            <div class="well">
                <?php
                echo $this->Form->create('User', array('controller' => 'users', 'action' => 'account'));
                echo $this->Form->input('email', array('required' => true, 'class' => 'span4', 'label' => __('Email')));
                echo $this->Form->input('password', array('required' => true, 'class' => 'span4', 'value' => '', 'label' => __('Passwort')));
                echo $this->Form->input('password_confirm', array('required' => true, 'type' => 'password', 'class' => 'span4', 'label' => __('Passwort bestätigen')));
                ?>
                <hr/>
                <?php
                echo $this->Form->submit(__('Speichern'), array('class' => 'btn btn-darkblue btn-medium'));
                echo $this->Form->end();
                ?>
            </div>
        </div>

        <div class="tab-pane" id="tab2">
            <div class="well">
                <?php
                echo $this->Form->create('User', array('controller' => 'users', 'action' => 'details'));
                echo $this->Form->input('gender_id', array('required' => true, 'class' => 'span2', 'label' => __('Anrede')));
                echo $this->Form->input('title', array('empty' => true, 'class' => 'span3', 'label' => __('Titel')));
                echo $this->Form->input('firstname', array('required' => true, 'class' => 'span4', 'label' => __('Vorname')));
                echo $this->Form->input('lastname', array('required' => true, 'class' => 'span4', 'label' => __('Nachname')));
                echo $this->Form->input('department_id', array('class' => 'span5'));
                echo $this->Form->input('occupation_id', array('class' => 'span5'));
                echo $this->Form->input('hrz', array('class' => 'span3'));
                echo $this->Form->input('phone', array('required' => true, 'class' => 'span3'));
                ?>
                <hr/>
                <?php
                echo $this->Form->submit(__('Speichern'), array('class' => 'btn btn-darkblue btn-medium'));
                echo $this->Form->end();
                ?>
            </div>
        </div>

    </div>

</div>

<?php echo $this->Html->script('users/edit'); ?>