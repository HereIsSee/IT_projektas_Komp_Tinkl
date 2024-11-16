<?php
    $social_groups_query = "SELECT * FROM SOCIALINES_GRUPES";
    $social_groups_result = mysqli_query($dbc, $social_groups_query);
    $social_groups = [];
    while ($row = mysqli_fetch_assoc($social_groups_result)) {
        $social_groups[] = $row;
    }
?>