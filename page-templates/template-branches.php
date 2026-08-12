<?php
/**
 * Template Name: Locations
 *
 * Branch/location listing — pulls directly from the wc-service-booking
 * plugin's own branch settings (Settings::get_branches()), so adding a new
 * branch in the plugin's admin automatically shows up here too, with nothing
 * to keep in sync manually.
 */

defined('ABSPATH') || exit;

get_header();
$branches = serenity_get_branches();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php serenity_page_hero(get_the_title() ?: __('Our Locations', 'serenity'), __('Conveniently located branches, each with its own dedicated team.', 'serenity')); ?>

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

                <?php if (!empty($branches)) : ?>
                <div class="serenity-branch-list">
                    <?php foreach ($branches as $branch) : ?>
                    <div class="serenity-branch-card">
                        <div class="serenity-branch-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="serenity-branch-card-body">
                            <h3><?php echo esc_html($branch['name']); ?></h3>
                            <?php if (!empty($branch['description'])): ?>
                                <p><?php echo esc_html($branch['description']); ?></p>
                            <?php endif; ?>
                            <a class="serenity-branch-card-link" href="<?php echo esc_url(home_url('/services/')); ?>"><?php esc_html_e('Book at this location', 'serenity'); ?> &rarr;</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                    <p class="serenity-empty-note"><?php esc_html_e('Location details coming soon.', 'serenity'); ?></p>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>
<?php get_footer(); ?>
