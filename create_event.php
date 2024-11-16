<?php
include 'database_connection.php';
mysqli_set_charset($dbc, "utf8");
include 'is_user.php';
include 'Event.php';

if ($_SESSION['vaidmuo'] === 'vartotojas') {
    header("Location: dashboard.php");
    exit();
}

include 'fetch_cities.php';
include 'fetch_social_groups.php';
include 'fetch_event_types.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sukurti renginį</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .row.content { height: 100vh; }
        
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }
        label { display:block }
        .main-content {
            padding: 20px;
        }

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
            
            <div class="col-sm-9 main-content">

                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $title = mysqli_real_escape_string($dbc, $_POST['title']);
                        $date = mysqli_real_escape_string($dbc, $_POST['date']);
                        $description = mysqli_real_escape_string($dbc, $_POST['description']);
                        $event_type_id = mysqli_real_escape_string($dbc, $_POST['event_type']);
                        $address = mysqli_real_escape_string($dbc, $_POST['address']);
                        $city_id = mysqli_real_escape_string($dbc, $_POST['city_id']);
                        $microcity_id = mysqli_real_escape_string($dbc, $_POST['microcity_id']);
                        $user_id = $_SESSION['user_id'];
                        
                        $query = "INSERT INTO RENGINYS (pavadinimas, renginio_data, aprasymas, adresas, fk_renginio_tipas_id, fk_vip_vartotojo_id, fk_miesto_id, fk_mikrorajono_id) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $dbc->prepare($query);
                        $stmt->bind_param("ssssiiii", $title, $date, $description, $address, $event_type_id, $user_id, $city_id, $microcity_id);

                        
                        if ($stmt->execute()) {
                            $event_id = mysqli_insert_id($dbc);
                    
                            echo "<p id='success-message'class='alert alert-success'>Renginiys sukurtas sėkmingai!!</p>";
                            
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
                        <h2>Renginio vieta</h2>
                        <label for="city_id">Renginio miestas:</label>
						
                        <select class="form-control" id="city_id" name="city_id" required>
                            <option value="default">--Pasirinkite miestą--</option>
							<?php foreach ($cities as $city): ?>
								<option value="<?= $city['id'] ?>">
									<?= htmlspecialchars($city['miestas']) ?>
								</option>
							<?php endforeach; ?>
						</select>
						
                        <label for="microcity_id">Renginio mikrorajonas</label>

                        <select class="form-control" id="microcity_id" name="microcity_id" required>
                            
                        </select>

                        <label for="address">Renginio adresas: </label>
                        <input type="text" id="address" name="address">
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
    <script src="success_message_fade_out.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="microcity_dropdown.js"></script>
</body>
</html>
