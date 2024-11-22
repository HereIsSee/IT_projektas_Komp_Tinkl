<?php
require_once '../src/controllers/DashboardController.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$controller = new DashboardController($dbc);
$event_selections = $controller->getFullSubscriptionsByUserId($_SESSION['user_id']);

require_once '../src/views/dashboard_view.php';
?>
