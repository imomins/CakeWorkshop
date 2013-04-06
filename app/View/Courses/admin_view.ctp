<div class="page-header">
    <h4><?php  echo __('Kursdaten'); ?></h4>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('Kategorie'); ?></dt>
        <dd>
            <?php echo $this->Html->link($coursesTerm['Category']['name'], array('controller' => 'categories', 'action' => 'view', $coursesTerm['Category']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Kurstitel'); ?></dt>
        <dd>
            <?php echo h($coursesTerm['Course']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Abkürzung'); ?></dt>
        <dd>
            <?php echo h($coursesTerm['Course']['code']); ?>
            &nbsp;
        </dd>
        <?php if (!empty($coursesTerm['Course']['description'])): ?>
            <dt><?php echo __('Description'); ?></dt>
            <dd>
                <?php echo h($coursesTerm['Course']['description']); ?>
            </dd>
        <?php endif; ?>
    </dl>
</div>

<div class="btn-group">
    <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $coursesTerm['Course']['id']), array('class' => 'btn')); ?>
    <?php echo $this->Html->link(__('Übersicher aller Kurse'), array('action' => 'index'), array('class' => 'btn')); ?>
    <?php echo $this->Html->link(__('Weiteren Kurs anlegen'), array('action' => 'add'), array('class' => 'btn')); ?>
    <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $coursesTerm['Course']['id']), array('class' => 'btn btn-warning'), __('Are you sure you want to delete # %s?', $coursesTerm['Course']['id'])); ?>
</div>

<br/>
<br/>

<div class="page-header">
    <h4><?php echo __('Angelegt für folgende Semester'); ?></h4>
</div>

<?php if (!empty($coursesTerm['Term'])): ?>
    <table class="table table-bordered table-condensed table-striped">
        <tr>
            <th><?php echo __('Semester'); ?></th>
            <th><?php echo __('Von'); ?></th>
            <th><?php echo __('Bis'); ?></th>
            <th class="actions"><?php echo __('Aktionen'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($coursesTerm['Term'] as $term): ?>
            <tr>
                <td><?php echo $term['name']; ?></td>
                <td><?php echo $term['start']; ?></td>
                <td><?php echo $term['end']; ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('controller' => 'terms', 'action' => 'view', $term['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('controller' => 'terms', 'action' => 'edit', $term['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'terms', 'action' => 'delete', $term['id']), null, __('Are you sure you want to delete # %s?', $term['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>