

<div class="col-wrapper">
    <? include get_template_directory() . '/page-templates/includes/call_feedback_col.php' ?>

    <?
        $index = 0;

        $posts = get_posts(array(
                'post_type' => 'coffee-dispensers',
                'post_status' => 'publish',
                'category_name' => getLangID().'-cafitesse',
                'orderby' => 'date',
                'order' => 'ASC',
                'numberposts' => -1
        ));

        foreach ($posts as $post) : setup_postdata($post); ?>

        <? if ($index % 4 == 0) : ?>
        <? if ($index > 0) : ?>
        </div>
        <? endif; ?>
        <div class="row product-list<?= $index < count($posts) - 4 ? ' border-curved' : '' ?>">
        <? endif; ?>

            <div class="col col-1-5of6">
                <div class="product">
                    <a href="<? the_permalink() ?>">
                        <? the_post_thumbnail('dispenser-preview') ?>
                    </a>
                    <h3><? the_title() ?></h3>
                    <label><input type="checkbox" data-decs-machineid="<? the_ID(); ?>"/><span></span> <?= langS('Сравнить', 'Compare') ?></label>
                    <a class="button" href="<? the_permalink() ?>"><?= langS('Подробнее', 'Details') ?><span><span></span></span></a>
                </div>
            </div>

    <? 	$index++; endforeach; wp_reset_postdata(); ?>

    <? if ($index > 0) : ?>
        </div>
    <? endif; ?>
</div>

<div class="product-toolbox">
    <h4><?= langS('Выбранные диспенсеры:', 'Selected coffee machines:') ?></h4>
    <ul></ul>
    <a href="<?= makeLangURL('/%/equipment/cafitesse/compare/') ?>" class="button"><?= langS('Сравнить', 'Compare') ?><span><span></span></span></a>
</div>
