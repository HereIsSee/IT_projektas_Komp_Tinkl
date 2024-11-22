<?php
require_once '../config/database_connection.php';
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/MessageController.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$messages = MessageController::getUserMessages($dbc, $_SESSION['user_id']);
require_once '../src/views/messages_view.php';
?>
