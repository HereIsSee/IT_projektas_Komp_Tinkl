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

    public function __construct($id, $title, $date, $description, 
            $type_id, $vip_user_id, $place_id, $previous_event_id = null) {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->description = $description;
        $this->type_id = $type_id;
        $this->vip_user_id = $vip_user_id;
        $this->place_id = $place_id;
        $this->previous_event_id = $previous_event_id;
    }


    public static function getEventsFromDB($dbc, $month, $year) {
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
	
	public static function getAllEventsFromDB($dbc) {
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

    public static function createEvent($dbc, $data){
        $query = "INSERT INTO RENGINYS (pavadinimas, renginio_data, aprasymas, adresas, fk_renginio_tipas_id, fk_vip_vartotojo_id, fk_miesto_id, fk_mikrorajono_id)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("ssssiiii", $data['title'], $data['date'], $data['description'], $data['address'], $data['event_type_id'], $data['user_id'], $data['city_id'], $data['microcity_id']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public static function addSocialGroups($dbc, $event_id, $social_groups){
        $query = "INSERT INTO RENGINIAI_GRUPES (fk_renginio_id, fk_socialines_grupes_id) VALUES (?, ?)";
        $stmt = $dbc->prepare($query);
        foreach ($_POST['social_groups'] as $group_id) {
            $stmt->bind_param("ii", $event_id, $group_id);
            $stmt->execute();
        }                                                
    }

    public static function uploadImages($dbc, $event_id, $user_id, $files){
        $targetDir = "assets/images/" . $user_id . "/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $query = "INSERT INTO RENGINIU_NUOTRAUKOS (nuotraukos_kelias, fk_renginio_id) VALUES (?, ?)";
        $stmt = $this->dbc->prepare($query);

        foreach ($files['name'] as $key => $file_name) {
            $targetFilePath = $targetDir . basename($file_name);
            if (!file_exists($targetFilePath) && move_uploaded_file($files["tmp_name"][$key], $targetFilePath)) {
                $stmt->bind_param("si", $targetFilePath, $event_id);
                $stmt->execute();
            }
        }
    }

}
?>
