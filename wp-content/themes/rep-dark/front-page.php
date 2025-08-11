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
?>
    <section class="rep-hero" style="<?php echo esc_attr('background: linear-gradient(135deg, ' . $grad_from . ', ' . $grad_to . ');'); ?>">
        <div class="rep-hero-inner">
            <h1><?php echo esc_html($hero_title); ?></h1>
            <p class="rep-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
        </div>
    </section>

    <main>
        <section id="properties" class="rep-section">
            <h2 class="rep-section-title">Latest Properties</h2>
            <?php echo do_shortcode('[rep_properties limit="6"]'); ?>
        </section>

        <section id="services" class="rep-section">
            <h2 class="rep-section-title">Renovation Services</h2>
            <?php echo do_shortcode('[rep_services limit="6"]'); ?>
        </section>

        <section id="news" class="rep-section">
            <h2 class="rep-section-title">Latest News</h2>
            <?php echo do_shortcode('[rep_news limit="6"]'); ?>
        </section>
    </main>

<?php
get_footer();