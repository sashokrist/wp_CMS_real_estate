<?php
if (!defined('ABSPATH')) { exit; }
get_header();

// Get Customizer values or fallbacks
$hero_title    = get_theme_mod('rep_hero_title', '');
$hero_subtitle = get_theme_mod('rep_hero_subtitle', '');
$grad_from     = get_theme_mod('rep_hero_grad_from', '#0e1520');
$grad_to       = get_theme_mod('rep_hero_grad_to', '#1a2a3f');

if ($hero_title === '') {
    $hero_title = get_bloginfo('name');
}
if ($hero_subtitle === '') {
    $hero_subtitle = get_bloginfo('description');
}

// Fetch 3 latest images from Media Library
$rep_slides = get_posts([
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'numberposts'    => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>
<section class="rep-hero" style="<?php echo esc_attr('background: linear-gradient(135deg, ' . $grad_from . ', ' . $grad_to . ');'); ?>">
    <div class="rep-hero-inner">
        <h1><?php echo esc_html($hero_title); ?></h1>
        <p class="rep-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
    </div>
</section>

<main>
    <?php if (!empty($rep_slides)): ?>
        <!-- Slideshow: 3 images from Media Library rotating every 3 seconds -->
        <section id="slideshow" class="rep-section rep-slideshow" aria-label="Featured slideshow">
            <div class="rep-slideshow-viewport">
                <?php foreach ($rep_slides as $i => $img_post):
                    $src = wp_get_attachment_image_url($img_post->ID, 'large');
                    if (!$src) { continue; }
                    $alt = get_post_meta($img_post->ID, '_wp_attachment_image_alt', true);
                    if ($alt === '') { $alt = get_the_title($img_post->ID); }
                    ?>
                    <img
                        class="rep-slide <?php echo $i === 0 ? 'is-active' : ''; ?>"
                        src="<?php echo esc_url($src); ?>"
                        alt="<?php echo esc_attr($alt ?: 'Slideshow image'); ?>"
                        loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>"
                    />
                <?php endforeach; ?>
            </div>
        </section>

        <style>
            .rep-slideshow-viewport {
                position: relative;
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                overflow: hidden;
                border-radius: 8px;
                aspect-ratio: 16 / 9;
                background: #e9eef5;
            }
            .rep-slideshow-viewport .rep-slide {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0;
                transition: opacity 600ms ease;
            }
            .rep-slideshow-viewport .rep-slide.is-active {
                opacity: 1;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var container = document.querySelector('.rep-slideshow-viewport');
                if (!container) return;

                var slides = container.querySelectorAll('.rep-slide');
                if (!slides.length) return;

                var index = 0;
                var intervalMs = 3000;

                slides.forEach(function (img, i) {
                    img.classList.toggle('is-active', i === 0);
                });

                setInterval(function () {
                    slides[index].classList.remove('is-active');
                    index = (index + 1) % slides.length;
                    slides[index].classList.add('is-active');
                }, intervalMs);
            });
        </script>
    <?php endif; ?>

    <section id="properties" class="rep-section">
        <h2 class="rep-section-title">Latest Properties</h2>
        <?php echo do_shortcode('[rep_properties limit="6"]'); ?>
    </section>

    <?php
    // Renovation Services: image on the right, text on the left
    $services_q = new WP_Query([
        'post_type'      => 'renovation_service',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ]);
    ?>
    <section id="services" class="rep-section">
        <h2 class="rep-section-title">Renovation Services</h2>

        <div class="rep-list">
            <?php if ($services_q->have_posts()): while ($services_q->have_posts()): $services_q->the_post(); ?>
                <?php
                // Prepare content excerpt
                $content = get_the_excerpt();
                if (!$content) { $content = wp_strip_all_tags(get_the_content('')); }
                $short = mb_substr($content, 0, 300);
                $needs_more = mb_strlen($content) > 300;
                ?>
                <article class="rep-news-item" id="service-<?php the_ID(); ?>" style="display:flex; gap:16px; align-items:flex-start;">
                    <div class="rep-service-text" style="flex:1 1 auto; min-width:0;">
                        <h3 class="rep-item-title" style="margin-top:0;">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="rep-news-excerpt" data-collapsed="true">
                            <p class="rep-news-text" style="margin:0;">
                                <?php echo esc_html($short); ?><?php echo $needs_more ? '…' : ''; ?>
                            </p>
                            <?php if ($needs_more): ?>
                                <div class="rep-news-more" style="display:none; margin-top:8px;">
                                    <p><?php echo esc_html(mb_substr($content, 300)); ?></p>
                                </div>
                                <button class="rep-read-more" data-expanded="false" style="margin-top:8px;">Read more</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="rep-service-media" style="flex:0 0 180px; max-width:180px; margin-left:auto;">
                        <a href="<?php the_permalink(); ?>" class="rep-card-thumb" style="display:block;">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium', ['style' => 'width:100%;height:auto;display:block;object-fit:cover;']);
                            } else {
                                echo '<div class="rep-thumb-placeholder" style="background:#f5f5f5;color:#777;display:flex;align-items:center;justify-content:center;width:100%;height:120px;">No image</div>';
                            }
                            ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p>No renovation services found.</p>
            <?php endif; ?>
        </div>

        <div class="rep-view-all" style="margin-top:16px; text-align:center;">
            <a class="rep-button" href="<?php echo esc_url(get_post_type_archive_link('renovation_service')); ?>">View all services</a>
        </div>
    </section>

    <?php
    // News: image on the left, text on the right
    $news_q = new WP_Query([
        'post_type'      => 'news',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'no_found_rows'  => true,
        'ignore_sticky_posts' => true,
    ]);
    ?>
    <section id="news" class="rep-section">
        <h2 class="rep-section-title">Latest News</h2>

        <div class="rep-list">
            <?php if ($news_q->have_posts()): while ($news_q->have_posts()): $news_q->the_post(); ?>
                <?php
                $content = get_the_excerpt();
                if (!$content) { $content = wp_strip_all_tags(get_the_content('')); }
                $short = mb_substr($content, 0, 300);
                $needs_more = mb_strlen($content) > 300;
                ?>
                <article class="rep-news-item" id="news-<?php the_ID(); ?>" style="display:flex; gap:16px; align-items:flex-start;">
                    <div class="rep-news-media" style="flex:0 0 180px; max-width:180px;">
                        <a href="<?php the_permalink(); ?>" class="rep-card-thumb" style="display:block;">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium', ['style' => 'width:100%;height:auto;display:block;object-fit:cover;']);
                            } else {
                                echo '<div class="rep-thumb-placeholder" style="background:#f5f5f5;color:#777;display:flex;align-items:center;justify-content:center;width:100%;height:120px;">No image</div>';
                            }
                            ?>
                        </a>
                    </div>

                    <div class="rep-news-textwrap" style="flex:1 1 auto; min-width:0;">
                        <h3 class="rep-item-title" style="margin-top:0;">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="rep-news-excerpt" data-collapsed="true">
                            <p class="rep-news-text" style="margin:0;">
                                <?php echo esc_html($short); ?><?php echo $needs_more ? '…' : ''; ?>
                            </p>
                            <?php if ($needs_more): ?>
                                <div class="rep-news-more" style="display:none; margin-top:8px;">
                                    <p><?php echo esc_html(mb_substr($content, 300)); ?></p>
                                </div>
                                <button class="rep-read-more" data-expanded="false" style="margin-top:8px;">Read more</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p>No news found.</p>
            <?php endif; ?>
        </div>

        <div class="rep-view-all" style="margin-top:16px; text-align:center;">
            <a class="rep-button" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">View all news</a>
        </div>
    </section>
    <section id="contact" class="rep-section">
       <h1>Contact Us</h1>
        <?php
        echo do_shortcode('[forminator_form id="139"]');
        ?>
    </section>

</main>

<?php
get_footer();