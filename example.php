<?php
include 'database_connection.php'; // Include your database connection file
include 'Calendar.php';
include 'Event.php';

$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

// Create the Calendar object for the specified month and year
$date = "$year-$month-01";
$calendar = new Calendar($date);

// Load events from the database and add them to the calendar
$events = Event::get_events_from_db($dbc, $month, $year);
foreach ($events as $event) {
    $calendar->add_event($event);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Calendar</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="calendar.css" rel="stylesheet" type="text/css">
</head>
<body>
    <nav class="navtop">
        <div>
            <h1>Event Calendar</h1>
        </div>
    </nav>
    <div class="content home">
        <?=$calendar?>
    </div>
</body>
</html>
