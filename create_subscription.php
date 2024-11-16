<?php
include 'database_connection.php';
mysqli_set_charset($dbc, "utf8");
include 'is_user.php';

include 'fetch_cities.php';
include 'fetch_social_groups.php';
include 'fetch_event_types.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Subscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .row.content { height: 100vh; }
        
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }

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
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $user_id = $_SESSION['user_id'];
                $city_id = $_POST['city_id'];
                $microcity_id = $_POST['microcity_id'];
            
                $insert_user_choice = "INSERT INTO VARTOTOJO_PASIRINKIMAI (fk_vartotojo_id, fk_miesto_id, fk_mikrorajono_id) VALUES (?, ?, ?)";
                $stmt = $dbc->prepare($insert_user_choice);
                $stmt->bind_param("iii", $user_id, $city_id, $microcity_id);
                $stmt->execute();
                $user_choice_id = $stmt->insert_id;
            
                if (!empty($_POST['event_types'])) {
                    $insert_event_type_choice = "INSERT INTO VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI (fk_vartotojo_pasirinkimo_id, fk_renginio_tipo_id) VALUES (?, ?)";
                    $stmt = $dbc->prepare($insert_event_type_choice);
                    foreach ($_POST['event_types'] as $event_type_id) {
                        $stmt->bind_param("ii", $user_choice_id, $event_type_id);
                        $stmt->execute();
                    }
                }
            
                if (!empty($_POST['social_groups'])) {
                    $insert_group_choice = "INSERT INTO VARTOTOJO_GRUPES_PASIRINKIMAI (fk_vartotojo_pasirinkimo_id, fk_socialines_grupes_id) VALUES (?, ?)";
                    $stmt = $dbc->prepare($insert_group_choice);
                    foreach ($_POST['social_groups'] as $group_id) {
                        $stmt->bind_param("ii", $user_choice_id, $group_id);
                        $stmt->execute();
                    }
                }
            
                echo "<p id='success-message' class='alert alert-success'>Prenumėrata sukurta sėkmingai!</p>";
            }
            ?>
                <h2>Sukurti naują prenumeratą</h2>
                
                <form action="create_subscription.php" method="post" class="form">
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
    <script src="success_message_fade_out.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="microcity_dropdown.js"></script>
</body>
</html>
