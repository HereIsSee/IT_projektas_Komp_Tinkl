<?php
session_start();
include 'is_user.php';
include 'database_connection.php';
mysqli_set_charset($dbc, "utf8");

$user_id = $_SESSION['user_id'];

$query = "
    SELECT 
        vp.id AS selection_id,
        m.miestas AS location,
        rt.pavadinimas AS event_type,
        sg.pavadinimas AS social_group
    FROM 
        VARTOTOJO_PASIRINKIMAI vp
    LEFT JOIN 
        MIESTAS m ON vp.fk_miesto_id = m.id
    LEFT JOIN 
        VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI vrtp ON vp.id = vrtp.fk_vartotojo_pasirinkimo_id
    LEFT JOIN 
        RENGINIO_TIPAS rt ON vrtp.fk_renginio_tipo_id = rt.id
    LEFT JOIN 
        VARTOTOJO_GRUPES_PASIRINKIMAI vgp ON vp.id = vgp.fk_vartotojo_pasirinkimo_id
    LEFT JOIN 
        SOCIALINES_GRUPES sg ON vgp.fk_socialines_grupes_id = sg.id
    WHERE 
        vp.fk_vartotojo_id = ?
    ORDER BY 
        selection_id
";

$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$event_selections = [];
while ($row = $result->fetch_assoc()) {
    $selection_id = $row['selection_id'];
    if (!isset($event_selections[$selection_id])) {
        $event_selections[$selection_id] = [
            'location' => $row['location'] . ($row['micro_location'] ? ', ' . $row['micro_location'] : ''),
            'event_types' => [],
            'social_groups' => []
        ];
    }
    if ($row['event_type'] && !in_array($row['event_type'], $event_selections[$selection_id]['event_types'])) {
        $event_selections[$selection_id]['event_types'][] = $row['event_type'];
    }
    if ($row['social_group'] && !in_array($row['social_group'], $event_selections[$selection_id]['social_groups'])) {
        $event_selections[$selection_id]['social_groups'][] = $row['social_group'];
    }
}
?>
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
    <div class="col-sm-3 sidenav hidden-xs">
      <h2>Logo</h2>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#section1">Dashboard</a></li>
        <li><a href="calendar_page.php">Renginių kalendorius</a></li>
        <li><a href="all_events.php">Visi renginiai</a></li>
        <?php
            if ($_SESSION['vaidmuo'] === 'admin' || $_SESSION['vaidmuo'] === 'vip') {
                echo '<li><a href="create_event.php">Sukurti rengini</a></li>';
            }
        ?>
        <li><a href="create_subscription.php">Sukurti norimų renginių prenumeratą</a></li>
      </ul><br>
    </div>

    <div class="col-sm-9">
      <div class="well">
        <h2>Sveiki atvyke į jūsų dashboard, <?php echo $_SESSION['vardas']; ?>!</h2>
        <p>Jūsų rolė: <?php echo $_SESSION['vaidmuo']; ?></p>
        <p><a href="logout.php">Atsijungti</a></p>
      </div>
      
      <!-- Display user event selections -->
      <?php if (empty($event_selections)): ?>
        <p>Nerasta renginių pasirinkimo.</p>
      <?php else: ?>
        <?php foreach ($event_selections as $selection_id => $selection): ?>
          <div class="event-selection-container">
            <h3>Renginio pasirinkimas #<?= htmlspecialchars($selection_id) ?></h3>
            <div class="event-details">
              <span class="event-detail-label">Renginio vieta:</span> <?= htmlspecialchars($selection['location']) ?>
            </div>
            <div class="event-details">
              <span class="event-detail-label">Renginių tipai:</span> 
              <?= htmlspecialchars(implode(', ', $selection['event_types'])) ?>
            </div>
            <div class="event-details">
              <span class="event-detail-label">Socialinės grupės:</span> 
              <?= htmlspecialchars(implode(', ', $selection['social_groups'])) ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
