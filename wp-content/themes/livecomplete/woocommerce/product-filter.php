<?php

/**
 * Product Filter Button
 *
 * @package Live Complete WordPress theme
 */

// Exit if accessed directly
if (! defined('ABSPATH')) {
    exit;
}

if (is_single() || ! have_posts()) {
    return;
}

?>

<style>
    .filter-button {
        display: flex;
        align-items: center;
        height: 34px;
        background-color: #fff;
        color: #000;
        border: 1px solid #000;
        min-width: 156px;
        padding-left: 8px;
        padding-right: 8px;
        float: right;
    }

    .filter-button:hover,
    .filter-button:focus {
        background-color: #fff;
    }

    .filter-button-text {
        margin-right: auto;
    }

    .filter-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .filter-modal-body {
        margin-top: 20px;
    }

    .filter-modal.active {
        display: block;
    }

    .filter-modal-content {
        position: fixed;
        right: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: #fff;
        padding: 40px 20px 20px;
        overflow-y: auto;
    }

    /* Adjust for WordPress admin bar */
    .admin-bar .filter-modal-content {
        top: 32px;
        /* Standard admin bar height */
        height: calc(100% - 32px);
    }

    @media screen and (max-width: 782px) {
        .admin-bar .filter-modal-content {
            top: 46px;
            /* Mobile admin bar height */
            height: calc(100% - 46px);
        }
    }

    .close-modal {
        position: absolute;
        right: 0;
        top: 0;
        border: none;
        background: none;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1001;
    }
</style>

<button class="filter-button">
    <span class="filter-button-text">
        <?php esc_html_e('Filter', 'livecomplete'); ?>
    </span>
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 21V14M4 10V3M12 21V12M12 8V3M20 21V16M20 12V3M1 14H7M9 8H15M17 16H23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</button>

<div id="filter-modal" class="filter-modal">
    <div class="filter-modal-content">
        <button class="close-modal live-complete-navbar-close">
            <img src="<?php echo get_template_directory_uri() . '/assets/image/icon-close.svg'; ?>" alt="Close">
        </button>
        <div class="filter-modal-body">

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButton = document.querySelector('.filter-button');
        const filterModal = document.querySelector('.filter-modal');
        const closeModal = document.querySelector('.close-modal');
        const modalContent = document.querySelector('.filter-modal-content');
        const modalBody = document.querySelector('.filter-modal-body');
        
        const wcapfWidget = document.querySelector('.wcapf-form');
        if (!wcapfWidget) {
            console.log('WCAPF widget not found');
            return;
        }

        const originalParent = wcapfWidget.parentNode;
        let isMobile = window.innerWidth < 768;

        // Initially hide the filter button
        filterButton.style.display = 'none';

        function moveWidget() {
            if (!wcapfWidget || !modalBody || !originalParent) {
                console.log('Missing required elements for widget move');
                return;
            }

            if (window.innerWidth < 768) {
                if (wcapfWidget.parentNode !== modalBody) {
                    modalBody.appendChild(wcapfWidget);
                    filterButton.style.display = 'flex'; // Show button on mobile
                }
            } else {
                if (wcapfWidget.parentNode !== originalParent) {
                    originalParent.appendChild(wcapfWidget);
                    filterButton.style.display = 'none'; // Hide button on desktop
                }
            }
        }

        // Open modal
        filterButton.addEventListener('click', function(e) {
            e.stopPropagation();
            filterModal.classList.add('active');
            document.body.style.overflow = 'hidden';
            moveWidget();
        });

        // Close modal with close button
        closeModal.addEventListener('click', function(e) {
            e.stopPropagation();
            filterModal.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Close modal when clicking outside content
        filterModal.addEventListener('click', function(e) {
            if (!modalContent.contains(e.target)) {
                filterModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Prevent modal content clicks from closing modal, but only when clicking the container itself
        modalContent.addEventListener('click', function(e) {
            if (e.target === modalContent) {
                e.stopPropagation();
            }
        });

        // Move on resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                const wasMobile = isMobile;
                isMobile = window.innerWidth < 768;
                
                if (wasMobile !== isMobile) {
                    moveWidget();
                }
            }, 250);
        });

        // Initial move and button visibility
        moveWidget();
    });
</script>