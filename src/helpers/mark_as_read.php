<?php
require_once '../models/Message.php'; // Include the Message class
require_once '../../config/database_connection.php'; // Include your database connection
error_log("Got into mark_as_read.php");
// Get the JSON payload
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['message_id'])) {
    $message_id = (int)$data['message_id'];
    Message::setMessageAsRead($dbc, $message_id);
    http_response_code(200); // Success
} else {
    http_response_code(400); // Bad request
}
?>
