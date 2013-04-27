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
    <h4><?php echo __('Referentierte Kurse'); ?></h4>
</div>

<?php if (!empty($category['Course'])): ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th><?php echo __('Kurstitel'); ?></th>
            <th><?php echo __('Kürzel'); ?></th>
            <th class="actions"><?php echo __('Optinen'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($category['Course'] as $course): ?>
            <tr>
                <td><?php echo $this->Html->link($course['name'], array('controller' => 'courses', 'action' => 'view', $course['id'])); ?></td>
                <td><?php echo $course['code']; ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Bearbeiten'), array('controller' => 'courses', 'action' => 'edit', $course['id'])); ?>
                    <?php echo $this->Form->postLink(__('Löschen'), array('controller' => 'courses', 'action' => 'delete', $course['id']), null, __('Are you sure you want to delete # %s?', $course['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<div class="actions">
    <ul>
        <?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?>
    </ul>
</div>
