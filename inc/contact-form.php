<?php
/**
 * Self-contained contact form handler — no external form plugin, matching this
 * project's "no build step / vanilla" convention elsewhere. Submits via
 * admin-post.php (same pattern the wc-service-booking plugin itself uses for its
 * own classic forms), redirects back to the contact page with a status flag
 * rather than returning JSON, since this is a plain full-page form, not an
 * AJAX-driven admin screen.
 */

defined('ABSPATH') || exit;

function serenity_handle_contact_form() {
    if (!isset($_POST['serenity_contact_nonce']) || !wp_verify_nonce($_POST['serenity_contact_nonce'], 'serenity_contact_form')) {
        wp_die(esc_html__('Security check failed. Please go back and try again.', 'serenity'));
    }

    // Honeypot — a real visitor never fills this (hidden via CSS), a bot
    // filling every field usually does. Silently "succeeds" so the bot doesn't
    // learn it was caught, without sending an email or hitting wp_mail() at all.
    if (!empty($_POST['serenity_contact_website'])) {
        wp_safe_redirect(add_query_arg('contact', 'sent', wp_get_referer() ?: home_url('/')));
        exit;
    }

    $name    = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $phone   = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));
    $redirect_to = wp_get_referer() ?: home_url('/');

    if ($name === '' || !is_email($email) || $message === '') {
        wp_safe_redirect(add_query_arg('contact', 'error', $redirect_to));
        exit;
    }

    $to      = get_option('admin_email');
    $subject = sprintf(/* translators: %s: sender name */ __('New contact message from %s', 'serenity'), $name);
    $body    = sprintf(
        "Name: %s\nEmail: %s\nPhone: %s\n\nMessage:\n%s",
        $name,
        $email,
        $phone ?: '—',
        $message
    );
    $headers = ['Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>'];

    $sent = wp_mail($to, $subject, $body, $headers);

    wp_safe_redirect(add_query_arg('contact', $sent ? 'sent' : 'error', $redirect_to));
    exit;
}
add_action('admin_post_serenity_contact_submit', 'serenity_handle_contact_form');
add_action('admin_post_nopriv_serenity_contact_submit', 'serenity_handle_contact_form');
