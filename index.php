<?php
include 'database_connection.php';
include 'is_user.php';
include 'Calendar.php';
include 'Event.php';
// Check if month and year are provided in the URL; if not, use the current month and year
$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

// Set up the date for the calendar view
$date = "$year-$month-01";
$calendar = new Calendar($date);

// Fetch events for the specified month and year
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

