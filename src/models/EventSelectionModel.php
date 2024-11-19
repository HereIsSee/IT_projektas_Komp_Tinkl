<?php
class EventSelectionModel{
    private $dbc;

    public function __construct($dbc){
        $this->dbc = $dbc;
    }

    public function getEventSelectionByUserId($user_id){
        $query = "
        SELECT 
            vp.id AS selection_id,
            m.miestas AS location,
            rt.pavadinimas AS event_type,
            sg.pavadinimas AS social_group
        FROM 
            VARTOTOJO_PASIRINKIMAI vp
        LEFT JOIN 
            MIESTAS m ON vp.fk_miesto_id = m.id
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
            selection_id
        ";

        $stmt = $this->dbc->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>