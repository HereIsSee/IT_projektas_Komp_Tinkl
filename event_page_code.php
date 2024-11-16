<?php 
include 'database_connection.php';
mysqli_set_charset($dbc, "utf8");
include 'is_user.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = $_GET['id'];

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
    if (!$stmt) {
        die("SQL preparation failed: " . mysqli_error($dbc));
    }

    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Display primary event details
        echo "<h1>" . htmlspecialchars($row['event_title']) . "</h1>";
        echo "<p><strong>Data:</strong> " . htmlspecialchars($row['event_date']) . "</p>";
        echo "<p><strong>Renginio tipas:</strong> " . htmlspecialchars($row['event_type']) . "</p>";
        echo "<p><strong>Aprašymas:</strong> " . htmlspecialchars($row['description']) . "</p>";

        // Display location information
        echo "<h3>Renginio vietos detalės</h3>";
        echo "<p><strong>Miestas:</strong> " . htmlspecialchars($row['miestas']) . "</p>";
        echo "<p><strong>Mikrorajonas:</strong> " . (empty($row['mikrorajonas']) ? "-------" : htmlspecialchars($row['mikrorajonas'])) . "</p>";
        echo "<p><strong>Adresas:</strong> " . (empty($row['adresas']) ? "-------" : htmlspecialchars($row['adresas'])) . "</p>";

        // Fetch associated social groups
        $group_query = "
            SELECT sg.pavadinimas AS group_name 
            FROM RENGINIAI_GRUPES rg
            LEFT JOIN SOCIALINES_GRUPES sg ON rg.fk_socialines_grupes_id = sg.id
            WHERE rg.fk_renginio_id = ?
        ";

        $group_stmt = $dbc->prepare($group_query);
        if (!$group_stmt) {
            die("Group query preparation failed: " . mysqli_error($dbc));
        }

        $group_stmt->bind_param("i", $event_id);
        $group_stmt->execute();
        $group_result = $group_stmt->get_result();

        if ($group_result->num_rows > 0) {
            echo "<h3>Socialinės grupės</h3><ul>";
            while ($group_row = $group_result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($group_row['group_name']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='no-content'>Nėra grupių.</p>";
        }

        $photo_query = "
            SELECT 
                nuot.nuotraukos_pavadinimas,
                nuot.nuotraukos_duomenys AS failas
            FROM RENGINYS ren
            LEFT JOIN RENGINIU_NUOTRAUKOS nuot ON ren.id = nuot.fk_renginio_id
            WHERE nuot.fk_renginio_id = ?
        ";

        $photo_stmt = $dbc->prepare($photo_query);
        if (!$photo_stmt) {
            die("Photos query preparation failed: " . mysqli_error($dbc));
        }

        $photo_stmt->bind_param("i", $event_id);
        $photo_stmt->execute();
        $photo_result = $photo_stmt->get_result();

        if ($photo_result->num_rows > 0) {
            echo "<h3>Nuotraukos renginio</h3><div class='photo-gallery'>";
            while ($photo_row = $photo_result->fetch_assoc()) {
                $base64_image = base64_encode($photo_row['failas']);
                $image_src = "data:image/jpeg;base64," . $base64_image;
                
                echo "<img src='" . htmlspecialchars($image_src) . "' alt='" . htmlspecialchars($photo_row['nuotraukos_pavadinimas']) . "' style='max-width: 150px; height: auto;'>";
            }
            echo "</div>";
        } else {
            echo "<p class='no-content'>Nuotraukų apie renginį nerasta.</p>";
        }

        if (!empty($row['fk_seno_renginio_id'])) {
            $previous_event_id = $row['fk_seno_renginio_id'];
            $previous_query = "SELECT pavadinimas FROM RENGINYS WHERE id = ?";
            $previous_stmt = $dbc->prepare($previous_query);
            if (!$previous_stmt) {
                die("Previous event query preparation failed: " . mysqli_error($dbc));
            }

            $previous_stmt->bind_param("i", $previous_event_id);
            $previous_stmt->execute();
            $previous_result = $previous_stmt->get_result();

            if ($previous_result->num_rows > 0) {
                $previous_row = $previous_result->fetch_assoc();
                $previous_event_title = $previous_row['pavadinimas'];
                echo "<h3>Preiti panašūs renginiai</h3>";
                echo "<p class='previous-event'><a href='event_page.php?id=" . urlencode($previous_event_id) . "'>" . htmlspecialchars($previous_event_title) . "</a></p>";
            } 
        } else {
            echo "<p class='no-content'>Preitų renginių nerasta.</p>";
        }

        // Delete button for admin
        if ($_SESSION['vaidmuo'] === 'admin') {
            echo "<form action='' method='post' onsubmit='return confirm(\"Ar tikrai norite ištrinti šį renginį?\");'>";
            echo "<input type='hidden' name='delete_event' value='$event_id'>";
            echo "<button type='submit' class='btn btn-danger'>Ištrinti renginį</button>";
            echo "</form>";
        }
        
    } else {
        echo "<p>Renginys nerastas.</p>";
    }
} else {
    echo "<p>Neteisingas renginio ID.</p>";
}

if (isset($_POST['delete_event']) && $_SESSION['vaidmuo'] === 'admin') {
    $delete_event_id = $_POST['delete_event'];

    // Delete from renginiai_grupes
    $delete_groups = "DELETE FROM RENGINIAI_GRUPES WHERE fk_renginio_id = ?";
    $stmt_groups = $dbc->prepare($delete_groups);
    $stmt_groups->bind_param("i", $delete_event_id);
    $stmt_groups->execute();

    // Delete photos
    $delete_photos = "DELETE FROM RENGINIU_NUOTRAUKOS WHERE fk_renginio_id = ?";
    $stmt_photos = $dbc->prepare($delete_photos);
    $stmt_photos->bind_param("i", $delete_event_id);
    $stmt_photos->execute();

    // Delete the main event
    $delete_event = "DELETE FROM RENGINYS WHERE id = ?";
    $stmt_event = $dbc->prepare($delete_event);
    $stmt_event->bind_param("i", $delete_event_id);
    $stmt_event->execute();

    // Redirect after deletion
    header("Location: all_events.php");
    exit();
}
?>
