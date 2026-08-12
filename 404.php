<?php
defined('ABSPATH') || exit;

get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="serenity-section serenity-404">
            <div class="serenity-container serenity-404-inner">
                <span class="serenity-404-mark" aria-hidden="true">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M12 3c-3 3-6 6-6 10a6 6 0 0 0 12 0c0-4-3-7-6-10Z"/></svg>
                </span>
                <h1><?php esc_html_e('Page Not Found', 'serenity'); ?></h1>
                <p><?php esc_html_e("The page you're looking for has drifted away. Let's get you back to something relaxing.", 'serenity'); ?></p>
                <div class="serenity-404-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="serenity-btn serenity-btn-primary"><?php esc_html_e('Back to Home', 'serenity'); ?></a>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>" class="serenity-btn serenity-btn-outline"><?php esc_html_e('Browse Services', 'serenity'); ?></a>
                </div>
            </div>
        </section>
    </main>
</div>
<?php get_footer(); ?>
