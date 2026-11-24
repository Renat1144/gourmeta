<?
    require_once 'custom-post-type.php';
    class CoffeeDispensersPostType extends CustomPostType
    {
        public function __construct($flush = false)
        {
            parent::__construct(
                array(
                    'post_type' => 'coffee-dispensers',
                    'show_in_rest' => true,
                    'labels' => array(
                        'name' => 'Кофе диспенсеры',
                        'singular_name' => 'Кофе диспенсер',
                        'all_items' => 'Все кофе диспенсеры',
                        'add_new' => 'Добавить кофе диспенсер'
                    ),
                    'rewrite' => array(
                        '^(.+?)/equipment/(.+?)/(?!compare)(.+?)$',
                        'index.php?category_name=$matches[1]-$matches[2]&coffee-dispensers=$matches[3]-$matches[1]'
                    ),
                    'slug' => 'equipment',
                    'split_cat_char' => '-'
                ),
                $flush,
                array(
                    array(
                        'label' => 'Режимы',
                        'fields' => array('mode' => 'text')
                    ),
                    array(
                        'label' => 'Объем пакета кофе (л)',
                        'fields' => array('packages' => 'text')
                    ),
                    array(
                        'label' => 'Объем пакета молока (л)',
                        'fields' => array('milk' => 'text')
                    ),
                    array(
                        'label' => 'Пиковое потребление воды (л)',
                        'fields' => array('water_peak' => 'text')
                    ),
                    array(
                        'label' => 'Почасовое потребление воды (л)',
                        'fields' => array('water_hour' => 'text')
                    ),
                    array(
                        'label' => 'Производительность (чашек/час)',
                        'fields' => array('perfomance' => 'text')
                    ),
                    array(
                        'label' => 'Скорость приготовления кофе (сек/чашка)',
                        'fields' => array('speed' => 'text')
                    ),
                    array(
                        'label' => 'Подключение к воде',
                        'fields' => array('water' => 'checkbox')
                    ),
                    array(
                        'label' => 'Вес (кг, пустой)',
                        'fields' => array('weight' => 'text')
                    ),
                    array(
                        'label' => 'Размер (высота х ширина х глубина, мм)',
                        'fields' => array('size' => 'text')
                    ),
                    array(
                        'label' => 'Напряжение (В)',
                        'fields' => array('voltage' => 'text')
                    ),
                    array(
                        'label' => 'Мощность (Вт)',
                        'fields' => array('power' => 'text')
                    ),
                    array(
                        'label' => 'Сила тока (А)',
                        'fields' => array('amperage' => 'text')
                    ),
                    array(
                        'label' => 'Количество концентрата (л)',
                        'fields' => array('concentrate' => 'text')
                    ),
                    array(
                        'label' => 'Объем резервуара (л)',
                        'fields' => array('tank' => 'text')
                    ),
                    array(
                        'label' => 'Порядок цены',
                        'fields' => array('price' => array(
                            'type' => 'select',
                            'values' => array(
                                1 => 1,
                                2 => 2,
                                3 => 3,
                                4 => 4,
                                5 => 5
                            )
                        ))
                    ),
                    array(
                        'label' => 'Тип Espresso',
                        'fields' => array('espresso_type' => array(
                            'type' => 'select',
                            'values' => array(
                                'auto' => 'Автоматические',
                                'prof' => 'Профессиональные'
                            )
                        ))
                    )
                )
            );
        }
    }
?>