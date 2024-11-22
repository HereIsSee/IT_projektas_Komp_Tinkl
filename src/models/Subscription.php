<?php
// include ''
class Subscription {

    private $id;
    private $heading;
    private $description;
    private $user_id;
    private $user_subscription_id;


    public function __construct($id, $heading, $description, $user_id, 
            $user_subscription_id) {
        $this->id = $id;
        $this->heading = $heading;
        $this->description = $description;
        $this->user_id = $user_id;
        $this->user_subscription_id = $user_subscription_id;
    }

    public static function createSubscription($dbc, $user_id, $city_id, $microcity_id, $event_types, $social_groups) {
        $query = "INSERT INTO VARTOTOJO_PASIRINKIMAI (fk_vartotojo_id, fk_miesto_id, fk_mikrorajono_id) VALUES (?, ?, ?)";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("iii", $user_id, $city_id, $microcity_id);
        $stmt->execute();
        $user_choice_id = $stmt->insert_id;

        if (!empty($event_types)) {
            $query = "INSERT INTO VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI (fk_vartotojo_pasirinkimo_id, fk_renginio_tipo_id) VALUES (?, ?)";
            $stmt = $dbc->prepare($query);
            foreach ($event_types as $event_type_id) {
                $stmt->bind_param("ii", $user_choice_id, $event_type_id);
                $stmt->execute();
            }
        }

        if (!empty($social_groups)) {
            $query = "INSERT INTO VARTOTOJO_GRUPES_PASIRINKIMAI (fk_vartotojo_pasirinkimo_id, fk_socialines_grupes_id) VALUES (?, ?)";
            $stmt = $dbc->prepare($query);
            foreach ($social_groups as $group_id) {
                $stmt->bind_param("ii", $user_choice_id, $group_id);
                $stmt->execute();
            }
        }

        return "Prenumėrata sukurta sėkmingai!";
    }

    public static function getSubscriptionsByUserId($dbc, $user_id){
        $query = "
        SELECT 
            vp.id AS subscription_id,
            m.miestas AS city,
            mikr.pavadinimas AS microcity,
            rt.pavadinimas AS event_type,
            sg.pavadinimas AS social_group
        FROM 
            VARTOTOJO_PASIRINKIMAI vp
        LEFT JOIN 
            MIESTAS m ON vp.fk_miesto_id = m.id
        LEFT JOIN 
            MIKRORAJONAS mikr ON vp.fk_mikrorajono_id = mikr.id
        LEFT JOIN 
            VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI vrtp ON vp.id = vrtp.fk_vartotojo_pasirinkimo_id
        LEFT JOIN 
            RENGINIO_TIPAS rt ON vrtp.fk_renginio_tipo_id = rt.id
        LEFT JOIN 
            VARTOTOJO_GRUPES_PASIRINKIMAI vgp ON vp.id = vgp.fk_vartotojo_pasirinkimo_id
        LEFT JOIN 
            SOCIALINES_GRUPES sg ON vgp.fk_socialines_grupes_id = sg.id
        WHERE 
            vp.fk_vartotojo_id = ?
        ORDER BY 
            vp.id
        ";

        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public static function getSubscriptionData($dbc, $subscription_id){
        $query = "
        SELECT 
            vp.id AS selection_id,
            m.id AS city_id,
            m.miestas AS city,
            mikr.id AS microcity_id,
            mikr.pavadinimas AS microcity,
            rt.pavadinimas AS event_type,
            sg.pavadinimas AS social_group,
            GROUP_CONCAT(rt.id) AS event_type_ids,
            GROUP_CONCAT(sg.id) AS social_group_ids
        FROM 
            VARTOTOJO_PASIRINKIMAI vp
        LEFT JOIN 
            MIESTAS m ON vp.fk_miesto_id = m.id
        LEFT JOIN 
            MIKRORAJONAS mikr ON vp.fk_mikrorajono_id = mikr.id
        LEFT JOIN 
            VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI vrtp ON vp.id = vrtp.fk_vartotojo_pasirinkimo_id
        LEFT JOIN 
            RENGINIO_TIPAS rt ON vrtp.fk_renginio_tipo_id = rt.id
        LEFT JOIN 
            VARTOTOJO_GRUPES_PASIRINKIMAI vgp ON vp.id = vgp.fk_vartotojo_pasirinkimo_id
        LEFT JOIN 
            SOCIALINES_GRUPES sg ON vgp.fk_socialines_grupes_id = sg.id
        WHERE 
            vp.id = ?
        ";

        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $subscription_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function userIsInterestedInEvent($dbc, $event, $subscription_id){    
        $result = self::getSubscriptionData($dbc, $subscription_id);
        $row = $result->fetch_assoc();

        $event_type_ids = explode(',', $row['event_type_ids']);
        $social_group_ids = explode(',', $row['social_group_ids']);

        $is_in_the_same_city = false;
        $has_at_least_one_matching_event_type = false;
        $has_at_least_one_matching_social_group = false;
        if($row['city_id'] == $event->getCityId())
        {
            $is_in_the_same_city = true;
        }
        foreach($event_type_ids as $event_type_id){
            if($event_type_id == $event->getEventTypeId()){
                $has_at_least_one_matching_event_type = true;
                
                break;
            }
        }

        foreach($social_group_ids as $social_group_id){
            $matched_social_group_ids = Event::fetchEventSocialGroupsIds($dbc, $event->getId());
            while ($row = $matched_social_group_ids->fetch_assoc()) {
                $social_group_id_from_event = $row['id'];
                if($social_group_id == $social_group_id_from_event){
                    $has_at_least_one_matching_social_group = true;

                    break;
                }
            }
            if($has_at_least_one_matching_social_group){
                break;
            }
        }
        if($is_in_the_same_city && $has_at_least_one_matching_event_type && $has_at_least_one_matching_social_group){
            return true;
        }
        return false;
         
    }
}
?>
