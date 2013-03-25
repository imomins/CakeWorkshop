<div class="page-header">
    <h3><?php echo __('Aktuelle Buchungen'); ?></h3>
    <div class="pull-right"></div>
</div>

<table class="table table-bordered table-striped">
    <tr>
        <th><?php echo $this->Paginator->sort('user_id', __('Teilnehmer')); ?></th>
        <th><?php echo $this->Paginator->sort('courses_term_id', __('Kurs')); ?></th>
        <th><?php echo $this->Paginator->sort('term_id', __('Semester')); ?></th>
        <th style="min-width:140px;"><?php echo $this->Paginator->sort('created', __('Gebucht am')); ?></th>
        <th style="min-width: 200px;" class="actions"><?php echo __('Buchungsaktionen'); ?></th>
    </tr>
    <?php
    foreach ($bookings as $booking): ?>
        <tr>
            <td>
                <?php echo $this->Html->link($booking['User']['name'], array('controller' => 'users', 'action' => 'view', $booking['User']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link($booking['CoursesTerm']['Course']['name'], array('controller' => 'courses_terms', 'action' => 'view', $booking['CoursesTerm']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link($booking['CoursesTerm']['Term']['name'], array('controller' => 'terms', 'action' => 'view', $booking['CoursesTerm']['Term']['id'])); ?>
            </td>

            <td><?php echo h(date('d.m.Y, H:i', strtotime($booking['Booking']['created']))); ?>&nbsp;</td>
            <td class="actions">
                <?php echo $this->Html->link(__('Anzeigen'), array('action' => 'view', $booking['Booking']['id'])); ?>
                <?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $booking['Booking']['id'])); ?>
                <?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $booking['Booking']['id']), null, __('Soll die Buchung gelöscht werden?', $booking['Booking']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Seite {:page} von {:pages}, angezeigt {:current} von {:count} Buchungen, Datensatz von {:start}, bis {:end}')
    ));
    ?>    </p>

<div class="paging">
    <?php
    echo $this->Paginator->prev('< ' . __('zurück'), array(), null, array('class' => 'prev disabled'));
    echo h(' | ');
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(__('weiter') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>
