<?php

/**
 * Plugin Name: LiveComplete SendGrid
 * Plugin URI: https://livecomplete.com
 * Description: Replaces WordPress default mail function with SendGrid API
 * Version: 1.0.0
 * Author: Warren
 * Author URI: https://livecomplete.com
 * License: GPL v2 or later
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('LCSG_VERSION', '1.0.0');
define('LCSG_PLUGIN_DIR', plugin_dir_path(__FILE__));

class LiveComplete_SendGrid
{
    private $api_key;
    private $template_id;
    private $woocommerce_integration;
    private $logger;

    public function __construct()
    {
        // Initialize the plugin
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));

        // Replace wp_mail with our custom function
        if (get_option('lcsg_api_key')) {
            $this->api_key = get_option('lcsg_api_key');
            add_filter('pre_wp_mail', array($this, 'send_via_sendgrid'), 10, 2);
        }

        // Initialize WooCommerce integration if WooCommerce is active
        if ($this->is_woocommerce_active()) {
            require_once LCSG_PLUGIN_DIR . 'includes/woocommerce-integration.php';
            $this->woocommerce_integration = new LiveComplete_SendGrid_WooCommerce();
            
            // Disable default WooCommerce emails
            add_action('woocommerce_email', array($this, 'disable_wc_emails'));
            
            // Add single hook for new orders
            add_action('woocommerce_checkout_order_processed', array($this, 'trigger_new_order_email'));
        }

        // Initialize logging
        $this->logger = $this->initialize_logger();
        
        // Add logging settings
        add_action('admin_init', array($this, 'register_settings'));

        // Add handler for clearing logs
        add_action('admin_init', array($this, 'handle_clear_logs'));

        // Install database table
        register_activation_hook(__FILE__, array($this, 'install'));
    }

    private function is_woocommerce_active() {
        return class_exists('WooCommerce');
    }

    public function register_settings()
    {
        register_setting('lcsg_settings', 'lcsg_api_key');
        register_setting('lcsg_settings', 'lcsg_template_id');
        register_setting('lcsg_settings', 'lcsg_use_template');
        register_setting('lcsg_settings', 'lcsg_enable_logging');
        register_setting('lcsg_settings', 'lcsg_from_email');
        register_setting('lcsg_settings', 'lcsg_from_name');
        register_setting('lcsg_settings', 'lcsg_reply_to_email');
    }

    public function settings_page() {
        // Get current tab
        $current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'settings';
        ?>
        <div class="wrap">
            <h1>LiveComplete SendGrid Settings</h1>
            
            <nav class="nav-tab-wrapper">
                <a href="?page=livecomplete-sendgrid&tab=settings" 
                   class="nav-tab <?php echo $current_tab === 'settings' ? 'nav-tab-active' : ''; ?>">
                    Settings
                </a>
                <a href="?page=livecomplete-sendgrid&tab=logs" 
                   class="nav-tab <?php echo $current_tab === 'logs' ? 'nav-tab-active' : ''; ?>">
                    Error Logs
                </a>
                <a href="?page=livecomplete-sendgrid&tab=history" 
                   class="nav-tab <?php echo $current_tab === 'history' ? 'nav-tab-active' : ''; ?>">
                    Email History
                </a>
            </nav>

            <div class="tab-content">
                <?php
                switch ($current_tab) {
                    case 'settings':
                        $this->render_settings_tab();
                        break;
                    case 'logs':
                        $this->render_logs_tab();
                        break;
                    case 'history':
                        $this->render_history_tab();
                        break;
                }
                ?>
            </div>
        </div>
        <?php
    }

    private function render_settings_tab() {
        ?>
        <form method="post" action="options.php">
            <?php
            settings_fields('lcsg_settings');
            do_settings_sections('lcsg_settings');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">SendGrid API Key</th>
                    <td>
                        <input type="password" name="lcsg_api_key" value="<?php echo esc_attr(get_option('lcsg_api_key')); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">From Email Address</th>
                    <td>
                        <input type="email" name="lcsg_from_email" value="<?php echo esc_attr(get_option('lcsg_from_email', get_option('admin_email'))); ?>" class="regular-text">
                        <p class="description">The email address that emails will be sent from. Defaults to WordPress admin email if not set.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">From Name</th>
                    <td>
                        <input type="text" name="lcsg_from_name" value="<?php echo esc_attr(get_option('lcsg_from_name', get_bloginfo('name'))); ?>" class="regular-text">
                        <p class="description">The name that emails will be sent from. Defaults to site name if not set.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Reply-To Email Address</th>
                    <td>
                        <input type="email" name="lcsg_reply_to_email" value="<?php echo esc_attr(get_option('lcsg_reply_to_email', get_option('admin_email'))); ?>" class="regular-text">
                        <p class="description">The email address that recipients will reply to. Defaults to From Email if not set.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Use SendGrid Template</th>
                    <td>
                        <input type="checkbox" name="lcsg_use_template" value="1" <?php checked(1, get_option('lcsg_use_template'), true); ?>>
                        <span class="description">Enable to use SendGrid dynamic templates</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Template ID</th>
                    <td>
                        <input type="text" name="lcsg_template_id" value="<?php echo esc_attr(get_option('lcsg_template_id')); ?>" class="regular-text">
                        <p class="description">Enter your SendGrid dynamic template ID</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Enable Logging</th>
                    <td>
                        <input type="checkbox" name="lcsg_enable_logging" value="1" <?php checked(1, get_option('lcsg_enable_logging'), true); ?>>
                        <span class="description">Log SendGrid API errors for debugging</span>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <?php
    }

    private function render_logs_tab() {
        if (!get_option('lcsg_enable_logging')) {
            echo '<div class="notice notice-warning"><p>Logging is currently disabled. Enable it in Settings to view logs.</p></div>';
            return;
        }

        $logs = $this->get_recent_logs();
        if (!empty($logs)): ?>
            <div class="sendgrid-logs-wrapper" style="margin-top: 20px;">
                <table class="widefat">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Message</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo esc_html($log['timestamp']); ?></td>
                                <td><?php echo esc_html($log['message']); ?></td>
                                <td>
                                    <?php if (!empty($log['context'])): ?>
                                        <pre style="white-space: pre-wrap;"><?php echo esc_html(json_encode($log['context'], JSON_PRETTY_PRINT)); ?></pre>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <form method="post" action="">
                    <?php wp_nonce_field('clear_sendgrid_logs', 'sendgrid_logs_nonce'); ?>
                    <input type="submit" name="clear_sendgrid_logs" class="button button-secondary" value="Clear Logs" style="margin-top: 10px;">
                </form>
            </div>
        <?php else: ?>
            <p>No errors have been logged.</p>
        <?php endif;
    }

    private function render_history_tab() {
        $emails = $this->get_email_history();
        if (!empty($emails)): ?>
            <table class="widefat">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Template Type</th>
                        <th>Recipient</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emails as $email): ?>
                        <tr>
                            <td><?php echo esc_html($email->timestamp); ?></td>
                            <td>
                                <?php 
                                if (!empty($email->template_type)) {
                                    // Convert class name to readable format
                                    $template_name = str_replace('WC_Email_', '', $email->template_type);
                                    $template_name = str_replace('_', ' ', $template_name);
                                    echo esc_html(ucwords($template_name));
                                } else {
                                    echo 'Unknown';
                                }
                                ?>
                            </td>
                            <td><?php echo esc_html($email->recipient); ?></td>
                            <td><?php echo esc_html($email->subject); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo esc_attr($email->status); ?>">
                                    <?php echo esc_html(ucfirst($email->status)); ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($email->error)): ?>
                                    <pre><?php echo esc_html($email->error); ?></pre>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <style>
                .status-badge {
                    padding: 3px 8px;
                    border-radius: 3px;
                    font-size: 12px;
                    font-weight: bold;
                }
                .status-success {
                    background-color: #dff0d8;
                    color: #3c763d;
                }
                .status-failed {
                    background-color: #f2dede;
                    color: #a94442;
                }
                .nav-tab-wrapper {
                    margin-bottom: 20px;
                }
            </style>
        <?php else: ?>
            <p>No emails have been sent yet.</p>
        <?php endif;
    }

    public function send_via_sendgrid($args)
    {
        if (empty($this->api_key)) {
            $this->log_error('SendGrid API key is not set');
            return false;
        }

        // Debug log the incoming arguments
        $this->log_error('WP Mail Request', array(
            'args' => $args,
            'backtrace' => wp_debug_backtrace_summary()
        ));

        // Extract wp_mail arguments
        $to = !empty($args['to']) ? $args['to'] : get_option('admin_email');
        $subject = !empty($args['subject']) ? $args['subject'] : '';
        $message = !empty($args['message']) ? $args['message'] : '';
        $headers = !empty($args['headers']) ? $args['headers'] : array();
        $attachments = !empty($args['attachments']) ? $args['attachments'] : array();

        // Log the recipient being used
        $this->log_error('Using recipient', array(
            'to' => $to,
            'is_fallback' => empty($args['to'])
        ));

        // Format the 'to' parameter to handle arrays and strings
        $to_emails = array();
        if (is_array($to)) {
            foreach ($to as $recipient) {
                $to_emails[] = array('email' => $recipient);
            }
        } else {
            $to_emails[] = array('email' => $to);
        }

        // Base email structure
        $email = array(
            'personalizations' => array(
                array(
                    'to' => $to_emails
                )
            ),
            'subject' => $subject
        );

        // Get template data from filter
        $template_data = array();
        if (has_filter('lcsg_template_data')) {
            $template_data = apply_filters('lcsg_template_data', array());
            $this->log_error('Template data from filter', array(
                'template_data' => $template_data
            ));
        }

        // Only use template if template_id is explicitly set in the data
        if (!empty($template_data['template_id'])) {
            $email['template_id'] = $template_data['template_id'];
            
            // Remove template_id from dynamic data
            unset($template_data['template_id']);

            // Add template data to email
            $email['personalizations'][0]['dynamic_template_data'] = $template_data;

            $this->log_error('Using SendGrid template', array(
                'template_id' => $email['template_id']
            ));
        } else {
            // No template ID provided, use default WooCommerce template content
            $email['content'] = array(
                array(
                    'type' => 'text/html',
                    'value' => $message
                )
            );
            $this->log_error('Using default WooCommerce template');
        }

        // Parse headers for from email and reply-to
        $from_email = get_option('lcsg_from_email', get_option('admin_email'));
        $from_name = get_option('lcsg_from_name', get_bloginfo('name'));
        $reply_to_email = get_option('lcsg_reply_to_email', $from_email);

        if (!empty($headers)) {
            foreach ((array)$headers as $header) {
                if (strpos($header, 'From:') === 0) {
                    $from = str_replace('From:', '', $header);
                    $from = trim($from);
                    if (strpos($from, '<') !== false) {
                        preg_match('/(.*?)\s*<(.+)>/', $from, $matches);
                        $from_name = trim($matches[1]);
                        $from_email = trim($matches[2]);
                    } else {
                        $from_email = $from;
                    }
                } elseif (strpos($header, 'Reply-To:') === 0) {
                    $reply_to = str_replace('Reply-To:', '', $header);
                    $reply_to_email = trim($reply_to);
                }
            }
        }

        $email['from'] = array(
            'email' => $from_email,
            'name' => $from_name
        );

        // Add reply-to if set
        if (!empty($reply_to_email)) {
            $email['reply_to'] = array(
                'email' => $reply_to_email
            );
        }

        // Send email via SendGrid API
        $response = wp_remote_post('https://api.sendgrid.com/v3/mail/send', array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($email),
            'timeout' => 30
        ));

        // Log the email attempt
        $this->log_email_status(array(
            'to' => $to,
            'subject' => $subject,
            'status' => !is_wp_error($response) && $response['response']['code'] === 202 ? 'success' : 'failed',
            'error' => is_wp_error($response) ? $response->get_error_message() : 
                      ($response['response']['code'] !== 202 ? json_decode($response['body'], true) : null),
            'timestamp' => current_time('mysql')
        ));

        if (is_wp_error($response)) {
            $this->log_error('WordPress error while sending email', array(
                'error' => $response->get_error_message(),
                'to' => $to,
                'subject' => $subject
            ));
            return false;
        }

        if ($response['response']['code'] !== 202) {
            $this->log_error('SendGrid API error', array(
                'code' => $response['response']['code'],
                'message' => $response['response']['message'],
                'body' => json_decode($response['body'], true),
                'to' => $to,
                'subject' => $subject
            ));
            return false;
        }

        return true;
    }

    public function add_admin_menu() {
        add_options_page(
            'LiveComplete SendGrid Settings', // Page title
            'SendGrid Settings',             // Menu title
            'manage_options',                // Capability required
            'livecomplete-sendgrid',         // Menu slug
            array($this, 'settings_page')    // Callback function
        );
    }

    private function get_template_id_for_email()
    {
        // Check if this is a WooCommerce email
        if ($this->is_woocommerce_active() && did_action('woocommerce_email')) {
            // Get the appropriate template ID based on the email type
            $template_id = get_option('lcsg_new_order_template_id');
            if (!empty($template_id)) {
                return $template_id;
            }
        }

        // Fall back to default template ID
        return $this->template_id;
    }

    private function initialize_logger() {
        if (function_exists('wc_get_logger')) {
            return wc_get_logger();
        }
        return new LiveComplete_SendGrid_Logger();
    }

    private function log_error($message, $context = array()) {
        if (!get_option('lcsg_enable_logging')) {
            return;
        }

        $context = array_merge($context, array(
            'source' => 'livecomplete-sendgrid'
        ));

        if ($this->logger instanceof WC_Logger_Interface) {
            $this->logger->error($message, $context);
        } else {
            $this->logger->log($message, $context);
        }
    }

    private function get_recent_logs($limit = 100) {
        $logs = array();
        $log_dir = WP_CONTENT_DIR . '/logs/sendgrid';
        $log_file = $log_dir . '/sendgrid-' . date('Y-m-d') . '.log';

        if (!file_exists($log_file)) {
            return $logs;
        }

        $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$lines) {
            return $logs;
        }

        $lines = array_reverse($lines); // Most recent first
        $lines = array_slice($lines, 0, $limit);

        foreach ($lines as $line) {
            if (preg_match('/^\[(.*?)\] (.*?) ({.*})?$/', $line, $matches)) {
                $logs[] = array(
                    'timestamp' => $matches[1],
                    'message' => $matches[2],
                    'context' => isset($matches[3]) ? json_decode($matches[3], true) : null
                );
            }
        }

        return $logs;
    }

    public function handle_clear_logs() {
        if (
            isset($_POST['clear_sendgrid_logs']) && 
            isset($_POST['sendgrid_logs_nonce']) && 
            wp_verify_nonce($_POST['sendgrid_logs_nonce'], 'clear_sendgrid_logs')
        ) {
            $log_dir = WP_CONTENT_DIR . '/logs/sendgrid';
            $log_file = $log_dir . '/sendgrid-' . date('Y-m-d') . '.log';
            
            if (file_exists($log_file)) {
                unlink($log_file);
            }
            
            add_settings_error(
                'sendgrid_logs',
                'logs_cleared',
                'Logs have been cleared successfully.',
                'updated'
            );
        }
    }

    private function log_email_status($data) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sendgrid_emails';

        // Get template type from template data
        $template_type = '';
        if (has_filter('lcsg_template_data')) {
            $template_data = apply_filters('lcsg_template_data', array());
            $template_type = !empty($template_data['template_type']) ? $template_data['template_type'] : '';
        }

        // Ensure required fields have default values
        $data = wp_parse_args($data, array(
            'to' => 'No recipient',
            'subject' => 'No subject',
            'status' => 'unknown',
            'error' => null,
            'template_type' => $template_type,
            'timestamp' => current_time('mysql')
        ));

        // Format recipient if it's an array
        $recipient = is_array($data['to']) ? implode(', ', $data['to']) : $data['to'];
        
        // Ensure error is properly formatted for database
        $error = is_array($data['error']) ? json_encode($data['error']) : $data['error'];

        // Insert with sanitized values
        $wpdb->insert(
            $table_name,
            array(
                'recipient' => substr($recipient, 0, 1000),
                'subject' => substr($data['subject'], 0, 1000),
                'status' => $data['status'],
                'error' => $error,
                'template_type' => $data['template_type'],
                'timestamp' => $data['timestamp']
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s')
        );

        if ($wpdb->last_error) {
            $this->log_error('Database error while logging email status', array(
                'error' => $wpdb->last_error,
                'data' => $data
            ));
        }
    }

    private function get_email_history($limit = 200) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sendgrid_emails';
        
        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table_name} ORDER BY timestamp DESC LIMIT %d",
                $limit
            )
        );
    }

    public function install() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sendgrid_emails';
        $charset_collate = $wpdb->get_charset_collate();

        // Check if table exists
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                recipient text NOT NULL,
                subject text NOT NULL,
                status varchar(20) NOT NULL,
                error text,
                template_type varchar(100),
                timestamp datetime NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    public function disable_wc_emails($email_class) {
        // Remove all default WooCommerce email actions
        foreach ($email_class->emails as $email) {
            remove_all_actions(isset($email->trigger_action) ? $email->trigger_action : '');
        }

        $this->log_error('Disabled WooCommerce default emails');
    }

    /**
     * Trigger new order email
     *
     * @param int $order_id
     */
    public function trigger_new_order_email($order_id) {
        $order = wc_get_order($order_id);
        if (!$order) {
            $this->log_error('Failed to get order for email trigger', array('order_id' => $order_id));
            return;
        }

        // Get WooCommerce mailer
        $mailer = WC()->mailer();
        $email = $mailer->emails['WC_Email_New_Order'];

        // Ensure email class exists
        if (!$email) {
            $this->log_error('New Order email class not found');
            return;
        }

        // Get email content
        $email->object = $order;
        $content = $email->get_content();
        $content = $email->style_inline($content);
        
        // Get admin email
        $admin_email = get_option('admin_email');

        // Send via wp_mail (will be intercepted by our SendGrid integration)
        $sent = wp_mail(
            array('to' => $admin_email),
            array('subject' => sprintf('New Order #%s', $order->get_order_number())),
            array('message' => $content)
        );

        $this->log_error('New order email trigger attempt', array(
            'order_id' => $order_id,
            'sent' => $sent,
            'recipient' => $admin_email
        ));
    }
}

// Custom logger class for when WooCommerce is not available
class LiveComplete_SendGrid_Logger {
    public function log($message, $context = array()) {
        $log_dir = WP_CONTENT_DIR . '/logs/sendgrid';
        if (!file_exists($log_dir)) {
            wp_mkdir_p($log_dir);
        }

        $log_file = $log_dir . '/sendgrid-' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        
        $log_entry = sprintf(
            "[%s] %s %s\n",
            $timestamp,
            $message,
            !empty($context) ? json_encode($context) : ''
        );

        error_log($log_entry, 3, $log_file);
    }
}

// Replace the existing lcsg_set_template_data function
function lcsg_set_template_data($data) {
    global $livecomplete_sendgrid_template_data;
    $livecomplete_sendgrid_template_data = $data;
    
    add_filter('lcsg_template_data', function() use ($data) {
        return $data;
    }, 10);
}

// Initialize the plugin
new LiveComplete_SendGrid();
