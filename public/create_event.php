<?php
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/EventController.php';

$controller = new EventController($dbc);

if ($_SESSION['vaidmuo'] === 'vartotojas') {
    header("Location: dashboard.php");
    exit();
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $user_id = $_SESSION['user_id'];
//     $controller->createSubscription($user_id, $_POST);
//     echo "<p id='success-message' class='alert alert-success'>Prenumėrata sukurta sėkmingai!</p>";
// };
$message = $controller->handleCreateEvent();
$data = $controller->getCreateEventData();

include '../src/views/create_event_view.php';
?>