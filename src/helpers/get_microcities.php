<?php
require_once '../../config/database_connection.php';
mysqli_set_charset($dbc, "utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['city_id'])) {
    $city_id = intval($_POST['city_id']);
    $context = $_POST['context'] ?? 'general';

    $query = "SELECT id, pavadinimas, kartu_panaudotas FROM MIKRORAJONAS WHERE fk_miesto_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("i", $city_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">-- Pasirinkite mikrorajoną --</option>';
    while ($row = $result->fetch_assoc()) {
        if ($context === 'subscription') {
            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['pavadinimas']) . " | populiarumas: " . htmlspecialchars($row['kartu_panaudotas']) . '</option>';
        } else {
            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['pavadinimas']) . '</option>';
        }
    }
}
?>
