<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Enqueue frontend assets when our shortcodes are used
 */
function rep_enqueue_frontend() {
    wp_enqueue_style('rep-style');
    wp_enqueue_script('rep-script');
}

/**
 * [rep_header title="Your Title" subtitle="Optional subtitle"]
 */
add_shortcode('rep_header', function ($atts) {
    rep_enqueue_frontend();

    $a = shortcode_atts([
        'title' => 'Welcome to Our Real Estate Portal',
        'subtitle' => 'Find properties, services, and latest news',
    ], $atts);

    ob_start();
    ?>
    <section class="rep-hero">
        <div class="rep-hero-inner">
            <h1><?php echo esc_html($a['title']); ?></h1>
            <?php if (!empty($a['subtitle'])): ?>
                <p class="rep-subtitle"><?php echo esc_html($a['subtitle']); ?></p>
            <?php endif; ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
});

/**
 * [rep_news limit="6"]
 */
add_shortcode('rep_news', function ($atts) {
    rep_enqueue_frontend();

    $a = shortcode_atts(['limit' => 6], $atts);
    $limit = max(1, (int)$a['limit']);

    $q = new WP_Query([
        'post_type' => 'news',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
    ]);

    ob_start();
    ?>
    <section class="rep-section">
        <h2 class="rep-section-title">Latest News</h2>
        <div class="rep-list">
            <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
                <article class="rep-news-item" id="news-<?php the_ID(); ?>">
                    <h3 class="rep-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="rep-news-excerpt" data-collapsed="true">
                        <?php
                        $content = get_the_excerpt();
                        if (!$content) { $content = wp_strip_all_tags(get_the_content('')); }
                        $short = mb_substr($content, 0, 300);
                        $needs_more = mb_strlen($content) > 300;
                        ?>
                        <p class="rep-news-text">
                            <?php echo esc_html($short); ?><?php echo $needs_more ? '…' : ''; ?>
                        </p>
                        <?php if ($needs_more): ?>
                            <div class="rep-news-more" style="display:none;">
                                <p><?php echo esc_html(mb_substr($content, 300)); ?></p>
                            </div>
                            <button class="rep-read-more" data-expanded="false">Read more</button>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p>No news found.</p>
            <?php endif; ?>
        </div>
        <div class="rep-view-all">
            <a class="rep-button" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">View all news</a>
        </div>
    </section>
    <?php
    return ob_get_clean();
});

/**
 * [rep_properties limit="6"]
 */
add_shortcode('rep_properties', function ($atts) {
    rep_enqueue_frontend();

    $a = shortcode_atts(['limit' => 6], $atts);
    $limit = max(1, (int)$a['limit']);

    $q = new WP_Query([
        'post_type' => 'property',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'no_found_rows' => true,
    ]);

    ob_start();
    ?>
    <section class="rep-section">
        <h2 class="rep-section-title">Latest Properties</h2>
        <div class="rep-card-grid">
            <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
                <article class="rep-card">
                    <a href="<?php the_permalink(); ?>" class="rep-card-thumb">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium_large');
                        } else {
                            echo '<div class="rep-thumb-placeholder">No image</div>';
                        } ?>
                    </a>
                    <div class="rep-card-body">
                        <h3 class="rep-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="rep-card-excerpt">
                            <?php
                            $excerpt = get_the_excerpt();
                            if (!$excerpt) { $excerpt = wp_strip_all_tags(get_the_content('')); }
                            echo esc_html(mb_substr($excerpt, 0, 140)) . (mb_strlen($excerpt) > 140 ? '…' : '');
                            ?>
                        </p>
                        <a class="rep-button-outline" href="<?php the_permalink(); ?>">View details</a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p>No properties found.</p>
            <?php endif; ?>
        </div>
        <div class="rep-view-all">
            <a class="rep-button" href="<?php echo esc_url(get_post_type_archive_link('property')); ?>">View all properties</a>
        </div>
    </section>
    <?php
    return ob_get_clean();
});

/**
 * [rep_services limit="6"]
 */
add_shortcode('rep_services', function ($atts) {
    rep_enqueue_frontend();

    $a = shortcode_atts(['limit' => 6], $atts);
    $limit = max(1, (int)$a['limit']);

    $q = new WP_Query([
        'post_type' => 'renovation_service',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'no_found_rows' => true,
    ]);

    ob_start();
    ?>
    <section class="rep-section">
        <h2 class="rep-section-title">Renovation Services</h2>
        <div class="rep-list">
            <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
                <article class="rep-news-item" id="service-<?php the_ID(); ?>">
                    <h3 class="rep-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="rep-news-excerpt" data-collapsed="true">
                        <?php
                        $content = get_the_excerpt();
                        if (!$content) { $content = wp_strip_all_tags(get_the_content('')); }
                        $short = mb_substr($content, 0, 300);
                        $needs_more = mb_strlen($content) > 300;
                        ?>
                        <p class="rep-news-text">
                            <?php echo esc_html($short); ?><?php echo $needs_more ? '…' : ''; ?>
                        </p>
                        <?php if ($needs_more): ?>
                            <div class="rep-news-more" style="display:none;">
                                <p><?php echo esc_html(mb_substr($content, 300)); ?></p>
                            </div>
                            <button class="rep-read-more" data-expanded="false">Read more</button>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p>No renovation services found.</p>
            <?php endif; ?>
        </div>
        <div class="rep-view-all">
            <a class="rep-button" href="<?php echo esc_url(get_post_type_archive_link('renovation_service')); ?>">View all services</a>
        </div>
    </section>
    <?php
    return ob_get_clean();
});