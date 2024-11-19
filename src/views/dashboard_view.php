<!DOCTYPE html>
<html lang="en">
<head>
<title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>
    .row.content {height: 100vh;}
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    /* Styling for event selection cards */
    .event-selection-container {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }
    .event-selection-container h3 {
      margin-top: 0;
      color: #333;
    }
    .event-details {
      margin-bottom: 10px;
    }
    .event-detail-label {
      font-weight: bold;
      color: #555;
    }
    /* Ensure layout is responsive */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;}
    }
  </style>
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
                        <h3>Renginio pasirinkimas #<?= htmlspecialchars($selection_id) ?></h3>
                        <p><strong>Renginio vieta:</strong> <?= htmlspecialchars($selection['location']) ?></p>
                        <p><strong>Renginių tipai:</strong> <?= htmlspecialchars(implode(', ', $selection['event_types'])) ?></p>
                        <p><strong>Socialinės grupės:</strong> <?= htmlspecialchars(implode(', ', $selection['social_groups'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>