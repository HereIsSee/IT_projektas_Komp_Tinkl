<?php
require_once '../config/database_connection.php';
require_once '../src/models/Event.php';

class EventController {
    private $dbc;

    public function __construct($dbc) {
        $this->dbc = $dbc;
    }

    public function getAllEvents() {
        return Event::getAllEventsFromDB($this->dbc);
    }
}
?>