<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Visi renginiai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../IT_darbas/assets/css/sidenavigation.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/all_events.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/toggle_filter.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>
<body>
<div class="container-fluid">
    <div class="row content">
        <?php
        $activePage = 'events';
        include 'sidebar.php';
        ?>

        <div class="col-sm-9 main-content">
            <h2>Visi renginiai</h2>
            <div class="toggle-btn" id="toggle-btn">
                <span id="arrow">▼</span> <span>Filtras</span>
            </div>
            <div id="form-container" class="hidden">
            <form action="all_events.php" method="post">
            <!-- <form action="test_form.php" method="post"> -->
                
                <div class="form-group">
                    <label for="title">Renginio pavadinimas</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
					<label for="event_type">Renginio tipas:</label>
                    <select class="form-control" id="event_type" name="event_type" >
                        <option value="default">--Pasirinkite renginio tipą--</option>
						<?php foreach ($data['event_types'] as $event_type): ?>
							<option value="<?= $event_type['id'] ?>">
								<?= htmlspecialchars($event_type['pavadinimas']) ?>
							</option>
						<?php endforeach; ?>
					</select>
                </div>
                
                <div id="dates_from_to">
                    <div class="form-group">
                        <label for="date_from">Paieška nuo datos:</label>
                        <input type="date" class="form-control" id="date_from" name="date_from">
                    </div>        
                    
                    <div class="form-group">
                        <label for="date_to">Paieška iki datos:</label>
                        <input type="date" class="form-control" id="date_to" name="date_to">
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="city_id">Renginio miestas:</label>
                    <select class="form-control" id="city_id" name="city_id">
                        <option value="default">--Pasirinkite miestą--</option>
						<?php foreach ($data['cities'] as $city): ?>
							<option value="<?= $city['id'] ?>">
								<?= htmlspecialchars($city['miestas']) ?>
							</option>
						<?php endforeach; ?>
					</select>
                
                <label for="microcity_id">Renginio mikrorajonas</label>
                <select class="form-control" id="microcity_id" name="microcity_id">
                    <option value="default">--Pasirinkite miestą--</option>
                </select>
                </div>

                <div class="form-group">
                    <label for="social_groups">Socialines grupes:</label>
                    <?php foreach ($data['social_groups'] as $group): ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="social_groups[]" value="<?= $group['id'] ?>">
                                <?= htmlspecialchars($group['pavadinimas']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn btn-primary">Filtruoti</button>
            </form>
            </div>
            <?php if (empty($events)): ?>
                <p>Renginių nerasta.</p>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <h3>
                            <a href="event_page.php?id=<?= urlencode($event->getId()); ?>" style="color: inherit; text-decoration: none;">
                                <?= htmlspecialchars($event->getTitle()); ?>
                            </a>
                        </h3>
                        <p><strong>Data:</strong> <?= htmlspecialchars(date('Y-m-d', strtotime($event->getDate()))); ?></p>
                        <p><strong>Aprašymas:</strong> <?= nl2br(htmlspecialchars($event->getDescription())); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../assets/js/toggle_filter.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../assets/js/microcity_dropdown.js"></script>
</body>
</html>





