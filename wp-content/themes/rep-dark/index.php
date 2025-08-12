<?php
if (!defined('ABSPATH')) { exit; }
get_header();
?>
<main class="rep-section" role="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article <?php post_class('rep-card'); ?> id="post-<?php the_ID(); ?>">
            <h2 class="rep-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="rep-card-excerpt">
                <?php
                if (is_singular()) {
                    the_content();
                    wp_link_pages([
                        'before' => '<div class="page-links">',
                        'after'  => '</div>',
                    ]);
                } else {
                    the_excerpt();
                }
                ?>
            </div>
        </article>
    <?php endwhile; else : ?>
        <p><?php esc_html_e('No content found.', 'rep-dark'); ?></p>
    <?php endif; ?>
</main>
<?php get_footer();
