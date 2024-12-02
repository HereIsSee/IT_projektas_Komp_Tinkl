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
  <link href="../assets/css/all_events.css" rel="stylesheet">
  <link href="../assets/css/dashboard.css" rel="stylesheet">
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
        <div class="col-sm-9 main-content" >
            <div class="hello_box">
                <h2>Sveiki atvyke į jūsų dashboard, <?= htmlspecialchars($_SESSION['vardas']) ?>!</h2>
                <p>Jūsų rolė: <?= htmlspecialchars($_SESSION['vaidmuo']) ?></p>
                <p><a href="logout.php">Atsijungti</a></p>
            </div>
            
            <?php if($_SESSION['vaidmuo'] == 'vartotojas'): ?>
                <h3>Prenumeratos</h3>
                <?php include 'display_subscriptions.php' ?>
            <?php endif; ?>
            
            <?php if($_SESSION['vaidmuo'] == 'vip'): ?>
                <h3>Sukurti renginiai</h3>
                <?php include 'display_events.php' ?>
            <?php endif; ?>

            <?php if($_SESSION['vaidmuo'] == 'admin'): ?>
                <h3>Visi renginiai</h3>
                <?php include 'display_events.php' ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>