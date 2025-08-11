<?php
if (!defined('ABSPATH')) { exit; }
get_header();

$archive_url = get_post_type_archive_link('property');

// Selected filters (sanitized for redisplay)
$sel_type     = isset($_GET['type']) ? sanitize_text_field(wp_unslash($_GET['type'])) : '';
$sel_location = isset($_GET['location']) ? sanitize_text_field(wp_unslash($_GET['location'])) : '';
$sel_min      = isset($_GET['min_price']) ? preg_replace('/\D+/', '', (string) $_GET['min_price']) : '';
$sel_max      = isset($_GET['max_price']) ? preg_replace('/\D+/', '', (string) $_GET['max_price']) : '';
$sel_beds     = isset($_GET['beds']) ? (int) $_GET['beds'] : 0;
$sel_baths    = isset($_GET['baths']) ? (int) $_GET['baths'] : 0;
$sel_s        = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';

// Terms for dropdowns
$types     = get_terms(['taxonomy' => 'property_type', 'hide_empty' => false]);
$locations = get_terms(['taxonomy' => 'property_location', 'hide_empty' => false]);
?>
<main class="rep-section">
    <h1 class="rep-section-title">Properties</h1>

    <form class="rep-filters" method="get" action="<?php echo esc_url($archive_url); ?>">
        <div class="rep-filters-row">
            <div class="rep-filter">
                <label for="rep-s">Search</label>
                <input type="text" id="rep-s" name="s" value="<?php echo esc_attr($sel_s); ?>" placeholder="Keywords" />
            </div>
            <div class="rep-filter">
                <label for="rep-type">Type</label>
                <select id="rep-type" name="type">
                    <option value="">Any</option>
                    <?php if (!is_wp_error($types)) : foreach ($types as $t): ?>
                        <option value="<?php echo esc_attr($t->slug); ?>" <?php selected($sel_type, $t->slug); ?>>
                            <?php echo esc_html($t->name); ?>
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            <div class="rep-filter">
                <label for="rep-location">Location</label>
                <select id="rep-location" name="location">
                    <option value="">Any</option>
                    <?php if (!is_wp_error($locations)) : foreach ($locations as $l): ?>
                        <option value="<?php echo esc_attr($l->slug); ?>" <?php selected($sel_location, $l->slug); ?>>
                            <?php echo esc_html($l->name); ?>
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
        </div>

        <div class="rep-filters-row">
            <div class="rep-filter">
                <label for="rep-min">Min Price</label>
                <input type="number" id="rep-min" name="min_price" min="0" step="1" value="<?php echo esc_attr($sel_min); ?>" placeholder="0" />
            </div>
            <div class="rep-filter">
                <label for="rep-max">Max Price</label>
                <input type="number" id="rep-max" name="max_price" min="0" step="1" value="<?php echo esc_attr($sel_max); ?>" placeholder="1000000" />
            </div>
            <div class="rep-filter">
                <label for="rep-beds">Beds (min)</label>
                <input type="number" id="rep-beds" name="beds" min="0" step="1" value="<?php echo esc_attr((string)$sel_beds); ?>" />
            </div>
            <div class="rep-filter">
                <label for="rep-baths">Baths (min)</label>
                <input type="number" id="rep-baths" name="baths" min="0" step="1" value="<?php echo esc_attr((string)$sel_baths); ?>" />
            </div>
        </div>

        <div class="rep-filters-actions">
            <button class="rep-button" type="submit">Filter</button>
            <a class="rep-button-outline" href="<?php echo esc_url($archive_url); ?>">Reset</a>
        </div>
    </form>

    <?php if (have_posts()): ?>
        <div class="rep-card-grid">
            <?php while (have_posts()): the_post(); ?>
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
            <?php endwhile; ?>
        </div>

        <div class="rep-pagination">
            <?php
            echo paginate_links([
                'total'   => $wp_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
            ]);
            ?>
        </div>
    <?php else: ?>
        <p>No properties found. Try adjusting your filters.</p>
    <?php endif; ?>
</main>
<?php
get_footer();
