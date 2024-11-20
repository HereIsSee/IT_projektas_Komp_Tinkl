<?php
class DatabaseHelper{
    public static function fetchAll($dbc, $tableName){
        $query = "SELECT * FROM $tableName";
        $result = mysqli_query($dbc, $query);
        $data = [];

        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
}
?>