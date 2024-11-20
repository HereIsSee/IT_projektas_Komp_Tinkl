<?php
require_once '../src/models/Subscription.php';

class SubscriptionController {
    private $dbc;

    public function __construct($dbc) {
        $this->dbc = $dbc;
    }

    public function createSubscription($user_id, $postData) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $city_id = $postData['city_id'];
            $microcity_id = $postData['microcity_id'];
            $event_types = $postData['event_types'] ?? [];
            $social_groups = $postData['social_groups'] ?? [];

            return Subscription::createSubscription($this->dbc, $user_id, $city_id, $microcity_id, $event_types, $social_groups);
        };
        
    }
}
?>
