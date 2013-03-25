<div class="page-header">
    <h4><?php  echo __('Semesterübersicht'); ?></h4>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($term['Term']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Start'); ?></dt>
        <dd>
            <?php echo h($term['Term']['start']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('End'); ?></dt>
        <dd>
            <?php echo h($term['Term']['end']); ?>
            &nbsp;
        </dd>
    </dl>
</div>

<div class="btn-group">
    <?php echo $this->Html->link(__('Semester bearbeiten'), array('action' => 'edit', $term['Term']['id']), array('class' => 'btn')); ?>
    <?php echo $this->Html->link(__('Semester anlegen'), array('action' => 'add'), array('class' => 'btn')); ?>
    <?php echo $this->Form->postLink(__('Semester Löschen'), array('action' => 'delete', $term['Term']['id']), array('class' => 'btn'), __('Are you sure you want to delete # %s?', $term['Term']['id'])); ?>
</div>

<br />
<br />

<div class="page-header">
    <h4><?php  echo __('Referenzierte Kurse'); ?></h4>
</div>

<?php if (!empty($term['Course'])): ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th style="width: 20%;"><?php echo __('Category Id'); ?></th>
            <th><?php echo __('Name'); ?></th>
            <th><?php echo __('Code'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($term['Course'] as $course): ?>
            <tr>
                <td><?php echo $course['Category']['name']; ?></td>
                <td><?php echo $course['name']; ?></td>
                <td><?php echo $course['code']; ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('controller' => 'courses', 'action' => 'view', $course['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('controller' => 'courses', 'action' => 'edit', $course['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'courses', 'action' => 'delete', $course['id']), null, __('Are you sure you want to delete # %s?', $course['id'])); ?>
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
