<?php
/**
 * Template Name: Login
 *
 * Custom-branded, AJAX-driven login screen for staff/managers reaching their
 * own dashboard — see inc/login.php for the wp_signon()/retrieve_password()
 * handlers this form posts to. Deliberately its own page template (not the
 * homepage) since this is a public marketing site with a real homepage for
 * real visitors.
 */

defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html(sprintf(__('Sign In — %s', 'serenity'), get_bloginfo('name'))); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('serenity-login-body'); ?>>
<?php wp_body_open(); ?>

<div class="serenity-login-page">
    <div class="serenity-login-card">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="serenity-login-brand">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="serenity-login-mark" aria-hidden="true">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3c-3 3-6 6-6 10a6 6 0 0 0 12 0c0-4-3-7-6-10Z"/><path d="M12 8c-1.4 1.4-2.5 2.9-2.5 4.6a2.5 2.5 0 0 0 5 0C14.5 10.9 13.4 9.4 12 8Z"/></svg>
                </span>
            <?php endif; ?>
        </a>

        <h1 class="serenity-login-title"><?php esc_html_e('Welcome back', 'serenity'); ?></h1>
        <p class="serenity-login-subtitle"><?php esc_html_e('Sign in to manage your dashboard.', 'serenity'); ?></p>

        <div class="serenity-login-alert" id="serenity-login-alert" role="alert" style="display:none;"></div>

        <form id="serenity-login-form" class="serenity-login-form" autocomplete="on">
            <div class="serenity-form-field">
                <label for="serenity-login-username"><?php esc_html_e('Username or Email', 'serenity'); ?></label>
                <input type="text" id="serenity-login-username" name="username" autocomplete="username" required autofocus>
            </div>
            <div class="serenity-form-field">
                <label for="serenity-login-password"><?php esc_html_e('Password', 'serenity'); ?></label>
                <div class="serenity-pwd-field">
                    <input type="password" id="serenity-login-password" name="password" autocomplete="current-password" required>
                    <button type="button" class="serenity-pwd-toggle" data-target="serenity-login-password" aria-label="<?php esc_attr_e('Show password', 'serenity'); ?>">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <div class="serenity-login-row">
                <label class="serenity-login-remember">
                    <input type="checkbox" id="serenity-login-remember" name="remember">
                    <?php esc_html_e('Remember me', 'serenity'); ?>
                </label>
                <button type="button" class="serenity-login-forgot-link" id="serenity-login-forgot-trigger"><?php esc_html_e('Forgot password?', 'serenity'); ?></button>
            </div>
            <button type="submit" class="serenity-login-submit" id="serenity-login-submit">
                <span class="serenity-login-submit-text"><?php esc_html_e('Sign In', 'serenity'); ?></span>
                <span class="serenity-login-spinner" aria-hidden="true"></span>
            </button>
        </form>

        <form id="serenity-forgot-form" class="serenity-login-form" style="display:none;">
            <p class="serenity-login-subtitle" style="margin-bottom:18px;"><?php esc_html_e("Enter your username or email and we'll send you a reset link.", 'serenity'); ?></p>
            <div class="serenity-form-field">
                <label for="serenity-forgot-login"><?php esc_html_e('Username or Email', 'serenity'); ?></label>
                <input type="text" id="serenity-forgot-login" name="user_login" autocomplete="username" required>
            </div>
            <button type="submit" class="serenity-login-submit" id="serenity-forgot-submit">
                <span class="serenity-login-submit-text"><?php esc_html_e('Send Reset Link', 'serenity'); ?></span>
                <span class="serenity-login-spinner" aria-hidden="true"></span>
            </button>
            <button type="button" class="serenity-login-forgot-link" id="serenity-login-back-trigger" style="margin-top:14px;"><?php esc_html_e('&larr; Back to sign in', 'serenity'); ?></button>
        </form>

        <a href="<?php echo esc_url(home_url('/')); ?>" class="serenity-login-home-link">&larr; <?php esc_html_e('Back to website', 'serenity'); ?></a>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
