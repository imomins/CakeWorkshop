<div class="page-header">
    <h4><?php echo __('Benutzer Übersicht'); ?></h4>
</div>

<form class="form-search">
    <input type="text" class="input-medium search-query span4">
    <button type="submit" class="btn"><?php echo __('Suchen'); ?></button>
</form>
<br/>

<table class="table table-striped table-bordered">
    <tr>
        <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
        <th><?php echo $this->Paginator->sort('email', __('E-Mail')); ?></th>
        <th><?php echo $this->Paginator->sort('group_name', __('Benutzergruppe')); ?></th>
        <th><?php echo __('Bearbeiten'); ?></th>
        <th><?php echo __('Löschen'); ?></th>
    </tr>
    <?php
    foreach ($users as $user): ?>
        <tr>
            <td>
                <?php echo $this->Html->link($user['0']['name'], array('action' => 'view', $user['User']['id'])); ?>
            </td>
            <td><?php echo h($user['User']['email']); ?>&nbsp;</td>
            <td><?php echo h($user['Group']['display']); ?></td>
            <td>
                <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $user['User']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>
</p>

<div class="paging">
    <?php
    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>
