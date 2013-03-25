<div class="page-header">
    <h4><?php  echo __('Semester-Übersicht'); ?></h4>
</div>

<table class="table table-bordered table-striped">
    <tr>
        <th><?php echo $this->Paginator->sort('name', __('Bezeichnung')); ?></th>
        <th><?php echo $this->Paginator->sort('start', __('Von')); ?></th>
        <th><?php echo $this->Paginator->sort('end', __('Bis')); ?></th>
        <th class="actions"><?php echo __('Optionen'); ?></th>
    </tr>
    <?php
    foreach ($terms as $term): ?>
        <tr>
            <td><?php echo $this->Html->link($term['Term']['name'], array('action' => 'view', $term['Term']['id'])); ?></td>
            <td><?php echo h($term['Term']['start']); ?></td>
            <td><?php echo h($term['Term']['end']); ?></td>
            <td class="actions">
                <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $term['Term']['id'])); ?>
                <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $term['Term']['id']), null, __('Are you sure you want to delete # %s?', $term['Term']['id'])); ?>
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
