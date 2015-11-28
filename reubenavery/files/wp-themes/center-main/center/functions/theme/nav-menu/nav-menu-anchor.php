<?php
//** nav menu anchor field
function ux_nav_menu_anchor_field($item){
	$item_id = $item->ID;
	
	$pb_switch = get_post_meta($item->object_id, 'ux-pb-switch', true);
	$ux_pb_meta = get_post_meta($item->object_id, 'ux_pb_meta', true);
	
	$anchor_data = array();
	if($ux_pb_meta){
		foreach($ux_pb_meta as $num => $wrap){
			$type = $wrap['type'];
			$itemid = $wrap['itemid'];
			
			if($type == 'fullwidth'){
				$module_post = ux_pb_item_postid($itemid);
				
				$anchor_name = get_post_meta($module_post, 'module_fullwidth_anchor_name', true);
				$anchor_slug = str_replace(' ', '-', $anchor_name);
				
				$push = array(
					'slug' => $anchor_slug,
					'name' => $anchor_name
				);
				
				if($anchor_name != ''){
					array_push($anchor_data, $push);
				}
			}
		}
	}
	
	if($item->object == 'page' && $pb_switch == 'pagebuilder' && count($anchor_data)){
		$item_anchor = $item->anchor ? $item->anchor : 'top'; ?>
    
        <p class="field-anchor description description-thin">
            <label for="<?php echo esc_attr('edit-menu-item-anchor-' .$item_id); ?>">
                <?php esc_html_e('Anchor','ux'); ?><br /> 
                <select id="<?php echo esc_attr('edit-menu-item-anchor-' .$item_id); ?>" class="widefat code edit-menu-item-anchor" name="<?php echo esc_attr('menu-item-anchor[' .$item_id. ']'); ?>">
					
                    <option value="0" <?php selected(esc_attr($item_anchor), 0); ?>><?php esc_attr_e('None','ux'); ?></option>

                    <option value="top" <?php selected(esc_attr($item_anchor), 'top'); ?>><?php esc_attr_e('The top of this page','ux'); ?></option>
					
					<?php foreach($anchor_data as $anchor){ ?>
                        
                        <option value="<?php echo esc_attr($anchor['slug']); ?>" <?php selected(esc_attr($item_anchor), $anchor['slug']); ?>><?php echo esc_attr($anchor['name']); ?></option>
                        
                    <?php } ?>
                    
                </select>
            </label>   
        </p>
        
    <?php
	}
}
add_action('ux_nav_menu_field', 'ux_nav_menu_anchor_field');

//** nav menu anchor field save
function ux_nav_menu_anchor_field_save($menu_id, $menu_item_db_id, $args){   
    if(isset($_REQUEST['menu-item-anchor']) && is_array($_REQUEST['menu-item-anchor'])){   
		if(isset($_REQUEST['menu-item-anchor'][$menu_item_db_id])){ 
			$custom_value = $_REQUEST['menu-item-anchor'][$menu_item_db_id];   
			update_post_meta($menu_item_db_id, '_menu_item_anchor', $custom_value); 
		}
    }   
}   
add_action('wp_update_nav_menu_item', 'ux_nav_menu_anchor_field_save', 15, 3);   

//** nav menu anchor setup
function ux_nav_menu_anchor_field_setup($menu_item){   
    $menu_item->anchor = get_post_meta($menu_item->ID, '_menu_item_anchor', true);
	
	$anchor_url = false;
	
	if($menu_item->anchor){
		 $anchor_url = '#' . $menu_item->anchor;
	}
	
	if(is_page() || is_single() || is_archive() || is_search()){
		if($menu_item->object_id == get_the_ID()){
			$menu_item->url = $anchor_url;
			if($menu_item->anchor){
				//$menu_item->classes[] = 'ux-menu-anchor-heightlight';
				$menu_item->classes[] = 'anchor-in-current-page';
			}
		}else{
			$menu_item->url = $menu_item->url . $anchor_url;
			$menu_item->classes[] = 'external';
		}
	}
	
    return $menu_item;   
}  
add_filter('wp_setup_nav_menu_item', 'ux_nav_menu_anchor_field_setup');   

?>