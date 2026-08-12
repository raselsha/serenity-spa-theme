<?php
/**
 * Template Name: Contact
 *
 * Contact page — branch/contact details (from the plugin's own branch
 * settings + this theme's Customizer contact fields) alongside a
 * self-contained contact form (inc/contact-form.php).
 */

defined('ABSPATH') || exit;

get_header();
$branches = serenity_get_branches();
$status   = isset($_GET['contact']) ? sanitize_key($_GET['contact']) : '';
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php serenity_page_hero(get_the_title() ?: __('Contact Us', 'serenity'), __("We'd love to hear from you — reach out any time.", 'serenity')); ?>

        <section class="serenity-section">
            <div class="serenity-container serenity-contact-layout">
                <div class="serenity-contact-info">
                    <?php
                    while (have_posts()) : the_post();
                        $content = get_the_content();
                        if (trim(wp_strip_all_tags($content)) !== '') {
                            echo '<div class="serenity-prose serenity-page-intro">' . apply_filters('the_content', $content) . '</div>';
                        }
                    endwhile;
                    ?>

                    <ul class="serenity-contact-details">
                        <?php $phone = get_theme_mod('serenity_phone', ''); if ($phone): ?>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php $email = get_theme_mod('serenity_email', ''); if ($email): ?>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16v16H4z" opacity="0"/><path d="m3 6 9 6 9-6"/><rect x="3" y="5" width="18" height="14" rx="2"/></svg>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php $hours = get_theme_mod('serenity_hours', ''); if ($hours): ?>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                            <?php echo esc_html($hours); ?>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <?php if (!empty($branches)) : ?>
                    <div class="serenity-contact-branches">
                        <h3><?php esc_html_e('Our Locations', 'serenity'); ?></h3>
                        <?php foreach ($branches as $branch) : ?>
                        <div class="serenity-contact-branch">
                            <strong><?php echo esc_html($branch['name']); ?></strong>
                            <?php if (!empty($branch['description'])): ?><span><?php echo esc_html($branch['description']); ?></span><?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="serenity-social-row serenity-contact-social">
                        <?php serenity_social_links(); ?>
                    </div>
                </div>

                <div class="serenity-contact-form-wrap">
                    <?php if ($status === 'sent') : ?>
                        <div class="serenity-form-notice serenity-form-notice-success">
                            <?php esc_html_e("Thanks — your message has been sent. We'll get back to you shortly.", 'serenity'); ?>
                        </div>
                    <?php elseif ($status === 'error') : ?>
                        <div class="serenity-form-notice serenity-form-notice-error">
                            <?php esc_html_e('Something went wrong — please check the fields and try again.', 'serenity'); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="serenity-contact-form">
                        <input type="hidden" name="action" value="serenity_contact_submit">
                        <?php wp_nonce_field('serenity_contact_form', 'serenity_contact_nonce'); ?>
                        <div class="serenity-form-honeypot" aria-hidden="true">
                            <label for="serenity_contact_website"><?php esc_html_e('Website', 'serenity'); ?></label>
                            <input type="text" id="serenity_contact_website" name="serenity_contact_website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="serenity-form-row-duo">
                            <div class="serenity-form-field">
                                <label for="serenity-contact-name"><?php esc_html_e('Name', 'serenity'); ?></label>
                                <input type="text" id="serenity-contact-name" name="name" required>
                            </div>
                            <div class="serenity-form-field">
                                <label for="serenity-contact-phone"><?php esc_html_e('Phone', 'serenity'); ?></label>
                                <input type="tel" id="serenity-contact-phone" name="phone">
                            </div>
                        </div>
                        <div class="serenity-form-field">
                            <label for="serenity-contact-email"><?php esc_html_e('Email', 'serenity'); ?></label>
                            <input type="email" id="serenity-contact-email" name="email" required>
                        </div>
                        <div class="serenity-form-field">
                            <label for="serenity-contact-message"><?php esc_html_e('Message', 'serenity'); ?></label>
                            <textarea id="serenity-contact-message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="serenity-btn serenity-btn-primary serenity-btn-lg serenity-form-submit"><?php esc_html_e('Send Message', 'serenity'); ?></button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>
<?php get_footer(); ?>
