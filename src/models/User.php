<?php
class User{

    public static function getAllUsersId($dbc){
        $query = "SELECT id FROM VARTOTOJAS";
        $stmt = $dbc->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>