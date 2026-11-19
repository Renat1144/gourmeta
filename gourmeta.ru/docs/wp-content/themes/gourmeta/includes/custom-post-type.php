<?
    class CustomPostType
    {
        // const
        const PROJECT = 'gourmeta';
        
        // private
        private $farr_info = null;
        private $farr_meta = null;
        private $flush = null;
        
        private function register()
        {
            return !array_key_exists('register', $this->farr_info) || $this->farr_info['register'];
        }
        
        private function getPostType()
        {
            return $this->farr_info['post_type'];
        }
        
        private function getUID($name)
        {
            return CustomPostType::PROJECT.'_'.$this->getPostType().'_'.$name;
        }
        
        // public
        public function __construct($info, $flush = false, $meta = null)
        {
            $this->farr_info = $info;
            $this->flush = $flush;
            $this->farr_meta = $meta;
            
            add_action('init', array($this, 'init'));
            
            if ($this->register())
                add_filter('post_type_link', array($this, 'post_type_link'), 10, 2);
            
            if ($this->farr_meta)
            {
                add_action('add_meta_boxes', array($this, 'add_meta_box'));
                add_action('save_post', array($this, 'save'));
            }
        }
        
        public function init()
        {
            if ($this->register())
            {
                register_post_type($this->getPostType(),
                    array(
                        'public' => true,
                        'rewrite' => array(
                            'slug' => '%c%/'.(isset($this->farr_info['slug']) ? $this->farr_info['slug'] : $this->getPostType()).'/%sc%'
                        ),
                        'taxonomies' => array('category'),
                        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
                        'labels' => $this->farr_info['labels']
                    )
                );
                
                // /wp-includes/class-wp.php
                // не забываем $flush_rewrite_rules
                if (isset($this->farr_info['rewrite']) && !empty($this->farr_info['rewrite']))
                    add_rewrite_rule( $this->farr_info['rewrite'][0], $this->farr_info['rewrite'][1], 'top' );
                else
                    add_rewrite_rule( '^(.+?)/'.$this->getPostType().'/(?!page\/)(.+?)$', 'index.php?category_name=$matches[1]&'.$this->getPostType().'=$matches[2]-$matches[1]', 'top' );
            }
            else if (array_key_exists('labels', $this->farr_info))
            {
                global $wp_post_types;
                $labels = &$wp_post_types[$this->getPostType()]->labels;
                
                $labels->name = $this->farr_info['labels']['name'];
                $labels->singular_name = $this->farr_info['labels']['singular_name'];
                $labels->add_new = $this->farr_info['labels']['add_new'];
                $labels->add_new_item = $this->farr_info['labels']['add_new_item'];
                $labels->edit_item = $this->farr_info['labels']['edit_item'];
                $labels->new_item = $this->farr_info['labels']['new_item'];
                $labels->view_item = $this->farr_info['labels']['view_item'];
                $labels->search_items = $this->farr_info['labels']['search_items'];
            }
            
            if ($this->flush)
                flush_rewrite_rules();
        }
        
        function post_type_link($link, $post)
        {
            // обрабатываем наши пути к элементам
            if ($post->post_type == $this->getPostType())
            {
                $category = '';
                if ($cats = get_the_terms($post->ID, 'category'))
                    $category = array_pop($cats)->slug;
                
                $split_cat = '';
                if (isset($this->farr_info['split_cat_char']))
                {
                    $category = explode($this->farr_info['split_cat_char'], $category);
                    if (count($category) > 1)
                        $split_cat = '/'.join('/', array_slice($category, 1));
                    $category = $category[0];
                }
                
                $link = str_replace('/%sc%', $split_cat, $link);
                $link = str_replace('%c%', $category, $link);
                
                if (empty($category))
                    $link = str_replace('//', '/', $link);
                
                // отрезаем признак языка
                if (strpos($link, '-en/', strlen($link) - 4) !== false || strpos($link, '-ru/', strlen($link) - 4) !== false)
                    $link = substr($link, 0, strlen($link) - 4).'/';
            }
            return $link;
        }
        
        public function add_meta_box( $post_type )
        {
            add_meta_box(
                $this->getPostType().'_meta_box'
                ,'Прочие свойства'
                ,array( $this, 'render_meta_box_content' )
                ,$this->getPostType()
                ,'normal'
                ,'high'
            );
        }
        
        public function save($post_id)
        {
            if (!isset( $_POST[CustomPostType::PROJECT.'_'.$this->getPostType().'_custom_box_nonce']))
                return $post_id;
            
            $nonce = $_POST[CustomPostType::PROJECT.'_'.$this->getPostType().'_custom_box_nonce'];
            
            // Verify that the nonce is valid.
            if (!wp_verify_nonce($nonce, CustomPostType::PROJECT.'_'.$this->getPostType().'_custom_box'))
                return $post_id;
            
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;
            
            // Check the user's permissions.
            if ('page' == $_POST['post_type'])
            {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            }
            else
            {
                if (!current_user_can('edit_post', $post_id))
                    return $post_id;
            }
            
            foreach ($this->farr_meta as $meta)
                foreach($meta['fields'] as $name => $data)
                {
                    $value = sanitize_text_field($_POST[$this->getUID($name)]);
                    update_post_meta($post_id, $name, $value);
                }
        }
        
        public function render_meta_box_content($post)
        {
            wp_nonce_field(CustomPostType::PROJECT.'_'.$this->getPostType().'_custom_box', CustomPostType::PROJECT.'_'.$this->getPostType().'_custom_box_nonce' );
            
            echo '<table>';
                
                foreach ($this->farr_meta as $meta)
                {
                    $keys = array_keys($meta['fields']);
                    echo '<tr>';
                        echo '<td><label for="'.$this->getUID($keys[0]).'">'.$meta['label'].'</label></td>';
                        echo '<td>';
                            foreach($meta['fields'] as $name => $data)
                            {
                                if (!is_array($data))
                                {
                                    $data = explode(':', $data);
                                    $data = array(
                                        'type' => $data[0],
                                        'size' => $data[1],
                                    );
                                }
                                $type = $data['type'];
                                
                                $value = get_post_meta($post->ID, $name, true);
                                switch ($type)
                                {
                                    case 'checkbox':
                                        echo '<input type="checkbox" id="'.$this->getUID($name).'" name="'.$this->getUID($name).'"'.(empty($value) ? '' : ' checked' ).' />';
                                        break;
                                    case 'select':
                                        echo '<select id="'.$this->getUID($name).'" name="'.$this->getUID($name).'">';
                                        foreach ($data['values'] as $svalue => $sname)
                                            echo '<option value="'.$svalue.'"'.($value == $svalue ? ' selected' : '' ).'>'.$sname.'</option>';
                                        echo '</select>';
                                        break;
                                    case 'text':
                                        echo '<input type="text" id="'.$this->getUID($name).'" name="'.$this->getUID($name).'" size="'.$data['size'].'" value="'.$value.'">';
                                        break;
                                }
                            }
                        echo '</td>';
                    echo '</tr>';
                }
            echo '</table>';
        }
    }
?>