<?php
    $event_types_query = "SELECT * FROM RENGINIO_TIPAS";
    $event_types_result = mysqli_query($dbc, $event_types_query);
    $event_types = [];
    while ($row = mysqli_fetch_assoc($event_types_result)) {
        $event_types[] = $row;
    }
?>