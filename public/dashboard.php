<?php
require_once '../config/database_connection.php';
require_once '../src/controllers/SubscriptionController.php';
require_once '../src/controllers/MessageController.php';
require_once '../src/controllers/EventController.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$_SESSION['has_unread_messages'] = MessageController::userHasUnreadMessages($dbc, $_SESSION['user_id']);

$controllerSubscription = new SubscriptionController($dbc);
$event_selections = [];

$controller = new EventController($dbc);
$events = [];

if(($_SESSION['vaidmuo'] == 'vartotojas')){
    $event_selections = $controllerSubscription->getFullSubscriptionsByUserId($_SESSION['user_id']);
}
if(($_SESSION['vaidmuo'] == 'admin')){
    $events = $controller->getAllEvents();
}
if(($_SESSION['vaidmuo'] == 'vip')){
    $events = $controller->getEventsCreatedByUser($_SESSION['user_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_subscription'])) {
    $deletionSuccess = $controllerSubscription->deleteSubscription($_POST['delete_subscription'], $_SESSION['user_id']);

    if ($deletionSuccess) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $errorMessage = "Failed to delete the subscription.";
    }
}

require_once '../src/views/dashboard_view.php';
?>
