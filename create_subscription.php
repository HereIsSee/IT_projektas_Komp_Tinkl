<?php
include 'database_connection.php';
mysqli_set_charset($dbc, "utf8");
include 'is_user.php';


$locations_query = "SELECT * FROM VIETA";
$locations_result = mysqli_query($dbc, $locations_query);
$locations = [];
while ($row = mysqli_fetch_assoc($locations_result)) {
    $locations[] = $row;
}


$event_types_query = "SELECT * FROM RENGINIO_TIPAS";
$event_types_result = mysqli_query($dbc, $event_types_query);
$event_types = [];
while ($row = mysqli_fetch_assoc($event_types_result)) {
    $event_types[] = $row;
}


$social_groups_query = "SELECT * FROM SOCIALINES_GRUPES";
$social_groups_result = mysqli_query($dbc, $social_groups_query);
$social_groups = [];
while ($row = mysqli_fetch_assoc($social_groups_result)) {
    $social_groups[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert into VARTOTOJO_PASIRINKIMAI
    $user_id = $_SESSION['user_id'];
    $location_id = $_POST['location_id'];

    $insert_user_choice = "INSERT INTO VARTOTOJO_PASIRINKIMAI (fk_vartotojo_id, fk_vieta_id) VALUES (?, ?)";
    $stmt = $dbc->prepare($insert_user_choice);
    $stmt->bind_param("ii", $user_id, $location_id);
    $stmt->execute();
    $user_choice_id = $stmt->insert_id; // Get the inserted id to use for related tables

    // Insert selected event types into VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI
    if (!empty($_POST['event_types'])) {
        $insert_event_type_choice = "INSERT INTO VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI (fk_vartotojo_pasirinkimo_id, fk_renginio_tipo_id) VALUES (?, ?)";
        $stmt = $dbc->prepare($insert_event_type_choice);
        foreach ($_POST['event_types'] as $event_type_id) {
            $stmt->bind_param("ii", $user_choice_id, $event_type_id);
            $stmt->execute();
        }
    }

    // Insert selected social groups into VARTOTOJO_GRUPES_PASIRINKIMAI
    if (!empty($_POST['social_groups'])) {
        $insert_group_choice = "INSERT INTO VARTOTOJO_GRUPES_PASIRINKIMAI (fk_vartotojo_pasirinkimo_id, fk_socialines_grupes_id) VALUES (?, ?)";
        $stmt = $dbc->prepare($insert_group_choice);
        foreach ($_POST['social_groups'] as $group_id) {
            $stmt->bind_param("ii", $user_choice_id, $group_id);
            $stmt->execute();
        }
    }

    echo "<p class='alert alert-success'>Prenumėrata sukurta sėkmingai!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Subscription</title>
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
                    <?php
						if ($_SESSION['vaidmuo'] === 'admin' || $_SESSION['vaidmuo'] === 'vip') {
							echo '<li><a href="create_event.php">Sukurti rengini</a></li>';
						}
					?>
                    <li class="active"><a href="create_subscription.php">Sukurti norimų renginių prenumeratą</a></li>
                </ul><br>
            </div>
            
            <div class="col-sm-9 main-content">
                <h2>Sukurti naują prenumeratą</h2>
                
                <form action="create_subscription.php" method="post" class="form">
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
                        <label for="event_types">Pasirinkti renginio tipus:</label>
                        <?php foreach ($event_types as $event_type): ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="event_types[]" value="<?= $event_type['id'] ?>">
                                    <?= htmlspecialchars($event_type['pavadinimas']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
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
                    
                    <button type="submit" class="btn btn-primary">Sukurti prenumerata</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
