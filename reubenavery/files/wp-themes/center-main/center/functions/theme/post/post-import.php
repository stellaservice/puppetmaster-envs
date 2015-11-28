<?php
//theme import post set taxonomy
function ux_import_set_post_taxonomy(){
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'page',
		'post_status' => 'any',
		'meta_key' => 'ux_theme_meta'
	));
	
	if($get_posts){
		foreach($get_posts as $post){
			$ux_theme_meta = get_post_meta($post->ID, 'ux_theme_meta', true);
			if(isset($ux_theme_meta['theme_meta_page_portfolio_category'])){
				$category_id = $ux_theme_meta['theme_meta_page_portfolio_category'];
				$category_id = ux_import_taxonomy_replace('category', $category_id);
				
				$ux_theme_meta['theme_meta_page_portfolio_category'] = $category_id;
				update_post_meta($post->ID, 'ux_theme_meta', $ux_theme_meta);
			}
		}
	}
}
add_action( 'import_end' , 'ux_import_set_post_taxonomy' );

//theme import set post meta
function ux_import_set_post_meta(){
	global $wpdb;
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'any',
		'post_status' => 'any'
	));
	
	foreach($get_posts as $post){
		$get_custom_meta = $wpdb->get_results($wpdb->prepare("
			SELECT `meta_id`, `meta_key`, `meta_value`
			FROM $wpdb->postmeta 
			WHERE `post_id` = %s
			",
			$post->ID
		));
		
		if($get_custom_meta){
			foreach($get_custom_meta as $meta){
				$meta_value = get_post_meta($post->ID, $meta->meta_key, false);
				
				if(count($meta_value) > 1){
					$this_meta_value = get_post_meta($post->ID, $meta->meta_key, true);
					delete_post_meta($post->ID, $meta->meta_key, $this_meta_value);
					add_post_meta($post->ID, $meta->meta_key, $this_meta_value);
				}
			}
		}
	}
}
add_action( 'import_end' , 'ux_import_set_post_meta' );

//theme import set posts
function ux_import_set_posts(){
	global $wpdb;
	$get_meta_image = $wpdb->get_results($wpdb->prepare("
		SELECT `post_id` as 'ID', `meta_key`, `meta_value`
		FROM $wpdb->postmeta
		WHERE ((`meta_key` LIKE 'ux_theme_meta')
		AND (`meta_value` LIKE '%theme_zoomslider_slide_bg_image%'))
		", ''
	));
	
	if($get_meta_image){
		foreach($get_meta_image as $meta_image){
			$post_id = $meta_image->ID;
			$get_post_meta = get_post_meta($post_id, 'ux_theme_meta', true);
			if($get_post_meta){
				foreach($get_post_meta as $meta_key => $meta_value){
					if($meta_key == 'theme_zoomslider_slide_bg_image'){
						if(count($meta_value)){
							$zoomslider_slides = $meta_value;
							foreach($zoomslider_slides as $slide_num => $slide){
								$attachment_url = ux_import_attachment_replace('url', $slide);
								$get_post_meta['theme_zoomslider_slide_bg_image'][$slide_num] = $attachment_url;
							}
						}
					}
				}
			}
			update_post_meta($post_id, 'ux_theme_meta', $get_post_meta);
		}
	}
	
	//post gallery library
	$get_post_gallery = $wpdb->get_results($wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = 'post')
		AND (`meta_key` LIKE 'ux_theme_meta')
		AND (`meta_value` LIKE '%theme_meta_portfolio%'))
		", ''
	));
	
	if($get_post_gallery){
		foreach($get_post_gallery as $gallery){
			$post_id = $gallery->ID;
			$get_post_meta = get_post_meta($post_id, 'ux_theme_meta', true);
			if($get_post_meta){
				foreach($get_post_meta as $meta_key => $meta_value){
					if($meta_key == 'theme_meta_portfolio'){
						if(is_array($meta_value)){
							foreach($meta_value as $num => $image){
								$attachment_id = ux_import_attachment_replace('id', $image);
								$get_post_meta['theme_meta_portfolio'][$num] = $attachment_id;
							}
						}
					}
				}
				update_post_meta($post_id, 'ux_theme_meta', $get_post_meta);
			}
		}
	}
}
add_action( 'import_end' , 'ux_import_set_posts' );

//theme import process module
function ux_import_process_post_content_demo_images(){
	global $wpdb;
	
	$demo_attachment = get_option('ux_theme_demo_attachment');
	if($demo_attachment){
		
		$get_post = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => array('post', 'page', 'modules')
		));
		
		if($get_post){
			foreach($get_post as $post){
				
				//permalink
				preg_match_all("#href=('|\")(.*)('|\")#isU", $post->post_content, $permalink);
				if(count($permalink[2])){
					foreach($permalink[2] as $from_url){
						$to_href = ux_import_attachment_replace('url', $from_url);
						$wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_href));
					}
				}
				
				//image
				preg_match_all("#src=('|\")(.*)('|\")#isU", $post->post_content, $images);
				if(count($images[2])){
					foreach($images[2] as $from_img){
						$to_img = ux_import_attachment_replace('url', $from_img);
						$wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_img, $to_img));
					}
				}
			}
		}
	}
}
add_action('ux_theme_process_demo_images_ajax', 'ux_import_process_post_content_demo_images');

?>