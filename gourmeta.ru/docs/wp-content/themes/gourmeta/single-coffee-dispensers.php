<? get_header() ?>

<? while (have_posts()) : the_post(); ?>
	<!-- detail page intro -->
	<div class="col-wrapper col-wrapper-grey">
        <div class="row">
            <!-- imageS holder -->
            <div class="col col-2of6">
                <div class="image-holder">
                    <? the_post_thumbnail() ?>                 
                </div>
            </div>
            <div class="col col-4of6">
                <div class="intro">
                    <h1>
                        <span><? the_title(); ?></span>
                    </h1>
                    <div>
                        <? the_excerpt() ?>
                    </div>
                </div>
                <div class="col-box call-to-action">
                    <!-- example content -->
                    <em><?= langS('Заинтересовало?', 'Interested?') ?></em>
        
                    <div class="call-button-holder">
                        <div>
                            <p>
                                <a class="button button" href="<?= makeLangURL('/%/quote/?dispensers='.get_the_ID()) ?>">
                                    <?= langS('Узнать цену', 'Quote') ?>
                                    <span>
                                        <span></span>
                                    </span>
                                </a>
                                <? include 'page-templates/includes/feedback_button.php' ?>
                            </p>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>
        <div class="col-wrapper-grey-bottom"></div>
        
		<!-- tabs -->
		<div class="row" style="margin-top: 10px;">
			<div class="machine-properties-holder">
				<div class="tabs-holder">
					<ul class="nav tabs clearfix">
						<li><a href="#description"><?= langS('Описание', 'Description') ?></a></li>
						<li><a href="#specifications"><?= langS('Характеристики', 'Specifications') ?></a></li>
						<!--li><a href="#media">Photo's &amp; video's</a></li>
						<li><a href="#faq">Faq</a></li-->
					</ul>
					<div id="description">
						<? the_content(); ?>
                        
						<div class="tab-nav">
							<a href="" class="readmore"><?= langS('Характеристики товара', 'Product specification') ?></a>
						</div>
					</div>
					<div id="specifications">
                        
                        <? $custom = get_post_custom() ?>
                        
						<table class="specifications">
							<tr>
								<td colspan="2">
									<h3><?= langS('Основное', 'Hihglights') ?></h3>
									<ul class="clearfix highlights">
                                        <li>
											<strong><?= $custom['perfomance'][0] ?></strong>
											<dfn><?= langS('Произ.', 'Perfomance') ?></dfn>
											<em><?= langS('чашек / час', 'cups / hour') ?></em>
										</li>
                                        <li>
											<strong class="small"><?= $custom['speed'][0] ?></strong>
											<dfn><?= langS('Скорость', 'Speed') ?></dfn>
											<em><?= langS('секунд / чашку', 'sec / cup') ?></em>
										</li>
                                        <li>
											<strong><?= $custom['weight'][0] ?></strong>
											<dfn><?= langS('Вес', 'Weight') ?></dfn>
											<em><?= langS('кг (пустой)', 'kg (empty)') ?></em>
										</li>
										<li>
											<strong><?= $custom['concentrate'][0] ?></strong>
											<dfn><?= langS('Концен.', 'Concentrate') ?></dfn>
											<em><?= langS('литр', 'liter') ?></em>
										</li>
									</ul>
								</td>
							</tr>
                            
                            <? foreach ($cdLangProps as $code => $langs) : ?>
                            <? if (!empty($custom[$code][0])) : ?>
                            <tr>
								<th><?= $langs[getLangID()] ?><!--a class="tooltip" data-tiptitle="Titel vd tip" data-tiptext="dit is een tooltip"></a--></th>
								<td><?= langPropVal($code, $custom[$code][0]); ?></td>
							</tr>
                            <? endif; ?>
                            <? endforeach; ?>
                            
						</table>
						<div class="tab-nav">
							<a href="" class="return"><?= langS('Описание', 'Description') ?></a>
							<!--a href="" class="readmore">Photos and video's</a-->
						</div>
					</div>
					<!--div id="media">
						<ul class="nav clearfix media">
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540" class="video-thumb"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /><span></span></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
							<li><a href="carousel-product.html" rel="shadowbox; width=510;height=540"><img src="<?= bloginfo('template_url') ?>/img/temp/cafitesse_60_108x108.png" alt="" /></a></li>
						</ul>
						<div class="tab-nav">
							<a href="" class="return">Specifications</a>
							<a href="" class="readmore">Frequently asked questions</a>
						</div>
					</div>
					<div id="faq">
						<ol class="faq">
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
							<li>
								<h3>Hoeveel tijd neemt de verzorging van een koffie machine? </h3>
								<p>De tijd die het schoonmaken en onderhoud van koffiemachines in beslag neemt, verschilt per koffiemachine. Indien u een indicatie hiervan wilt, kunt u contact met ons opnemen via info@decs.nl.</p>
							</li>
						</ol>

						<h2>Your question not in the list?</h2>
						<a href="" class="button"><span><span></span></span>Ask us</a>

						<div class="tab-nav">
							<a href="" class="return">Photo's and video's</a>
						</div>
					</div-->
				</div>
				<div class="tab-bottom clearfix">
					<div class="tab-bottom-left call-to-action">
						<h2><?= langS('Заинтересовались?', 'Interested?') ?></h2>
						<a href="<?= makeLangURL('/%/quote/?dispensers='.get_the_ID()) ?>" class="button"><span><span></span></span><?= langS('Узнать цену', 'Quote') ?></a>
						<br /><? include 'page-templates/includes/feedback_button.php' ?>
					</div>
					<!--div class="tab-bottom-right">
						<h2>Downloads</h2>
						<ul class="nav downloads">
							<li><a href="" class="pdf"><span></span>Cafitesse 60 - Brochure</a> <small>(pdf - 60kb)</small></li>
							<li><a href="" class="doc"><span></span>Cafitesse 60 - Brochure</a> <small>(pdf - 60kb)</small></li>
							<li><a href="" class="img"><span></span>Cafitesse 60 - Brochure</a> <small>(pdf - 60kb)</small></li>
							<li><a href="" class="ppt"><span></span>Cafitesse 60 - Brochure</a> <small>(pdf - 60kb)</small></li>
						</ul>
					</div-->
				</div>
			</div>
			<!--<div class="col col-2of6">
			<div class="row">
					<h3>Service concepts</h3>

					<p>Douwe Egberts Coffee System is driven to continuously innovate its products and knowledge to offer its customers the best possible solution.</p>

					<a href="" class="readmore">More about service concept</a>
				</div>
			</div>-->	
		</div>
	</div>	
<? endwhile; // end of the loop. ?>

<? get_footer() ?>