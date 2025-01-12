document.addEventListener('DOMContentLoaded', function() {
    const signupForm = document.getElementById('newsletterSignupForm');
    
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Newsletter form submitted');
            
            const formData = new FormData(this);
            formData.append('action', 'submit_newsletter_signup');
            const messageDiv = document.getElementById('signupMessage');

            fetch(newsletter_signup_vars.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Newsletter form response:', data);
                if (data.success) {
                    messageDiv.innerHTML = '<div class="success-message">' + data.data.message + '</div>';
                    signupForm.reset();
                } else {
                    messageDiv.innerHTML = '<div class="error-message">' + data.data.message + '</div>';
                }
            })
            .catch(error => {
                console.error('Newsletter form error:', error);
                messageDiv.innerHTML = '<div class="error-message">Sorry, there was an error processing your request. Please try again later.</div>';
            });
        });
    }
}); 