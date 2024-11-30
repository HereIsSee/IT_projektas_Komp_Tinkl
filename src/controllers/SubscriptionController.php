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

            return Subscription::createSubscription($this->dbc, $title, $user_id, $city_id, $microcity_id, $event_types, $social_groups);
        };
        
    }

    public function deleteSubscription($subscription_id){
        return Subscription::deleteSubscription($this->dbc, $subscription_id);
    }
}
?>
