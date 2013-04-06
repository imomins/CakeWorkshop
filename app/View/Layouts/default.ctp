<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <?php echo $this->Html->css('bootstrap.min'); ?>
    <style>
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>
    <script>
        var CAKEWORKSHOP = {
            controller: '<?php echo $this->request->params['controller']; ?>',
            view      : '<?php //echo $this->request->params['view']; ?>',
            action    : '<?php echo $this->request->params['action']; ?>',
            webroot   : '<?php echo $this->request->webroot; ?>'
        };
    </script>
    <?php echo $this->Html->css('bootstrap-responsive.min'); ?>
    <?php //echo $this->Html->css('custom-theme/jquery-ui-1.8.23.custom'); ?>
    <?php echo $this->Html->css('main'); ?>

    <?php echo $this->Html->script('vendor/modernizr-2.6.1-respond-1.1.0.min'); ?>
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an outdated browser. <a
    href="http://browsehappy.com/">Upgrade your browser today</a> or <a
    href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.
</p>
<![endif]-->

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo $this->Html->link('Uni-Frankfurt Workshops', $brandLink, array('class' => 'brand')); ?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <?php if (!$loggedIn) : ?>
                        <li><?php echo $this->Html->link(__('Startseite'), array('controller' => 'users', 'action' => 'login')); ?></li>
                    <?php
                    else:
                        switch ($group):
                            case 'attendee':
                                echo $this->element('nav_attendee');
                                break;
                            case 'admin':
                                echo $this->element('nav_admin');
                                break;
                            case 'assistant':
                                echo $this->element('nav_assistant');
                                break;
                        endswitch;
                    endif; ?>
                </ul>

                <ul class="nav pull-right">
                    <?php if ($group === 'admin'): ?>
                        <li class="nav-search">
                            <?php echo $this->Form->create(null, array('class' => 'form-search', 'url' => array('controller' => 'bookings', 'action' => 'index'))); ?>
                            <?php echo $this->Form->input('Course.name', array('div' => false, 'label' => false, 'class' => 'span3 input-medium search-query')); ?>
                            <?php echo $this->Form->end(); ?>
                        </li>
                    <?php endif; ?>

                    <?php if ($loggedIn) : ?>
                        <li class="divider-vertical"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="icon-user"></i> <?php echo $username; ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo $this->Html->link(__('Mein Konto'), '/users/edit'); ?></li>
                                <li><?php echo $this->Html->link(__('Abmelden'), '/users/logout'); ?></li>
                                <li class="divider"></li>
                                <li><?php echo $this->Html->link(__('Kontakt'), array('controller' => 'pages', 'action' => 'contact')); ?></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (!$loggedIn) : ?>
                        <li><?php echo $this->Html->link(__('Kontakt'), array('controller' => 'pages', 'action' => 'contact')); ?></li>
                    <?php endif; ?>

                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>

<?php echo $this->Html->script('vendor/jquery-1.9.1.min'); ?>
<?php echo $this->Html->script('vendor/bootstrap.min'); ?>
<?php echo $this->Html->script('vendor/ICanHaz.min'); ?>
<?php echo $this->Html->script('main'); ?>

<div class="container">
    <div class="row">
        <div class="span12">
            <div class="row">
                <div class="span12">
                    <div id="messages">
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->Session->flash('auth'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="span12">

                    <div class="row">
                        <div class="span12">
                            <div class="pull-right">
                                <?php echo $this->Html->image('uni_logo.png', array('id' => 'logo')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="span12">
                            <?php echo $this->fetch('content'); ?>
                        </div>
                    </div>

                    <div class="hero-unit">
                        <?php echo $this->element('sql_dump'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /container -->
</body>
</html>

<script id="alert" type="text/html">
    <div class="alert {{className}}" style="display:none;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <p>{{message}}</p>
    </div>
</script>