<?php
class Subscription {

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

        return $user_choice_id;
    }
}
?>
