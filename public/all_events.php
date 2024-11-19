<?php
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/EventController.php';

$controller = new EventController($dbc);
$events = $controller->getAllEvents();

include '../src/views/all_events_view.php';
?>