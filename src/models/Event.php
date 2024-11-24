<?php
class Event {
    private $id;
    private $title;
    private $date;
    private $description;
    private $address;
    private $previous_event_id;
    private $event_type_id;
    private $vip_user_id;
    private $city_id;
    private $microcity_id;
    
    

    public function __construct($id, $title, $date, $description, $address, $previous_event_id = null,
            $event_type_id, $vip_user_id, $city_id, $microcity_id) {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->description = $description;
        $this->address = $address;
        $this->previous_event_id = $previous_event_id;
        $this->event_type_id = $event_type_id;
        $this->vip_user_id = $vip_user_id;
        $this->city_id = $city_id;
        $this->microcity_id = $microcity_id;
    }

    public function getId(){return $this->id;}

    public function getTitle(){return $this->title;}
    public function getDate(){return $this->date;}
    public function getDescription(){return $this->description;}
    public function getAddress(){return $this->address;}
    
    public function getPreviousEventId(){return $this->previous_event_id;}
    public function getEventTypeId(){return $this->event_type_id;}
    public function getVipUserId(){return $this->vip_user_id;}
    public function getCityId(){return $this->city_id;}
    public function getMicrocityId(){return $this->microcity_id;}

    public function getEventType($dbc){
        $query = "
        SELECT
            rt.pavadinimas AS event_type
        FROM
            RENGINYS r
        LEFT JOIN 
            RENGINIO_TIPAS rt ON r.fk_renginio_tipas_id = rt.id
        WHERE
            r.id = ?   
        ";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['event_type'];
    }
    public function getCity($dbc){
        $query = "
        SELECT
            m.miestas AS city
        FROM
            RENGINYS r
        LEFT JOIN 
            MIESTAS m ON r.fk_miesto_id = m.id
        WHERE
            r.id = ?   
        ";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['city'];
    }
    public function getMicrocity($dbc){
        $query = "
        SELECT
            mk.pavadinimas AS microcity
        FROM
            RENGINYS r
        LEFT JOIN 
            MIKRORAJONAS mk ON r.fk_mikrorajono_id = mk.id
        WHERE
            r.id = ?   
        ";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['microcity'];
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

    public static function getFilteredEvents($dbc, $title, $date_from, $date_to, $city_id, $microcity_id, $event_type, $social_groups) {
        $events = [];
        $query = "
            SELECT r.*
            FROM RENGINYS r
            LEFT JOIN RENGINIAI_GRUPES rg ON r.id = rg.fk_renginio_id
            WHERE 1=1
        ";
        $params = [];
        $types = '';
    
        // Dynamically add conditions to the query
        if (!empty($title)) {
            $query .= " AND r.pavadinimas LIKE ?";
            $params[] = '%' . $title . '%';
            $types .= 's';
        }
        if (!empty($date_from)) {
            $query .= " AND r.renginio_data >= ?";
            $params[] = $date_from;
            $types .= 's';
        }
        if (!empty($date_to)) {
            $query .= " AND r.renginio_data <= ?";
            $params[] = $date_to;
            $types .= 's';
        }
        if ($city_id !== 'default') {
            $query .= " AND r.fk_miesto_id = ?";
            $params[] = $city_id;
            $types .= 'i';
        }
        if ($microcity_id !== 'default' && $microcity_id !== '') {
            $query .= " AND r.fk_mikrorajono_id = ?";
            $params[] = $microcity_id;
            $types .= 'i';
        }
        if ($event_type !== 'default') {
            $query .= " AND r.fk_renginio_tipas_id = ?";
            $params[] = $event_type;
            $types .= 'i';
        }
        if (!empty($social_groups)) {
            $placeholders = implode(',', array_fill(0, count($social_groups), '?'));
            $query .= " AND rg.fk_socialines_grupes_id IN ($placeholders)";
            foreach ($social_groups as $group) {
                $params[] = $group;
                $types .= 'i';
            }
        }
    
        $query .= " GROUP BY r.id";
    
        // error_log("Query: $query");
        // error_log("Params: " . json_encode($params));
    
        $stmt = $dbc->prepare($query);
        if (!$stmt) {
            die("Database query failed: " . $dbc->error);
        }
    
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Process results
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
        
        $event_type_id = self::verifyEventTypeSelected($data);

        $stmt = $dbc->prepare($query);
        $stmt->bind_param("ssssiiii", $data['title'], $data['date'], $data['description'], $data['address'], $event_type_id, $data['user_id'], $data['city_id'], $data['microcity_id']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public static function verifyEventTypeSelected($data){
        $event_type_id = $data['event_type_id'];
        if($event_type_id == 'default'){
            $event_type_id = $data['vip_specialization'];
        }
        return $event_type_id;
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
        $targetDir = "../assets/images/" . $user_id . "/" . $event_id . "/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        error_log("files Event.php: " . json_encode($files));
        $query = "INSERT INTO RENGINIU_NUOTRAUKOS (nuotraukos_kelias, fk_renginio_id) VALUES (?, ?)";
        $stmt = $dbc->prepare($query);

        foreach ($files['name'] as $key => $file_name) {
            $targetFilePath = $targetDir . basename($file_name);
            if (!file_exists($targetFilePath) && move_uploaded_file($files["tmp_name"][$key], $targetFilePath)) {
            // if (move_uploaded_file($files["tmp_name"][$key], $targetFilePath)) {
            
                $stmt->bind_param("si", $targetFilePath, $event_id);
                $stmt->execute();
            }
        }
    }

    public static function fetchEventDetails($dbc, $event_id) {
        $query = "
            SELECT 
                reng.id,
                reng.pavadinimas AS event_title,
                reng.renginio_data AS event_date,
                reng.aprasymas AS description,
                reng.adresas,
                rt.pavadinimas AS event_type,
                m.miestas,
                mik.pavadinimas AS mikrorajonas,
                reng.adresas,
                reng.fk_seno_renginio_id
            FROM 
                RENGINYS reng
            LEFT JOIN 
                RENGINIO_TIPAS rt ON reng.fk_renginio_tipas_id = rt.id
            LEFT JOIN
                MIESTAS m ON reng.fk_miesto_id = m.id
            LEFT JOIN 
                MIKRORAJONAS mik ON reng.fk_mikrorajono_id = mik.id
            WHERE 
                reng.id = ?
        ";

        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function fetchEventSocialGroups($dbc, $event_id) {
        $query = "
            SELECT sg.pavadinimas AS group_name
            FROM RENGINIAI_GRUPES rg
            LEFT JOIN SOCIALINES_GRUPES sg ON rg.fk_socialines_grupes_id = sg.id
            WHERE rg.fk_renginio_id = ?
        ";

        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public static function fetchEventSocialGroupsIds($dbc, $event_id) {
        $query = "
            SELECT sg.id
            FROM RENGINIAI_GRUPES rg
            LEFT JOIN SOCIALINES_GRUPES sg ON rg.fk_socialines_grupes_id = sg.id
            WHERE rg.fk_renginio_id = ?
        ";

        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function fetchEventPhotos($dbc, $event_id) {
        $query = "
            SELECT nuot.nuotraukos_kelias AS photo
            FROM RENGINIU_NUOTRAUKOS nuot
            WHERE nuot.fk_renginio_id = ?
        ";

        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        error_log("event_id Event.php: " . $event_id);
        error_log("photos paths Event.php: " . json_encode($result));
        $photos = [];
        while ($row = $result->fetch_assoc()) {
            $photos[] = $row['photo'];
        }
        error_log("photos paths EVENT.php: " . json_encode($photos));
        return $photos;
    }

    public static function fetchPreviousEvent($dbc, $event_id) {
        $query = "SELECT id, pavadinimas FROM RENGINYS WHERE id = ?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function deleteEvent($dbc, $event_id) {
        $query = "DELETE FROM RENGINIAI_GRUPES WHERE fk_renginio_id = ?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();

        $query = "DELETE FROM RENGINIU_NUOTRAUKOS WHERE fk_renginio_id = ?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();

        $query = "DELETE FROM RENGINYS WHERE id = ?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();

    }

}
?>
