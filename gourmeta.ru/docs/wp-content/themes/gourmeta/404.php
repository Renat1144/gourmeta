<? get_header() ?>

	<!-- Basic html styles and rich text editor elements -->
	<div class="col-wrapper col-box">
		<!-- 
			a page is build with rows and has child columns within each of these rows.
			a 6-column grid is used, see layout.css for details
		-->
		<div class="row">
			<div class="col col6of6">
				<h1>404</h1>
				<p><?= langS('К сожалению, мы ничего не нашли по этому адресу.', 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.') ?></p>
			</div>
		</div>
	</div>

<? get_footer() ?>