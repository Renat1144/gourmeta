<div class="row quote-form">
            <div class="quote-form-head">
                <div class="quote-form-selection">
                    <h1><? the_title(); ?></h1>

                    <?
                        $dispensers = explode(',', $_GET['dispensers'] ?? '');
                        foreach ($dispensers as $did)
                        {
                            $did = intval($did);
                            $dispenser = $did ? get_post($did) : null;
                            if ($dispenser && $dispenser->post_type === 'coffee-dispensers' && $dispenser->post_status === 'publish')
                            {
                                $post = $dispenser;
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
