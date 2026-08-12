<?php
/**
 * Small helpers shared across templates — kept here instead of duplicated in
 * each template file (front-page.php, page-templates/*.php all need the branch
 * list and the page-hero banner markup).
 */

defined('ABSPATH') || exit;

// True when the wc-service-booking plugin is active — every helper that reads
// its data (branches, services) checks this first so the theme degrades
// gracefully (shows nothing, not a fatal error) if it's ever deactivated.
function serenity_booking_plugin_active() {
    return class_exists('\WCSBM\Admin\Settings');
}

// Branch list as ['key' => ['name' => ..., 'description' => ...]], or empty
// array if the plugin isn't active — used by the homepage's "Our Locations"
// section and the Branches page template.
function serenity_get_branches() {
    if (!serenity_booking_plugin_active()) return [];
    return \WCSBM\Admin\Settings::get_branches();
}

// Renders the plugin's own service grid via its existing shortcode rather than
// re-querying/re-rendering service_booking products here — keeps the card
// markup, pricing, and "Book Now" wiring (assets/script.js against
// .wcsbm-book-now-btn) as the single source of truth instead of a second,
// possibly-diverging copy in this theme.
function serenity_render_services($limit = -1) {
    if (!serenity_booking_plugin_active()) {
        echo '<p class="serenity-empty-note">' . esc_html__('Services will appear here once the booking plugin is active.', 'serenity') . '</p>';
        return;
    }
    echo do_shortcode('[wcsbm_services limit="' . (int) $limit . '"]');
}

// Consistent inner-page banner (title + optional subtitle over a tinted
// background) — used by page.php and every page-templates/*.php file so
// About/Contact/Branches/Services all share one visual treatment instead of
// each template rolling its own header block.
function serenity_page_hero($title, $subtitle = '') {
    ?>
    <section class="serenity-page-hero">
        <div class="serenity-container">
            <h1 class="serenity-page-hero-title"><?php echo esc_html($title); ?></h1>
            <?php if ($subtitle): ?>
                <p class="serenity-page-hero-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

// Social icon links row (header/footer) — only renders icons whose Customizer
// URL was actually filled in, so an unconfigured site doesn't show three
// dead links to nowhere.
function serenity_social_links() {
    $links = [
        'facebook'  => ['url' => get_theme_mod('serenity_social_facebook', ''), 'label' => 'Facebook'],
        'instagram' => ['url' => get_theme_mod('serenity_social_instagram', ''), 'label' => 'Instagram'],
        'whatsapp'  => ['url' => get_theme_mod('serenity_social_whatsapp', ''), 'label' => 'WhatsApp'],
    ];
    $icons = [
        'facebook'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.23.2 2.23.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.89h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94Z"/></svg>',
        'instagram' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>',
        'whatsapp'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.28-1.38a9.9 9.9 0 0 0 4.76 1.21h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2Zm5.8 14.06c-.24.68-1.4 1.32-1.93 1.36-.5.05-1 .24-3.4-.8-2.87-1.24-4.7-4.16-4.85-4.35-.14-.2-1.16-1.54-1.16-2.94 0-1.4.73-2.08.99-2.37.27-.28.58-.35.78-.35.2 0 .4.002.57.01.18.008.43-.07.67.51.25.6.85 2.07.92 2.22.07.15.12.33.02.53-.1.2-.15.32-.3.5-.15.17-.31.39-.44.52-.15.15-.3.31-.13.6.17.29.76 1.25 1.63 2.02 1.12.99 2.06 1.3 2.35 1.45.29.15.46.13.63-.08.17-.2.72-.84.92-1.13.2-.29.4-.24.66-.15.27.1 1.72.81 2.01.96.29.15.49.22.56.34.07.13.07.75-.17 1.43Z"/></svg>',
    ];
    foreach ($links as $key => $link) {
        if (empty($link['url'])) continue;
        printf(
            '<a class="serenity-social-link" href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a>',
            esc_url($link['url']),
            esc_attr($link['label']),
            $icons[$key]
        );
    }
}
