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
  <link href="../assets/css/sidenavigation.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/all_events.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row content">
        <?php
        $activePage = 'messages';
        include 'sidebar.php';
        ?>
        <div class="col-sm-9">
        <h2>Visos žinutės</h2>
            <?php if (empty($messages)): ?>
                <p>Žinučių nerasta.</p>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                    <div class="event-card">
                        
                        <a href="event_page.php?id=<?= urlencode($message['event_id']); ?>" style="color: inherit; text-decoration: none;">
                            <p class ="dispaly-4 lead"><?= htmlspecialchars($message['heading']); ?> <h3>"<?= htmlspecialchars($message['event_title']); ?>"</h3></p>
                        </a>        
                        
                        <p>Jūs gavote šią žinute dėl prenumeratos: "<?= htmlspecialchars($message['subscription_title']); ?>"</p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>