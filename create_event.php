<?php
include 'database_connection.php';
mysqli_set_charset($dbc, "utf8");
include 'is_user.php';
include 'Event.php';

if ($_SESSION['vaidmuo'] === 'vartotojas') {
    header("Location: dashboard.php");
    exit();
}

$locations_query = "SELECT * FROM VIETA";
$locations_result = mysqli_query($dbc, $locations_query);
$locations = [];
while ($row = mysqli_fetch_assoc($locations_result)) {
    $locations[] = $row;
}

$social_groups_query = "SELECT * FROM SOCIALINES_GRUPES";
$social_groups_result = mysqli_query($dbc, $social_groups_query);
$social_groups = [];
while ($row = mysqli_fetch_assoc($social_groups_result)) {
    $social_groups[] = $row;
}

$event_types_query = "SELECT * FROM RENGINIO_TIPAS";
$event_types_result = mysqli_query($dbc, $event_types_query);
$event_types = [];
while ($row = mysqli_fetch_assoc($event_types_result)) {
    $event_types[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($dbc, $_POST['title']);
    $date = mysqli_real_escape_string($dbc, $_POST['date']);
    $description = mysqli_real_escape_string($dbc, $_POST['description']);
    $event_type_id = mysqli_real_escape_string($dbc, $_POST['event_type']);
    $location_id = mysqli_real_escape_string($dbc, $_POST['location_id']);
    $user_id = $_SESSION['user_id']; // Assuming the user's ID is stored in session
    
    // Insert new event into the database
    $query = "INSERT INTO RENGINYS (pavadinimas, renginio_data, aprasymas, fk_renginio_tipas_id, fk_vip_vartotojo_id, fk_vieta_id) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("sssiii", $title, $date, $description, $event_type_id, $user_id, $location_id);
    
    if ($stmt->execute()) {
        // Get the ID of the newly created event
        $event_id = mysqli_insert_id($dbc);

        echo "<p class='alert alert-success'>Renginiys sukurtas sėkmingai!!</p>";
        
        // Insert selected social groups into RENGINIAI_GRUPES table
        if (!empty($_POST['social_groups'])) {
            $insert_group_choice = "INSERT INTO RENGINIAI_GRUPES (fk_renginio_id, fk_socialines_grupes_id) VALUES (?, ?)";
            $stmt = $dbc->prepare($insert_group_choice);
            foreach ($_POST['social_groups'] as $group_id) {
                $stmt->bind_param("ii", $event_id, $group_id);
                $stmt->execute();
            }
        }
        
    } else {
        echo "<p class='alert alert-danger'>Klaida kuriant renginį: " . $dbc->error . "</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sukurti renginį</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content { height: 100vh; }
        
        /* Gray background color for sidebar */
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }
        
        /* Main content styling */
        .main-content {
            padding: 20px;
        }

        /* Form styling */
        .form-group > label {
            font-weight: bold;
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
                    <li><a href="all_events.php">Visi renginiai</a></li>
                    <li class="active"><a href="create_event.php">Sukurti renginį</a></li>
                    <li><a href="create_subscription.php">Sukurti norimų renginių prenumeratą</a></li>
                </ul><br>
            </div>
            
            <!-- Main content area with event creation form -->
            <div class="col-sm-9 main-content">
                <h2>Sukurti naują renginį</h2>
                
                <form action="create_event.php" method="post" class="form">
                    <div class="form-group">
                        <label for="title">Renginio pavadinimas:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="date">Renginio data:</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Renginio aprašas:</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group">
						<label for="event_type">Renginio tipas:</label>
                        <select class="form-control" id="event_type" name="event_type" required>
							<?php foreach ($event_types as $event_type): ?>
								<option value="<?= $event_type['id'] ?>">
									<?= htmlspecialchars($event_type['pavadinimas']) ?>
								</option>
							<?php endforeach; ?>
						</select>
                    </div>
                    
                    <div class="form-group">
                        <label for="location_id">Renginio vieta:</label>
						
                        <select class="form-control" id="location_id" name="location_id" required>
							<?php foreach ($locations as $location): ?>
								<option value="<?= $location['id'] ?>">
									Miestas: <?= htmlspecialchars($location['miestas']) ?>
									<?php if (!empty($location['mikrorajonas'])): ?>
										- Mikrorajonas: <?= htmlspecialchars($location['mikrorajonas']) ?>
									<?php endif; ?>
								</option>
							<?php endforeach; ?>
						</select>
                    </div>
					
					<div class="form-group">
                        <label for="social_groups">Pasirinkti socialines grupes:</label>
                        <?php foreach ($social_groups as $group): ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="social_groups[]" value="<?= $group['id'] ?>">
                                    <?= htmlspecialchars($group['pavadinimas']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
					
                    <button type="submit" class="btn btn-primary">Sukurti renginį</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
