<?php
require_once '../config/database_connection.php';
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/SubscriptionController.php';
require_once '../src/controllers/EventController.php';

if ($_SESSION['vaidmuo'] !== 'vartotojas') {
    header("Location: dashboard.php");
    exit();
}

$controller = new SubscriptionController($dbc);
$controllerEvent = new EventController($dbc);

$message = $controller->createSubscription($_SESSION['user_id'], $_POST);

$data =  $controllerEvent->getCreateEventData();
include '../src/views/create_subscription_view.php';
?>
