<?php
/**
 * Single blog post template.
 */

defined('ABSPATH') || exit;

get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php while (have_posts()) : the_post(); ?>
            <?php serenity_page_hero(get_the_title(), get_the_date()); ?>
            <section class="serenity-section">
                <div class="serenity-container serenity-page-content">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="serenity-page-thumb"><?php the_post_thumbnail('large'); ?></div>
                    <?php endif; ?>
                    <div class="serenity-prose">
                        <?php the_content(); ?>
                    </div>
                    <?php if (comments_open() || get_comments_number()) : comments_template(); endif; ?>
                </div>
            </section>
        <?php endwhile; ?>
    </main>
</div>
<?php get_footer(); ?>
