<?php
function handle_contact_form_submission() {
    error_log('AJAX handler started'); // Debug log
    
    if (!check_ajax_referer('submit_contact_form', 'contact_form_nonce', false)) {
        error_log('Nonce verification failed');
        wp_send_json_error(array(
            'message' => 'Security check failed'
        ));
        return;
    }

    // Log POST data
    error_log('POST data: ' . print_r($_POST, true));

    // Sanitize form inputs
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $message = sanitize_textarea_field($_POST['message']);

    // Email configuration
    $to = get_option('admin_email');
    $subject = 'LiveComplete.com Contact Form Submission';

    // Create HTML email body
    $body = "<html><body>";
    $body .= "<h2>New Contact Form Submission</h2>";
    $body .= "<p><strong>Name:</strong> " . esc_html($first_name) . " " . esc_html($last_name) . "</p>";
    $body .= "<p><strong>Email:</strong> " . esc_html($email) . "</p>";
    $body .= "<p><strong>Phone:</strong> " . esc_html($phone) . "</p>";
    $body .= "<p><strong>Message:</strong><br>" . nl2br(esc_html($message)) . "</p>";
    $body .= "</body></html>";

    // SendGrid API configuration
    $sendgrid_api_key = get_option('lcsg_api_key');
    $url = 'https://api.sendgrid.com/v3/mail/send';

    $data = array(
        'personalizations' => array(
            array(
                'to' => array(
                    array(
                        'email' => $to
                    )
                )
            )
        ),
        'from' => array(
            'email' => get_option('admin_email'),
            'name' => 'LiveComplete Contact'
        ),
        'subject' => $subject,
        'content' => array(
            array(
                'type' => 'text/html',
                'value' => $body
            )
        )
    );

    $args = array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $sendgrid_api_key,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode($data),
        'method' => 'POST'
    );

    $response = wp_remote_post($url, $args);
    $response_code = wp_remote_retrieve_response_code($response);

    // Log SendGrid response
    error_log('SendGrid response code: ' . $response_code);
    error_log('SendGrid response: ' . print_r($response, true));

    if ($response_code == 202) {
        error_log('Sending success response');
        wp_send_json_success(array(
            'message' => 'Thank you for your message. We\'ll get back to you soon!'
        ));
    } else {
        error_log('Sending error response');
        wp_send_json_error(array(
            'message' => 'Sorry, there was an error sending your message. Please try again later.'
        ));
    }
    exit;
}

add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission'); 