document.addEventListener("DOMContentLoaded", function () {
    const roleDropdown = document.getElementById("role");
    const specializationContainer = document.getElementById("specialization-container");

    roleDropdown.addEventListener("change", function () {
        if (roleDropdown.value === "vip") {
            let options = '<option value="default" disabled selected>--Pasirinkite renginio specializacija--</option>';
            eventTypes.forEach(eventType => {
                options += `<option value="${eventType.id}">${eventType.pavadinimas}</option>`;
            });

            specializationContainer.innerHTML = `
                <div class="form-group">
                    <label for="event_type">Pasirinkite renginio specializacija:</label>
                    <select class="form-control" id="event_type" name="event_type" required>
                        ${options}
                    </select>
                </div>
            `;
        } else {
            specializationContainer.innerHTML = ""; // Remove the section
        }
    });
});
