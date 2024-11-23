<?php
require_once '../config/database_connection.php';
require_once '../src/models/Calendar.php';
include '../src/models/Event.php';
include '../src/helpers/is_user.php';

// Get month and year from URL or default to current month and year
$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

// Ensure $month and $year are integers
$month = (int) $month;
$year = (int) $year;

// Adjust month and year if out of range
if ($month > 12) {
    $month = 1;
    $year++;
} elseif ($month < 1) {
    $month = 12;
    $year--;
}

// Create a valid date for the calendar
$date = "$year-$month-01";
$calendar = new Calendar($date);

// Fetch events for the specified month and year
$events = Event::getEventsFromDB($dbc, $month, $year);
foreach ($events as $event) {
    $calendar->add_event($event);
}
?>
