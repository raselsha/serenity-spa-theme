<?php
/**
 * Footer — closes #page (opened in header.php). Each template closes its own
 * #primary/#main before this loads, matching header.php's own contract.
 */

defined('ABSPATH') || exit;

$branches = serenity_get_branches();
?>
    <footer class="serenity-footer">
        <div class="serenity-container serenity-footer-grid">
            <div class="serenity-footer-col serenity-footer-brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="serenity-logo serenity-footer-logo">
                    <?php if (has_custom_logo()) : the_custom_logo(); else : ?>
                        <span class="serenity-logo-mark" aria-hidden="true">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3c-3 3-6 6-6 10a6 6 0 0 0 12 0c0-4-3-7-6-10Z"/><path d="M12 8c-1.4 1.4-2.5 2.9-2.5 4.6a2.5 2.5 0 0 0 5 0C14.5 10.9 13.4 9.4 12 8Z"/></svg>
                        </span>
                        <span class="serenity-logo-text"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
                <p class="serenity-footer-tagline">
                    <?php echo esc_html(get_bloginfo('description') ?: __('Restore your body, calm your mind — booked online in minutes.', 'serenity')); ?>
                </p>
                <div class="serenity-social-row">
                    <?php serenity_social_links(); ?>
                </div>
            </div>

            <div class="serenity-footer-col">
                <h4 class="serenity-footer-heading"><?php esc_html_e('Explore', 'serenity'); ?></h4>
                <?php if (has_nav_menu('footer')) : ?>
                    <?php wp_nav_menu(['theme_location' => 'footer', 'container' => false, 'menu_class' => 'serenity-footer-links', 'fallback_cb' => false]); ?>
                <?php else : ?>
                    <ul class="serenity-footer-links">
                        <li><a href="<?php echo esc_url(home_url('/services/')); ?>"><?php esc_html_e('Services', 'serenity'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/locations/')); ?>"><?php esc_html_e('Locations', 'serenity'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('About Us', 'serenity'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'serenity'); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="serenity-footer-col">
                <h4 class="serenity-footer-heading"><?php esc_html_e('Locations', 'serenity'); ?></h4>
                <?php if (!empty($branches)) : ?>
                    <ul class="serenity-footer-branches">
                        <?php foreach ($branches as $branch) : ?>
                            <li>
                                <strong><?php echo esc_html($branch['name']); ?></strong>
                                <?php if (!empty($branch['description'])): ?>
                                    <span><?php echo esc_html($branch['description']); ?></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="serenity-empty-note"><?php esc_html_e('Location details coming soon.', 'serenity'); ?></p>
                <?php endif; ?>
            </div>

            <div class="serenity-footer-col">
                <h4 class="serenity-footer-heading"><?php esc_html_e('Get in Touch', 'serenity'); ?></h4>
                <ul class="serenity-footer-contact">
                    <?php $phone = get_theme_mod('serenity_phone', ''); if ($phone): ?>
                        <li><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li>
                    <?php endif; ?>
                    <?php $email = get_theme_mod('serenity_email', ''); if ($email): ?>
                        <li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li>
                    <?php endif; ?>
                    <?php $hours = get_theme_mod('serenity_hours', ''); if ($hours): ?>
                        <li><?php echo esc_html($hours); ?></li>
                    <?php endif; ?>
                </ul>
                <?php if (is_active_sidebar('footer-widgets')) : ?>
                    <?php dynamic_sidebar('footer-widgets'); ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="serenity-footer-bottom">
            <div class="serenity-container serenity-footer-bottom-inner">
                <p>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'serenity'); ?></p>
                <p class="serenity-footer-credit"><?php esc_html_e('Powered by Serenity', 'serenity'); ?></p>
            </div>
        </div>
    </footer>

</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
