// $(document).ready(function () {
//     // Attach a change event listener to the city dropdown
//     $('#city_id').on('change', function () {
//         let cityId = $(this).val(); // Get the selected city ID
//         let $microcityDropdown = $('#microcity_id'); // Target the microcity dropdown

//         if (cityId && cityId !== "default") {
//             // Make an AJAX POST request to fetch microcities
//             $.ajax({
//                 url: '/IT_darbas/public/get_microcities.php', // Corrected URL
//                 type: 'POST',
//                 data: { city_id: cityId },
//                 beforeSend: function () {
//                     $microcityDropdown.html('<option>Loading...</option>');
//                 },
//                 success: function (response) {
//                     $microcityDropdown.html(response);
//                 },
//                 error: function (xhr, status, error) {
//                     console.error("Error fetching microcities:", status, error);
//                     $microcityDropdown.html('<option value="">Unable to load options</option>');
//                 }
//             });
            
//         } else {
//             // Clear the microcity dropdown if no city is selected
//             $microcityDropdown.html('<option value="">-- Pasirinkite mikrorajoną --</option>');
//         }
//     });
// });



$(document).ready(function() {
    $('#city_id').change(function() {
        const cityId = $(this).val();

        if (cityId) {
            $.ajax({
                url: '../src/helpers/get_microcities.php',
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
