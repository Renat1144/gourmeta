<?php
/**
 * Equipment details used on the site and around the editable description.
 */
function gourmeta_product_has_specs( $id ) {
	global $cdLangProps;
	foreach ( array_keys( $cdLangProps ) as $field ) {
		if ( '' !== get_post_meta( $id, $field, true ) ) {
			return true;
		}
	}
	return false;
}

function gourmeta_render_product_part( $part, $preview = false ) {
	if ( 'intro' === $part ) :
		$thumbnail = get_the_post_thumbnail();
		?>
		<div class="col-wrapper gourmeta-product-intro<?php echo $thumbnail || $preview ? '' : ' gourmeta-product-intro-text'; ?>">
			<?php if ( $thumbnail || $preview ) : ?>
				<div class="image-holder"><?php echo $thumbnail; ?></div>
			<?php endif; ?>
			<div class="gourmeta-product-copy">
				<div class="intro">
					<h1><?php the_title(); ?></h1>
					<div class="gourmeta-product-excerpt"><?php the_excerpt(); ?></div>
				</div>
				<div class="call-to-action"<?php echo $preview ? ' inert' : ''; ?>>
					<em><?php echo esc_html( langS( 'Заинтересовало?', 'Interested?' ) ); ?></em>
					<div class="call-button-holder"><?php gourmeta_product_links(); ?></div>
				</div>
			</div>
		</div>
		<?php
	elseif ( 'tabs' === $part ) :
		?>
		<ul class="nav tabs clearfix">
			<li<?php echo $preview ? ' class="ui-tabs-selected"' : ''; ?>><a href="#description"><?php echo esc_html( langS( 'Описание', 'Description' ) ); ?></a></li>
			<?php if ( gourmeta_product_has_specs( get_the_ID() ) ) : ?>
				<li><a href="#specifications"><?php echo esc_html( langS( 'Характеристики', 'Specifications' ) ); ?></a></li>
			<?php endif; ?>
		</ul>
		<?php
	elseif ( 'specifications' === $part ) :
		global $cdLangProps;
		$id = get_the_ID();
		$highlights = [
			'perfomance' => [ langS( 'Производительность', 'Performance' ), langS( 'чашек / час', 'cups / hour' ) ],
			'speed' => [ langS( 'Скорость', 'Speed' ), langS( 'секунд / чашку', 'sec / cup' ) ],
			'weight' => [ langS( 'Вес', 'Weight' ), langS( 'кг (пустой)', 'kg (empty)' ) ],
			'concentrate' => [ langS( 'Концентрат', 'Concentrate' ), langS( 'литр', 'liter' ) ],
		];
		$meta = array_map( static fn( $field ) => (string) get_post_meta( $id, $field, true ), array_keys( $highlights ) );
		?>
		<div class="specifications gourmeta-spec-table">
			<?php if ( array_filter( $meta, static fn( $value ) => '' !== $value ) ) : ?>
				<h3><?php echo esc_html( langS( 'Основное', 'Highlights' ) ); ?></h3>
				<ul class="highlights">
					<?php foreach ( $highlights as $field => [ $label, $unit ] ) : ?>
						<?php if ( '' !== $meta[ $field ] ) : ?>
							<li><strong><?php echo esc_html( $meta[ $field ] ); ?></strong><dfn><?php echo esc_html( $label ); ?></dfn><em><?php echo esc_html( $unit ); ?></em></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<table>
				<thead>
					<tr>
						<th scope="col"><?php echo esc_html( langS( 'Характеристика', 'Specification' ) ); ?></th>
						<th scope="col"><?php echo esc_html( langS( 'Значение', 'Value' ) ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $cdLangProps as $field => $labels ) : ?>
						<?php $value = get_post_meta( $id, $field, true ); ?>
						<?php if ( '' !== $value ) : ?>
							<tr><th scope="row"><?php echo esc_html( $labels[ getLangID() ] ); ?></th><td><?php echo wp_kses_post( langPropVal( $field, $value ) ); ?></td></tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	elseif ( 'actions' === $part ) :
		?>
		<div class="tab-bottom">
			<div class="tab-bottom-left call-to-action">
				<h2><?php echo esc_html( langS( 'Заинтересовались?', 'Interested?' ) ); ?></h2>
				<div class="call-button-holder"><?php gourmeta_product_links(); ?></div>
			</div>
		</div>
		<?php
	endif;
}

function gourmeta_product_links() {
	?>
	<a class="button" href="<?php echo esc_url( makeLangURL( '/%/quote/?dispensers=' . get_the_ID() ) ); ?>"><?php echo esc_html( langS( 'Узнать цену', 'Quote' ) ); ?></a>
	<?php require dirname( __DIR__ ) . '/page-templates/includes/feedback_button.php'; ?>
	<?php
}
