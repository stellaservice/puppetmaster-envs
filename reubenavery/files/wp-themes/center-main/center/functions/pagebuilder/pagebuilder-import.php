<?php
//theme import module set taxonomy
function ux_import_module_set_taxonomy(){
	global $wpdb;
	
	$db_query = $wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = 'modules')
		AND (`meta_key` LIKE 'module_carousel_category'
		  OR `meta_key` LIKE 'module_blog_category'
		  OR `meta_key` LIKE 'module_gallery_category'
		  OR `meta_key` LIKE 'module_latestpost_category'
		  OR `meta_key` LIKE 'module_liquidlist_category'
		  OR `meta_key` LIKE 'module_portfolio_category'
		  OR `meta_key` LIKE 'module_slider_category'
		  OR `meta_key` LIKE 'module_client_category'
		  OR `meta_key` LIKE 'module_faq_category'
		  OR `meta_key` LIKE 'module_jobs_category'
		  OR `meta_key` LIKE 'module_team_category'
		  OR `meta_key` LIKE 'module_testimonials_category'))
		", ''
	);
	$get_category = $wpdb->get_results($db_query);
	
	if($get_category){
		foreach($get_category as $category){
			$category_id = $category->meta_value;
			$post_id = $category->ID;
			$post_type = get_post($post_id)->post_type;
			$meta_key = $category->meta_key;
			$category_taxonomy = 'category';
			
			switch($meta_key){
				case 'module_client_category':       $category_taxonomy = 'client_cat'; break;
				case 'module_faq_category':          $category_taxonomy = 'question_cat'; break;
				case 'module_jobs_category':         $category_taxonomy = 'job_cat'; break;
				case 'module_team_category':         $category_taxonomy = 'team_cat'; break;
				case 'module_testimonials_category': $category_taxonomy = 'testimonial_cat'; break;
			}
			
			$category_id = ux_import_taxonomy_replace($category_taxonomy, $category_id);
			update_post_meta($post_id, $category->meta_key, $category_id);
		}
	}
	
}
add_action( 'import_end' , 'ux_import_module_set_taxonomy' );

//theme import module layerslider
function ux_import_module_layerslider(){
	global $wpdb;
	$db_query = $wpdb->prepare("
		SELECT `post_id`, `meta_key`
		FROM $wpdb->postmeta
		WHERE `meta_value` LIKE '%layerslider%'
		", ''
	);
	$get_module_layerslider = $wpdb->get_results($db_query);
	
	if($get_module_layerslider){
		foreach($get_module_layerslider as $module_layerslider){
			$post = get_post($module_layerslider->post_id);
			switch($post->post_type){
				case 'modules':
					$get_post_meta = get_post_meta($module_layerslider->post_id, 'module_slider_layerslider', true);
					$new_id = get_option('import_cache_layerslider_' . $get_post_meta);
					update_post_meta($module_layerslider->post_id, 'module_slider_layerslider', $new_id);
				break;
			}
		}
	}
}
add_action( 'import_end' , 'ux_import_module_layerslider' );

//theme import set module
function ux_import_set_modules(){
	global $wpdb;
	
	//module image box / single image
	$db_query_image = $wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = 'modules')
		AND (`meta_key` LIKE 'module_singleimage_image'
		  OR `meta_key` LIKE 'module_imagebox_image'
		  OR `meta_key` LIKE 'module_fullwidth_background_image'
		  OR `meta_key` LIKE 'module_fullwidth_alt_image'
		  OR `meta_key` LIKE 'module_video_cover'
		  OR `meta_key` LIKE 'module_googlemap_pin_custom'))
		", ''
	);
	$get_module_image = $wpdb->get_results($db_query_image);
	
	if($get_module_image){
		foreach($get_module_image as $module_image){
			$image_url = $module_image->meta_value;
			$post_id = $module_image->ID;
			$post_type = get_post($post_id)->post_type;
			$attachment_url = ux_import_attachment_replace('url', $image_url);
			update_post_meta($post_id, $module_image->meta_key, $attachment_url);
		}
	}
	
	//module gallery library
	$db_query_gallery = $wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = 'modules')
		AND (`meta_key` LIKE 'module_gallery_library'))
		", ''
	);
	$get_module_gallery = $wpdb->get_results($db_query_gallery);
	
	if($get_module_gallery){
		foreach($get_module_gallery as $gallery){
			$post_id = $gallery->ID;
			$get_post_meta = get_post_meta($post_id, 'module_gallery_library', true);
			if($get_post_meta){
				if(is_array($get_post_meta)){
					foreach($get_post_meta as $num => $image){
						$attachment_id = ux_import_attachment_replace('id', $image);
						$get_post_meta[$num] = $attachment_id;
					}
				}else{
					$attachment_id = ux_import_attachment_replace('id', $image);
					$get_post_meta = $attachment_id;
				}
				update_post_meta($post_id, 'module_gallery_library', $get_post_meta);
			}
		}
	}
}
add_action( 'import_end' , 'ux_import_set_modules' );

//theme import process module
function ux_import_process_modules_demo_images(){
	global $wpdb;
	
	$demo_attachment = get_option('ux_theme_demo_attachment');
	if($demo_attachment){
	
		//module image box / single image
		$db_query_image = $wpdb->prepare("
			SELECT 
			`$wpdb->postmeta`.`post_id` as 'ID',
			`$wpdb->postmeta`.`meta_key` as 'meta_key',
			`$wpdb->postmeta`.`meta_value` as 'meta_value',
			`$wpdb->posts`.`post_type` as 'post_type'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = 'modules')
			AND (`meta_key` LIKE 'module_singleimage_image'
			  OR `meta_key` LIKE 'module_imagebox_image'
			  OR `meta_key` LIKE 'module_fullwidth_background_image'
			  OR `meta_key` LIKE 'module_fullwidth_alt_image'
			  OR `meta_key` LIKE 'module_video_cover'
			  OR `meta_key` LIKE 'module_googlemap_pin_custom'))
			", ''
		);
		$get_module_image = $wpdb->get_results($db_query_image);
		
		if($get_module_image){
			foreach($get_module_image as $module_image){
				$image_url = $module_image->meta_value;
				$post_id = $module_image->ID;
				$post_type = get_post($post_id)->post_type;
				$attachment_url = wp_get_attachment_image_src($demo_attachment, 'full');
				update_post_meta($post_id, $module_image->meta_key, $attachment_url[0]);
			}
		}
		
		//module gallery library
		$db_query_gallery = $wpdb->prepare("
			SELECT 
			`$wpdb->postmeta`.`post_id` as 'ID',
			`$wpdb->postmeta`.`meta_key` as 'meta_key',
			`$wpdb->postmeta`.`meta_value` as 'meta_value',
			`$wpdb->posts`.`post_type` as 'post_type'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = 'modules')
			AND (`meta_key` LIKE 'module_gallery_library'))
			", ''
		);
		$get_module_gallery = $wpdb->get_results($db_query_gallery);
		
		if($get_module_gallery){
			foreach($get_module_gallery as $gallery){
				$post_id = $gallery->ID;
				$get_post_meta = get_post_meta($post_id, 'module_gallery_library', true);
				if($get_post_meta){
					if(is_array($get_post_meta)){
						foreach($get_post_meta as $num => $image){
							$get_post_meta[$num] = $demo_attachment;
						}
					}else{
						$get_post_meta = $demo_attachment;
					}
					update_post_meta($post_id, 'module_gallery_library', $get_post_meta);
				}
			}
		}
		
		//module fullwidth front-background parallax
		$db_query_foreground = $wpdb->prepare("
			SELECT `$wpdb->postmeta`.`post_id` as 'ID'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = 'modules')
			AND (`meta_key` LIKE 'module_fullwidth_foreground'))
			", ''
		);
		
		$get_module_full_foreground = $wpdb->get_results($db_query_foreground);
		
		if($get_module_full_foreground){
			foreach($get_module_full_foreground as $foreground){
				$post_id = $foreground->ID;
				$get_post_meta = get_post_meta($post_id, 'module_fullwidth_foreground', true);
				if($get_post_meta){
					$foreground_image = $get_post_meta['image'];
					foreach($foreground_image as $num => $image){
						$get_post_meta['image'][$num] = $demo_attachment;
					}
					update_post_meta($post_id, 'module_fullwidth_foreground', $get_post_meta);
				}
			}
		}
	}
}
add_action('ux_theme_process_demo_images_ajax', 'ux_import_process_modules_demo_images');
?>