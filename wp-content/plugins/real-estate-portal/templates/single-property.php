<?php
if (!defined('ABSPATH')) { exit; }
get_header();

while (have_posts()): the_post();
    $price   = get_post_meta(get_the_ID(), '_rep_price', true);
    $address = get_post_meta(get_the_ID(), '_rep_address', true);
    $beds    = get_post_meta(get_the_ID(), '_rep_bedrooms', true);
    $baths   = get_post_meta(get_the_ID(), '_rep_bathrooms', true);
    $area    = get_post_meta(get_the_ID(), '_rep_area', true);
    ?>
    <main class="rep-single">
        <article class="rep-single-article">
            <header class="rep-single-header">
                <h1><?php the_title(); ?></h1>
                <?php if (has_post_thumbnail()): ?>
                    <div class="rep-single-hero"><?php the_post_thumbnail('large'); ?></div>
                <?php endif; ?>
            </header>

            <section class="rep-property-details">
                <ul class="rep-prop-specs">
                    <?php if ($price !== ''): ?><li><strong>Price:</strong> <?php echo esc_html($price); ?></li><?php endif; ?>
                    <?php if ($address !== ''): ?><li><strong>Address:</strong> <?php echo esc_html($address); ?></li><?php endif; ?>
                    <?php if ($beds !== ''): ?><li><strong>Bedrooms:</strong> <?php echo esc_html($beds); ?></li><?php endif; ?>
                    <?php if ($baths !== ''): ?><li><strong>Bathrooms:</strong> <?php echo esc_html($baths); ?></li><?php endif; ?>
                    <?php if ($area !== ''): ?><li><strong>Area:</strong> <?php echo esc_html($area); ?> sq ft</li><?php endif; ?>
                </ul>
            </section>

            <section class="rep-content">
                <?php the_content(); ?>
            </section>
        </article>
    </main>
<?php
endwhile;
get_footer();