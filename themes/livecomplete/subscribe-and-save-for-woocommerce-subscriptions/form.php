<?php

/**
 * Buy Now or Subscribe Form.
 *
 * This template can be overridden by copying it to yourtheme/subscribe-and-save-for-woocommerce-subscriptions/form.php.
 * 
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 */
defined('ABSPATH') || exit;

$product = wc_get_product($subscribe_product_id);
$regular_price = $product->get_regular_price();
$reduced_price = $product->get_price();
?>
<div class="asp-ssws-subscribe-wrapper" data-subscribe-level="<?php echo esc_attr($subscribe_level); ?>" data-product-id="<?php echo esc_attr($subscribe_product_id); ?>">
    <ul class="asp-ssws-subscribe-options">
        <?php if (! $subscribe_forced) : ?>
            <li class="asp-ssws-pay-option-one-time">
                <input type="radio" class="asp-ssws-pay-option" name="asp_ssws_pay_option[<?php echo esc_attr($subscribe_product_id); ?>]" value="one-time" id="asp_ssws_pay_one_time_<?php echo esc_attr($subscribe_product_id); ?>" <?php checked(('no' === $is_subscribed || (is_null($is_subscribed) && 'one-time' === $default_subscribe_value)), true, true); ?> />
                <label for="asp_ssws_pay_one_time_<?php echo esc_attr($subscribe_product_id); ?>"><?php echo esc_html($one_time_purchase_option_label); ?></label>
                <label class="price-label"><?php echo wc_price($regular_price); ?></label>
            </li>
        <?php endif; ?>
        <li class="asp-ssws-pay-option-subscribe">
            <input type="radio" class="asp-ssws-pay-option" name="asp_ssws_pay_option[<?php echo esc_attr($subscribe_product_id); ?>]" value="subscribe" id="asp_ssws_pay_subscribe_<?php echo esc_attr($subscribe_product_id); ?>" <?php checked(('yes' === $is_subscribed || $subscribe_forced || (is_null($is_subscribed) && 'subscribe' === $default_subscribe_value)), true, true); ?> />
            <label for="asp_ssws_pay_subscribe_<?php echo esc_attr($subscribe_product_id); ?>"><?php echo esc_html($subscribe_option_label); ?></label>
            <?php if ($product != null) : ?>
                <!-- <label class="price-label">
                    <?php
                    $regular_price = floatval($product->get_regular_price());
                    $subscription_price = $regular_price * (1 - (floatval($subscribe_discount) / 100));
                    echo wp_kses_post(wc_price($reduced_price));
                    ?>
                </label> -->
                <?php if ($chosen_subscribe_plan > 0) : ?>
                    <label class="price-label subscribe-price">
                        <?php
                        echo wp_kses_post(wc_price($subscription_price) . ' <del>' . wc_price($regular_price) . '</del>');
                        ?>
                    </label>

                <?php else : ?>
                    <label class="price-label">
                        <?php
                        echo wp_kses_post(wc_price($regular_price));
                        ?>
                    </label>
                <?php endif; ?>
            <?php endif; ?>
        </li>

        <?php if ($via_modal) : ?>
            <input type="hidden" name="asp_ssws_pay_option_via_modal[<?php echo esc_attr($subscribe_product_id); ?>]" value="1" />
        <?php endif; ?>
    </ul>

    <ul class="asp-ssws-subscribe-plan-options">
        <?php if ('yes' === $is_subscribed) : ?>
            <?php if (count($subscribe_plans) > 0) : ?>
                <li class="asp-ssws-subscribe-row-plan-selection">
                    <label for="asp_ssws_subscribe_plans"><?php echo esc_html($subscribe_plan_label); ?></label>
                    <select id="asp_ssws_subscribe_plans" name="asp_ssws_subscribe_plan">
                        <?php foreach ($subscribe_plans as $plan) { ?>
                            <?php
                            $regular_price = floatval($product->get_regular_price());
                            $subscription_price = $regular_price * (1 - (floatval($plan->get_subscription_discount()) / 100));
                            ?>
                            <option value="<?php echo esc_attr($plan->get_id()); ?>" <?php selected($plan->get_id(), ($chosen_subscribe_plan > 0 ? $chosen_subscribe_plan : $default_subscribe_plan), true); ?>><?php echo wp_kses_post($plan->get_name() . ' (' . wc_price($subscription_price) . ')'); ?></option>
                        <?php } ?>
                    </select>
                </li>

                <!-- <?php if (! empty($subscribe_discount_label) && $subscribe_discount > 0) : ?>
                    <li class="asp-ssws-subscribe-row-discount">
                        <label for="asp_ssws_subscribe_discount"></label>
                        <span class="asp-ssws-subscribe-discount">
                            <?php echo wp_kses_post(str_replace('{subscribe_discount}', $subscribe_discount, $subscribe_discount_label)); ?>
                        </span>
                    </li>
                <?php endif; ?>

                <?php if ('predefined' === $subscribe_definition) : ?>
                    <li class="asp-ssws-subscribe-row-price-string">
                        <label for="asp_ssws_subscribe_price_string"></label>
                        <span class="asp-ssws-subscribe-price-string">
                            <?php echo wp_kses_post($subscribe_price_string); ?>
                        </span>
                    </li>
                <?php endif; ?> -->
            <?php else : ?>
                <li class="asp-ssws-subscribe-row-no-plans-found">
                    <?php esc_html_e('No subscribe plans found.', 'subscribe-and-save-for-woocommerce-subscriptions'); ?>
                </li>
            <?php endif; ?>
        <?php else : ?>
            <?php if ($default_subscribe_plan > 0) : ?>
                <input type="hidden" name="asp_ssws_subscribe_plan" value="<?php echo esc_attr($default_subscribe_plan); ?>" />
            <?php elseif (count($subscribe_plans) > 0) : ?>
                <input type="hidden" name="asp_ssws_subscribe_plan" value="<?php echo esc_attr(current($subscribe_plans)->get_id()); ?>" />
            <?php endif; ?>
        <?php endif; ?>
    </ul>

    <?php if ('yes' === $is_subscribed && 'userdefined' === $subscribe_definition) : ?>
        <ul class="asp-ssws-subscribe-custom-plan-options">
            <?php if (! empty($chosen_subscribe_period)) { ?>
                <li class="asp-ssws-subscribe-row-custom-period-interval">
                    <label for="asp_ssws_subscribe_period_intervals"><?php echo esc_html($billing_interval_label); ?></label>
                    <select id="asp_ssws_subscribe_period_intervals" name="asp_ssws_subscribe_period_interval">
                        <?php foreach (wcs_get_subscription_period_interval_strings() as $value => $label) { ?>
                            <?php
                            if (
                                isset($subscribe_interval_length[$chosen_subscribe_period]['interval']['min'], $subscribe_interval_length[$chosen_subscribe_period]['interval']['max']) &&
                                $value >= $subscribe_interval_length[$chosen_subscribe_period]['interval']['min'] && $value <= $subscribe_interval_length[$chosen_subscribe_period]['interval']['max']
                            ) {
                            ?>
                                <option value="<?php echo esc_attr($value); ?>" <?php selected($value, $chosen_subscribe_interval, true); ?>><?php echo esc_html($label); ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </li>

                <li class="asp-ssws-subscribe-row-custom-period">
                    <label for="asp_ssws_subscribe_periods"><?php echo esc_html($billing_period_label); ?></label>
                    <select id="asp_ssws_subscribe_periods" name="asp_ssws_subscribe_period">
                        <?php foreach (wcs_get_subscription_period_strings() as $value => $label) { ?>
                            <?php if (isset($subscribe_interval_length[$value]['enabled']) && 'yes' === $subscribe_interval_length[$value]['enabled']) { ?>
                                <option value="<?php echo esc_attr($value); ?>" <?php selected($chosen_subscribe_period, $value, true); ?>><?php echo esc_html($label); ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </li>

                <li class="asp-ssws-subscribe-row-custom-length">
                    <label for="asp_ssws_subscribe_lengths"><?php echo esc_html($billing_expiration_label); ?></label>
                    <select id="asp_ssws_subscribe_lengths" name="asp_ssws_subscribe_length">
                        <?php
                        if (isset($subscribe_interval_length[$chosen_subscribe_period]['length']['min'], $subscribe_interval_length[$chosen_subscribe_period]['length']['max'])) {
                            $needs_never_expire = true;

                            foreach (asp_ssws_get_subscription_length_ranges($chosen_subscribe_period, $chosen_subscribe_interval) as $value => $label) {
                                if ($value >= $subscribe_interval_length[$chosen_subscribe_period]['length']['min']) {
                                    if ('0' === $subscribe_interval_length[$chosen_subscribe_period]['length']['max']) {
                                        $needs_never_expire = true;
                        ?>
                                        <option value="<?php echo esc_attr($value); ?>" <?php selected($value, $chosen_subscribe_length, true); ?>><?php echo esc_html($label); ?></option>
                                    <?php
                                    } else if ($value <= $subscribe_interval_length[$chosen_subscribe_period]['length']['max']) {
                                        $needs_never_expire = false;
                                    ?>
                                        <option value="<?php echo esc_attr($value); ?>" <?php selected($value, $chosen_subscribe_length, true); ?>><?php echo esc_html($label); ?></option>
                                <?php
                                    }
                                }
                            }

                            if ($needs_never_expire) {
                                ?>
                                <option value="0" <?php selected('0', $chosen_subscribe_length, true); ?>><?php esc_html_e('Never expire', 'subscribe-and-save-for-woocommerce-subscriptions'); ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </li>
            <?php } ?>

            <?php if ('userdefined' === $subscribe_definition) : ?>
                <li class="asp-ssws-subscribe-row-price-string">
                    <label for="asp_ssws_subscribe_price_string"></label>
                    <span class="asp-ssws-subscribe-price-string">
                        <?php echo wp_kses_post($subscribe_price_string); ?>
                    </span>
                </li>
            <?php endif; ?>
        </ul>
        test
    <?php endif; ?>
</div>