<?php
require_once '../config/database_connection.php';
require_once '../src/models/EventSelectionModel.php';

class DashboardController {
    private $dbc;
    private $eventModel;

    public function __construct($dbc) {
        $this->dbc = $dbc;
        $this->eventModel = new EventSelectionModel($dbc);
    }

    public function getEventSelection($user_id) {
        $result = $this->eventModel->getEventSelectionByUserId($user_id);
        
        $event_selections = [];
        while ($row = $result->fetch_assoc()) {
            $selection_id = $row['selection_id'];
            if(!isset($event_selections[$selection_id])){
                $selections[$selection_id] = [
                    'location' => $row['location'],
                    'event_types' => [],
                    'social_groups' => []
                ];
            }
            if ($row['event_type'] && !in_array($row['event_type'], $selections[$selection_id]['event_types'])) {
                $selections[$selection_id]['event_types'][] = $row['event_type'];
            }
            if ($row['social_group'] && !in_array($row['social_group'], $selections[$selection_id]['social_groups'])) {
                $selections[$selection_id]['social_groups'][] = $row['social_group'];
            }
        }
        return $selections;
    }
}
?>