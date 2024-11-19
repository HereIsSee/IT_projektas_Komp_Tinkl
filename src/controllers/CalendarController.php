<?php
require_once '../config/database_connection.php';
require_once '../src/models/Calendar.php';
include '../src/models/Event.php';
include '../src/helpers/is_user.php';

$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

$date = "$year-$month-01";
$calendar = new Calendar($date);

$events = Event::getEventsFromDB($dbc, $month, $year);
foreach ($events as $event) {
    $calendar->add_event($event);
}
?>