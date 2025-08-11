<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Property meta fields: price, address, bedrooms, bathrooms, area
 */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'rep_property_details',
        'Property Details',
        'rep_render_property_meta_box',
        'property',
        'normal',
        'high'
    );
});

function rep_render_property_meta_box($post) {
    wp_nonce_field('rep_property_meta_nonce', 'rep_property_meta_nonce_field');

    $price    = get_post_meta($post->ID, '_rep_price', true);
    $address  = get_post_meta($post->ID, '_rep_address', true);
    $beds     = get_post_meta($post->ID, '_rep_bedrooms', true);
    $baths    = get_post_meta($post->ID, '_rep_bathrooms', true);
    $area     = get_post_meta($post->ID, '_rep_area', true);

    ?>
    <style>
        .rep-grid { display:grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap:12px; }
        .rep-grid label { display:block; font-weight:600; margin-bottom:6px; }
        .rep-grid input { width:100%; }
    </style>
    <div class="rep-grid">
        <div>
            <label for="rep_price">Price</label>
            <input type="text" id="rep_price" name="rep_price" value="<?php echo esc_attr($price); ?>" />
        </div>
        <div>
            <label for="rep_address">Address</label>
            <input type="text" id="rep_address" name="rep_address" value="<?php echo esc_attr($address); ?>" />
        </div>
        <div>
            <label for="rep_bedrooms">Bedrooms</label>
            <input type="number" id="rep_bedrooms" name="rep_bedrooms" value="<?php echo esc_attr($beds); ?>" min="0" />
        </div>
        <div>
            <label for="rep_bathrooms">Bathrooms</label>
            <input type="number" id="rep_bathrooms" name="rep_bathrooms" value="<?php echo esc_attr($baths); ?>" min="0" />
        </div>
        <div>
            <label for="rep_area">Area (sq ft)</label>
            <input type="number" id="rep_area" name="rep_area" value="<?php echo esc_attr($area); ?>" min="0" step="1" />
        </div>
    </div>
    <?php
}

add_action('save_post_property', function ($post_id) {
    if (!isset($_POST['rep_property_meta_nonce_field']) || !wp_verify_nonce($_POST['rep_property_meta_nonce_field'], 'rep_property_meta_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
    if (!current_user_can('edit_post', $post_id)) { return; }

    $map = [
        '_rep_price'     => 'rep_price',
        '_rep_address'   => 'rep_address',
        '_rep_bedrooms'  => 'rep_bedrooms',
        '_rep_bathrooms' => 'rep_bathrooms',
        '_rep_area'      => 'rep_area',
    ];
    foreach ($map as $meta_key => $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }
}, 10, 1);