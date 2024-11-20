<?php
$cities = $data['cities'];
$social_groups = $data['social_groups'];
$event_types = $data['event_types'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Subscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="../assets/css/sidenavigation.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container-fluid">
        
        <div class="row content">
            <?php
            $activePage = 'subscription';
            include 'sidebar.php';
            ?>
            
            <div class="col-sm-9 main-content">
            <h2>Sukurti naują prenumeratą</h2>

            <form action="create_subscription.php" method="post" class="form">
                <div class="form-group">
                    <h2>Renginio vieta</h2>
                    <label for="city_id">Renginio miestas:</label>
                    <select class="form-control" id="city_id" name="city_id" required>
                        <option value="">--Pasirinkite miestą--</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= $city['id'] ?>"><?= htmlspecialchars($city['miestas']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label for="microcity_id">Renginio mikrorajonas:</label>
                    <select class="form-control" id="microcity_id" name="microcity_id" required></select>
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
                
                <button type="submit" class="btn btn-primary">Sukurti prenumeratą</button>
            </form>

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../assets/js/microcity_dropdown.js"></script>
    <script src="../../IT_darbas/assets/js/success_message_fade_out.js"></script>
</body>
</html>
