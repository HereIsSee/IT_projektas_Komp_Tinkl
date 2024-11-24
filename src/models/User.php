<?php
class User {
    private $dbc;

    public function __construct($dbc){
        $this->dbc = $dbc;
    }

    public static function getAllUsersId($dbc){
        $query = "SELECT id FROM VARTOTOJAS";
        $stmt = $dbc->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function isUserExists($vardas, $el_pastas) {
        $query = "SELECT * FROM VARTOTOJAS WHERE vardas = ? OR el_pastas = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bind_param("ss", $vardas, $el_pastas);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function registerUser($vardas, $el_pastas, $slaptazodis, $role, $vip_event_specialization = null){
        $query = "INSERT INTO VARTOTOJAS (vardas, el_pastas, slaptazodis, vaidmuo, vip_specializacija) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbc->prepare($query);
        $stmt->bind_param("ssssi", $vardas, $el_pastas, $slaptazodis, $role, $vip_event_specialization);
        return $stmt->execute();
    }

    public function findUserByEmail($email) {
        $query = "SELECT id, slaptazodis, vaidmuo, vardas, vip_specializacija FROM VARTOTOJAS WHERE el_pastas = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>