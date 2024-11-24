$(document).ready(function() {
    $('#city_id').change(function() {
        const cityId = $(this).val();
        const isSubscription = $('#subscription-context').length > 0; // Check if in subscription context

        if (cityId) {
            $.ajax({
                url: '../src/helpers/get_microcities.php',
                type: 'POST',
                data: { 
                    city_id: cityId,
                    context: isSubscription ? 'subscription' : 'general' // Set context dynamically
                },
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
