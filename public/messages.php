<?php
require_once '../src/controllers/MessageController.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../src/views/messages_view.php';
?>
