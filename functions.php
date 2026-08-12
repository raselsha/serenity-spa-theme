<?php
/**
 * Serenity theme setup.
 */

defined('ABSPATH') || exit;

define('SERENITY_VERSION', '1.0.0');
define('SERENITY_DIR', get_template_directory());
define('SERENITY_URI', get_template_directory_uri());

// ===== Theme support =====
function serenity_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');

    // WooCommerce — required so the wc-service-booking plugin's own single-product
    // template (get_header('shop')/get_footer('shop'), which falls back to this
    // theme's plain header.php/footer.php) and the default shop/archive markup both
    // render inside this theme's page chrome instead of a bare, unstyled fallback.
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus([
        'primary' => __('Primary Menu', 'serenity'),
        'footer'  => __('Footer Menu', 'serenity'),
    ]);
}
add_action('after_setup_theme', 'serenity_setup');

// ===== Assets =====
function serenity_enqueue_assets() {
    wp_enqueue_style('serenity-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Manrope:wght@400;500;600;700;800&display=swap', [], null);
    wp_enqueue_style('serenity-main', SERENITY_URI . '/assets/css/main.css', [], SERENITY_VERSION);
    wp_enqueue_script('serenity-main', SERENITY_URI . '/assets/js/main.js', [], SERENITY_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'serenity_enqueue_assets');

// ===== Widget areas (footer) =====
function serenity_widgets_init() {
    register_sidebar([
        'name'          => __('Footer', 'serenity'),
        'id'            => 'footer-widgets',
        'before_widget' => '<div class="serenity-footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="serenity-footer-widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'serenity_widgets_init');

// ===== WooCommerce wrapper integration =====
// Standard WooCommerce theme-integration hooks: WC's own template parts
// (archive-product.php, single-product.php content, etc.) call these instead of
// assuming any particular theme markup, so a theme has to supply matching
// open/close wrappers. Needed both for the default /shop/ archive (kept as a
// working fallback even though the "Services" page template is the primary way
// visitors browse services) and because it keeps WooCommerce's own hook-based
// rendering consistent with this theme's #primary/#main structure used
// everywhere else (header.php/footer.php, page.php, front-page.php).
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'serenity_wc_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'serenity_wc_wrapper_end', 10);
function serenity_wc_wrapper_start() {
    echo '<div id="primary" class="content-area serenity-shop-wrap"><main id="main" class="site-main" role="main">';
}
function serenity_wc_wrapper_end() {
    echo '</main></div>';
}

// Default WooCommerce sidebar (product filters/categories widget area) isn't part
// of this theme's design — the dedicated "Services" page template
// ([wcsbm_services] shortcode, full-width grid) is the intended browsing
// experience, so the sidebar hook is left unregistered rather than styled.
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Simplify the default shop loop's per-product markup — this theme doesn't use
// WooCommerce's own add-to-cart button/price/rating template parts on the
// archive (service_booking products are always "Book Now", handled by the
// plugin's own script.js against .wcsbm-book-now-btn elsewhere), so remove the
// pieces that would otherwise show a mismatched native "Add to cart" link only
// on this one fallback page.
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

// ===== Customizer: business details used in the header/footer/homepage =====
require SERENITY_DIR . '/inc/customizer.php';

// ===== Contact page form handler =====
require SERENITY_DIR . '/inc/contact-form.php';

// ===== Small template helpers shared across templates =====
require SERENITY_DIR . '/inc/template-helpers.php';
