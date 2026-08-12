<?php
/**
 * Required fallback template — blog index / any query WordPress can't match to
 * a more specific template file. This is a business/booking site first, so
 * this stays a simple, branded post list rather than a heavily designed blog.
 */

defined('ABSPATH') || exit;

get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php serenity_page_hero(is_home() ? __('Latest Updates', 'serenity') : get_the_archive_title()); ?>

        <section class="serenity-section">
            <div class="serenity-container">
                <?php if (have_posts()) : ?>
                    <div class="serenity-post-list">
                        <?php while (have_posts()) : the_post(); ?>
                            <article <?php post_class('serenity-post-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>" class="serenity-post-card-thumb"><?php the_post_thumbnail('medium_large'); ?></a>
                                <?php endif; ?>
                                <div class="serenity-post-card-body">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <p class="serenity-post-card-meta"><?php echo esc_html(get_the_date()); ?></p>
                                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="serenity-post-card-link"><?php esc_html_e('Read more', 'serenity'); ?> &rarr;</a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    <div class="serenity-pagination">
                        <?php the_posts_pagination(['prev_text' => __('&larr; Newer', 'serenity'), 'next_text' => __('Older &rarr;', 'serenity')]); ?>
                    </div>
                <?php else : ?>
                    <p class="serenity-empty-note"><?php esc_html_e('Nothing found here yet.', 'serenity'); ?></p>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>
<?php get_footer(); ?>
