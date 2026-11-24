
<?php
/*
Template Name:  Big Picture
Template Post Type: post, coffee-dispensers
*/

?>

<? get_header() ?>

<? while (have_posts()) : the_post(); ?>
	<!-- detail page intro -->
	<div class="col-wrapper col-wrapper-grey">
	
        <div class="rows">
		<h1><?php the_title(); ?></h1>
		<? the_content(); ?>
		</div>
            
       
	</div>	
<? endwhile; // end of the loop. ?>

<? get_footer() ?>