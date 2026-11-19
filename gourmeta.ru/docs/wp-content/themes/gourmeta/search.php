<? get_header() ?>

	<!-- search results -->
	<div class="col-wrapper col-box">
		<!-- specific classes can be set on the row -->
		<div class="row search">
			<div class="col col-6of6">
				<p class="search-summary"><?= langS('Вы искали', 'You searched for') ?> <strong>'<?= get_search_query() ?>'</strong></p>
				<? if (have_posts()) : ?>
					<ul>
						<? while (have_posts()) : the_post(); ?>
						<li>
							<h3><? the_title() ?></h3>
							<p><? the_excerpt() ?></p>
							<a href="<? the_permalink() ?>" class="readmore"><?= langS('Узнать больше о', 'Read more about') ?> <? the_title() ?></a>
						</li>
						<? endwhile; ?>
					</ul>
				<? else : ?>
					<ul>
						<li>
							Nothing found
						</li>
					</ul>
				<? endif; ?>
			</div>
		</div>
		
		<!-- paginator -->
		<!--div class="row paginator">
			<ul>
				<li class="previous"><span>Vorige</span></li>
				<li class="active"><span>1</span></li>
				<li><a href="">2</a></li>
				<li><a href="">3</a></li>
				<li class="next"><a href="">Volgende</a></li>
			</ul>
		</div-->
	</div>

<? get_footer() ?>