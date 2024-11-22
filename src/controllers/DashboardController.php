<?php
require_once '../config/database_connection.php';
require_once '../src/models/Subscription.php';

class DashboardController {
    private $dbc;

    public function __construct($dbc) {
        $this->dbc = $dbc;
    }

    public function getFullSubscriptionsByUserId($user_id) {
        $result = Subscription::getSubscriptionsByUserId($this->dbc, $user_id);
        $subscriptions = [];
        while ($row = $result->fetch_assoc()) {
            $subscription_id = $row['subscription_id'];
            $subscriptions[$subscription_id] = [
                'city' => $row['city'],
                'microcity' => $row['microcity'],
                'event_types' => [],
                'social_groups' => []
            ];
            if ($row['event_type'] && !in_array($row['event_type'], $subscriptions[$subscription_id]['event_types'])) {
                $subscriptions[$subscription_id]['event_types'][] = $row['event_type'];
            }
            if ($row['social_group'] && !in_array($row['social_group'], $subscriptions[$subscription_id]['social_groups'])) {
                $subscriptions[$subscription_id]['social_groups'][] = $row['social_group'];
            }
        }
        return $subscriptions;
    }
}
?>