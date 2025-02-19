<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/EventController.php';

$controller = new EventController($dbc);

if ($_SESSION['vaidmuo'] !== 'vip') {
    header("Location: dashboard.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = $controller->handleCreateEvent($_POST);     
}

$data = $controller->getCreateEventData();
$old_user_events = $controller->getEventsCreatedByUser($_SESSION['user_id']);

include '../src/views/create_event_view.php';
?>