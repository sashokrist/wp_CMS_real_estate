<?php
if (!defined('ABSPATH')) { exit; }
get_header();
?>
    <main class="rep-section">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article <?php post_class('rep-card'); ?>>
                <h1 class="rep-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <div class="rep-card-excerpt"><?php the_excerpt(); ?>BOB</div>
            </article>
        <article <?php post_class('rep-card'); ?>>
                <h1 class="rep-card-title">Jana is  a good dog</h1>
                <div class="rep-card-excerpt">She went to the park with Sasho</div>
            </article>
        <?php endwhile; else: ?>
            <p><?php esc_html_e('No content found.', 'rep-dark'); ?></p>
        <?php endif; ?>
    </main>
<?php get_footer();