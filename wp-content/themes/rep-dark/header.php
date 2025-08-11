<?php
if (!defined('ABSPATH')) { exit; }
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="container">
        <div class="site-title">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
        </div>
        <nav class="site-nav">
            <a href="#properties">Properties</a>
            <a href="#services">Services</a>
            <a href="#news">News</a>
        </nav>
    </div>
</header>