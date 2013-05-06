<div class="page-header">
    <h3><?php echo __('Kursdaten'); ?></h3>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('Kategorie'); ?></dt>
        <dd>
            <?php echo $this->Html->link($course['Category']['name'], array('controller' => 'categories', 'action' => 'view', $course['Category']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Kurstitel'); ?></dt>
        <dd>
            <?php echo h($course['Course']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Abkürzung'); ?></dt>
        <dd>
            <?php echo h($course['Course']['code']); ?>
            &nbsp;
        </dd>
        <?php if (!empty($course['Course']['description'])): ?>
            <dt><?php echo __('Description'); ?></dt>
            <dd>
                <?php echo h($course['Course']['description']); ?>
            </dd>
        <?php endif; ?>
    </dl>
</div>

    <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $course['Course']['id']), array('class' => 'btn btn-primary')); ?>
    <?php echo $this->Html->link(__('Übersicher aller Kurse'), array('action' => 'index'), array('class' => 'btn')); ?>
    <?php echo $this->Html->link(__('Weiteren Kurs anlegen'), array('action' => 'add'), array('class' => 'btn')); ?>
    <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $course['Course']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $course['Course']['id'])); ?>
<br/>
<br/>

<div class="page-header">
    <h3><?php echo __('Angelegt für folgende Semester'); ?></h3>
</div>

<table class="table table-bordered table-hover table-striped">
    <thead>
    <th><?php echo __('Kurs-Nr.'); ?></th>
    <th><?php echo __('Semester'); ?></th>
    <th><?php echo __('Status'); ?></th>
    <th><?php echo __('Anzeigen'); ?></th>
    <th><?php echo __('Bearbeiten'); ?></th>
    </thead>
    <tbody>
    <?php if (empty($course)): ?>
        <?php echo __('Keine Semesterkurse angesetzt'); ?>
    <?php else: ?>
        <?php foreach ($course['children'] as $coursesTerm): ?>
            <tr>
                <td><?php echo $coursesTerm['CoursesTerm']['id']; ?></td>
                <td><?php echo $coursesTerm['Term']['name']; ?></td>
                <td><?php echo $coursesTerm['Schedule']['display']; ?></td>
                <td><?php echo $this->Html->link(__('Anzeigen'), array('controller' => 'courses_terms', 'action' => 'view', $coursesTerm['CoursesTerm']['id'])); ?></td>
                <td><?php echo $this->Html->link(__('Bearbeiten'), array('controller' => 'courses_terms', 'action' => 'edit', $coursesTerm['CoursesTerm']['id'])); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>