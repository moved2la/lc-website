document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('supportContactForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'submit_contact_form');
            const messageDiv = document.getElementById('formMessage');

            fetch(contact_form_vars.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<div class="success-message">' + data.data.message + '</div>';
                    form.reset();
                } else {
                    messageDiv.innerHTML = '<div class="error-message">' + data.data.message + '</div>';
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<div class="error-message">Sorry, there was an error sending your message. Please try again later.</div>';
            });
        });
    }
}); 