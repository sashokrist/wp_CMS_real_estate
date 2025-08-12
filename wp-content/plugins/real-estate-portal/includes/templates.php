<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Use plugin single templates for property, renovation_service, news if theme does not provide them.
 */
add_filter('single_template', function ($single) {
    global $post;
    if (!$post) {
        return $single;
    }
    if ($post->post_type === 'property') {
        $tpl = REP_PLUGIN_DIR . 'templates/single-property.php';
        if (file_exists($tpl)) { return $tpl; }
    }
    if ($post->post_type === 'renovation_service') {
        $tpl = REP_PLUGIN_DIR . 'templates/single-renovation_service.php';
        if (file_exists($tpl)) { return $tpl; }
    }
    if ($post->post_type === 'news') {
        $tpl = REP_PLUGIN_DIR . 'templates/single-news.php';
        if (file_exists($tpl)) { return $tpl; }
    }
    return $single;
});

/**
 * Provide archive templates if theme doesn't.
 */
add_filter('archive_template', function ($archive) {
    if (is_post_type_archive('property')) {
        $tpl = REP_PLUGIN_DIR . 'templates/archive-property.php';
        if (file_exists($tpl)) { return $tpl; }
    }
    if (is_post_type_archive('renovation_service')) {
        $tpl = REP_PLUGIN_DIR . 'templates/archive-renovation_service.php';
        if (file_exists($tpl)) { return $tpl; }
    }
    if (is_post_type_archive('news')) {
        $tpl = REP_PLUGIN_DIR . 'templates/archive-news.php';
        if (file_exists($tpl)) { return $tpl; }
    }
    return $archive;
});