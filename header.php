<?php
/**
 * Header — opens #page. Each template (front-page.php, page.php,
 * page-templates/*.php, and the wc-service-booking plugin's own single-product
 * template) opens/closes its own #primary/#main; footer.php closes #page.
 */

defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

    <a class="serenity-skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'serenity'); ?></a>

    <header class="serenity-header" id="serenity-header">
        <div class="serenity-container serenity-header-inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="serenity-logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <span class="serenity-logo-mark" aria-hidden="true">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3c-3 3-6 6-6 10a6 6 0 0 0 12 0c0-4-3-7-6-10Z"/><path d="M12 8c-1.4 1.4-2.5 2.9-2.5 4.6a2.5 2.5 0 0 0 5 0C14.5 10.9 13.4 9.4 12 8Z"/></svg>
                    </span>
                    <span class="serenity-logo-text">
                        <?php bloginfo('name'); ?>
                        <?php if (get_bloginfo('description')): ?>
                            <small><?php bloginfo('description'); ?></small>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            </a>

            <nav class="serenity-nav" id="serenity-nav" aria-label="<?php esc_attr_e('Primary', 'serenity'); ?>">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'serenity-nav-list',
                        'fallback_cb'    => false,
                    ]);
                } else {
                    echo '<ul class="serenity-nav-list">';
                    $fallback = [
                        home_url('/')          => __('Home', 'serenity'),
                        home_url('/services/') => __('Services', 'serenity'),
                        home_url('/locations/') => __('Locations', 'serenity'),
                        home_url('/about/')    => __('About', 'serenity'),
                        home_url('/contact/')  => __('Contact', 'serenity'),
                    ];
                    foreach ($fallback as $url => $label) {
                        echo '<li><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></li>';
                    }
                    echo '</ul>';
                }
                ?>
            </nav>

            <div class="serenity-header-actions">
                <?php $phone = get_theme_mod('serenity_phone', ''); ?>
                <?php if ($phone): ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="serenity-header-phone">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <?php echo esc_html($phone); ?>
                </a>
                <?php endif; ?>
                <?php if (get_theme_mod('serenity_header_cta_mode', 'book') === 'buy'): ?>
                    <?php
                    // Plugin-demo-site mode (Customizer: Header CTA Button) — this
                    // site is showcasing the wc-service-booking plugin itself, so the
                    // persistent top-nav CTA drives toward buying it (opens in a new
                    // tab) instead of opening the booking modal; the hero button below
                    // still demonstrates that modal regardless of this setting.
                    ?>
                    <a href="<?php echo esc_url(get_theme_mod('serenity_buy_now_url', 'https://lieusoft.com/')); ?>" class="serenity-btn serenity-btn-primary serenity-btn-sm" target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e('Buy Now', 'serenity'); ?>
                    </a>
                <?php else: ?>
                    <?php
                    // Real-spa-site mode (default) — wcsbm-trigger-modal is the
                    // wc-service-booking plugin's own global "open the booking modal,
                    // no service preselected" trigger (assets/script.js, bound on
                    // wp_body_open()'s modal markup which is injected on every page
                    // automatically). href stays a real URL so a no-JS visitor still
                    // lands somewhere useful instead of a dead link.
                    ?>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>" class="serenity-btn serenity-btn-primary serenity-btn-sm wcsbm-trigger-modal">
                        <?php esc_html_e('Book Now', 'serenity'); ?>
                    </a>
                <?php endif; ?>
                <button type="button" class="serenity-nav-toggle" id="serenity-nav-toggle" aria-expanded="false" aria-controls="serenity-nav">
                    <span></span><span></span><span></span>
                    <span class="screen-reader-text"><?php esc_html_e('Menu', 'serenity'); ?></span>
                </button>
            </div>
        </div>
    </header>
