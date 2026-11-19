<?
    /**
     * Template Name: Каталог Espresso
     */
    
    get_header();
?>

<? while (have_posts()) : the_post(); ?>
<div class="col-wrapper">
    <div class="col col-6of6">
        <h1><? the_title(); ?></h1>
        
        <? the_content(); ?>
    </div>
</div>
<? endwhile; ?>

<div class="col-wrapper">
    <? include 'includes/call_feedback_col.php' ?>
    
    <div class="row">
        <div class="col col6of6">
            <h2>Автоматические</h2>
        </div>
    </div>
    
    <?
        $index = 0;
        
        $posts = get_posts(array(
            'post_type' => 'coffee-dispensers',
            'post_status' => 'publish',
            'category_name' => getLangID().'-espresso',
            'orderby' => 'date',
            'order' => 'ASC',
            'numberposts' => -1,
            'meta_query' => array(
                array(
                    'key' => 'espresso_type',
                    'value' => 'auto',
                )
            )
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
                    <p><? the_excerpt() ?></p>
                    <label><input type="checkbox" data-decs-machineid="<? the_ID(); ?>"/><span></span> <?= langS('Сравнить', 'Compare') ?></label>
                    <a class="button" href="<? the_permalink() ?>"><?= langS('Подробнее', 'Details') ?><span><span></span></span></a>
                </div>
            </div>
            
    <? 	$index++; endforeach; wp_reset_postdata(); ?>
    
    <? if ($index > 0) : ?>
        </div>
    <? endif; ?>
    
    <div class="row">
        <div class="col col6of6">
            <h2>Профессиональные</h2>
        </div>
    </div>
    
    <?
        $index = 0;
        
        $posts = get_posts(array(
            'post_type' => 'coffee-dispensers',
            'post_status' => 'publish',
            'category_name' => getLangID().'-espresso',
            'orderby' => 'date',
            'order' => 'ASC',
            'numberposts' => -1,
            'meta_query' => array(
                array(
                    'key' => 'espresso_type',
                    'value' => 'prof',
                )
            )
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
                    <p><? the_excerpt() ?></p>
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
    <a href="<?= makeLangURL('/%/equipment/espresso/compare/') ?>" class="button"><?= langS('Сравнить', 'Compare') ?><span><span></span></span></a>
</div>

<? get_footer() ?>