=== Generate Random Orders For WooCommerce ===
Contributors:      aspengrovestudios, annaqq
Tags:              woocommerce, orders, generate, random, sample orders
Requires at least: 5.0
Requires PHP:      7.3
Tested up to:      6.6.1
Stable tag:        1.0.0
License: GNU General Public License version 3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Generates random orders for your WooCommerce store. It's a great tool for testing and populating your store's database with random data.


== Description ==

The "Generate Random Orders for WooCommerce" plugin allows store owners to generate random orders quickly, making it a valuable tool for testing and data population. You can set the number of orders to generate.

Once you generate the orders, you can easily view them in the WooCommerce admin panel. This plugin can save you a significant amount of time when testing your store's ordering and payment processes or when populating your database with random data.

## How it works?
This plugin runs a script to generate random orders and related data in this site's WooCommerce database. You can specify how many orders you want to generate.

Order dates are set as follows:
* Order #1: midnight today
* Order #2: midnight yesterday
* Order #3: midnight one week ago
* Order #4: midnight 30 days ago
* Order #5+: random date and time between now and 365 days ago, with ~50% of orders between now and 30 days ago

1. Order billing name and shipping name are each randomly selected from two possible names.
2. >Order billing phone and shipping phone are randomly generated 10-digit numbers.
3. Order user ID is either 1 or 2. The JSON assumes that the nickname of user 1 is user1, and the nickname of user 2 is user2 (this doesn't matter if the JSON is not being used.
4. Order billing address and shipping address are the same, randomly selected from two possible addresses, one Canadian and one US.
5. Order billing email is example<em>N</em>@example.com, where <em>N</em> is a random number from 1 to 3.
6. Each order has (randomly) 1 to 5 product items. The WooCommerce store must have both variable and simple products. Products are selected at random with a ~33% bias toward variable products and ~67% bias toward simple products. Each item has a random quantity between 1 and 5 (whole number).
7. ~25% of orders are assigned local pickup. ~75% of orders are assigned flat rate shipping. The shipping in the WooCommerce store must be set up with flat rate having instance ID 1 and local pickup having instance ID 2. Shipping amount is a random whole number between 5 and 20.
8. ~33% of orders have coupon code 50OFF added. This coupon code must be configured in WooCommerce.
9. Orders are randomly assigned statuses with the following approximate distribution: 14% pending, 29% processing, 57% completed. Some orders may have their status automatically changed to refunded due to the line item refund, if the refund results in the entire order being refunded.
10. ~50% of orders have a custom meta field wpz_custom_meta_1, and ~50% of orders have a custom meta field wpz_custom_meta_2. The value of either field is a random 3 digit number.
11. The JSON assumes that two taxes are set up: tax ID 1 is GST, tax ID 2 is PST. This doesn't matter if the JSON is not being used.
12. ~20% orders have line item refunds. Each refund has one product item, and the quantity refunded is 1; refund amounts correspond to quantity pro-rated line total and taxes. A corresponding amount of shipping is refunded (ignoring other items that may be on the order). Refunds are dated between 1 and 14 days from the order date, but not past the current time.


### Addons & Integrations
Looking to automate your WooCommerce reports, share them on the frontend of your site, or create in-depth sales reports? We have more free and premium reporting tools for WooCommerce.

- [Extra Product Options Addon](https://wpzone.co/product/extra-product-options-addon-for-export-order-items-pro/) - export fields from the [WooCommerce Extra Product Options](https://codecanyon.net/item/woocommerce-extra-product-options/7908619) plugin
- [Scheduled Email Reports for WooCommerce](https://wpzone.co/product/scheduled-email-reports-for-woocommerce/) - plugin to automate report sending
- [Frontend Reports for WooCommerce](https://wpzone.co/product/frontend-reports-for-woocommerce/) - display reports on the frontend of your site
- [Product Sales Report for WooCommerce](https://wordpress.org/plugins/product-sales-report-for-woocommerce/) (Free and [Pro](https://wordpress.org/plugins/product-sales-report-for-woocommerce/) - create sales reports for your store


If you like this plugin, please consider leaving a comment or review.

## You may also like these plugins
[WP Zone](https://wpzone.co/) has built a bunch of plugins, add-ons, and themes. Check out other favorites here on the repository and don’t forget to leave a 5-star review to help others in the community decide.

* [Product Sales Report for WooCommerce](https://wordpress.org/plugins/product-sales-report-for-woocommerce/) - setup a custom sales report for the products in your WooCommerce store with toggle sorting options. Including or excluding items based on date range, sale status, product category and id, define display order, choose what fields to include, and generate your report with a click.
* [Replace Image](https://wordpress.org/plugins/replace-image/) – keep the same URL when uploading to the WordPress media library
* [Force Update Check for Plugins and Themes](https://wordpress.org/plugins/force-update-check-for-plugins-and-themes/) -force Update Check for Plugins and Themes forces WordPress to run a theme and plugin update check whenever you visit the WordPress updates page
* [Connect SendGrid for Emails](https://wordpress.org/plugins/connect-sendgrid-for-emails/) -  connect SendGrid for Emails is a third-party fork of (and a drop-in replacement for) the official SendGrid plugin
* [Custom CSS and JavaScript](https://wordpress.org/plugins/custom-css-and-javascript/) - allows you to add custom site-wide CSS styles and JavaScript code to your WordPress site. Useful for overriding your theme’s styles and adding client-side functionality.
* [Disable User Registration Notification Emails](https://wordpress.org/plugins/disable-user-registration-notification-emails/) - when this plugin is activated, it disables the notification sent to the admin email when a new user account is registered.
* [Inline Image Upload for BBPress](https://wordpress.org/plugins/image-upload-for-bbpress/) - enables the TinyMCE WYSIWYG editor for BBPress forum topics and replies and adds a button to the editor’s “Insert/edit image” dialog that allows forum users to upload images from their computer and insert them inline into their posts.
* [Password Strength for WooCommerce](https://wordpress.org/plugins/password-strength-for-woocommerce/) - disables password strength enforcement in WooCommerce.
* [Potent Donations for WooCommerce](https://wordpress.org/plugins/donations-for-woocommerce/) – acceptance donations through your WooCommerce store
* [Shortcodes for Divi](https://wordpress.org/plugins/shortcodes-for-divi/) - allows to use Divi Library layouts as shortcodes everywhere where text comes.
* [Stock Export and Import for WooCommerce](https://wordpress.org/plugins/stock-export-and-import-for-woocommerce/) - generates reports on the stock status (in stock / out of stock) and quantity of individual WooCommerce products.
* [Random Quiz Generator for LifterLMS](https://wordpress.org/plugins/random-quiz-addon-for-lifterlms/) - pull a random set of questions from your quiz so users never get the same question twice when retaking or setting up a practice quiz.
* [WP and Divi Icons](https://wordpress.org/plugins/wp-and-divi-icons/) - adds over 660 custom outline SVG icons to your website. SVG icons are vector icons, so they are sharp and look good on any screen at any size.
* [WP Layouts](https://wordpress.org/plugins/wp-layouts/) - the best way to organize, import, and export your layouts, especially if you have multiple websites.
* [WP Squish](https://wordpress.org/plugins/wp-squish/) - reduce the amount of storage space consumed by your WordPress installation through the application of user-definable JPEG compression levels and image resolution limits to uploaded images.

To view WP Zone's premium WordPress plugins and themes, visit our [WordPress products catalog page](https://wpzone.co/product/)

Enjoy!


== Installation ==

1. Click "Plugins" > "Add New" in the WordPress admin menu.
2. Search for "Generate Random Orders For WooCommerce".
3. Click "Install Now".
4. Click "Activate Plugin".

Alternatively, you can manually upload the plugin to your wp-content/plugins directory.


== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.0.0 = May 9. 2023

Initial release
