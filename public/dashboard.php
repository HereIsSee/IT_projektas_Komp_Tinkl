<?php
require_once '../config/database_connection.php';
require_once '../src/controllers/SubscriptionController.php';
require_once '../src/controllers/MessageController.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$_SESSION['has_unread_messages'] = MessageController::userHasUnreadMessages($dbc, $_SESSION['user_id']);
// error_log("User have unread messages:" . $_SESSION['has_unread_messages']);

$controllerSubscription = new SubscriptionController($dbc);
$event_selections = $controllerSubscription->getFullSubscriptionsByUserId($_SESSION['user_id']);

// error_log($event_selections);

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
