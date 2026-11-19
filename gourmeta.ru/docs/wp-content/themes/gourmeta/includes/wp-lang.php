<?
    $cdLangProps = array(
        'mode' => array(
            'ru' => 'Режимы',
            'en' => '',
        ),
        'packages' => array(
            'ru' => 'Объем пакета кофе (л)',
            'en' => '',
        ),
        'milk' => array(
            'ru' => 'Объем пакета молока (л)',
            'en' => '',
        ),
        'water_peak' => array(
            'ru' => 'Пиковое потребление воды (л)',
            'en' => '',
        ),
        'water_hour' => array(
            'ru' => 'Почасовое потребление воды (л)',
            'en' => '',
        ),
        'perfomance' => array(
            'ru' => 'Производительность (чашек/час)',
            'en' => '',
        ),
        'speed' => array(
            'ru' => 'Скорость приготовления кофе (сек/чашка)',
            'en' => '',
        ),
        'water' => array(
            'ru' => 'Подключение к воде',
            'en' => '',
        ),
        'weight' => array(
            'ru' => 'Вес (кг, пустой)',
            'en' => '',
        ),
        'size' => array(
            'ru' => 'Размер (высота х ширина х глубина, мм)',
            'en' => '',
        ),
        'voltage' => array(
            'ru' => 'Напряжение (В)',
            'en' => '',
        ),
        'power' => array(
            'ru' => 'Мощность (Вт)',
            'en' => '',
        ),
        'amperage' => array(
            'ru' => 'Сила тока (А)',
            'en' => '',
        ),
        'concentrate' => array(
            'ru' => 'Количество концентрата (л)',
            'en' => '',
        ),
        'tank' => array(
            'ru' => 'Объем резервуара (л)',
            'en' => '',
        ),
        'price' => array(
            'ru' => 'Порядок цены',
            'en' => '',
        )
    );
    
    function langPropVal($code, $value)
    {
        switch ($code)
        {
            case 'water': return $value == 'on' ? langS('Да', 'Yes') : langS('Нет', 'No'); break;
            case 'price': return '<span class="indicator indicator-'.$value.'"><img src="'.get_bloginfo('template_url').'/img/spr-indicator.png" alt="" /></span>'; break;
            default: return $value;
        }
    }
    
	// Для текущей страницы возвращает идентификатор текущего языка
	function getLangID()
	{
		$uri = $_SERVER["REQUEST_URI"];
		
		// по умолчанию считаем русский язык
	$lang = $_GET['lang'] ?? null; // может не быть
if (substr($uri, 0, 4) === '/en/' || $lang === 'en') {
    return 'en';
}
return 'ru';
	}
	
	function langS($ru, $en)
    {
        if (getLangID() == 'ru')
            return $ru;
        else
            return $en;
    }
	
	function makeLangURL($urlPattern)
	{
		return str_replace('%', getLangID(), $urlPattern);
	}
	
	// Для текущей страницы возвращает <a> с сылкой на адрес страницы на другом языке
	function getLangA()
	{
		$uri = $_SERVER["REQUEST_URI"];
        if (isset($_GET['lang']))
        {
            if (getLangID() == 'ru')
                return '<a href="'.str_replace('lang=ru', 'lang=en', $uri).'" class="language en">in english</a>';
            else
                return '<a href="'.str_replace('lang=en', 'lang=ru', $uri).'" class="language en">по русски</a>';
        }
        else if (substr($uri, 0, 4) == '/en/' || substr($uri, 0, 4) == '/ru/')
        {
            if (getLangID() == 'ru')
                return '<a href="/en/'.substr($uri, 4).'" class="language en">in english</a>';
            else
                return '<a href="/ru/'.substr($uri, 4).'" class="language ru">по русски</a>';
        }
        else
            return '<a href="/en'.$uri.'" class="language en">in english</a>';
	}
	
	// Для текущей страницы возвращает название верхнего меню
	function getLangTopMenuName()
	{
		if (getLangID() == 'ru')
			return 'Верхнее меню';
		else
			return 'Top menu';
	}
	
	// Для текущей страницы возвращает название главного меню
	function getLangMainMenuName()
	{
		if (getLangID() == 'ru')
			return 'Главное меню';
		else
			return 'Main menu';
	}
	
	// Для текущей страницы возвращает название меню подвала
	function getLangFooterMenuName()
	{
		if (getLangID() == 'ru')
			return 'Меню подвала';
		else
			return 'Footer menu';
	}
	
	// Для текущей страницы возвращает название нижнего меню
	function getLangBottomMenuName()
	{
		if (getLangID() == 'ru')
			return 'Нижнее меню';
		else
			return 'Bottom menu';
	}
	
	// Для текущей страницы возвращает домашнюю страницу
	function getHomeLink()
	{
		if (getLangID() == 'ru')
			return '/ru/';
		else
			return '/en/';
	}
?>