<?php
require_once '../config/database_connection.php';
require_once '../src/helpers/is_user.php';
require_once '../src/controllers/MessageController.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$_SESSION['has_unread_messages'] = MessageController::userHasUnreadMessages($dbc, $_SESSION['user_id']);

$messages = MessageController::getUserMessages($dbc, $_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message'])) {
    $deletionSuccess = MessageController::deleteMessage($dbc, $_POST['delete_message'], $_SESSION['user_id']);

    if ($deletionSuccess) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $errorMessage = "Failed to delete the message.";
    }
}
require_once '../src/views/messages_view.php';
?>
