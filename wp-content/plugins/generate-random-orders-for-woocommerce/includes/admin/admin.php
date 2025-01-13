<div id="wpz-woocommerce-random-orders-settings-container">
    <div id="wpz-woocommerce-random-orders-settings">

        <div id="wpz-woocommerce-random-orders-settings-header">
            <div class="wpz-woocommerce-random-orders-settings-logo">
                <img alt="wpz-woocommerce-random-orders-settings-logo"
                     src="<?php echo esc_url( WPZ_Generate_Random_Orders_For_WooCommerce::$plugin_base_url . 'assets/images/plugin_icon.svg' ); ?>">
                <h1><?php esc_html_e( 'Generate Random Orders For WooCommerce', 'wpz-woocommerce-random-orders' ); ?></h1>
            </div>
            <div id="wpz-woocommerce-random-orders-settings-header-links">
                <a id="wpz-woocommerce-random-orders-settings-header-link-settings"
                   href=""><?php esc_html_e( 'Settings', 'wpz-woocommerce-random-orders' ); ?></a>
<!--                <a id="wpz-woocommerce-random-orders-settings-header-link-support"-->
<!--                   href="https://docs.divi.space"-->
<!--                   target="_blank">--><?php //esc_html_e( 'Documentation', 'wpz-woocommerce-random-orders' ); ?><!--</a>-->
            </div>
        </div>

        <ul id="wpz-woocommerce-random-orders-settings-tabs">

			<?php
				?>
                <li class="wpz-woocommerce-random-orders-settings-active">
                    <a href="#about"><?php esc_html_e( 'Generate Orders', 'wpz-woocommerce-random-orders' ); ?></a>
                </li>
                <li>
                    <a href="#addons"><?php esc_html_e( 'Addons', 'wpz-woocommerce-random-orders' ) ?></a>
                </li>
        </ul>

        <div id="wpz-woocommerce-random-orders-settings-tabs-content">

                <div id="wpz-woocommerce-random-orders-settings-about"
                     class="wpz-woocommerce-random-orders-settings-active">

                    <h3>Generate Orders</h3>

                    <p class="mb-20">This plugin runs a script to generate random orders and related data in this site's WooCommerce database. You can specify how many orders you want to generate.</p>


                    <form id="wpz-random-orders-form" class="mb-50" method="post" action="">
                            <label class="wpz-form-row ">
                                <h4>Number of orders:</h4>
                                <input type="number" name="orderCount" value="100" step="1" min="1">
                            </label>

                             <label class="wpz-form-row">
                                <h4>Automatically delete JSON file?</h4>
                                <input type="checkbox" name="deleteJson" checked>
                            </label>
                        <p>
                            <small>The script creates an orders.json file in the WordPress root directory with the generated order data. Uncheck this box to keep the file instead of deleting it automatically.</small>
                        </p>
                        <p>
			                <?php wp_nonce_field('wpz-random-orders', 'nonce'); ?>
			                <?php if (count(get_posts(['post_type' => ['product', 'product_variation'], 'fields' => 'ids', 'posts_per_page' => 5, 'orderby' => 'none'])) < 5) { ?>
                        <p class="wpz-random-orders-error">You must have at least 5 products or product variations in your store in order to use this plugin.</p>
	                    <?php } else { ?>

                        <button class="wpz-woocommerce-random-orders-button wpz-woocommerce-random-orders-button-medium" >Generate</button>
	                    <?php } ?>
                        </p>

                        <progress id="wpz-random-orders-progress" value="0"></progress>

                        <pre id="wpz-random-orders-output"></pre>
                    </form>

                    <div>
                        <h3>Orders are set as follows:</h3>

                        <h4>Dates:</h4>
                        <ol>
                            <li>Order #1: midnight today</li>
                            <li>Order #2: midnight yesterday</li>
                            <li>Order #3: midnight one week ago</li>
                            <li>Order #4: midnight 30 days ago</li>
                            <li>Order #5+: random date and time between now and 365 days ago, with ~50% of orders between now and 30 days ago</li>
                        </ol>

                        <h4>Order details:</h4>
                        <ul>
                        <li>Order billing name and shipping name are each randomly selected from two possible names.</li>
                        <li>Order billing phone and shipping phone are randomly generated 10-digit numbers.</li>
                        <li>Order user ID is either 1 or 2. The JSON assumes that the nickname of user 1 is user1, and the nickname of user 2 is user2 (this doesn't matter if the JSON is not being used.</li>
                        <li>Order billing address and shipping address are the same, randomly selected from two possible addresses, one Canadian and one US.</li>
                        <li>Order billing email is example<em>N</em>@example.com, where <em>N</em> is a random number from 1 to 3.</li>
                        <li>Each order has (randomly) 1 to 5 product items. The WooCommerce store must have both variable and simple products. Products are selected at random with a ~33% bias toward variable products and ~67% bias toward simple products. Each item has a random quantity between 1 and 5 (whole number).</li>
                        <li>~25% of orders are assigned local pickup. ~75% of orders are assigned flat rate shipping. The shipping in the WooCommerce store must be set up with flat rate having instance ID 1 and local pickup having instance ID 2. Shipping amount is a random whole number between 5 and 20.</li>
                        <li>~33% of orders have coupon code 50OFF added. This coupon code must be configured in WooCommerce.</li>
                        <li>Orders are randomly assigned statuses with the following approximate distribution: 14% pending, 29% processing, 57% completed. Some orders may have their status automatically changed to refunded due to the line item refund, if the refund results in the entire order being refunded.</li>
                        <li>~50% of orders have a custom meta field wpz_custom_meta_1, and ~50% of orders have a custom meta field wpz_custom_meta_2. The value of either field is a random 3 digit number.</li>
                        <li>The JSON assumes that two taxes are set up: tax ID 1 is GST, tax ID 2 is PST. This doesn't matter if the JSON is not being used.</li>
                        <li>~20% orders have line item refunds. Each refund has one product item, and the quantity refunded is 1; refund amounts correspond to quantity pro-rated line total and taxes. A corresponding amount of shipping is refunded (ignoring other items that may be on the order). Refunds are dated between 1 and 14 days from the order date, but not past the current time.</li>
                        </ul>
                    </div>

                </div>
                <div id="wpz-woocommerce-random-orders-settings-addons">
					<?php WPZ_Generate_Random_Orders_For_WooCommerce_Addons::outputList(); ?>
                </div>
				<?php
			?>

        </div>

    </div>
</div>