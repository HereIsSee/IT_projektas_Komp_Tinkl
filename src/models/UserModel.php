<?php
class UserModel {
    private $dbc;

    public function __construct($dbc){
        $this->dbc = $dbc;
    }

    public function isUserExists($vardas, $el_pastas) {
        $query = "SELECT * FROM VARTOTOJAS WHERE vardas = ? OR el_pastas = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bind_param("ss", $vardas, $el_pastas);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function registerUser($vardas, $el_pastas, $slaptazodis, $role){
        $query = "INSERT INTO VARTOTOJAS (vardas, el_pastas, slaptazodis, vaidmuo) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbc->prepare($query);
        $stmt->bind_param("ssss", $vardas, $el_pastas, $slaptazodis, $role);
        return $stmt->execute();
    }

    public function findUserByEmail($email) {
        $query = "SELECT id, slaptazodis, vaidmuo, vardas FROM VARTOTOJAS WHERE el_pastas = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>