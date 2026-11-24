<?php get_header(); ?>

<?php while ( have_posts() ) : the_post();
	$has_specs = gourmeta_product_has_specs( get_the_ID() );
?>
	<main>
		<?php gourmeta_render_product_part( 'intro' ); ?>
		<div class="col-wrapper gourmeta-product-description">
			<div class="machine-properties-holder">
				<div class="tabs-holder">
					<?php gourmeta_render_product_part( 'tabs' ); ?>
					<div id="description">
						<?php the_content(); ?>
						<?php if ( $has_specs ) : ?>
							<div class="tab-nav"><a class="readmore" href="#specifications"><?php echo esc_html( langS( 'Характеристики товара', 'Product specification' ) ); ?></a></div>
						<?php endif; ?>
					</div>
					<?php if ( $has_specs ) : ?>
						<div id="specifications">
							<?php gourmeta_render_product_part( 'specifications' ); ?>
							<div class="tab-nav"><a class="return" href="#description"><?php echo esc_html( langS( 'Описание', 'Description' ) ); ?></a></div>
						</div>
					<?php endif; ?>
				</div>
				<?php gourmeta_render_product_part( 'actions' ); ?>
			</div>
		</div>
	</main>
<?php endwhile; ?>

<?php get_footer(); ?>
