<?php

/**
 * Template part for displaying Nutrimatch section
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .nutri-match-wrapper {
        background: #d9734d;
        padding: 60px 0px 60px 0px;
        /* display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: center;
        justify-content: flex-start;
        position: relative; */
    }

    .nutri-match {
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: center;
        justify-content: flex-start;
        position: relative;
    }

    .nutri-match .nutrimatch-logo {
        flex-shrink: 0;
        max-width: 976px;
        max-height: 183px;
        position: relative;
        overflow: visible;
        width: 100%;
    }

    .nutri-match .button-primary {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .nutri-match .button {
        color: var(--primary-btn-color);
        background: var(--primary-btn-bg-color);
        padding: 12px 24px 12px 24px;
        text-align: left;
        font-family: "Roboto-SemiBold", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 600;
        position: relative;
    }

    .button-primary .button:hover {
        background: var(--primary-btn-bg-color-h-alt);
    }
</style>

<div class="nutri-match-wrapper">
    <div class="nutri-match container">
        <img class="nutrimatch-logo"
            src="<?php echo get_template_directory_uri() . '/assets/image/nutrimatch-logo.svg'; ?>" />
        <div class="button-primary">
            <a href="<?php echo get_permalink(get_page_by_path('nutrimatch')); ?>"><button class="button">Learn more</button></a>
        </div>
    </div>
</div>