<?
    /**
     * Template Name: Главная страница
     */
    
	get_header();
?>

	<!-- Pushbox -->
	<div class="branding-wrapper">
		<!-- data-decs-pushbox-pause is the pause in seconds for each rotation -->
		<div class="pushbox" data-decs-pushbox-pause="5">
			<!-- main viewport with slides -->
			<div class="pushbox-viewport">		
				<ul class="pushbox-slides">
					<li>
						<div class="text-box">
							<h3><?= langS('Уже более 260 лет мы отбираем, смешиваем и обжариваем кофе. Восхитительный кофе Douwe Egberts.', 'С любовью к кофе с 1753 года') ?></h3>
							<!--a href="" class="button">Learn more<span><span></span></span></a>
							<a href="" class="button-yellow button button-video">Play video<span><span></span></span></a-->
						</div>
						<!--img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox.jpg" alt="" /-->
						<img src="/wp-content/uploads/2015/07/1st.jpg" alt="" />
					</li>
					<li>
						<div class="text-box">
							<h3><?= langS('Изумительный вкус нашего кофе удовлетворит самого изысканного гурмана. Попробуйте сами!', 'Douwe Egberts') ?></h3>
							<!--a href="" class="button">Learn more<span><span></span></span></a-->
						</div>
						<!--img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox.jpg" alt="" /-->
						<img src="/wp-content/uploads/2015/07/2nd.jpg" alt="" />
					</li>
					<li>
						<div class="text-box">
							<h3><?= langS('Чашка ароматного, свежего кофе для каждого вашего гостя. Быстро и элегантно. Каждый день.', 'Неизменный вкус от опытнейшего обжарщика Европы для Нашего Гостя!') ?></h3>
							<!--a href="" class="button">Learn more<span><span></span></span></a-->
						</div>
						<!--img src="<?= bloginfo('template_url') ?>/img/temp/visual-pushbox.jpg" alt="" /-->
						<img src="/wp-content/uploads/2015/07/3rd.png" alt="" />
					</li>
				</ul>
			</div>

			<!-- pushbox navigation  -->
			<div class="pushbox-nav">
				<ul>
					<li>1</li>
					<li>2</li>
					<li>3</li>
				</ul>
			</div>

			<!--a class="pushbox-next">next</a>
			<a class="pushbox-prev">previous</a-->
<?/*
		<div class="row col-box pushbox-teasers">
				<div class="pushbox-teasers-box clearfix">
					<div class="slide-teasers" data-decs-slideindex="0"> 
					<?	
							$posts = array(
								get_post( $dummy_id = 39 ),
								get_post( $dummy_id = 48 ),
								get_post( $dummy_id = 67 )
							);
							foreach ($posts as $post) : setup_postdata($post);
						?>
						<div class="slide-teaser">
							<a class="col col-2of6" href="<? the_permalink() ?>">
								<span></span>
								<h3><? the_title() ?></h3>
								<? the_post_thumbnail(array(60, 90)) ?>
								<div style="max-height: 70px; overflow: hidden;"><? the_excerpt() ?></div>
							</a>
						</div>
						<? 	endforeach; wp_reset_postdata(); ?>
					</div>
					
					<div class="slide-teasers" data-decs-slideindex="1"> 
						<?
							$posts = array(
								get_post( $dummy_id = 159 ),
								get_post( $dummy_id = 27 ),
								get_post( $dummy_id = 163 )
							);
							foreach ($posts as $post) : setup_postdata($post);
						?>
						<div class="slide-teaser">
							<a class="col col-2of6" href="<? the_permalink() ?>">
								<span></span>
								<h3><? the_title() ?></h3>
								<? the_post_thumbnail(array(60, 90)) ?>
								<div style="max-height: 70px; overflow: hidden;"><? the_excerpt() ?></div>
							</a>
						</div>
						<? 	endforeach; wp_reset_postdata(); ?>
					</div>
					
					<div class="slide-teasers" data-decs-slideindex="2"> 
						<?
							$posts = array(
								get_post( $dummy_id = 114 ),
								get_post( $dummy_id = 149 ),
								get_post( $dummy_id = 151 )
							);
							foreach ($posts as $post) : setup_postdata($post);
						?>
						<div class="slide-teaser">
							<a class="col col-2of6" href="<? the_permalink() ?>">
								<span></span>
								<h3><? the_title() ?></h3>
								<? the_post_thumbnail(array(60, 90)) ?>
								<div style="max-height: 70px; overflow: hidden;"><? the_excerpt() ?></div>
							</a>
						</div>
						<? 	endforeach; wp_reset_postdata(); ?>
					</div>
				</div>			
		</div> */ ?>
			<div class="pushbox-teasers-shadow"></div>
		</div>
	</div>
	
	<div class="col-wrapper">
		<? include 'includes/call_feedback_col.php' ?>
        
		<div class="row">
			<div class="col col6of6">
				<? the_content(); ?>
			</div>
		</div>
		
		<!-- teasers-->
		<div class="row">
			<div class="col col-6of6">
				<ul class="nav teasers-related clearfix">
					<li>
						<!-- default color for teaser is -->
						<a href="/ru/equipment/cafitesse/">
							<img src="<?= bloginfo('template_url') ?>/img/temp/hotel.jpg" width="189" height="106" alt="Our business" />
							<h3><?= langS('Завтрак', 'Hotel') ?></h3>
							<p>Правильный выбор для вашего отеля. Ароматный кофе быстро и просто.</p>
						</a>
					</li>
					<li>
						<!-- different colors for the teasers -->
						<a href="/ru/equipment/espresso/" class="black">
							<img src="<?= bloginfo('template_url') ?>/img/temp/bar.jpg" width="189" height="106" alt="<?= langS('Отель', 'Hotel') ?>" />
							<h3><?= langS('Бар', 'Transport') ?></h3>
							<p>Эспрессо решения для вашего бара</p> 
						</a>
					</li>
					<li>
						<a href="/ru/equipment/cafitesse/cafitesse-quantum-120/" class="red">
							<img src="<?= bloginfo('template_url') ?>/img/temp/keit.jpg" width="189" height="106" alt="<?= langS('Транспорт', 'Transport') ?>" />
							<h3><?= langS('Кейтеринг', 'Business / Office') ?></h3>
							<p>Высокое качество и производительность</p>
						</a>
					</li>
					<li>
						<a href="/ru/equipment/cafitesse/cafitesse-excellence-compact/" class="green">
							<img src="<?= bloginfo('template_url') ?>/img/temp/office.jpg" width="189" height="106" alt="Our business" />
							<h3><?= langS('Офис', 'Bar') ?></h3>
							<p>Деловая обстановка и свежий кофе станут визитной карточкой вашей компании.</p>
						</a>
					</li>
				</ul>
			</div>
		</div> 
	</div>
	
	<div class="col-wrapper label-green">
	
			<img src="<?= bloginfo('template_url') ?>/img/bgcof.png"/>

	</div>

<? get_footer() ?>