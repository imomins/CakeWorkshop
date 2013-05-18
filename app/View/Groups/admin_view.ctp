<h3 class="page-header"><?php echo __('Mitglieder der Gruppe: %s', $groups['Group']['display']); ?></h3>

<table class="table table-bordered table-hover table-striped" id="group"></table>

<?php echo $this->Html->script('groups/admin/view'); ?>