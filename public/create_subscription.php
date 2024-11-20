<?php
require_once '../config/database_connection.php';
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/SubscriptionController.php';
require_once '../src/controllers/EventController.php';

$controller = new SubscriptionController($dbc);
$controllerEvent = new EventController($dbc);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $controller->createSubscription($user_id, $_POST);
    echo "<p id='success-message' class='alert alert-success'>Prenumėrata sukurta sėkmingai!</p>";
};

$data =  $controllerEvent->getCreateEventData();
include '../src/views/create_subscription_view.php';
?>
