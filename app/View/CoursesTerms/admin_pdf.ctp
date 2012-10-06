<?php
App::import('Vendor', 'xtcpdf');
$tcpdf = new XTCPDF();
$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans'

// add a page (required with recent versions of tcpdf)
$tcpdf->AddPage('', 'A4');
$tcpdf->SetAutoPageBreak(false);
$tcpdf->setHeaderFont(array($textfont, '', 40));

$tcpdf->writeHTML('<h2>'.h($coursesTerm['Course']['name']).'</h2>');
$tcpdf->writeHTML('<h3>Teilnehmerliste</h3>');

if (!empty($coursesTerm['User'])) {
    $tcpdf->writeHTML('<table>');
    $tcpdf->writeHTML('<thead>');
    $tcpdf->writeHTML('<th>Email</th>');
    $tcpdf->writeHTML('<th>Name</th>');
    $tcpdf->writeHTML('<th>Gebucht am</th>');
    $tcpdf->writeHTML('</thead>');
    $tcpdf->writeHTML('<tbody>');
    foreach ($coursesTerm['User'] as $user) {
        $tcpdf->writeHTML('<tr>');
        $tcpdf->writeHTML('<td>'.$user['email'].'</td>');
        $tcpdf->writeHTML('<td>'.$user['name'].'</td>');
        $tcpdf->writeHTML('<td>'.date('d.m.Y, h:i', strtotime($user['created'])).'</td>');
        $tcpdf->writeHTML('</tr>');
    }
    $tcpdf->writeHTML('</tbody>');
    $tcpdf->writeHTML('</table>');
} else {
    $tcpdf->writeHTML('<p>'.__('Keine Buchungen').'</p>');
}

echo $tcpdf->Output('test.pdf', 'D');
?>