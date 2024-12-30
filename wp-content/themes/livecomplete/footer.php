<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package live-complete
 */

?>

</div><!-- #content -->



<?php
/**
 * Hook - live_complete_site_footer
 *
 * @hooked live_complete_container_wrap_start
 */
do_action('live_complete_site_footer');
?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>