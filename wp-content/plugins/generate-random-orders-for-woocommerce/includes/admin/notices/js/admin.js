// Admin Notice
jQuery(document).ready(function ($) {
    $('#wpz-woocommerce-random-orders-notice .notice-dismiss'
    ).on('click', function () {
        jQuery.post(ajaxurl, {action: 'wpz_woocommerce_random_orders_notice_hide'})
    });
});