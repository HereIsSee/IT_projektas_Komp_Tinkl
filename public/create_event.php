<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/EventController.php';

$controller = new EventController($dbc);

if ($_SESSION['vaidmuo'] === 'vartotojas') {
    header("Location: dashboard.php");
    exit();
}

$message = $controller->handleCreateEvent();
$data = $controller->getCreateEventData();

include '../src/views/create_event_view.php';
?>