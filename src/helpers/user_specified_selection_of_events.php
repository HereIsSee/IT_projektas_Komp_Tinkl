<?php
$user_id = $_SESSION['user_id'];

// Fetch event selections with location, event types, and social groups
$query = "
    SELECT 
        vp.id AS selection_id,
        v.miestas AS location,
        v.mikrorajonas AS micro_location,
        rt.pavadinimas AS event_type,
        sg.pavadinimas AS social_group
    FROM 
        VARTOTOJO_PASIRINKIMAI vp
    LEFT JOIN 
        VIETA v ON vp.fk_vieta_id = v.id
    LEFT JOIN 
        VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI vrtp ON vp.id = vrtp.fk_vartotojo_pasirinkimo_id
    LEFT JOIN 
        RENGINIO_TIPAS rt ON vrtp.fk_renginio_tipo_id = rt.id
    LEFT JOIN 
        VARTOTOJO_GRUPES_PASIRINKIMAI vgp ON vp.id = vgp.fk_vartotojo_pasirinkimo_id
    LEFT JOIN 
        SOCIALINES_GRUPES sg ON vgp.fk_socialines_grupes_id = sg.id
    WHERE 
        vp.fk_vartotojo_id = ?
    ORDER BY 
        selection_id, event_type, social_group
";

$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$event_selections = [];
while ($row = $result->fetch_assoc()) {
    $selection_id = $row['selection_id'];
    if (!isset($event_selections[$selection_id])) {
        $event_selections[$selection_id] = [
            'location' => $row['location'] . ($row['micro_location'] ? ', ' . $row['micro_location'] : ''),
            'event_types' => [],
            'social_groups' => []
        ];
    }
    if ($row['event_type'] && !in_array($row['event_type'], $event_selections[$selection_id]['event_types'])) {
        $event_selections[$selection_id]['event_types'][] = $row['event_type'];
    }
    if ($row['social_group'] && !in_array($row['social_group'], $event_selections[$selection_id]['social_groups'])) {
        $event_selections[$selection_id]['social_groups'][] = $row['social_group'];
    }
}
?>