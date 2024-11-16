<?php
    $cities_query = "SELECT * FROM MIESTAS";
    $cities_result = mysqli_query($dbc, $cities_query);
    $cities = [];
    while ($row = mysqli_fetch_assoc($cities_result)) {
        $cities[] = $row;
    }
?>