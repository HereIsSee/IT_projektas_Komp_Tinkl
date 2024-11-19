<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Visi renginiai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../IT_darbas/assets/css/sidenavigation.css" rel="stylesheet" type="text/css">
    <link href="../../IT_darbas/assets/css/all_events.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
            <?php if (empty($events)): ?>
                <p>Renginių nerasta.</p>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <h3>
                            <a href="event_page.php?id=<?= urlencode($event->id); ?>" style="color: inherit; text-decoration: none;">
                                <?= htmlspecialchars($event->title); ?>
                            </a>
                        </h3>
                        <p><strong>Data:</strong> <?= htmlspecialchars(date('Y-m-d', strtotime($event->date))); ?></p>
                        <p><strong>Aprašymas:</strong> <?= htmlspecialchars($event->description); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>





