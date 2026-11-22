<?php
get_header();
// Imported blocks already contain the site's rendered typography.
$removed = remove_filter( 'the_content', 'wptexturize' );
try {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
} finally {
	if ( $removed ) {
		add_filter( 'the_content', 'wptexturize' );
	}
}
get_footer();
