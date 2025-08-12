<?php
if (!defined('ABSPATH')) { exit; }
get_header();
?>
    <main class="rep-section">
        <h1 class="rep-section-title"><?php echo esc_html__('Latest News', 'real-estate-portal'); ?></h1>

        <?php if (have_posts()): ?>
            <div class="rep-list">
                <?php while (have_posts()): the_post(); ?>
                    <article class="rep-news-item" id="news-<?php the_ID(); ?>" style="display:flex; gap:16px; align-items:flex-start;">
                        <div class="rep-news-media" style="flex:0 0 180px; max-width:180px;">
                            <a href="<?php the_permalink(); ?>" class="rep-card-thumb" style="display:block;">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('medium', ['style' => 'width:100%;height:auto;display:block;object-fit:cover;']);
                                } else {
                                    echo '<div class="rep-thumb-placeholder" style="background:#f5f5f5;color:#777;display:flex;align-items:center;justify-content:center;width:100%;height:120px;">' . esc_html__('No image', 'real-estate-portal') . '</div>';
                                }
                                ?>
                            </a>
                        </div>
                        <div class="rep-news-textwrap" style="flex:1 1 auto; min-width:0;">
                            <h3 class="rep-item-title" style="margin-top:0;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="rep-news-text" style="margin:0;">
                                <?php
                                $excerpt = get_the_excerpt();
                                if (!$excerpt) { $excerpt = wp_strip_all_tags(get_the_content('')); }
                                echo esc_html(mb_substr($excerpt, 0, 220)) . (mb_strlen($excerpt) > 220 ? '…' : '');
                                ?>
                            </p>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="rep-pagination">
                <?php
                global $wp_query;
                echo paginate_links([
                        'total'   => $wp_query->max_num_pages,
                        'current' => max(1, get_query_var('paged')),
                ]);
                ?>
            </div>
        <?php else: ?>
            <p><?php echo esc_html__('No news found.', 'real-estate-portal'); ?></p>
        <?php endif; ?>
    </main>
<?php
get_footer();