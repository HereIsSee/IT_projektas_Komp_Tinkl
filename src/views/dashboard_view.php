<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="../../IT_darbas/assets/css/sidenavigation.css" rel="stylesheet" type="text/css">
  <link href="../../IT_darbas/assets/css/darboard_event_boxes.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row content">
        <?php
        $activePage = 'dashboard';
        include 'sidebar.php';
        ?>
        <div class="col-sm-9">
            <div class="well">
                <h2>Sveiki atvyke į jūsų dashboard, <?= htmlspecialchars($_SESSION['vardas']) ?>!</h2>
                <p>Jūsų rolė: <?= htmlspecialchars($_SESSION['vaidmuo']) ?></p>
                <p><a href="logout.php">Atsijungti</a></p>
            </div>
            <?php if (empty($event_selections)): ?>
                <p>Nerasta renginių pasirinkimo.</p>
            <?php else: ?>
                <?php foreach ($event_selections as $selection_id => $selection): ?>
                    <div class="event-selection-container">
                        <h3>Prenumerata "<?= htmlspecialchars($selection['title']) ?>"</h3>
                        <p><strong>Renginio miestas:</strong> <?= htmlspecialchars($selection['city']) ?></p>
                        <p><strong>Renginio mikrorajonas:</strong> <?= htmlspecialchars($selection['microcity']) ?></p>
                        <p><strong>Renginių tipai:</strong> <?= htmlspecialchars(implode(', ', $selection['event_types'])) ?></p>
                        <p><strong>Socialinės grupės:</strong> <?= htmlspecialchars(implode(', ', $selection['social_groups'])) ?></p>
                        <form action="" method="post" onsubmit="return confirm('Ar tikrai norite ištrinti šią prenumerata?');">
                            <input type="hidden" name="delete_subscription" value="<?= $selection_id ?>">
                            <button type="submit" class="btn btn-danger">Ištrinti prenumerata</button>
                        </form>
                    </div>
                    
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>