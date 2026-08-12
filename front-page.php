<?php
/**
 * Homepage — hero, services (via the plugin's own [wcsbm_services] shortcode),
 * how-it-works, locations, testimonials, final CTA.
 */

defined('ABSPATH') || exit;

get_header();

$hero_image = get_theme_mod('serenity_hero_image', '');
$branches   = serenity_get_branches();
?>

<main id="main" class="site-main serenity-home">

    <section class="serenity-hero" <?php if ($hero_image): ?>style="--serenity-hero-image: url('<?php echo esc_url($hero_image); ?>');"<?php endif; ?>>
        <div class="serenity-hero-overlay"></div>
        <div class="serenity-container serenity-hero-inner">
            <span class="serenity-eyebrow"><?php echo esc_html(get_theme_mod('serenity_hero_eyebrow', __('Welcome to', 'serenity'))); ?> <?php bloginfo('name'); ?></span>
            <h1 class="serenity-hero-title"><?php echo esc_html(get_theme_mod('serenity_hero_title', __('Restore your body, calm your mind', 'serenity'))); ?></h1>
            <p class="serenity-hero-subtitle"><?php echo esc_html(get_theme_mod('serenity_hero_subtitle', __('Traditional Thai massage, modern spa therapies, and a dedicated team of licensed therapists — booked online in under a minute.', 'serenity'))); ?></p>
            <div class="serenity-hero-actions">
                <a href="<?php echo esc_url(home_url('/services/')); ?>" class="serenity-btn serenity-btn-primary serenity-btn-lg"><?php esc_html_e('Book an Appointment', 'serenity'); ?></a>
                <a href="<?php echo esc_url(home_url('/about/')); ?>" class="serenity-btn serenity-btn-ghost serenity-btn-lg"><?php esc_html_e('Learn More', 'serenity'); ?></a>
            </div>
        </div>
    </section>

    <section class="serenity-features">
        <div class="serenity-container serenity-features-grid">
            <?php
            $features = [
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"/><path d="m16 8 2 2"/><path d="M15 15 9 9"/></svg>', 'title' => __('Licensed Therapists', 'serenity'), 'text' => __('Every treatment is performed by a certified, experienced therapist.', 'serenity')],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>', 'title' => __('Instant Online Booking', 'serenity'), 'text' => __('Pick a service, a time, and a therapist — confirmed in seconds.', 'serenity')],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>', 'title' => __('Multiple Locations', 'serenity'), 'text' => __('Conveniently located branches, each with its own dedicated team.', 'serenity')],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3c-3 3-6 6-6 10a6 6 0 0 0 12 0c0-4-3-7-6-10Z"/></svg>', 'title' => __('Premium Products', 'serenity'), 'text' => __('Natural oils and hot-stone treatments sourced for real results.', 'serenity')],
            ];
            foreach ($features as $f): ?>
            <div class="serenity-feature-card">
                <span class="serenity-feature-icon"><?php echo $f['icon']; ?></span>
                <h3><?php echo esc_html($f['title']); ?></h3>
                <p><?php echo esc_html($f['text']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="serenity-section serenity-services-section" id="services">
        <div class="serenity-container">
            <div class="serenity-section-head">
                <span class="serenity-section-eyebrow"><?php esc_html_e('Our Menu', 'serenity'); ?></span>
                <h2 class="serenity-section-title"><?php esc_html_e('Treatments &amp; Services', 'serenity'); ?></h2>
                <p class="serenity-section-subtitle"><?php esc_html_e('Choose from a full range of massage and spa experiences, each with flexible durations and transparent pricing.', 'serenity'); ?></p>
            </div>
            <?php serenity_render_services(6); ?>
            <div class="serenity-section-cta">
                <a href="<?php echo esc_url(home_url('/services/')); ?>" class="serenity-btn serenity-btn-outline"><?php esc_html_e('View All Services', 'serenity'); ?></a>
            </div>
        </div>
    </section>

    <section class="serenity-section serenity-how-section">
        <div class="serenity-container">
            <div class="serenity-section-head">
                <span class="serenity-section-eyebrow"><?php esc_html_e('Simple &amp; Fast', 'serenity'); ?></span>
                <h2 class="serenity-section-title"><?php esc_html_e('How Booking Works', 'serenity'); ?></h2>
            </div>
            <div class="serenity-steps">
                <?php
                $steps = [
                    ['num' => '01', 'title' => __('Choose a Service', 'serenity'), 'text' => __('Browse our treatments and pick the one that fits your mood.', 'serenity')],
                    ['num' => '02', 'title' => __('Pick a Time & Therapist', 'serenity'), 'text' => __('See live availability and choose whoever — and whenever — suits you.', 'serenity')],
                    ['num' => '03', 'title' => __('Relax', 'serenity'), 'text' => __("You're confirmed instantly. Just show up and unwind.", 'serenity')],
                ];
                foreach ($steps as $s): ?>
                <div class="serenity-step-card">
                    <span class="serenity-step-num"><?php echo esc_html($s['num']); ?></span>
                    <h3><?php echo esc_html($s['title']); ?></h3>
                    <p><?php echo esc_html($s['text']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if (!empty($branches)): ?>
    <section class="serenity-section serenity-locations-section" id="locations">
        <div class="serenity-container">
            <div class="serenity-section-head">
                <span class="serenity-section-eyebrow"><?php esc_html_e('Find Us', 'serenity'); ?></span>
                <h2 class="serenity-section-title"><?php esc_html_e('Our Locations', 'serenity'); ?></h2>
            </div>
            <div class="serenity-locations-grid">
                <?php foreach ($branches as $branch): ?>
                <div class="serenity-location-card">
                    <span class="serenity-location-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <h3><?php echo esc_html($branch['name']); ?></h3>
                    <?php if (!empty($branch['description'])): ?>
                        <p><?php echo esc_html($branch['description']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="serenity-section serenity-testimonials-section">
        <div class="serenity-container">
            <div class="serenity-section-head">
                <span class="serenity-section-eyebrow"><?php esc_html_e('Loved By Our Guests', 'serenity'); ?></span>
                <h2 class="serenity-section-title"><?php esc_html_e('What People Say', 'serenity'); ?></h2>
            </div>
            <div class="serenity-testimonials-grid">
                <?php
                $testimonials = [
                    ['text' => __('The Thai traditional massage was incredible — booking online took thirty seconds and I was seen right on time.', 'serenity'), 'name' => __('Marta S.', 'serenity'), 'role' => __('Regular guest', 'serenity')],
                    ['text' => __('Genuinely the most relaxing hour of my week. The therapists are attentive and the space feels like a real escape.', 'serenity'), 'name' => __('Henrique P.', 'serenity'), 'role' => __('First-time visitor', 'serenity')],
                    ['text' => __('I love that I can pick my favourite therapist every time. The whole experience feels effortless.', 'serenity'), 'name' => __('Ana L.', 'serenity'), 'role' => __('Monthly member', 'serenity')],
                ];
                foreach ($testimonials as $t): ?>
                <div class="serenity-testimonial-card">
                    <div class="serenity-testimonial-stars" aria-hidden="true">★★★★★</div>
                    <p class="serenity-testimonial-text">&ldquo;<?php echo esc_html($t['text']); ?>&rdquo;</p>
                    <div class="serenity-testimonial-author">
                        <span class="serenity-testimonial-name"><?php echo esc_html($t['name']); ?></span>
                        <span class="serenity-testimonial-role"><?php echo esc_html($t['role']); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="serenity-cta-banner">
        <div class="serenity-container serenity-cta-banner-inner">
            <h2><?php esc_html_e('Ready to feel your best?', 'serenity'); ?></h2>
            <p><?php esc_html_e('Book your appointment today and step into a moment of calm.', 'serenity'); ?></p>
            <a href="<?php echo esc_url(home_url('/services/')); ?>" class="serenity-btn serenity-btn-light serenity-btn-lg"><?php esc_html_e('Book Now', 'serenity'); ?></a>
        </div>
    </section>

</main>

<?php get_footer(); ?>
