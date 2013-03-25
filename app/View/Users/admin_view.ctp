<div class="page-header">
    <h4><?php  echo __('Daten des Benutzers: ' . h($user['User']['firstname']) . ' ' . h($user['User']['lastname'])); ?></h4>
</div>

<div class="well">
    <dl class="dl-horizontal">
        <dt><?php echo __('Anrede'); ?></dt>
        <dd>
            <?php echo $this->Html->link($user['Gender']['name'], array('controller' => 'genders', 'action' => 'view', $user['Gender']['id'])); ?>
            &nbsp;
        </dd>

        <?php if (!empty($user['User']['title'])): ?>
            <dt><?php echo __('Titel'); ?></dt>
            <dd>
                <?php echo $user['User']['title']; ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($user['User']['name']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Email'); ?></dt>
        <dd>
            <?php echo h($user['User']['email']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Fachbereich'); ?></dt>
        <dd>
            <?php echo $this->Html->link($user['Department']['name'], array('controller' => 'departments', 'action' => 'view', $user['Department']['id'])); ?>
            &nbsp;
        </dd>

        <?php if (!empty($user['User']['occupation'])): ?>
            <dt><?php echo __('Beschäftigung'); ?></dt>
            <dd>
                <?php echo h($user['User']['occupation']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <?php if (!empty($user['User']['hrz'])): ?>
            <dt><?php echo __('Hrz-Id'); ?></dt>
            <dd>
                <?php echo h($user['User']['hrz']); ?>
                &nbsp;
            </dd>
        <?php endif; ?>

        <dt><?php echo __('Tel.'); ?></dt>
        <dd>
            <?php echo h($user['User']['phone']); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Benutzer-Gruppe'); ?></dt>
        <dd>
            <?php echo $this->Html->link($this->Frontend->groupToName($user['Group']['name']), array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Konto-Aktiviert'); ?></dt>
        <dd>
            <?php echo h($user['User']['active'] === '1' ? __('Ja') : __('Nein')); ?>
            &nbsp;
        </dd>

        <dt><?php echo __('Konto-Erstellt am'); ?></dt>
        <dd>
            <?php echo date('d.m.Y, H:i ', strtotime($user['User']['created'])) . ' ' . __('Uhr'); ?>
            &nbsp;
        </dd>

    </dl>
</div>

<div class="page-header">
    <h4><?php  echo __('Gebuchte Kurse'); ?></h4>
</div>

<?php if (!empty($user['CoursesTerm'])): ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th><?php echo __('Semester'); ?></th>
            <th><?php echo __('Kurs'); ?></th>
            <th class="actions"><?php echo __('Optionen'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($user['CoursesTerm'] as $coursesTerm): ?>
            <tr>
                <td><?php echo $coursesTerm['Term']['name']; ?></td>
                <td><?php echo $coursesTerm['Course']['name']; ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('controller' => 'courses_terms', 'action' => 'view', $coursesTerm['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('controller' => 'courses_terms', 'action' => 'edit', $coursesTerm['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'courses_terms', 'action' => 'delete', $coursesTerm['id']), null, __('Are you sure you want to delete # %s?', $coursesTerm['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
