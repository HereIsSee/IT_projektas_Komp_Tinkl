<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Renginio detalės</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="../assets/css/event.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container">
        <div class="event-card">
            

            <h1><?= htmlspecialchars($event['event_title']) ?></h1>
            <p><strong>Data:</strong> <?= htmlspecialchars($event['event_date']) ?></p>
            <p><strong>Renginio tipas:</strong> <?= htmlspecialchars($event['event_type']) ?></p>
            <p><strong>Aprašymas:</strong> <br> <?= nl2br(htmlspecialchars($event['description'])) ?></p>

            <h3>Renginio vietos detalės</h3>
            <p><strong>Miestas:</strong> <?= htmlspecialchars($event['miestas']) ?></p>
            <p><strong>Mikrorajonas:</strong> <?= htmlspecialchars($event['mikrorajonas'] ?? '-------') ?></p>
            <p><strong>Adresas:</strong> <?= htmlspecialchars($event['adresas'] ?? '-------') ?></p>

            <h3>Socialinės grupės</h3>
            <ul>
                <?php foreach ($social_groups as $group): ?>
                    <li><?= htmlspecialchars($group['group_name']) ?></li>
                <?php endforeach; ?>
            </ul>

            <?php if ($photos): ?>
            <h3>Renginio nuotraukos</h3>
                <div class="photo-gallery">
                    <?php foreach ($photos as $photo): ?>
                        <img src="<?= htmlspecialchars($photo) ?>" style="max-width: 300px; height: auto;">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($previous_event): ?>
                <h3>Preiti panašūs renginiai</h3>
                <p class="previous-event">
                    <a href="event_page.php?id=<?= urlencode($previous_event['id']) ?>">
                        <?= htmlspecialchars($previous_event['pavadinimas']) ?>
                    </a>
                </p>
            <?php endif; ?>

            <?php if ($_SESSION['vaidmuo'] === 'admin'): ?>
                <form action="" method="post" onsubmit="return confirm('Ar tikrai norite ištrinti šį renginį?');">
                    <input type="hidden" name="delete_event" value="<?= $event['id'] ?>">
                    <button type="submit" class="btn btn-danger">Ištrinti renginį</button>
                </form>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>

