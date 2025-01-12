document.getElementById('supportContactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Form submitted');
    
    const form = this;
    const formData = new FormData(form);
    formData.append('action', 'submit_contact_form');
    const messageDiv = document.getElementById('formMessage');

    fetch(contact_form_vars.ajaxurl, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Raw response:', response);
        return response.json();
    })
    .then(data => {
        console.log('Parsed response:', data);
        const message = data.data ? data.data.message : data.message;
        
        if (data.success) {
            messageDiv.innerHTML = '<div class="success-message">' + message + '</div>';
            form.reset();
        } else {
            messageDiv.innerHTML = '<div class="error-message">' + message + '</div>';
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        messageDiv.innerHTML = '<div class="error-message">Sorry, there was an error sending your message. Please try again later.</div>';
    });
}); 