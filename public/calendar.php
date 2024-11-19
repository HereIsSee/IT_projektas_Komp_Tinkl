<?php
require_once '../src/controllers/CalendarController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
    
require_once '../src/views/calendar_view.php';
?>