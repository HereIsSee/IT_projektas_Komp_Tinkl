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

</html>

<head>
  <title>Renginiu kalendorius</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="calendar.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 100vh}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>



<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
      <h2>Logo</h2>
      <ul class="nav nav-pills nav-stacked">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li class="active"><a  href="calendar_page.php">Renginių kalendorius</a></li>
        <li><a href="all_events.php">Visi renginiai</a></li>
        <?php
			if ($_SESSION['vaidmuo'] === 'admin' || $_SESSION['vaidmuo'] === 'vip') {
    			echo '<li><a href="create_event.php">Sukurti rengini</a></li>';
			}
		?>
		<li><a href="create_subscription.php">Sukurti norimų renginių prenumerata</a></li>
      </ul><br>
    </div>
    <br>
    
    <div class="col-sm-9 main-content">
      <div class="calendar-wrapper">
        <?=$calendar?>
      </div>
    </div>

  </div>
</div>

</body>


