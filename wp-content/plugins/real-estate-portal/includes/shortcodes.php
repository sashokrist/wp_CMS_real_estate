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
 * [rep_create_page title="My Page" content="Hello" status="draft" template="templates/landing.php" parent="0" menu_order="0"]
 *
 * Creates a new Page (not a Post).
 */
add_shortcode('rep_create_page', function ($atts) {
    // Optional: enqueue assets only if your UI needs them.
    // rep_enqueue_frontend();

    // Attributes and sanitization
    $atts = shortcode_atts([
        'title'      => '',
        'content'    => '',
        'status'     => 'draft', // allowed: draft|publish|pending
        'template'   => '',      // e.g. templates/landing.php
        'parent'     => '0',     // parent page ID
        'menu_order' => '0',
    ], $atts, 'rep_create_page');

    $title       = sanitize_text_field($atts['title']);
    $content_raw = (string) $atts['content'];
    $content     = wp_kses_post($content_raw);
    $status      = in_array($atts['status'], ['draft', 'publish', 'pending'], true) ? $atts['status'] : 'draft';
    $parent_id   = (int) $atts['parent'];
    $menu_order  = (int) $atts['menu_order'];
    $template    = $atts['template'] ? sanitize_text_field($atts['template']) : '';

    // Basic checks
    if ($title === '') {
        return esc_html__('Missing title.', 'real-estate-portal');
    }
    if (!is_user_logged_in() || !current_user_can('publish_pages')) {
        return esc_html__('You do not have permission to create pages.', 'real-estate-portal');
    }

    // Build the page array
    $pagearr = [
        'post_type'    => 'page',
        'post_status'  => $status,
        'post_title'   => $title,
        'post_content' => $content,
        'post_author'  => get_current_user_id(),
        'post_parent'  => $parent_id,
        'menu_order'   => $menu_order,
    ];

    // Insert the page
    $page_id = wp_insert_post(wp_slash($pagearr), true);

    if (is_wp_error($page_id)) {
        return esc_html($page_id->get_error_message());
    }

    // Optional: set the page template
    if ($template !== '') {
        update_post_meta($page_id, '_wp_page_template', $template);
    }

    // Build response
    $link = get_permalink($page_id);
    if ($link) {
        $title_out = esc_html(get_the_title($page_id));
        $url_out   = esc_url($link);

        return sprintf(
            /* translators: 1: page title, 2: URL */
            esc_html__('Page "%1$s" created. View: %2$s', 'real-estate-portal'),
            $title_out,
            sprintf('<a href="%s">%s</a>', $url_out, $url_out)
        );
    }

    return esc_html__('Page created.', 'real-estate-portal');
});

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
                <p><?php echo esc_html__('No news found.', 'real-estate-portal'); ?></p>
            <?php endif; ?>
        </div>
        <div class="rep-view-all">
            <a class="rep-button" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>"><?php echo esc_html__('View all news', 'real-estate-portal'); ?></a>
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
<!--        <h2 class="rep-section-title">Latest Properties</h2>-->
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
                        <a class="rep-button-outline" href="<?php the_permalink(); ?>"><?php echo esc_html__('View details', 'real-estate-portal'); ?></a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p><?php echo esc_html__('No properties found.', 'real-estate-portal'); ?></p>
            <?php endif; ?>
        </div>
        <div class="rep-view-all">
            <a class="rep-button" href="<?php echo esc_url(get_post_type_archive_link('property')); ?>"><?php echo esc_html__('View all properties', 'real-estate-portal'); ?></a>
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
                <p><?php echo esc_html__('No renovation services found.', 'real-estate-portal'); ?></p>
            <?php endif; ?>
        </div>
        <div class="rep-view-all">
            <a class="rep-button" href="<?php echo esc_url(get_post_type_archive_link('renovation_service')); ?>"><?php echo esc_html__('View all services', 'real-estate-portal'); ?></a>
        </div>
    </section>
    <?php
    return ob_get_clean();
});