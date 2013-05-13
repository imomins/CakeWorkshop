<div class="pull-left">
    <h3>Unterschriftenliste zum Workshop</h3>
    <h3>Kurs-Nr.: <?php echo $course['CoursesTerm']['id']; ?>, <?php echo $course['Course']['name']; ?>, <?php echo $course['Term']['name']; ?></h3>
</div>

<?php if (isset($logo) && $logo): ?>
<div class="pull-right">
    <?php echo $this->Html->image('sd-logo.gif', array('style' => 'height: 2.5cm !important; margin-bottom: 15px;')); ?>
</div>
<?php endif; ?>
<br/>

<table style="border: 1px solid black; width:100%; font-size: 17px; background: white;">
    <thead style="font-weight: bold; background: #f8f8f8">
    <tr style="padding: 6px 10px;">
        <th style="width: 5%; border: 1px solid black; font-weight: bold; padding: 10px 10px;text-align: left;"><?php echo __('Nr.'); ?></th>
        <th style="width: 15%; border: 1px solid black; font-weight: bold; padding: 10px 10px;text-align: left;"><?php echo __('Titel'); ?></th>
        <th style="width: 20%; border: 1px solid black; font-weight: bold; padding: 10px 10px;text-align: left;"><?php echo __('Name'); ?></th>
        <th style="width: 20%; border: 1px solid black; font-weight: bold; padding: 10px 10px;text-align: left;"><?php echo __('Vorname'); ?></th>
        <th style="width: 40%; border: 1px solid black; font-weight: bold; padding: 10px 10px;text-align: left;"><?php echo __('Unterschrift'); ?></th>
    </tr>
    </thead>

    <tbody>
    <?php if (sizeof($bookings) === 0): ?>
        <tr>
            <td><?php echo __('Keine Teilnehmer'); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    <?php else: ?>
        <?php foreach ($bookings as $i => $booking): ?>
            <tr style="border:1px solid black;">
                <td style="width: 5%; border: 1px solid black; text-align: right;padding: 10px 10px;"><?php echo $i + 1; ?></td>
                <td style="width: 15%; border: 1px solid black; padding: 10px 10px;"><?php echo $booking['User']['title']; ?></td>
                <td style="width: 20%; border: 1px solid black; padding: 10px 10px;"><?php echo $booking['User']['lastname']; ?></td>
                <td style="width: 20%; border: 1px solid black; padding: 10px 10px;"><?php echo $booking['User']['firstname']; ?></td>
                <td style="width: 40%; border: 1px solid black; padding: 10px 10px;"></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<style type="text/css" media="all">
    @media print {
        @page {
            margin: 2cm 1.5cm;
            size: landscape
        }

        #header { display: none; }

        #controls, .footer, .footerarea, .navbar { display: none; }

        html, body {
            /*changing width to 100% causes huge overflow and wrap*/
            height: 100%;
            background: #FFF;
            font-size: 9.5pt;
        }

        .template { width: auto; left: 0; top: 0; }

        img { width: 100%; }

        li { margin: 0 0 10px 20px !important; }
    }
</style>