<?
    /**
     * Template Name: Заказ диспенсеров
     */
    
    get_header();
?>
    <!-- Basic html styles and rich text editor elements -->
	<div class="col-wrapper col-box">
		<!-- 
			a page is build with rows and has child columns within each of these rows.
			a 6-column grid is used, see layout.css for details
		-->
        <? while (have_posts()) : the_post(); ?>
		<div class="row quote-form">
            <div class="quote-form-head">
                <div class="quote-form-selection">
                    <h1><? the_title(); ?></h1>
                    
                    <?
                        $dispensers = explode(',', $_GET['dispensers']);
                        foreach ($dispensers as $did)
                        {
                            $did = intval($did);
                            $post = get_post($did);
                            if ($post && $post->post_type = 'coffee-dispensers')
                            {
                                setup_postdata($post);
                                
                                ?>
                                <div class="col col-2of6">
                                    <? the_post_thumbnail('dispenser-preview') ?>
                                    <h3><? the_title() ?></h3>
									<? if (count($dispensers) > 1) : ?>
                                    <label>
                                        <input type="checkbox" checked="checked"><span></span>Selected
                                    </label>
									<? endif; ?>
                                </div>
                                <?
                                
                                wp_reset_postdata();
                            }
                        }
                    ?>
                </div>
            </div>
		</div>
        <div class="row quote-form">
            <? the_content(); ?>
        </div>
        <? endwhile; // end of the loop. ?>
	</div>
	
	<script>
		jQuery(function() {
			//jQuery('#your-dispensers').prop('disabled', true);
			
			jQuery('.quote-form-selection .col input[type="checkbox"]').change(recordSelectedDispensers);
			
			recordSelectedDispensers();
		});
		
		function recordSelectedDispensers()
		{
			var text = [];
			jQuery('.quote-form-selection .col').each(function() {
				chb = jQuery(this).find('input[type="checkbox"]');
				if (chb.length == 0 || chb.prop('checked'))
				{
					text.push(jQuery(this).find('h3').text());
				}
			});
			
			jQuery('#your-dispensers').val(text.join('\n'));
		}
	</script>
<? get_footer() ?>