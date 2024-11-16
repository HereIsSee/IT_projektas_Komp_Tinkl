<?php
include 'database_connection.php';
mysqli_set_charset($dbc, "utf8");
include 'is_user.php';
include 'Event.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Visi renginiai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .row.content { height: 100vh; }
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }
        .event-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .event-card h3 {
            margin-top: 0;
        }
        .event-card p {
            margin-bottom: 8px;
        }
        @media screen and (max-width: 767px) {
            .row.content { height: auto; }
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
                    <li><a href="calendar_page.php">Renginių kalendorius</a></li>
                    <li class="active"><a href="all_events.php">Visi renginiai</a></li>
                    <?php
						if ($_SESSION['vaidmuo'] === 'admin' || $_SESSION['vaidmuo'] === 'vip') {
							echo '<li><a href="create_event.php">Sukurti rengini</a></li>';
						}
					?>
                    <li><a href="create_subscription.php">Sukurti norimų renginių prenumeratą</a></li>
                </ul><br>
            </div>
            
            <div class="col-sm-9 main-content">
                <h2>Visi renginiai</h2>

                <?php
                    $events = Event::get_all_events_from_db($dbc);

                    if (empty($events)) {
                        echo "<p>No events found for this month.</p>";
                    } else {
                        foreach ($events as $event) {
                            echo '<div class="event-card">';
                            echo '<h3> <a href="event_page.php?id=' . urlencode($event->id) . '" style="color: inherit; text-decoration: none;">' . htmlspecialchars($event->title) . '</a></h3>';
                            echo '<p><strong>Date:</strong> ' . htmlspecialchars(date('Y-m-d', strtotime($event->date))) . '</p>';
                            echo '<p><strong>Description:</strong> ' . htmlspecialchars($event->description) . '</p>';
                            echo '</div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
