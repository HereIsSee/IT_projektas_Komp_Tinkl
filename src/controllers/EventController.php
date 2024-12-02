<?php
require_once '../config/database_connection.php';
require_once '../src/models/Message.php';
require_once '../src/models/Event.php';
require_once '../src/models/User.php';
require_once '../src/models/Subscription.php';
require_once '../src/helpers/DatabaseHelper.php';


class EventController {
    private $dbc;

    public function __construct($dbc) {
        $this->dbc = $dbc;
    }

    public function getAllEvents() {
        return Event::getAllEventsFromDB($this->dbc);
    }

    public function handleCreateEvent($post_data): bool {
        $data = [
            'title' => $post_data['title'],
            'date' => $post_data['date'],
            'description' => $post_data['description'],
            'address' => $post_data['address'],
            'event_type_id' => $post_data['event_type'],
            'city_id' => $post_data['city_id'],
            'microcity_id' => $post_data['microcity_id'],
            'old_event_id' => $post_data['old_event_id'],
            'user_id' => $_SESSION['user_id'],
            'vip_specialization' => $_SESSION['vip_specialization'],
        ];
        
        if(Event::similarEventExists($this->dbc, $post_data['title'], $post_data['date'])){
            return false;
        }

        $event_type_id = Event::verifyEventTypeSelected($data);
        $event_id = Event::createEvent($this->dbc, $data);

        $event = new Event( $event_id, $data['title'], $data['date'], $data['description'], 
            $data['address'], null, $event_type_id, $data['user_id'], $data['city_id'], $data['microcity_id']);
        
        if (!empty($_POST['social_groups'])) {
            Event::addSocialGroups($this->dbc, $event_id, $post_data['social_groups']);
        }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            Event::uploadImages($this->dbc, $event_id, $_SESSION['user_id'], $_FILES['images']);
        }
        $this->sendMessagesAboutEventToSubscribedUsers($event);
        return true;
    }
    public function getFilteredEvents($queryParams) {
        $title = $queryParams['title'] ?? null;
        $date_from = $queryParams['date_from'] ?? null;
        $date_to = $queryParams['date_to'] ?? null;
        $city_id = $queryParams['city_id'] ?? null;
        $microcity_id = $queryParams['microcity_id'] ?? null;
        $event_type = $queryParams['event_type'] ?? null;
        $social_groups = $queryParams['social_groups'] ?? [];
    
        return Event::getFilteredEvents($this->dbc, $title, $date_from, $date_to, $city_id, $microcity_id, $event_type, $social_groups);
    }
    

    public function getEventsCreatedByUser($user_id){
        return Event::getEventsCreatedByUser($this->dbc, $user_id);
    }

    public function getCreateEventData() {
        return [
            'cities' => DatabaseHelper::fetchAll($this->dbc, 'MIESTAS'),
            'microcities' => DatabaseHelper::fetchAll($this->dbc, 'MIKRORAJONAS'),
            'social_groups' => DatabaseHelper::fetchAll($this->dbc, 'SOCIALINES_GRUPES'),
            'event_types' => DatabaseHelper::fetchAll($this->dbc, 'RENGINIO_TIPAS')
        ];
    }

    public function showEventDetails($event_id) {
        $eventDetails = Event::fetchEventDetails($this->dbc, $event_id);
        $socialGroups = Event::fetchEventSocialGroups($this->dbc, $event_id);
        $photos = Event::fetchEventPhotos($this->dbc, $event_id);

        if (!empty($eventDetails['fk_seno_renginio_id'])) {
            $previousEvent = Event::fetchPreviousEvent($this->dbc, $eventDetails['fk_seno_renginio_id']);
        } else {
            $previousEvent = null;
        }

        return [
            'event' => $eventDetails,
            'social_groups' => $socialGroups,
            'photos' => $photos,
            'previous_event' => $previousEvent
        ];
    }

    public function deleteEvent($event_id) {
        Event::deleteEvent($this->dbc, $event_id);
        header("Location: all_events.php");
        exit();
    }

    private function sendMessagesAboutEventToSubscribedUsers($event){
        $users = User::getAllUsersId($this->dbc);
        while ($row_user_id = $users->fetch_assoc()){
            $user_id = $row_user_id['id'];

            $subscriptions = Subscription::getSubscriptionsByUserId($this->dbc, $user_id);

            while ($row_subscription = $subscriptions->fetch_assoc()){
                if(Subscription::userIsInterestedInEvent($this->dbc, $event, $row_subscription['subscription_id'])){
                    Message::createMessage($this->dbc, "Naujas renginys!", "", $user_id, $row_subscription['subscription_id'], $event->getId());
                    break;
                }
            }
        }
    }

}
?>