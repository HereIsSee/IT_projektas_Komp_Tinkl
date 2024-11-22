<?php
class Message{
    public $id;
    public $heading;
    public $description;
    public $fk_user_id;
    public $fk_event_selection_id;

    public function __construct($id, $heading, $description, $fk_user_id, $fk_event_selection_id){
        $this->id = $id;
        $this->heading = $heading;
        $this->description = $description;
        $this->fk_user_id = $fk_user_id;
        $this->fk_event_selection_id = $fk_event_selection_id;
    }

    public static function getUserNewEventMessages($dbc, $user_id){
        $query = "
        SELECT
            z.id,
            z.antraste AS heading, 
            z.fk_vartotojo_pasirinkimo_id AS subscription_id,
            z.fk_renginio_id AS event_id,
            reng.pavadinimas AS event_title,
            vp.pavadinimas AS subscription_title
        FROM 
            ZINUTE z
        LEFT JOIN
            RENGINYS reng ON reng.id = z.fk_renginio_id
        LEFT JOIN
            VARTOTOJO_PASIRINKIMAI vp ON vp.id = z.fk_vartotojo_pasirinkimo_id
        WHERE
            z.fk_vartotojo_id = ?
        ";

        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function createMessage($dbc, $heading, $description, $user_id, $subscription_id, $event_id){
        $query = "INSERT INTO ZINUTE (antraste, aprasymas, perskaityta, fk_vartotojo_id, fk_vartotojo_pasirinkimo_id, fk_renginio_id) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $dbc->prepare($query);
        $isFalse = false;
        $stmt->bind_param("ssiiii",$heading, $description, $isFalse, $user_id, $subscription_id, $event_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>