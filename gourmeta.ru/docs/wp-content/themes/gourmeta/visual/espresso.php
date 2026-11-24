<?php
$espresso_groups = [
	'auto' => langS( 'Автоматические', 'Automatic' ),
	'prof' => langS( 'Профессиональные', 'Professional' ),
];
?>
<div class="col-wrapper">
	<?php require get_template_directory() . '/page-templates/includes/call_feedback_col.php'; ?>

	<div class="gh-espresso-groups">
		<?php foreach ( $espresso_groups as $type => $heading ) : ?>
			<?php
			$machines = get_posts( [
				'post_type' => 'coffee-dispensers',
				'post_status' => 'publish',
				'category_name' => getLangID() . '-espresso',
				'orderby' => 'date',
				'order' => 'ASC',
				'numberposts' => -1,
				'meta_key' => 'espresso_type',
				'meta_value' => $type,
			] );
			?>
			<section class="gh-espresso-group">
				<h2 class="gh-espresso-heading"><?php echo esc_html( $heading ); ?></h2>
				<?php if ( $machines ) : ?>
					<div class="row product-list">
						<?php foreach ( $machines as $machine ) : ?>
							<?php
							$url = get_permalink( $machine );
							$title = get_the_title( $machine );
							$thumbnail = get_the_post_thumbnail( $machine, 'full' );
							$excerpt = get_the_excerpt( $machine );
							?>
							<div class="col">
								<div class="product">
									<?php if ( $thumbnail ) : ?>
										<a class="gh-espresso-product-image" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $title ); ?>"><?php echo $thumbnail; ?></a>
									<?php endif; ?>
									<div class="gh-espresso-product-copy">
										<h3><?php echo esc_html( $title ); ?></h3>
										<?php if ( '' !== trim( $excerpt ) ) : ?>
											<?php echo wp_kses_post( apply_filters( 'the_excerpt', $excerpt ) ); ?>
										<?php endif; ?>
									</div>
									<div class="gh-espresso-product-actions">
										<label>
											<input type="checkbox" data-decs-machineid="<?php echo esc_attr( $machine->ID ); ?>">
											<?php echo esc_html( langS( 'Сравнить', 'Compare' ) ); ?>
										</label>
										<a class="button" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( langS( 'Подробнее', 'Details' ) ); ?></a>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</section>
		<?php endforeach; ?>
	</div>
</div>

<div class="product-toolbox">
	<h4><?php echo esc_html( langS( 'Выбранные диспенсеры:', 'Selected coffee machines:' ) ); ?></h4>
	<ul></ul>
	<a href="<?php echo esc_url( makeLangURL( '/%/equipment/espresso/compare/' ) ); ?>" class="button"><?php echo esc_html( langS( 'Сравнить', 'Compare' ) ); ?></a>
</div>
