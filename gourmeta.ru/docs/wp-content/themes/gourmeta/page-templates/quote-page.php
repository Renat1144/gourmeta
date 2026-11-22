<?
    /**
     * Template Name: Заказ диспенсеров
     */
    
    get_header();
?>
    <!-- Basic html styles and rich text editor elements -->
	<div class="col-wrapper col-box">
		<!-- 
			a page is build with rows and has child columns within each of these rows.
			a 6-column grid is used, see layout.css for details
		-->
        <? while (have_posts()) : the_post(); ?>
		<?php require get_template_directory() . "/visual/order.php"; ?>
        <div class="row quote-form">
            <? the_content(); ?>
        </div>
        <? endwhile; // end of the loop. ?>
	</div>
	
	<?php require get_template_directory() . "/visual/order-script.php"; ?>
<? get_footer() ?>