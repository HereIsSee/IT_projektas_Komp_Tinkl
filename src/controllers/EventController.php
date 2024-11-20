<?php
require_once '../config/database_connection.php';
require_once '../src/models/Event.php';
require_once '../src/helpers/DatabaseHelper.php';


class EventController {
    private $dbc;

    public function __construct($dbc) {
        $this->dbc = $dbc;
    }

    public function getAllEvents() {
        return Event::getAllEventsFromDB($this->dbc);
    }

    public function handleCreateEvent() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                'title' => $_POST['title'],
                'date' => $_POST['date'],
                'description' => $_POST['description'],
                'address' => $_POST['address'],
                'event_type_id' => $_POST['event_type'],
                'city_id' => $_POST['city_id'],
                'microcity_id' => $_POST['microcity_id'],
                'user_id' => $_SESSION['user_id']
            ];

            $event_id = Event::createEvent($data);

            if (!empty($_POST['social_groups'])) {
                Event::addSocialGroups($this->dbc, $event_id, $_POST['social_groups']);
            }

            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                Event::uploadImages($this->dbc, $event_id, $_SESSION['user_id'], $_FILES['images']);
            }

            return "Renginys sukurtas sėkmingai!";
        }

        return null;
    }

    public function getCreateEventData() {
        return [
            'cities' => DatabaseHelper::fetchAll($this->dbc, 'MIESTAS'),
            'social_groups' => DatabaseHelper::fetchAll($this->dbc, 'RENGINIO_TIPAS'),
            'event_types' => DatabaseHelper::fetchAll($this->dbc, 'SOCIALINES_GRUPES')
        ];
    }

}
?>