<?php
if (!defined('ABSPATH')) { exit; }
get_header();
?>
    <main class="rep-section">
        <h1 class="rep-section-title"><?php echo esc_html__('Properties', 'real-estate-portal'); ?></h1>

        <?php if (have_posts()): ?>
            <div class="rep-card-grid">
                <?php while (have_posts()): the_post(); ?>
                    <article class="rep-card" id="property-<?php the_ID(); ?>">
                        <a href="<?php the_permalink(); ?>" class="rep-card-thumb">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium_large');
                            } else {
                                echo '<div class="rep-thumb-placeholder">No image</div>';
                            }
                            ?>
                        </a>
                        <div class="rep-card-body">
                            <h3 class="rep-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="rep-card-excerpt">
                                <?php
                                $excerpt = get_the_excerpt();
                                if (!$excerpt) { $excerpt = wp_strip_all_tags(get_the_content('')); }
                                echo esc_html(mb_substr($excerpt, 0, 140)) . (mb_strlen($excerpt) > 140 ? '…' : '');
                                ?>
                            </p>
                            <a class="rep-button-outline" href="<?php the_permalink(); ?>"><?php echo esc_html__('View details', 'real-estate-portal'); ?></a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="rep-pagination">
                <?php
                global $wp_query;
                echo paginate_links([
                    'total'   => (int) $wp_query->max_num_pages,
                    'current' => max(1, (int) get_query_var('paged')),
                ]);
                ?>
            </div>
        <?php else: ?>
            <p><?php echo esc_html__('No properties found.', 'real-estate-portal'); ?></p>
        <?php endif; ?>
    </main>
<?php
get_footer();