		<!-- footer -->
		<div class="footer-wrapper clearfix">
			<div class="footer">
				<div class="footer-inner">
					<div class="row">
						<?/*<div class="col col-2of6">
							<?
								$aboutID = url_to_postid(makeLangURL('/%/about/'));
								if ($aboutID) :
							?>
							<?
								$post = get_post($aboutID);
								setup_postdata($post);
							?>
							<!--h3><a href="<? the_permalink() ?>"><? the_title() ?></a></h3-->
							<p><? the_excerpt() ?></p>
							<a href="<? the_permalink() ?>" class="cta"><?= langS('О нас', 'About us') ?></a>
							<? wp_reset_postdata(); ?>
							<? endif; ?>
						</div> */?>
						<div class="col col-2of6">
							<?
								$aboutID = url_to_postid(makeLangURL('/%/contacts/'));
								if ($aboutID) :
							?>
							<?
								$post = get_post($aboutID);
								setup_postdata($post);
							?>
							<h3><a href="<? the_permalink() ?>">Свяжитесь с нами</a></h3>
							
							<? wp_reset_postdata(); ?>
							<? endif; ?>
							
							<? $phone = get_option('phone'); ?>
							<p>
								<a href="tel:<?= $phone['clear'] ?>" class="call-text"><?= $phone['formated'] ?></a>
							</p>
							<p>
								<? include 'page-templates/includes/feedback_button.php' ?>
							</p>
						</div>
						<div class="col col-2of6">
							<!--img src="<?= bloginfo('template_url') ?>/img/temp/logo-beeldmerk.png"-->
							<!--img src="<?= bloginfo('template_url') ?>/img/temp/visual-136x94.jpg.png" alt="The best beans selected" /-->
						</div>
					</div>
	
					<div class="row">
						<div class="col col-6of6">
							<?
								wp_nav_menu(array(
									'menu'            => getLangMainMenuName(), 
									'container'       => '', 
									'container_class' => '',
									'echo'            => true,
									'items_wrap'      => '<ul id="%1$s" class="nav footer-sitemap clearfix %2$s">%3$s</ul>',
									'depth'           => 1,
									'walker'          => new Mainmenu_Bottom_Walker_Nav_Menu()
								));
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="ie-footer-bg-left"></div>
			<div class="ie-footer-bg-right"></div>
		</div>
	
		<div class="footermeta-wrapper">
			<div class="footer-meta">
				<p class="copyright"><?= get_option('copyright') ?></p>
				
				<?
					wp_nav_menu(array(
						'menu'            => getLangBottomMenuName(), 
						'container'       => '',
						'container_class' => '',
						'echo'            => true,
						'items_wrap'      => '<ul id="%1$s" class="nav nav-meta clearfix %2$s">%3$s</ul>',
						'depth'           => 1
					));
				?>
			</div>
		</div>
	
		<script src="<?= bloginfo('template_url') ?>/js/jquery/jquery-1.8.2.min.js"></script>
		<script src="<?= bloginfo('template_url') ?>/js/jquery/jquery-ui-1.8.21.custom.min.js"></script>
		<script src="<?= bloginfo('template_url') ?>/js/jwplayer/jwplayer.js"></script>
		<script src="<?= bloginfo('template_url') ?>/js/modules/pushbox.js"></script>
		<script src="<?= bloginfo('template_url') ?>/js/functions.js"></script>
		<script src="<?= bloginfo('template_url') ?>/js/modules/pushbox.js"></script>
		<script src="<?= bloginfo('template_url') ?>/js/modules/product.js"></script>
		<script src="<?= bloginfo('template_url') ?>/js/modules/etip.js"></script>
		<script src="<?= bloginfo('template_url') ?>/js/modules/waypoints.min.js" type="text/javascript"></script>
		<script src="<?= bloginfo('template_url') ?>/js/shadowbox/shadowbox.js"></script>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ff2add970229b7c"></script>
		<script type="text/javascript">
			Shadowbox.init();
			
			jQuery('.addthis_button_compact, .addthis_bubble_style').mousemove(function(e){
				o = jQuery('.addthis_button_compact').offset();
				o.top += 22;
				jQuery('#at15s').offset(o);
			});
		</script>
		<script src="<?= bloginfo('template_url') ?>/js/default.js"></script>
		
		<? wp_footer() ?>
	</body>
</html>