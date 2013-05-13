<div class="well">
    <legend><?php echo __('Semesterübersicht'); ?></legend>
    <dl class="dl-horizontal">
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($terms[0]['Term']['name']); ?>
        </dd>
        <dt><?php echo __('Start'); ?></dt>
        <dd>
            <?php echo h($terms[0]['Term']['start']); ?>
        </dd>
        <dt><?php echo __('End'); ?></dt>
        <dd>
            <?php echo h($terms[0]['Term']['end']); ?>
        </dd>
    </dl>
    <hr/>
    <?php echo $this->Html->link(__('Bearbeiten'), array('controller' => 'terms', 'action' => 'edit', $terms[0]['Term']['id']), array('class' => 'btn btn-primary')); ?>
</div>

<div class="page-header">
    <h3><?php echo __('Referenzierte Kurse'); ?></h3>
</div>

<?php if (!empty($terms)): ?>
    <table class="table table-striped table-bordered">
        <thead>
        <th style="width: 20%;"><?php echo __('Semester-Kurs-Nr.'); ?></th>
        <th><?php echo __('Semester-Kurs'); ?></th>
        </thead>
        <tbody>
        <?php foreach ($terms as $coursesTerm): ?>
            <tr>
                <td><?php echo $coursesTerm['CoursesTerm']['id']; ?></td>
                <td>
                    <?php echo $this->Html->link($coursesTerm['Course']['name'], array('controller' => 'courses_terms', 'action' => 'view', $coursesTerm['CoursesTerm']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>