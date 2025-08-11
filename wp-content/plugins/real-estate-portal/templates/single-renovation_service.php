<?php
if (!defined('ABSPATH')) { exit; }
get_header();

while (have_posts()): the_post(); ?>
    <main class="rep-single">
        <article class="rep-single-article">
            <header class="rep-single-header">
                <h1><?php the_title(); ?></h1>
                <?php if (has_post_thumbnail()): ?>
                    <div class="rep-single-hero"><?php the_post_thumbnail('large'); ?></div>
                <?php endif; ?>
            </header>
            <section class="rep-content">
                <?php the_content(); ?>
            </section>
        </article>
    </main>
<?php
endwhile;
get_footer();