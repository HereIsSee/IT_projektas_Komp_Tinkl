$(document).ready(function() {
    $('#city_id').change(function() {
        const cityId = $(this).val();

        if (cityId) {
            $.ajax({
                url: 'get_microcities.php',
                type: 'POST',
                data: { city_id: cityId },
                success: function(response) {
                    $('#microcity_id').html(response);
                },
                error: function() {
                    alert('Klaida: nepavyko gauti mikrorajonų.');
                }
            });
        } else {
            $('#microcity_id').html('<option value="default">-- Pasirinkite mikrorajoną --</option>');
        }
    });
});
