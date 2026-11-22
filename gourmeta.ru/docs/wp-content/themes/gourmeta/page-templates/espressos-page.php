<?
    /**
     * Template Name: Каталог Espresso
     */
    
    get_header();
?>

<? while (have_posts()) : the_post(); ?>
<div class="col-wrapper">
    <div class="col col-6of6">
        <h1><? the_title(); ?></h1>
        
        <? the_content(); ?>
    </div>
</div>
<? endwhile; ?>
<?php require get_template_directory() . "/visual/espresso.php"; ?>
<? get_footer() ?>