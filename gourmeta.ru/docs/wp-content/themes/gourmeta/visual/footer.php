<?php
if ( gourmeta_is_designed_home() ) {
	require __DIR__ . '/home-footer.php';
	return;
}
?>
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
							<h3><a href="<? the_permalink() ?>"><?php echo esc_html( gourmeta_visual_site_settings()['contactHeading'] ); ?></a></h3>

							<? wp_reset_postdata(); ?>
							<? endif; ?>

							<? $phone = get_option('phone'); ?>
							<p>
								<a href="tel:<?= $phone['clear'] ?>" class="call-text"><?= $phone['formated'] ?></a>
							</p>
							<p>
								<? include get_template_directory() . '/page-templates/includes/feedback_button.php' ?>
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
