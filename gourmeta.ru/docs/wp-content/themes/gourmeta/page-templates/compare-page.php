<?
    /**
     * Template Name: Сравнение диспенсеров
     */

    get_header();
    require get_template_directory() . "/visual/compare.php";
    add_action( 'wp_footer', 'gourmeta_visual_compare_script', 90 );
    get_footer();
