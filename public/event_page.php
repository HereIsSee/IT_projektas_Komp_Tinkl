<?php
require_once '../config/database_connection.php';
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/EventController.php';

$controller = new EventController($dbc);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event']) && $_SESSION['vaidmuo'] === 'admin') {
    $controller->deleteEvent($_POST['delete_event']);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $data = $controller->showEventDetails($_GET['id']);
    include '../src/views/event_page_view.php';
} else {
    echo "<p>Neteisingas renginio ID.</p>";
}
?>
