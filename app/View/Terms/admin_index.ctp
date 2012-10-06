<div class="terms index">
    <h2><?php echo __('Semester'); ?></h2>

    <table class="table table-condensed table-bordered table-striped">
        <tr>
            <th><?php echo $this->Paginator->sort('name', __('Bezeichnung')); ?></th>
            <th><?php echo $this->Paginator->sort('start', __('Anfang')); ?></th>
            <th><?php echo $this->Paginator->sort('end', __('Ende')); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php
        foreach ($terms as $term): ?>
            <tr>
                <td><?php echo h($term['Term']['name']); ?>&nbsp;</td>
                <td><?php echo h($term['Term']['start']); ?>&nbsp;</td>
                <td><?php echo h($term['Term']['end']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $term['Term']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $term['Term']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $term['Term']['id']), null, __('Are you sure you want to delete # %s?', $term['Term']['id'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>    </p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>