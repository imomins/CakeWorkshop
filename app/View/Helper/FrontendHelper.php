<?php
App::uses('AppHelper', 'View/Helper');

class FrontendHelper extends AppHelper {

    public function GroupToName($group) {
        switch($group) {
            case 'attendee':
                return 'Schulungsteilnehmer';
                break;
            case 'admin':
                return 'Administrator';
                break;
            default:
                return 'Unbekannte Gruppe';
        }
    }

    public function YesNo($value) {
        switch(intval($value)) {
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

}