<?php
/**
 * Custom branded login — a dedicated "Login" page template
 * (page-templates/template-login.php) with AJAX authentication, plus a
 * matching restyle of the native wp-login.php as a fallback (password reset
 * emails link there, and it's the safety net if JS fails or someone bookmarks
 * the old URL). wp-login.php itself is never replaced — only its CSS/branding
 * is themed via the standard login_enqueue_scripts hook, exactly like a
 * "customize the WP login screen" plugin would.
 *
 * The homepage is deliberately NOT used as the login screen (unlike some
 * sibling internal-tool projects) — this is a public marketing site with a
 * real homepage for real visitors; login is for staff/managers reaching their
 * own dashboard, not the primary visitor flow.
 */

defined('ABSPATH') || exit;

define('SERENITY_LOGIN_SLUG', 'login');

// ===== AJAX: login =====
function serenity_ajax_login() {
    check_ajax_referer('serenity_login', 'nonce');

    $username = isset($_POST['username']) ? sanitize_user(wp_unslash($_POST['username'])) : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';
    $remember = !empty($_POST['remember']);

    if ($username === '' || $password === '') {
        wp_send_json_error(['message' => __('Please enter your username and password.', 'serenity')]);
    }

    $user = wp_signon([
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember,
    ], is_ssl());

    if (is_wp_error($user)) {
        // Deliberately generic — WordPress core's own error tells an attacker
        // whether the username or the password was wrong; this doesn't.
        wp_send_json_error(['message' => __('Incorrect username or password.', 'serenity')]);
    }

    wp_send_json_success(['redirect' => serenity_login_redirect_url($user)]);
}
add_action('wp_ajax_nopriv_serenity_login', 'serenity_ajax_login');

// ===== AJAX: forgot password =====
function serenity_ajax_forgot_password() {
    check_ajax_referer('serenity_login', 'nonce');

    $login = isset($_POST['user_login']) ? sanitize_text_field(wp_unslash($_POST['user_login'])) : '';
    if ($login !== '') {
        // Return value intentionally ignored — always show the same message
        // below regardless of whether it matched a real account, so this
        // can't be used to enumerate valid usernames/emails.
        $_POST['user_login'] = $login;
        retrieve_password();
    }

    wp_send_json_success([
        'message' => __("If an account matches, we've sent a password reset link.", 'serenity'),
    ]);
}
add_action('wp_ajax_nopriv_serenity_forgot_password', 'serenity_ajax_forgot_password');

// Where a successfully-logged-in visitor lands. Restricted dashboard roles
// (Store Manager / Branch Manager / Staff) go straight to their own plugin
// dashboard via the same helper the plugin's own login_redirect filter uses,
// so this always agrees with wp-admin's own post-login destination for them.
// Everyone else (a real administrator, or any future customer-account use)
// falls back to wp-admin.
function serenity_login_redirect_url($user) {
    if (class_exists('\WCSBM\Admin\ProfilePanel') && \WCSBM\Admin\ProfilePanel::is_restricted_dashboard_user($user->ID)) {
        return \WCSBM\Admin\ProfilePanel::restricted_user_home_url($user->ID);
    }
    return admin_url();
}

// ===== Page template support =====
function serenity_login_enqueue($hook) {
    if (!is_page_template('page-templates/template-login.php')) return;

    wp_enqueue_style('serenity-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Manrope:wght@400;500;600;700&display=swap', [], null);
    wp_enqueue_style('serenity-login', SERENITY_URI . '/assets/css/login.css', [], SERENITY_VERSION);
    wp_enqueue_script('serenity-login', SERENITY_URI . '/assets/js/login.js', [], SERENITY_VERSION, true);
    wp_localize_script('serenity-login', 'SerenityLogin', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('serenity_login'),
        'i18n'    => [
            'signingIn'   => __('Signing in…', 'serenity'),
            'sending'     => __('Sending…', 'serenity'),
            'genericError' => __('Something went wrong. Please try again.', 'serenity'),
        ],
    ]);
}
add_action('wp_enqueue_scripts', 'serenity_login_enqueue');

// A logged-in visitor doesn't need the login form again — send them straight
// to their own dashboard, same destination a fresh login would use.
function serenity_login_page_redirect_if_authed() {
    if (is_page_template('page-templates/template-login.php') && is_user_logged_in()) {
        wp_safe_redirect(serenity_login_redirect_url(wp_get_current_user()));
        exit;
    }
}
add_action('template_redirect', 'serenity_login_page_redirect_if_authed');

// ===== Native wp-login.php restyle (fallback only — password-reset emails
// link here, and it's the safety net if JS is unavailable) =====
function serenity_login_screen_styles() {
    wp_enqueue_style('serenity-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Manrope:wght@400;500;600;700&display=swap', [], null);
    wp_enqueue_style('serenity-login', SERENITY_URI . '/assets/css/login.css', [], SERENITY_VERSION);
    ?>
    <style>
        /* wp-login.php has its own markup this theme doesn't control — this
           block reskins it with the same tokens login.css defines for the
           custom page, instead of duplicating the whole recipe here. */
        body.login {
            background: var(--serenity-cream, #FBF7F2);
            font-family: var(--serenity-font-body, 'Manrope', sans-serif);
        }
        body.login #login { padding-top: 8vh; }
        .login h1 a {
            background-image: none;
            width: auto; height: auto;
            font-family: var(--serenity-font-display, 'Fraunces', serif);
            font-size: 26px; font-weight: 700;
            color: var(--serenity-ink, #2B2622);
            text-indent: 0;
        }
        body.login form {
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(43,38,34,.10), 0 2px 8px rgba(43,38,34,.04);
            border: 1px solid var(--serenity-border, #E8E1D3);
            padding: 30px 30px 26px;
        }
        body.login form .input,
        body.login input[type="text"],
        body.login input[type="password"] {
            border-radius: 13px; border: 1.5px solid var(--serenity-border, #E8E1D3);
            background: var(--serenity-cream, #FBF7F2); height: 44px; font-size: 14.5px;
        }
        body.login form .input:focus,
        body.login input:focus {
            border-color: var(--serenity-primary, #D4A373) !important;
            box-shadow: 0 0 0 3.5px rgba(212,163,115,.18) !important;
        }
        body.login .wp-core-ui .button-primary {
            background: var(--serenity-primary, #D4A373); border-color: var(--serenity-primary-dark, #B8895C);
            border-radius: 13px; height: 46px; font-weight: 700; font-size: 14.5px;
            box-shadow: none; text-shadow: none;
        }
        body.login .wp-core-ui .button-primary:hover { background: var(--serenity-primary-dark, #B8895C); }
        body.login #nav a, body.login #backtoblog a { color: var(--serenity-ink-soft, #4A4238); }
        body.login #nav a:hover, body.login #backtoblog a:hover { color: var(--serenity-primary-dark, #B8895C); }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'serenity_login_screen_styles');

add_filter('login_headerurl', function () { return home_url('/'); });
add_filter('login_headertext', function () { return get_bloginfo('name'); });
