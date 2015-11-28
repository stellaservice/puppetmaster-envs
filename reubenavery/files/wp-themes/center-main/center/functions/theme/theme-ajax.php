<?php
//select icons
function ux_theme_option_select_icons(){
	$icons_fields = ux_theme_icons_fields();
	$get_value = get_option('ux_theme_option_icons_custom');
	$i = $_POST['i'];
	$type = $_POST['type']; ?>

    <div class="ux-theme-option-select-icons">
        <div class="row">
            <div class="col-xs-4">
                <h5><strong><?php esc_html_e('Select Icon','ux'); ?></strong></h5>
                <p class="text-muted"><?php esc_html_e('Choose a icon for this Icon Box','ux'); ?></p>
            </div>
            
            <div class="col-xs-8">
                <select class="form-control">
					<option value="fontawesome"><?php esc_html_e('Font Awesome','ux'); ?></option>
                    <?php if($get_value){ ?>
                        <option value="user-uploaded-icons"><?php esc_html_e('User Uploaded Icons','ux'); ?></option>
                    <?php } ?>
                </select>
                <div class="ux-theme-option-icons">
					<?php foreach($icons_fields as $icon){  ?>
                        <a href="#" class="fontawesome"><i class="<?php echo esc_attr($icon); ?>"></i></a>
                    <?php }
					
					if($get_value){
						foreach($get_value as $portfolio){
							$image_src = wp_get_attachment_image_src($portfolio); ?>
                            <a href="#" class="user-uploaded-icons"><img src="<?php echo esc_url($image_src[0]); ?>" /></a>
						<?php
						}
					} ?>
                    <div class="clearfix"></div>
                    <input type="hidden" id="ux-theme-social-medias-rel" value="<?php echo sanitize_text_field($i); ?>" />
                    <input type="hidden" id="ux-theme-option-icons-input" value="" />
                    <script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery('.ux-theme-option-select-icons').each(function(){
                                var _this = jQuery(this);
								var _this_select = _this.find('select');
								var _this_icon = _this.find('a');
								var _this_input = _this.find('#ux-theme-option-icons-input');
								var _this_rel = jQuery('#ux-theme-social-medias-rel').val();
								
								<?php if($type){ ?>
									var _target = jQuery('#<?php echo esc_attr($type); ?>').find('.ux-theme-social-medias[rel=' + _this_rel + ']');
								<?php }else{ ?>
									var _target = jQuery('.ux-theme-social-medias[rel=' + _this_rel + ']');
								<?php } ?>
								
								var _target_icon = _target.find('.new-media-col-icon');
								
								_this_select.change(function(){
									var _select_val = jQuery(this).val();
									_this_icon.each(function(){
                                        if(jQuery(this).hasClass(_select_val)){
											jQuery(this).fadeIn();
										}else{
											jQuery(this).hide();
										}
                                    });
								});
								
								_this_icon.click(function(){
									if(jQuery(this).is('.fontawesome')){
										var _icon = jQuery(this).find('i');
										var _icon_val = _icon.attr('class');
										var _icon_type = 'fontawesome';
									}else{
										var _icon = jQuery(this).find('img');
										var _icon_val = _icon.attr('src');
										var _icon_type = 'user';
									}
									
									_target_icon.find('.icon-content').html(_icon);
									_target_icon.find('.icon-content').next().val(_icon_val);
									_target_icon.find('.icon-content').next().next().val(_icon_type);
									jQuery('#ux-theme-modal').modal('hide');
									return false;
								});
                            });
						});
					</script>
                </div>
            </div>
        </div>
    </div>
    
	<?php
	die('');
}
add_action('wp_ajax_ux_theme_option_select_icons', 'ux_theme_option_select_icons');

//load google font
function ux_theme_option_googlefont(){
	$response = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyC83M8-g7oz8yZSslS7tzkF_5TA3gQfJzs', array('sslverify' => false));
	
	if(is_wp_error($response)){
		echo 'error';
	}else{
		if(isset($response['body']) && $response['body']){
			if(strpos($response['body'], 'error') === false){
				$fonts_json = $response['body'];
				update_option('ux_theme_googlefont', $fonts_json);
				echo 'success';
			}else{
				echo 'error';
			}
		}
	}
	die('');
}
add_action('wp_ajax_ux_theme_option_googlefont', 'ux_theme_option_googlefont');

//add google font
function ux_theme_option_font_ajax(){
	$data = $_POST['data'];
	$fonts = null;
	$fonts_object = null;
	
	$json = get_option('ux_theme_googlefont');
	
	if($json){
		$fonts_object = json_decode($json);
	}
	if($fonts_object && is_object($fonts_object)){
		if($fonts_object->items && is_array($fonts_object->items)){
			$fonts = $fonts_object->items;
			if($data == 'load-fonts'){ ?>
                <option value="-1"><?php esc_html_e('-- Select Font --','ux'); ?></option>
            <?php 
			}
			
			foreach($fonts as $item){
				$family_val = str_replace(' ', '+', $item->family);
				switch($data){
					case 'load-fonts': ?>
                        <option value="<?php echo sanitize_text_field($family_val); ?>"><?php echo esc_html($item->family); ?></option>
					<?php
					break;
					
					case 'load-style':
						$font_family = $_POST['font'];
						$selected = (isset($_POST['selected'])) ? $_POST['selected'] : false;
						if($family_val == $font_family){
							foreach($item->variants as $variants){ ?>
                                <option value="<?php echo sanitize_text_field($variants); ?>" <?php selected(sanitize_text_field($selected), sanitize_text_field($variants)); ?>><?php echo esc_html($variants); ?></option>
                            <?php
							}
						}
					break;
				}
            }
		}
	}
	die('');
}
add_action('wp_ajax_ux_theme_option_font_ajax', 'ux_theme_option_font_ajax');

//theme restore defaults
function ux_theme_option_restore(){
	$delete = delete_option('ux_theme_option');
	echo ($delete) ? 'success' : 'error';
	die('');
}
add_action('wp_ajax_ux_theme_option_restore', 'ux_theme_option_restore');

//load slider
function ux_theme_meta_slider_ajax(){
	$data = $_POST['data'];
	
	switch($data){
		case 'load-slider':
			$selected = (isset($_POST['selected'])) ? $_POST['selected'] : false; ?>
            
            <option value="-1" <?php selected(sanitize_text_field($selected), '-1'); ?>><?php esc_html_e('Select a slider','ux'); ?></option>
            
			<?php $slider = $_POST['slider'];
			switch($slider){
				case 'zoomslider':
					$get_topslider = get_posts(array(
						'posts_per_page' => -1,
						'post_type' => 'zoomslider'
					));
					foreach($get_topslider as $zoomslider){ ?>
						<option value="<?php echo sanitize_text_field($zoomslider->post_name); ?>" <?php selected(sanitize_text_field($selected), sanitize_text_field($zoomslider->post_name)); ?>><?php echo esc_html($zoomslider->post_title); ?></option>
					<?php
					}
				break;
				
				case 'revolutionslider':
					global $wpdb;
					$table_revslider = $wpdb->prefix . "revslider_sliders";
					$db_query = $wpdb->prepare("
						SELECT * FROM %s
						ORDER BY id ASC
						",
						$table_revslider
					);
					$revslidersliders = $wpdb->get_results($db_query);
					
					if(count($revslidersliders)){
						$slider_revslider = array();
						foreach($revslidersliders as $num => $slider){
							$params = (array) json_decode($slider->params);
							$template = $params['template'] == 'true' ? true : false;
							if(!$template){ ?>
                                <option value="<?php echo sanitize_text_field($slider->alias); ?>" <?php selected(sanitize_text_field($selected), sanitize_text_field($slider->alias)); ?>><?php echo esc_html($slider->title); ?></option>
                            <?php
							}
                        }
					}
				break;
				
				case 'layerslider':
					global $wpdb;
					$table_layerslider = $wpdb->prefix . "layerslider";
					$db_query = $wpdb->prepare("
						SELECT * FROM %s
						WHERE flag_hidden = '0' AND flag_deleted = '0'
						ORDER BY id ASC
						",
						$table_layerslider
					);
					$layerslider = $wpdb->get_results($db_query);
					
					if(count($layerslider)){
						$slider_layerslider = array();
						foreach($layerslider as $num => $slider){
							$name = empty($slider->name) ? 'Unnamed' : $slider->name; ?>
                            <option value="<?php echo sanitize_text_field($slider->id); ?>" <?php selected(sanitize_text_field($selected), sanitize_text_field($slider->id)); ?>><?php echo esc_html($name); ?></option>
						<?php	
						}
					}
				break;
			}
			
		break;
	}
	die('');
}
add_action('wp_ajax_ux_theme_meta_slider_ajax', 'ux_theme_meta_slider_ajax');

//generate thumbs
function ux_theme_option_generate_thumbs_ajax(){
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'any'
	));
	
	if($get_posts){
		$thumbnails = array();
		
		foreach($get_posts as $post){
			if(has_post_thumbnail($post->ID)){
				$attachment_metadata = wp_get_attachment_metadata(get_post_thumbnail_id($post->ID));
				$thumbnail_crop = update_post_meta(get_post_thumbnail_id($post->ID), '_thumbnail_crop', true);
				if($attachment_metadata && !$thumbnail_crop){
					$thumbnails[get_post_thumbnail_id($post->ID)] = get_post_thumbnail_id($post->ID);
				}
			}
		}
		
		if(count($thumbnails)){
			foreach($thumbnails as $thumbs){ ?>
				<input class="generate_thumbs_progress_thumbnails" type="hidden" value="<?php echo sanitize_text_field($thumbs); ?>" />
			<?php } ?>
            <input id="generate_thumbs_progress_count" type="hidden" value="<?php echo sanitize_text_field(count($thumbnails)); ?>" />
            <div id="generate_thumbs_progress" class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0/<?php echo esc_attr(count($thumbnails)); ?></div>
            </div>
		<?php
        }
	}else{
		echo 'error';
	}
	
	
	die('');
}
add_action('wp_ajax_ux_theme_option_generate_thumbs_ajax', 'ux_theme_option_generate_thumbs_ajax');

//process generate thumbs size
function ux_theme_option_process_generate_thumbs_size($image_width, $image_height, $target_name, $target_width, $target_height, $crop){
	$thumbs_width = $target_width;
	$thumbs_height = $target_height;
	$thumbs_crop = $crop;
	
	if($image_width < $image_height){ //is long vertical image
		if($target_name == 'blog-thumb' || $target_name == 'imagebox-thumb' || $target_name == 'image-thumb-1'){
			if($image_width < $target_width){
				$thumbs_width = $image_width;
				$thumbs_height = $image_width;
			}
		}
		
		if($target_name == 'standard-thumb'){
			$thumbs_crop = false;
			if($image_width < $target_width){
				$thumbs_width = $image_width;
			}
		}
		
		if($target_name == 'standard-blog-thumb' || $target_name == 'image-thumb'){
			if($image_width < $target_width){
				$target_ratio = $target_height / $target_width;
				$thumbs_width = $image_width;
				$thumbs_height = $image_width * $target_ratio;
			}
		}
		
		if($target_name == 'image-thumb-2' || $target_name == 'image-thumb-3'){
			if($image_width < $target_width){
				$target_ratio = $target_height / $target_width;
				$thumbs_width = $image_width;
				$thumbs_height = $image_width * $target_ratio;
				
				if($image_height < $thumbs_height){
					$target_ratio = $image_height / $thumbs_height;
					$thumbs_height = $image_height;
					$thumbs_width = $image_width * $target_ratio;
				}
			}
			
			if($image_width > $target_width){
				$target_ratio = $target_width / $image_width;
				$thumbs_height = $image_height * $target_ratio;
				
				if($thumbs_height < $target_height){
					$target_ratio = $target_width / $target_height;
					$thumbs_height = $image_height;
					$thumbs_width = $image_height * $target_ratio;
					
				}
			}
		}
	}
	
	if($image_width > $image_height){ //is long horizontal image
		if($target_name == 'blog-thumb' || $target_name == 'imagebox-thumb' || $target_name == 'image-thumb-1'){
			if($image_height < $target_height){
				$thumbs_width = $image_height;
				$thumbs_height = $image_height;
			}
		}
		
		if($target_name == 'standard-thumb'){
			$thumbs_crop = false;
			if($image_width < $target_width){
				$thumbs_width = $image_width;
			}
		}
		
		if($target_name == 'standard-blog-thumb' || $target_name == 'image-thumb'){
			if($image_height < $target_height){
				$target_ratio = $target_width / $target_height;
				$thumbs_height = $image_height;
				$thumbs_width = $image_height * $target_ratio;
				
				if($image_width < $thumbs_width){
					$target_ratio = $image_width /  $thumbs_width;
					$thumbs_width = $image_width;
					$thumbs_height = $image_height * $target_ratio;
				}
			}
			
			if($image_height > $target_height){
				$target_ratio = $target_height / $image_height;
				$thumbs_width = $image_width * $target_ratio;
				
				if($thumbs_width < $target_width){
					$target_ratio = $target_height / $target_width;
					$thumbs_width = $image_width;
					$thumbs_height = $image_width * $target_ratio;
				}
				
				if($thumbs_width > $target_width){
					$thumbs_width = $target_width;
					$thumbs_height = $target_height;
				}
			}
		}
		
		if($target_name == 'image-thumb-2' || $target_name == 'image-thumb-3'){
			if($image_height < $target_height){
				$target_ratio = $target_width / $target_height;
				$thumbs_height = $image_height;
				$thumbs_width = $image_height * $target_ratio;
			}
		}
		
	}
	
	if($image_width == $image_height){ //is square image
		if($target_name == 'blog-thumb' || $target_name == 'imagebox-thumb' || $target_name == 'image-thumb-1' || $target_name == 'standard-thumb'){
			if($image_width < $target_width){
				$thumbs_width = $image_width;
				$thumbs_height = $image_height;
			}
		}
		
		if($target_name == 'standard-blog-thumb' || $target_name == 'image-thumb'){
			if($image_width < $target_width){
				$target_ratio = $target_height / $target_width;
				$thumbs_width = $image_width;
				$thumbs_height = $image_height * $target_ratio;
			}
		}
		
		if($target_name == 'image-thumb-2' || $target_name == 'image-thumb-3'){
			if($image_height < $target_height){
				$target_ratio = $target_width / $target_height;
				$thumbs_height = $image_height;
				$thumbs_width = $image_width * $target_ratio;
			}
		}
	}
	
	return array($thumbs_width, $thumbs_height, $thumbs_crop);
}

//process generate thumb
function ux_theme_option_process_generate_thumb($thumbnail_id){
	$return = false;
	$upload_dir = wp_upload_dir();
	$attachment_metadata = wp_get_attachment_metadata($thumbnail_id);
	
	$custom_image_size = array(
		array('blog-thumb', 200, 200),
		array('imagebox-thumb', 400, 400),
		array('standard-blog-thumb', 800, 400),
		array('standard-thumb', 800, 9999),
		array('image-thumb', 800, 480),
		array('image-thumb-1', 800, 800),
		array('image-thumb-2', 400, 800),
		array('image-thumb-3', 500, 800),
	);
	
	if($attachment_metadata){
		$thumbnail_file = $upload_dir['basedir'] . '/' . $attachment_metadata['file'];
		$thumbnail_width = intval($attachment_metadata['width']);
		$thumbnail_height = intval($attachment_metadata['height']);
		$thumbnail_date = explode('/', $attachment_metadata['file']);
		$thumbnail_date_y = $thumbnail_date[0];
		$thumbnail_date_m = $thumbnail_date[1];
		$thumbnail_pathinfo = pathinfo($thumbnail_file);
		$thumbnail_extension = $thumbnail_pathinfo['extension'];
		$thumbnail_name = basename($thumbnail_file, '.' .$thumbnail_extension);
		
		foreach($custom_image_size as $image_size){
			$new_image = wp_get_image_editor($thumbnail_file);
			
			if(!is_wp_error($new_image)){
				$image_size_name = $image_size[0];
				$image_size_width = intval($image_size[1]);
				$image_size_height = intval($image_size[2]);
				
				$final_size = ux_theme_option_process_generate_thumbs_size($thumbnail_width, $thumbnail_height, $image_size_name, $image_size_width, $image_size_height, array('center', 'center'));
				$final_width = $final_size[0];
				$final_height = $final_size[1];
				$final_crop = $final_size[2];

				$new_image->resize($final_width, $final_height, $final_crop);
				$new_image_dir = $upload_dir['basedir'] . '/' . $thumbnail_date_y . '/' . $thumbnail_date_m;
				$new_image_file = $new_image_dir . '/' . $thumbnail_name . '-' . $image_size_name . '-' . $new_image->get_suffix() . '.' . $thumbnail_extension; 
				
				$result = @unlink($new_image_file); 
				$new_image->save($new_image_file);
				$attachment_metadata['sizes'][$image_size_name] = array(
					'file' => $thumbnail_name . '-' . $image_size_name . '-' . $new_image->get_suffix() . '.' . $thumbnail_extension,
					'width' => $image_size_width,
					'height' => $image_size_height
				);
				$new_image_update = wp_update_attachment_metadata($thumbnail_id, $attachment_metadata);
			}
		}
		
		$thumbnail_update = update_post_meta($thumbnail_id, '_thumbnail_crop', 'yes');
		if($thumbnail_update){
			$return = true;
		}
	}
	
	return $return;
}

//process generate thumbs
function ux_theme_option_process_generate_thumbs_ajax(){
	$thumbnail_id = $_POST['thumbnail_id'];
	if(ux_theme_option_process_generate_thumb($thumbnail_id)){
		echo 'success';
	}
	die('');
}
add_action('wp_ajax_ux_theme_option_process_generate_thumbs_ajax', 'ux_theme_option_process_generate_thumbs_ajax');


?>