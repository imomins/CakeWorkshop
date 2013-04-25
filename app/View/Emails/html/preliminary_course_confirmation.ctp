<strong>Vielen Dank für Ihre Anmeldung.</strong>

<p>Anbei erhalten Sie eine Übersicht der Kurse für die Sie sich registriert haben.</p>
<p>Dies ist eine vorläufige Anmeldung, welche noch bestätigt werden muss.</p>

<?php foreach ($categories as $category): ?>
    <h4><?php echo $category['Category']['name']; ?></h4>

    <table style="border:1px solid #d3d3d3;">
        <thead style="background: #fbf7f9;border-bottom:1px solid #d3d3d3;">
        <tr>
            <th width="5%" rowspan="2">Kurs-Nr.</th>
            <th width="50%" rowspan="2">Kurs-Titel</th>
            <th width="15%" rowspan="2">Semester</th>
            <th width="30%" colspan="3">Verantstaltungstag(e)</th>
        </tr>
        <tr>
            <th>Am</th>
            <th>Von</th>
            <th>Bis</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($category['Booking'] as $booking): ?>
            <tr style="border-bottom:1px solid #d3d3d3;">
                <td><?php echo $booking['CoursesTerm']['id']; ?></td>
                <td><?php echo $booking['Course']['name']; ?></td>
                <td><?php echo $booking['Term']['name']; ?></td>
                <td colspan="3">
                    <?php if (sizeof($booking['Days']) === 0): ?>
                        Noch kein Termin festgelegt.
                    <?php else: ?>
                        <?php foreach ($booking['Days'] as $day): ?>
                            <?php echo $day['start_date']; ?>, <?php echo $day['start_time']; ?> Uhr, <?php echo $day['end_time']; ?> Uhr
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <br/>
<?php endforeach; ?>

<p>
    Viele Grüße,<br />
    Ihr Workshop Team!
</p>