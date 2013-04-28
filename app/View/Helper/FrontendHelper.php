<?php
App::uses('AppHelper', 'View/Helper');

class FrontendHelper extends AppHelper {

    public function YesNo($value) {
        switch (intval($value)) {
            case 1:
                return 'Ja';
                break;
            case 0:
                return 'Nein';
                break;
            default:
                return 'Unbekannter Wert';
        }
    }

    public function DayFormatter($day) {
        $date           = new DateTime($day['start_date']);
        $date_formatted = $date->format('d.m.Y');

        $start = substr($day['start_time'], 0, 5);
        $end   = substr($day['end_time'], 0, 5);

        return $date_formatted . ', ' . $start . ' Uhr, ' . $end . ' Uhr';
    }

    public function note($note) {
        return (trim($note) === '' || $note === null) ? __('(Keine Notizen)') : $note;
    }

}