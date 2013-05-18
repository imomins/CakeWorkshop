<div class="page-header">
    <h3><?php echo __('Kategorie: ') . h($category['Category']['name']); ?></h3>
</div>

<div class="btn-group">
    <?php echo $this->Html->link(__('Kategorie bearbeiten'), array('action' => 'edit', $category['Category']['id']), array('class' => 'btn')); ?>
    <?php echo $this->Html->link(__('Kategorie anlegen'), array('action' => 'add'), array('class' => 'btn')); ?>
    <?php echo $this->Form->postLink(__('Kategorie löschen'), array('action' => 'delete', $category['Category']['id']), array('class' => 'btn'), __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?>
</div>

<br/>
<br/>

<div class="page-header">
    <h3><?php echo __('Referentierte Kurse'); ?></h3>
</div>

<?php if (!empty($category['Course'])): ?>
    <table id="category" class="table table-bordered table-striped">
        <thead>
        <th><?php echo __('Kurstitel'); ?></th>
        <th><?php echo __('Kürzel'); ?></th>
        <th><?php echo __('Bearbeiten'); ?></th>
        <th><?php echo __('Löschen'); ?></th>
        </thead>
        <tbody>
        <?php foreach ($category['Course'] as $coursesTerm): ?>
            <tr>
                <td><?php echo $this->Html->link($coursesTerm['name'], array('controller' => 'courses', 'action' => 'view', $coursesTerm['id'])); ?></td>
                <td><?php echo $coursesTerm['code']; ?></td>
                <td><?php echo $this->Html->link(__('Bearbeiten'), array('controller' => 'courses', 'action' => 'edit', $coursesTerm['id'])); ?></td>
                <td><?php echo $this->Form->postLink(__('Löschen'), array('controller' => 'courses', 'action' => 'delete', $coursesTerm['id']), null, __('Are you sure you want to delete # %s?', $coursesTerm['id'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php echo $this->Html->script('categories/admin/view'); ?>