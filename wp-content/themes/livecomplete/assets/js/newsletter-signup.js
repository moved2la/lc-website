document.getElementById('newsletterSignupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    formData.append('action', 'submit_newsletter_signup');
    const messageDiv = document.getElementById('signupMessage');

    fetch(newsletter_signup_vars.ajaxurl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.innerHTML = '<div class="form-message success">' + data.data.message + '</div>';
            form.reset();
        } else {
            messageDiv.innerHTML = '<div class="form-message error">' + data.data.message + '</div>';
        }
    })
    .catch(error => {
        messageDiv.innerHTML = '<div class="form-message error">Sorry, there was an error processing your request. Please try again later.</div>';
    });
}); 