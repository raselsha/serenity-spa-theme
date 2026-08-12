<?php
/**
 * Customizer settings — business contact details, homepage hero content, and
 * social links used by header.php/footer.php/front-page.php. Kept in the
 * Customizer (not hardcoded, not a separate options plugin) so a real site owner
 * can change them without editing theme files, matching how a real business would
 * actually use this theme day-to-day.
 */

defined('ABSPATH') || exit;

function serenity_customize_register($wp_customize) {
    // ===== Contact & Business Info =====
    $wp_customize->add_section('serenity_contact', [
        'title'    => __('Business Contact Info', 'serenity'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('serenity_phone', ['default' => '+351 21 000 0000', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('serenity_phone', ['label' => __('Phone Number', 'serenity'), 'section' => 'serenity_contact', 'type' => 'text']);

    $wp_customize->add_setting('serenity_email', ['default' => get_option('admin_email'), 'sanitize_callback' => 'sanitize_email']);
    $wp_customize->add_control('serenity_email', ['label' => __('Contact Email', 'serenity'), 'section' => 'serenity_contact', 'type' => 'email']);

    $wp_customize->add_setting('serenity_hours', ['default' => __('Mon – Sat: 10:00 – 21:00', 'serenity'), 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('serenity_hours', ['label' => __('Opening Hours (shown in footer)', 'serenity'), 'section' => 'serenity_contact', 'type' => 'text']);

    // ===== Social Links =====
    $wp_customize->add_section('serenity_social', [
        'title'    => __('Social Links', 'serenity'),
        'priority' => 31,
    ]);
    foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'whatsapp' => 'WhatsApp URL'] as $key => $label) {
        $wp_customize->add_setting("serenity_social_{$key}", ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
        $wp_customize->add_control("serenity_social_{$key}", ['label' => $label, 'section' => 'serenity_social', 'type' => 'url']);
    }

    // ===== Homepage Hero =====
    $wp_customize->add_section('serenity_hero', [
        'title'    => __('Homepage Hero', 'serenity'),
        'priority' => 32,
    ]);

    $wp_customize->add_setting('serenity_hero_eyebrow', ['default' => __('Welcome to', 'serenity'), 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('serenity_hero_eyebrow', ['label' => __('Eyebrow text', 'serenity'), 'section' => 'serenity_hero', 'type' => 'text']);

    $wp_customize->add_setting('serenity_hero_title', ['default' => __('Restore your body, calm your mind', 'serenity'), 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('serenity_hero_title', ['label' => __('Headline', 'serenity'), 'section' => 'serenity_hero', 'type' => 'text']);

    $wp_customize->add_setting('serenity_hero_subtitle', [
        'default' => __('Traditional Thai massage, modern spa therapies, and a dedicated team of licensed therapists — booked online in under a minute.', 'serenity'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('serenity_hero_subtitle', ['label' => __('Subheadline', 'serenity'), 'section' => 'serenity_hero', 'type' => 'textarea']);

    $wp_customize->add_setting('serenity_hero_image', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'serenity_hero_image', [
        'label'   => __('Hero Background Image', 'serenity'),
        'section' => 'serenity_hero',
    ]));
}
add_action('customize_register', 'serenity_customize_register');
