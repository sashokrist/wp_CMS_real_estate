<?php
if (!defined('ABSPATH')) { exit; }

add_action('init', function () {

    // Property
    register_post_type('property', [
        'labels' => [
            'name' => 'Properties',
            'singular_name' => 'Property',
            'add_new_item' => 'Add New Property',
            'edit_item' => 'Edit Property',
            'new_item' => 'New Property',
            'view_item' => 'View Property',
            'search_items' => 'Search Properties',
            'not_found' => 'No properties found',
        ],
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-building',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'properties'],
    ]);

    // Ensure featured image box appears even if theme doesn't declare support.
    add_post_type_support('property', 'thumbnail');

    // Renovation Service
    register_post_type('renovation_service', [
        'labels' => [
            'name' => 'Renovation Services',
            'singular_name' => 'Renovation Service',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
            'new_item' => 'New Service',
            'view_item' => 'View Service',
            'search_items' => 'Search Services',
            'not_found' => 'No services found',
        ],
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-hammer',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'services'],
    ]);

    // News
    register_post_type('news', [
        'labels' => [
            'name' => 'News',
            'singular_name' => 'News',
            'add_new_item' => 'Add News',
            'edit_item' => 'Edit News',
            'new_item' => 'New News',
            'view_item' => 'View News',
            'search_items' => 'Search News',
            'not_found' => 'No news found',
        ],
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'news'],
    ]);

    // Taxonomy: Location
    register_taxonomy('property_location', ['property'], [
        'labels' => [
            'name' => 'Locations',
            'singular_name' => 'Location',
            'search_items' => 'Search Locations',
            'all_items' => 'All Locations',
            'edit_item' => 'Edit Location',
            'update_item' => 'Update Location',
            'add_new_item' => 'Add New Location',
            'new_item_name' => 'New Location',
            'menu_name' => 'Locations',
        ],
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_quick_edit' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'location'],
        'show_admin_column' => true,
    ]);
});