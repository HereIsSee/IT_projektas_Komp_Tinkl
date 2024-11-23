<?php
// require_once '../config/database_connection.php';
require_once '../../config/database_connection.php';
mysqli_set_charset($dbc, "utf8");
echo '<h1> FOUND IT! </h1>';
if ($_SERVER['REQUEST_METHOD'] === 'POST' or isset($_POST['city_id'])) {
    $city_id = intval($_POST['city_id']); // Ensure city_id is an integer

    // Query to fetch microcities associated with the selected city
    $query = "SELECT id, pavadinimas, kartu_panaudotas FROM MIKRORAJONAS WHERE fk_miesto_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("i", $city_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generate dropdown options for microcities
    echo '<option value="">-- Pasirinkite mikrorajoną --</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['pavadinimas']) .  " | populiarumas: " . htmlspecialchars($row['kartu_panaudotas']) . '</option>';
    }
}
?>
