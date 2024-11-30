document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.mark-as-read');

    links.forEach(link => {
        link.addEventListener('click', function(event) {
            const messageId = this.getAttribute('data-message-id');
            
            // Send an AJAX request to mark the message as read
            fetch('../src/helpers/mark_as_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message_id: messageId })
            })
            .then(response => {
                if (!response.ok) {
                    console.error('Failed to mark the message as read');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});