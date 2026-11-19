<?
    require_once 'custom-post-type.php';
    class PostsPostType extends CustomPostType
    {
        public function __construct($flush = false)
        {
            parent::__construct(
                array(
                    'post_type' => 'post',
                    'register' => false,
                    'labels' => array(
                        'name' => 'Публикации',
                        'singular_name' => 'Публикация',
                        'add_new' => 'Добавить публикацию',
                        'add_new_item' => 'Новая публикация',
                        'edit_item' => 'Редактировать публикацию',
                        'new_item' => 'Новая публикация',
                        'view_item' => 'Посмотреть публикацию',
                        'search_items' => 'Найти публикацию'
                    ),
                ),
                $flush,
                array(
                    /*array(
                        'label' => 'Журнал',
                        'fields' => array('magazine' => 'text')
                    ),
                    array(
                        'label' => 'Где искать в журнале',
                        'fields' => array('magazine_pos' => 'text')
                    ),
                    array(
                        'label' => 'Автор публикации',
                        'fields' => array('author' => 'text')
                    ),*/
                )
            );
        }
    }
?>