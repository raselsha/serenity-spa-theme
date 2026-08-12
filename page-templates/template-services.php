<?php
/**
 * Template Name: Services
 *
 * Full services listing — embeds the wc-service-booking plugin's own
 * [wcsbm_services] shortcode (same card markup/booking wiring as the homepage's
 * preview section, just showing every published service instead of a limited
 * set).
 */

defined('ABSPATH') || exit;

get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php serenity_page_hero(get_the_title() ?: __('Our Services', 'serenity'), __('Every treatment, one place — pick a service and book in seconds.', 'serenity')); ?>

        <section class="serenity-section">
            <div class="serenity-container">
                <?php
                while (have_posts()) : the_post();
                    $content = get_the_content();
                    if (trim(wp_strip_all_tags($content)) !== '') {
                        echo '<div class="serenity-prose serenity-page-intro">' . apply_filters('the_content', $content) . '</div>';
                    }
                endwhile;
                ?>
                <?php serenity_render_services(-1); ?>
            </div>
        </section>
    </main>
</div>
<?php get_footer(); ?>
