<?php
class Event {
    public $id;
    public $title;
    public $date;
    public $description;
    public $type_id;
    public $vip_user_id;
    public $place_id;
    public $previous_event_id;

    public function __construct($id, $title, $date, $description, $type_id, $vip_user_id, $place_id, $previous_event_id = null) {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->description = $description;
        $this->type_id = $type_id;
        $this->vip_user_id = $vip_user_id;
        $this->place_id = $place_id;
        $this->previous_event_id = $previous_event_id;
    }

    public static function get_events_from_db($dbc, $month, $year) {
        $events = [];
        $query = "SELECT * FROM RENGINYS WHERE MONTH(renginio_data) = ? AND YEAR(renginio_data) = ?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $events[] = new Event(
                $row['id'],
				$row['pavadinimas'],
				$row['renginio_data'],
				$row['aprasymas'],
                $row['adresas'],
				$row['fk_renginio_tipas_id'],
				$row['fk_vip_vartotojo_id'],
				$row['fk_miesto_id'],
                $row['fk_mikrorajono_id'],
				$row['fk_seno_renginio_id']
            );
        }

        return $events;
    }
	
	public static function get_all_events_from_db($dbc) {
		$events = [];
		$query = "SELECT * FROM RENGINYS";
		$stmt = $dbc->prepare($query);

		// Check if statement preparation was successful
		if (!$stmt) {
			die("Database query failed: " . $dbc->error);
		}

		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			$events[] = new Event(
				$row['id'],
				$row['pavadinimas'],
				$row['renginio_data'],
				$row['aprasymas'],
                $row['adresas'],
				$row['fk_renginio_tipas_id'],
				$row['fk_vip_vartotojo_id'],
				$row['fk_miesto_id'],
                $row['fk_mikrorajono_id'],
				$row['fk_seno_renginio_id']
			);
		}

		return $events;
	}

}
?>
