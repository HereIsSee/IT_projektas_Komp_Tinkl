document.addEventListener("DOMContentLoaded", function() {
    const successMessage = document.getElementById("success-message");
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.transition = "opacity 1s";
            successMessage.style.opacity = 0;
        }, 5000);

        setTimeout(() => {
            successMessage.remove();
        }, 6000);
    }
});