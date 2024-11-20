<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sukurti renginį</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../IT_darbas/assets/css/create_event.css" rel="stylesheet" type="text/css">
    <link href="../../IT_darbas/assets/css/sidenavigation.css" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        label { display:block }

        .main-content {
            padding: 20px;
        }

        .form-group > label {
            font-weight: bold;
        }        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row content">
            <?php
            $activePage = 'create_event';
            include 'sidebar.php';
            ?>
            
            <div class="col-sm-9 main-content">
                <h2>Sukurti naują renginį</h2>
                
                <form action="create_event.php" method="post" class="form" enctype="multipart/form-data">
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
							<?php foreach ($data['event_types'] as $event_type): ?>
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
							<?php foreach ($data['cities'] as $city): ?>
								<option value="<?= $city['id'] ?>">
									<?= htmlspecialchars($city['miestas']) ?>
								</option>
							<?php endforeach; ?>
						</select>
						
                        <label for="microcity_id">Renginio mikrorajonas</label>

                        <select class="form-control" id="microcity_id" name="microcity_id" required>
                            
                        </select>

                        <label id="address_id" for="address">Renginio adresas: </label>
                        <input type="text" id="address" name="address">
                    </div>
					
					<div class="form-group">
                        <label for="social_groups">Pasirinkti socialines grupes:</label>
                        <?php foreach ($data['social_groups'] as $group): ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="social_groups[]" value="<?= $group['id'] ?>">
                                    <?= htmlspecialchars($group['pavadinimas']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-group">
                        <label for="images">Ikelkite nuotraukas:</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>
                    
					
                    <button type="submit" class="btn btn-primary">Sukurti renginį</button>
                </form>
            </div>
        </div>
    </div>
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../IT_darbas/assets/js/microcity_dropdown.js"></script>
    <script src="../../IT_darbas/assets/js/success_message_fade_out.js"></script>
</body>
</html>
