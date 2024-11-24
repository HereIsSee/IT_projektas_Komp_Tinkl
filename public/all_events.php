<?php
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/EventController.php';

$controller = new EventController($dbc);


$data = $controller->getCreateEventData();


$events = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $events = $controller->getFilteredEvents($_POST);
} else {
    $events = $controller->getAllEvents();
}


include '../src/views/all_events_view.php';
?>
