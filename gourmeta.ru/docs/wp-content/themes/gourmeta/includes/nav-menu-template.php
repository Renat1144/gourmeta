<?
    class Submenu_Walker_Nav_Menu extends Walker_Nav_Menu
    {
        public function walk( $elements, $max_depth, ...$args ) {
        
            $args = array_slice(func_get_args(), 2);
            $output = '';
            
            if ($max_depth < 0) // nothing to walk
                return $output;
            
            if (empty($elements)) // nothing to walk
                return $output;
            
            $parent_field = $this->db_fields['parent'];
            
            $tree = array();
            foreach ( $elements as $e)
                $tree[$e->$parent_field][] = $e;
            
            foreach ($tree[0] as $e)
            {
                if ($e->current || $e->current_item_ancestor)
                    foreach ($tree[$e->ID] as $sub)
                        $this->display_element( $sub, $tree[$sub->ID], $max_depth - 1, 0, $args, $output );
            }
            
            return $output;
        }
    }
    
    class Mainmenu_Walker_Nav_Menu extends Walker_Nav_Menu
    {
        public function start_lvl( &$output, $depth = 0, $args = array() )
        {
            $indent = str_repeat("\t", $depth);
            
            switch ($depth)
            {
                case 0:
                    $indent .= '<div class="flyout"><h3>'.$args->lvl_name.'</h3>';
                    break;
            }
            
            $output .= "\n$indent<ul class=\"nav clearfix sub-menu\">\n";
        }
        
        public function end_lvl( &$output, $depth = 0, $args = array() )
        {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>";
            
            if ($depth == 0)
                $output .= "</div>";
            
            $output .= "\n";
        }
        
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
        {
            $link_before = $args->link_before;
            $link_after = $args->link_after;
            
            switch ($depth)
            {
                case 0:
                    $args->link_before = '<span class="left"></span><span class="right"></span><span class="middle"></span><span class="text">';
                    $args->link_after = '</span>';
                    
                    $args->lvl_name = str_replace('<br/>', ' ', apply_filters( 'the_title', $item->title, $item->ID ));
                    break;
                case 1:
                    $args->link_before = '<h4>';
                    $args->link_after = '</h4>';
                    break;
            }
            
            parent::start_el($output, $item, $depth, $args, $id);
            
            $args->link_before = $link_before;
            $args->link_after = $link_after;
        }
    }
    
    class Mainmenu_Bottom_Walker_Nav_Menu extends Walker_Nav_Menu
    {
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
        {
            $link_before = $args->link_before;
            $link_after = $args->link_after;
            
            switch ($depth)
            {
                case 0:
                    $args->link_before = '<h3>';
                    $args->link_after = '</h3>';
                    
                    $item->title = str_replace('<br/>', ' ', $item->title);
                    break;
            }
            
            parent::start_el($output, $item, $depth, $args, $id);
            
            $args->link_before = $link_before;
            $args->link_after = $link_after;
        }
    }
?>