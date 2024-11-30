<?php
require_once '../src/models/Message.php';
class MessageController{

    public static function getUserMessages($dbc, $user_id){
        $result = Message::getUserNewEventMessages($dbc, $user_id);
        $messages = [];
        while ($row = $result->fetch_assoc()){
            $message_id = $row['id'];

            $messages[$message_id] = [
                'id' => $row['id'],
                'heading' => $row['heading'],
                'subscription_title' => $row['subscription_title'],
                'subscription_id' => $row['subscription_id'],
                'event_title' => $row['event_title'],
                'event_id' => $row['event_id'],
                'is_message_read' => $row['is_message_read'],
            ];
        }
        return $messages;
    }

    public static function userHasUnreadMessages($dbc, $user_id){
        return Message::userHasUnreadMessages($dbc, $user_id);
    }
}
?>