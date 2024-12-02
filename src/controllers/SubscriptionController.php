<?php
require_once '../src/models/Subscription.php';

class SubscriptionController {
    private $dbc;

    public function __construct($dbc) {
        $this->dbc = $dbc;
    }

    public function createSubscription($user_id, $postData) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $postData['title'];
            $city_id = $postData['city_id'];
            $microcity_id = $postData['microcity_id'];
            $event_types = $postData['event_types'] ?? [];
            $social_groups = $postData['social_groups'] ?? [];

            if(!Subscription::userHasSimilarSubscription($this->dbc, $title, $_SESSION['user_id'])){
                return Subscription::createSubscription($this->dbc, $title, $user_id, $city_id, $microcity_id, $event_types, $social_groups);
            } else {
                return false;
            }
            
        }
    }

    public function deleteSubscription($subscription_id, $user_id){
        if(Subscription::isSubscriptionUsers($this->dbc, $subscription_id, $user_id)){
            return Subscription::deleteSubscription($this->dbc, $subscription_id);
        }
    }

    public function getFullSubscriptionsByUserId($user_id) {
        $result = Subscription::getSubscriptionsByUserId($this->dbc, $user_id);
        $subscriptions = [];
        while ($row = $result->fetch_assoc()) {
            $subscription_id = $row['subscription_id'];
            if ($subscription_id !== null) {
                $subscriptions[$subscription_id] = [
                    'title' => $row['title'],
                    'city' => $row['city'],
                    'microcity' => $row['microcity'],
                    'event_types' => $row['event_type'] ? explode(',', $row['event_type']) : [],
                    'social_groups' => $row['social_group'] ? explode(',', $row['social_group']) : []
                ];
            }
            if ($subscription_id == null){
                return null;
            }
        }
        // error_log("Subscriptions: " . json_encode($subscriptions, JSON_PRETTY_PRINT));

        return $subscriptions;
    }
}
?>
