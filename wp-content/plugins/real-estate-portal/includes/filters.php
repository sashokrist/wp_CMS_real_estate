<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Filters for the Properties archive via GET params.
 * Supported:
 * - s: search term
 * - type: property_type term slug
 * - location: property_location term slug
 * - min_price, max_price: integers
 * - beds, baths: integers (>=)
 */
add_action('pre_get_posts', function ($q) {
    if (is_admin() || !$q->is_main_query()) { return; }

    if ($q->is_post_type_archive('property')) {
        $tax_query = [];
        $meta_query = [];

        // Taxonomies
        $type = isset($_GET['type']) ? sanitize_text_field(wp_unslash($_GET['type'])) : '';
        if ($type !== '') {
            $tax_query[] = [
                'taxonomy' => 'property_type',
                'field'    => 'slug',
                'terms'    => $type,
            ];
        }

        $location = isset($_GET['location']) ? sanitize_text_field(wp_unslash($_GET['location'])) : '';
        if ($location !== '') {
            $tax_query[] = [
                'taxonomy' => 'property_location',
                'field'    => 'slug',
                'terms'    => $location,
            ];
        }

        if (!empty($tax_query)) {
            $q->set('tax_query', $tax_query);
        }

        // Numeric meta filters
        $min_price = isset($_GET['min_price']) ? preg_replace('/\D+/', '', (string) $_GET['min_price']) : '';
        $max_price = isset($_GET['max_price']) ? preg_replace('/\D+/', '', (string) $_GET['max_price']) : '';
        $beds      = isset($_GET['beds']) ? (int) $_GET['beds'] : 0;
        $baths     = isset($_GET['baths']) ? (int) $_GET['baths'] : 0;

        if ($min_price !== '') {
            $meta_query[] = [
                'key'     => '_rep_price',
                'value'   => (int) $min_price,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            ];
        }
        if ($max_price !== '') {
            $meta_query[] = [
                'key'     => '_rep_price',
                'value'   => (int) $max_price,
                'type'    => 'NUMERIC',
                'compare' => '<=',
            ];
        }
        if ($beds > 0) {
            $meta_query[] = [
                'key'     => '_rep_bedrooms',
                'value'   => $beds,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            ];
        }
        if ($baths > 0) {
            $meta_query[] = [
                'key'     => '_rep_bathrooms',
                'value'   => $baths,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            ];
        }

        if (!empty($meta_query)) {
            $q->set('meta_query', $meta_query);
        }
    }
});