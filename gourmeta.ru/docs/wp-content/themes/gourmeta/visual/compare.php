<?php
    if ( ! function_exists( "gourmeta_compare_query" ) ) {
    function gourmeta_compare_query($ids, $exclude = null)
    {
        $result = array();
        foreach ($ids as $id)
            if ($id != $exclude)
                $result[] = $id;
        if (count($result))
            return '?dispensers='.implode(',', $result);
        else
            return '';
    }



    }
    $ids = array();
    if (isset($_GET['dispensers']))
        $ids = explode(',', $_GET['dispensers']);

    $correctedIDs = array();
    $dispensers = array();
    foreach ($ids as $id)
    {
        $id = intval($id);
        $post = get_post($id);
        if ($post && $post->post_type === 'coffee-dispensers' && $post->post_status === 'publish')
        {
            $dispensers[] = $post;
            $correctedIDs[] = $id;
        }
    }

	$backURL = get_permalink( get_queried_object_id() );
	$comparePos = strpos($backURL, '/compare/');

	$backURL = substr($backURL, 0, $comparePos + 1).gourmeta_compare_query($correctedIDs);
?>

    <!-- comparison tool -->
    <div class="col-wrapper">
		<div class="col col-6of6">
			<div class="row nomargin">
				<a class="return" href="<?= esc_url( $backURL ) ?>"><?= langS('Назад на предыдущую страницу', 'Back to previous page') ?></a>
			</div>
		</div>
		<div class="col col-3of6">
			<h1><?= langS('Сравнение', 'Compare '.count($dispensers).' machines') ?></h1>
		</div>
	</div>

	<div class="col-wrapper compare-nav">
		<div class="row nomargin">
			<a href="<?= makeLangURL('/%/equipment/cafitesse/') ?>"><?= langS('Начать заново', 'Start over') ?></a>
			<div class="comparison-button-holder">
                <? if (count($dispensers) > 1) : ?>
                <a class="comparison-button-holder share-link hide_same" href=""><?= langS('Скрыть одинаковые поля', 'Hide similiar fields') ?><span></span></a>
                <? endif; ?>
				<!--a href="" class="print-link">Print this comparison<span></span></a-->
			</div>
		</div>
	</div>

	<div data-decs-machinecount="<?= count($dispensers) ?>" class="col-wrapper col-box compare-machines" id="comparisonTool">
        <?
            $i = 0;
            for ($i = 0; $i < 3; $i++) :
        ?>
        <? if (isset($dispensers[$i])) : ?>

        <?
            $post = $dispensers[$i];
            setup_postdata($post);

            $custom = get_post_custom();
            global $cdLangProps;
        ?>
        <div class="col col-2of6">
			<div class="machine-name">.
				<a href="<?= makeLangURL('/%/equipment/dispensers/compare/'.gourmeta_compare_query($correctedIDs, get_the_ID())) ?>" class="close-button"></a>
				<h2><? the_title() ?></h2>
			</div>
			<div class="machine-details-holder">
				<div class="machine-intro">
					<a rel="shadowbox; width=510;height=540" href="carousel-product.html">
						<? the_post_thumbnail('dispenser-preview') ?>
                    </a>
					<!--h2>Maximum coffee variation</h2-->
				</div>

				<a class="button" href="<? the_permalink() ?>">
					<span>
						<span></span>
					</span>
					<?= langS('Подробнее', 'More details') ?>
				</a>

				<ul class="machine-details">
					<? foreach ($cdLangProps as $code => $langs) : ?>
					<li>
						<h3><?= $langs[getLangID()] ?></h3>
                        <span class="value">
						<? if (isset($custom[$code])) : ?>
                        <?= langPropVal($code, $custom[$code][0]) ?>
                        <? endif; ?>
                        </span>
					</li>
					<? endforeach; ?>
				</ul>
			</div>
		</div>
        <? wp_reset_postdata(); ?>
        <? else : ?>
        <div class="col col-2of6">
			<div class="machine-name">
				<a class="add-button" href="<?= esc_url( $backURL ) ?>"></a>
			</div>
			<div class="machine-details-holder">
				<div class="machine-intro">
					<h2><?= langS('Добавьте диспенсер к сравнению', 'Add a new machine to the selection') ?></h2>
				</div>
			</div>
		</div>
        <? endif; ?>

        <? endfor; ?>
    </div>

	<div class="col-wrapper">
		<? include get_template_directory() . '/page-templates/includes/call_feedback_col.php' ?>
	</div>
