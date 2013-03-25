<div class="page-header">
    <h3><?php  echo __('Kurse'); ?></h3>
</div>

<table class="table table-striped table-bordered">
    <tr>
        <th style="width: 50%;"><?php echo $this->Paginator->sort('name'); ?></th>
        <th><?php echo $this->Paginator->sort('code', __('Kürzel')); ?></th>
        <th><?php echo $this->Paginator->sort('category_id', __('Kategorie')); ?></th>
        <th class="actions"><?php echo __('Optionen'); ?></th>
    </tr>
    <?php
    foreach ($courses as $course): ?>
        <tr>
            <td>
                <?php echo $this->Html->link($course['Course']['name'], array('action' => 'view', $course['Course']['id'])); ?>
            </td>
            <td>
                <?php echo h($course['Course']['code']); ?>
            </td>
            <td>
                <?php echo $this->Html->link($course['Category']['name'], array('action' => 'view', $course['Course']['id'])); ?>
            </td>
            <td class="actions">
                <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $course['Course']['id'])); ?>
                <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete # %s?', $course['Course']['id'])); ?>
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