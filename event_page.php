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
    <title>Renginio detalės</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .container { max-width: 800px; margin-top: 20px; }
        .event-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .event-card h1, .event-card h3 {
            color: #333;
        }
        .event-card p {
            margin-bottom: 10px;
        }
        .photo-gallery img {
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        .no-content {
            color: #888;
        }
        .previous-event a {
            color: #337ab7;
            text-decoration: none;
        }
        .previous-event a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="event-card">
            <?php
				include 'event_page_code.php';
			?>
        </div>
    </div>
</body>
</html>

