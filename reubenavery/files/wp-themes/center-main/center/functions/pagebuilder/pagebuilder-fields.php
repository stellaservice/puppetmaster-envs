<?php
//pagebuilder fields
function ux_pb_getfield($item, $itemid, $moduleid){
	$select_fields = ux_pb_module_select_fields();
	$social_networks = ux_theme_social_networks();
	$theme_color = ux_theme_color();
	$key = 'ux-pb-meta';
	
	$type        = isset($item['type']) ? $item['type'] : false;
	$name        = isset($item['name']) ? $item['name'] : false;
	$unit        = isset($item['unit']) ? $item['unit'] : false;
	$default     = isset($item['default']) ? $item['default'] : false;
	$control     = isset($item['control']) ? $item['control'] : false;
	$placeholder = isset($item['placeholder']) ? $item['placeholder'] : false;
	$taxonomy = isset($item['taxonomy']) ? $item['taxonomy'] : 'category';
	
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'name' => $itemid,
		'post_type' => 'modules'
	));
	
	$post_id = $get_posts ? $get_posts[0]->ID : false;
	$get_post_meta = get_post_meta($post_id, $name, true);
	$get_value = $get_post_meta ? $get_post_meta : $default;
	$control = $control ? 'data-name="' . $control['name'] . '" data-value="' . $control['value'] . '"' : false;
	
	if($type){
		switch($type){
			case 'text': ?>
                <div class="form-group">
                    <input type="text" name="<?php echo esc_attr($name); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" class="form-control" value="<?php echo esc_attr($get_value); ?>" />
                </div>
                <?php if($unit){ ?>
                    <p class="text-danger"><?php esc_html_e('Unit:','ux'); ?> <?php echo esc_html($unit); ?></p>
                <?php
				}
			break;
			
			case 'textarea' ?>
                <textarea name="<?php echo esc_attr($name); ?>" class="form-control" rows="3"><?php echo esc_textarea($get_value); ?></textarea>
            <?php
			break;
			
			case 'select':
				if(isset($select_fields[$name])){ ?>
                    <select class="form-control" name="<?php echo esc_attr($name); ?>" data-value="<?php echo esc_attr($get_value); ?>">
                        <?php foreach($select_fields[$name] as $select){ ?>
                            <option value="<?php echo esc_attr($select['value']); ?>" <?php selected(esc_attr($get_value), $select['value']); ?>><?php echo esc_attr($select['title']); ?></option>
                        <?php } ?>
                    </select>
                <?php
				}
			break;
			
			case 'image_select':
				if(isset($select_fields[$name])){ ?>
					<ul class="nav nav-pills ux-pb-icon-mask">
						<?php foreach($select_fields[$name] as $select){
							$current = $get_value == $select['value'] ? 'current' : false; ?>
                            <li><a href="#" class="<?php echo esc_attr('mask-' .$select['value']); ?> <?php echo esc_attr($current); ?>" data-value="<?php echo esc_attr($select['value']); ?>"><span class="choosed"></span></a></li>
                        <?php } ?>
                        <input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($get_value); ?>" />
                    </ul>
				<?php
				}
			break;
			
			case 'bg-color':
				if(count($theme_color)){ ?>
                    <ul class="nav nav-pills ux-pb-bg-color">
						<?php foreach($theme_color as $color){ ?>
                            <li><button type="button" class="btn" data-value="<?php echo esc_attr($color['id']); ?>" style="background-color: <?php echo esc_attr($color['rgb']); ?>"><span class="glyphicon glyphicon-ok"></span></button></li>
                        <?php } ?>
                        <li><button type="button" class="btn btn-cancelcolor"></button></li>
                    </ul>
                    <input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($get_value); ?>">
				<?php
                }
			break;
			
			case 'switch-color': ?>
                <div class="row">
                    <div class="form-group ux-pb-switch-color col-sm-4">
                        <input type="text" class="form-control switch-color" data-position="bottom left" value="<?php echo esc_attr($get_value); ?>" name="<?php echo esc_attr($name); ?>" />
                        <span class="ux-pb-remove-color"></span>
                    </div>
                </div>
            <?php
			break;
			
			case 'upload':
				$image_src = $get_value ? $get_value : esc_url(UX_PAGEBUILDER . '/images/no-image.png'); ?>
                <div class="row">
                    <div class="input-group ux-pb-upload col-xs-10 input-group-sm">
                        <input type="text" name="<?php echo esc_attr($name); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" class="form-control" value="<?php echo esc_attr($get_value); ?>" />
                        <span class="input-group-btn">
                            <button class="btn btn-default ux-pb-upload-image" type="button"><?php esc_html_e('Upload Image','ux'); ?></button>
                            <button class="btn btn-danger ux-pb-remove-image" type="button"><?php esc_html_e('Remove','ux'); ?></button>
                        </span>
                    </div>
                    <div class="col-xs-10" style="margin-top:10px;">
                        <img src="<?php echo esc_attr($image_src); ?>" class="img-responsive" />
                    </div>
                </div>
            <?php
			break;
			
			case 'switch': ?>
                <div class="switch pb-make-switch" data-on="success" data-off="danger">
                    <input type="checkbox" value="on" <?php checked(esc_attr($get_value), 'on'); ?> />
                    <input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($get_value); ?>" data-value="<?php echo esc_attr($get_value); ?>" />
                </div>
            <?php
			break; 
			
			case 'tabs':
				if($get_value){
					if(is_array($get_value)){
						foreach($get_value as $i => $tab){
							ux_pb_getfield_tabs_template($name, esc_attr(__('Tab ','ux') . $i), $tab, $placeholder);
						}
					}else{
						ux_pb_getfield_tabs_template($name, esc_attr(__('Tab 1','ux')), $get_value, $placeholder);
					}
				}else{
					ux_pb_getfield_tabs_template($name, esc_attr(__('Tab 1','ux')), $get_value, $placeholder);
				}
			break;
			
			case 'checkbox-group':
				if(isset($select_fields[$name])){ ?>
                    <ul class="nav nav-pills ux-pb-checkbox-group">
                        <?php foreach($select_fields[$name] as $i => $select){
							$value = false;
							if(is_array($get_value)){
								$value = (in_array($select['value'], $get_value)) ? $select['value'] : false;
							}else{
								$value = $get_value;
							} ?>
                            <li>
                                <input type="checkbox" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($select['value']); ?>" <?php checked(esc_attr($value), esc_attr($select['value'])); ?>>
                                <span class="pull-left"><?php echo esc_html($select['title']); ?></span>
                            </li>
                        <?php } ?>
                    </ul>
				<?php
				}
			break;
			
			case 'icons':
				$icons_fields = ux_theme_icons_fields();
				$icons_uploaded = get_option('ux_theme_option_icons_custom');
				$icons_type = 'fontawesome';
				
				$hidden_fa = false;
				$hidden_user = 'hidden';
				if(!(strstr($get_value, "fa fa")) && $get_value){
					$icons_type = 'user-uploaded-icons';
					$hidden_fa = 'hidden';
					$hidden_user = false;
				}
				
				if($moduleid != 'progress-bar'){ ?>
				
                    <p><select class="form-control fonts-module-icons">
                        <option value="fontawesome" <?php selected(esc_attr($icons_type), 'fontawesome'); ?>><?php esc_attr_e('Font Awesome','ux'); ?></option>
                        <?php if($icons_uploaded){ ?>
                            <option value="user-uploaded-icons" <?php selected(esc_attr($icons_type), 'user-uploaded-icons'); ?>><?php esc_attr_e('User Uploaded Icons','ux'); ?></option>
                        <?php } ?>
                    </select></p>
                
                <?php } ?>
                
                <div class="ux-pb-module-icons">
                    <?php if($icons_fields){ ?>
						<div class="ux-pb-module-icons-fontawesome <?php echo esc_attr($hidden_fa); ?>" data-id="fontawesome">
							<?php foreach($icons_fields as $icon){
                                $current = $get_value == $icon ? 'current' : false; ?>
                                <a href="#" class="module-icon <?php echo esc_attr($current); ?>"><i class="<?php echo esc_attr($icon); ?>"></i></a>
                            <?php } ?>
                            <div class="clearfix"></div>
                        </div>
					<?php
                    }
					
					if($icons_uploaded){ ?>
                        <div class="ux-pb-module-icons-uploaded <?php echo esc_attr($hidden_user); ?>" data-id="user-uploaded-icons">
                            <?php foreach($icons_uploaded as $portfolio){
                                $image_src = wp_get_attachment_image_src($portfolio, true);
                                $current = $get_value == $image_src[0] ? 'current' : false; ?>
                                <a href="#" class="module-icon <?php echo esc_attr($current); ?>"><img src="<?php echo esc_url($image_src[0]); ?>" width="48" /></a>
                            <?php } ?>
                            <div class="clearfix"></div>
                        </div>
					<?php } ?>
                    <input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($get_value); ?>" />
                </div>
            <?php
			break;
			
			case 'price-item': ?>
                <button type="button" class="btn btn-info ux-pb-price-item-add"><?php esc_html_e('Add','ux'); ?></button>
                <div class="ux-pb-module-items-price-template">
                    <div class="row">
                        <div class="col-xs-4">
                            <select class="form-control input-sm">
                                <option value="fa fa-check"><?php esc_attr_e('Check','ux'); ?></option>
                                <option value="fa fa-arrow-right"><?php esc_attr_e('Arrow','ux'); ?></option>
                                <option value="noting"><?php esc_attr_e("Don't Show Icon", 'ux'); ?></option>
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" value="" class="form-control input-sm" />
                        </div>
                        <div class="col-xs-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger btn-sm ux-pb-items-remove"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group ux-pb-module-items-price"></div>
                <textarea name="<?php echo esc_attr($name); ?>" class="form-control hidden" rows="3"><?php echo esc_textarea($get_value); ?></textarea>
            <?php
			break;
			
			case 'items': ?>
                <button type="button" class="btn btn-info ux-pb-items-add"><?php esc_html_e('Add Item','ux'); ?></button>
                <div class="ux-pb-module-items-template">
					<?php ux_pb_getfield_items_template($name, array(
						'title' => __('New Item','ux'),
						'value' => false,
						'icons' => false,
						'textarea' => false,
						'percent' => 0,
						'bgcolor' => false,
						'bgcolor2' => false,
						'price' => 0,
						'button_text' => false,
						'button_link' => false,
						'upload' => false,
						'select' => false,
						'select2' => false,
						'switch' => false
					)); ?>
                </div>
                <div class="list-group ux-pb-module-items">
					<?php if($get_value){
						$items_count = count($get_value['items']);
						$subcontrol_value = array();
						$get_subcontrol = ux_pb_getfield_subcontrol($name);
						if($get_subcontrol){
							foreach($get_subcontrol as $subcontrol => $field){
								$field_value = $field['value'];
								$field_type = $field['type'];
								$subcontrol = $field_type == 'content' ? 'ux-pb-module-content' : $subcontrol;
								$subcontrol_value[$field_value] = $get_value[$subcontrol];
							}
						}
						
						for($i = 0; $i < $items_count; $i++){
							$num = $i + 1;
							$title = isset($subcontrol_value['title'][$i]) ? $subcontrol_value['title'][$i] : __('Item ','ux') . $num;
							$content = isset($subcontrol_value['content'][$i]) ? $subcontrol_value['content'][$i] : false;
							$icons = isset($subcontrol_value['icons'][$i]) ? $subcontrol_value['icons'][$i] : false;
							$textarea = isset($subcontrol_value['textarea'][$i]) ? $subcontrol_value['textarea'][$i] : false;
							$percent = isset($subcontrol_value['percent'][$i]) ? $subcontrol_value['percent'][$i] : 0;
							$bgcolor = isset($subcontrol_value['bgcolor'][$i]) ? $subcontrol_value['bgcolor'][$i] : false;
							$bgcolor2 = isset($subcontrol_value['bgcolor2'][$i]) ? $subcontrol_value['bgcolor2'][$i] : false;
							$select = isset($subcontrol_value['select'][$i]) ? $subcontrol_value['select'][$i] : false;
							$select2 = isset($subcontrol_value['select2'][$i]) ? $subcontrol_value['select2'][$i] : false;
							$switch = isset($subcontrol_value['switch'][$i]) ? $subcontrol_value['switch'][$i] : false;
							$price = isset($subcontrol_value['price'][$i]) ? $subcontrol_value['price'][$i] : 0;
							$button_text = isset($subcontrol_value['button_text'][$i]) ? $subcontrol_value['button_text'][$i] : false;
							$button_link = isset($subcontrol_value['button_link'][$i]) ? $subcontrol_value['button_link'][$i] : false;
							$upload = isset($subcontrol_value['upload'][$i]) ? $subcontrol_value['upload'][$i] : false;
							
							ux_pb_getfield_items_template($name, array(
								'title' => $title,
								'value' => $content,
								'icons' => $icons,
								'textarea' => $textarea,
								'percent' => $percent,
								'bgcolor' => $bgcolor,
								'bgcolor2' => $bgcolor2,
								'price' => $price,
								'button_text' => $button_text,
								'button_link' => $button_link,
								'upload' => $upload,
								'select' => $select,
								'select2' => $select2,
								'switch' => $switch
							));
						}
					}else{
						$items_count = 4;
						for($i = 1; $i <= $items_count; $i++){
							ux_pb_getfield_items_template($name, array(
								'title' => __('Item ','ux') . $i,
								'value' => false,
								'icons' => false,
								'textarea' => false,
								'percent' => 0,
								'bgcolor' => false,
								'bgcolor2' => false,
								'price' => 0,
								'button_text' => false,
								'button_link' => false,
								'upload' => false,
								'select' => false,
								'select2' => false,
								'switch' => false
							));
						}
					} ?>
                </div>
            <?php
			break;
			
			case 'content': ?>
                <div class="ux-pb-editor-ajax-content">
                    <?php if($get_value){
						echo balanceTags($get_value);
					}else{
						echo '&nbsp;';
					} ?>
                </div>
            <?php
            break;
			
			case 'date': ?>
                <div class="form-group">
                    <div class="input-group date form_datetime ux-pb-datetime">
                        <input class="form-control" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($get_value); ?>" type="text" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                </div>
			<?php
			break;
			
			case 'ratio': ?>
                <div data-id="ux-pb-ratio" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" name="<?php echo esc_attr($name. '[1]'); ?>" value="<?php echo esc_attr($get_value[1][0]); ?>">
                    </div>
                    <div class="form-group">:</div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="<?php echo esc_attr($name. '[2]'); ?>" value="<?php echo esc_attr($get_value[2][0]); ?>">
                    </div>
                </div>
                <script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('[data-id=ux-pb-ratio]').each(function(){
							var _this = jQuery(this);
							var _this_parents = _this.parents('.module-ajaxfield');
							var _this_parents_prev = _this_parents.prev();
							if(_this_parents_prev.is('[data-name=module_video_ratio]')){
								_this.parent().css({'margin-top': '-35px'});
							}
						})
					});
				</script>
            <?php
			break;
			
			case 'category': 
				$categories = get_categories(array(
					'type'     => 'any',
					'taxonomy' => $taxonomy
				));
				
				if($categories){
					wp_dropdown_categories(array(
						'show_option_all'  => __('All Categories','ux'),
						'class'            => 'form-control', 
						'name'             => esc_attr($name),
						'id'               => esc_attr('moduleid-' . $name),
						'show_count'       => 1,
						'taxonomy'         => $taxonomy,
						'selected'         => $get_value
					));
				}else{ ?>
                    <select class="form-control" name="<?php echo esc_attr($name); ?>">
                        <option selected="selected" value="0"><?php esc_attr_e('No Categories','ux'); ?></option>
                    </select>
                <?php	
				}
			break;
			
			case 'category-multiple':
				$categories = get_categories(array(
					'type'     => 'any',
					'taxonomy' => $taxonomy
				)); ?>
                
                <div class="ux-pb-category-multiple">
                    <div class="ux-pb-category-multiple-option">
						<?php if($categories){ ?>
                            <ul class="nav nav-pills ux-pb-checkbox-group">
                                <?php foreach($categories as $category){
                                    $value = false;
                                    if($get_value){
										if(is_array($get_value)){
											foreach($get_value as $cat_ID){
												if($category->cat_ID == $cat_ID){
													$value = $category->cat_ID;
												}
											}
										}else{
											$value = $get_value;
										}
                                    } ?>
                                    
                                    <li>
                                        <input type="checkbox" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($category->cat_ID); ?>" <?php checked($value, $category->cat_ID); ?>>
                                        <span class="pull-left"><?php echo esc_html($category->cat_name); ?></span>
                                        <div class="clearfix"></div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            <?php
			break;
			
			case 'orderby': ?>
				<div class="form-inline">
                    <div class="form-group">
                        <?php if(isset($select_fields[$name])){ ?>
                            <select class="form-control" name="<?php echo esc_attr($name); ?>">
                                <?php foreach($select_fields[$name] as $select){ ?>
                                    <option value="<?php echo esc_attr($select['value']); ?>" <?php selected(esc_attr($get_value), $select['value']); ?>><?php echo esc_attr($select['title']); ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <?php $name = 'module_select_order';
						$get_post_meta = get_post_meta($post_id, $name, true);
						$get_value = $get_post_meta ? $get_post_meta : 'DESC';
						if(isset($select_fields[$name])){ ?>
                            <select class="form-control" name="<?php echo esc_attr($name); ?>">
                                <?php foreach($select_fields[$name] as $select){ ?>
                                    <option value="<?php echo esc_attr($select['value']); ?>" <?php selected(esc_attr($get_value), $select['value']); ?>><?php echo esc_attr($select['title']); ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </div>
                </div>
			<?php
			break;
			
			case 'social-medias':
				if($get_value){
					foreach($get_value['name'] as $i => $m_name){
						$m_url = $get_value['url'][$i];
						$hidden_add = ($i == 0) ? false : 'hidden';
						$hidden_remove = ($i != 0) ? false : 'hidden'; ?>
                        <div class="ux-pb-social-medias row">
                            <div class="col-sm-3">
                                <select class="form-control input-sm" name="<?php echo esc_attr($name. '[name]'); ?>">
                                    <?php foreach($social_networks as $social){ ?>
                                        <option value="<?php echo esc_attr($social['slug']); ?>" <?php selected(esc_attr($m_name), $social['slug']); ?>><?php echo esc_attr($social['slug']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-6 ux-pb-no-col">
                                <input type="text" name="<?php echo esc_attr($name. '[url]'); ?>" class="form-control input-sm" value="<?php echo esc_attr($m_url); ?>" />
                            </div>
                            <div class="col-sm-3 ux-pb-no-col">
                                <button type="button" class="btn btn-info btn-sm ux-pb-social-medias-add <?php echo esc_attr($hidden_add); ?>"><span class="glyphicon glyphicon-plus"></span></button>
                                <button type="button" class="btn btn-danger btn-sm ux-pb-social-medias-remove <?php echo esc_attr($hidden_remove); ?>"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php	
					}
				}else{ ?>
                    <div class="ux-pb-social-medias row">
                        <div class="col-sm-3">
                            <select class="form-control input-sm" name="<?php echo esc_attr($name. '[name]'); ?>">
                                <?php foreach($social_networks as $social){ ?>
                                    <option value="<?php echo esc_attr($social['slug']); ?>"><?php echo esc_attr($social['slug']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6 ux-pb-no-col">
                            <input type="text" name="<?php echo esc_attr($name. '[url]'); ?>" class="form-control input-sm" value="" />
                        </div>
                        <div class="col-sm-3 ux-pb-no-col">
                            <button type="button" class="btn btn-info btn-sm ux-pb-social-medias-add"><span class="glyphicon glyphicon-plus"></span></button>
                            <button type="button" class="btn btn-danger btn-sm ux-pb-social-medias-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php
				}
			break;
			
			case 'gallery': ?>
                <div class="row">
                    <div class="col-xs-12"><button type="button" class="btn btn-primary ux-pb-gallery-select-images"><?php esc_html_e('Select Images','ux'); ?></button></div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ux-pb-gallery-select">
                            <ul class="nav nav-pills">
                            <?php if(is_array($get_value)){
                                foreach($get_value as $image){
                                    $image_thumbnail = wp_get_attachment_image_src($image, 'thumbnail'); ?>
                                    <li><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button><a href="#" class="thumbnail"><img src="<?php echo esc_url($image_thumbnail[0]); ?>" width="100" /></a><input type="hidden" name="module_gallery_library" value="<?php echo esc_attr($image); ?>" /></li>
                                <?php
                                }
                            } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
			break;
			
			case 'google_map':
				$module_map_location_l = -33.8674869;
				$module_map_location_r = 151.20699020000006;
				if($get_value){
					$module_map_location = str_replace('(', '', $get_value);
					$module_map_location = str_replace(')', '', $module_map_location);
					$module_map_location = explode(', ', $module_map_location);
					
					$module_map_location_l = (isset($module_map_location[0])) ? $module_map_location[0] : -33.8674869;
					$module_map_location_r = (isset($module_map_location[1])) ? $module_map_location[1] : 151.20699020000006;
				} ?>
				<input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($get_value); ?>" />
				<div id="ux-pb-map-canvas"></div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var geocoder;
						var google_map;
						var markers = [];
						var module_map_location_l = Number(<?php echo esc_attr($module_map_location_l); ?>);
						var module_map_location_r = Number(<?php echo esc_attr($module_map_location_r); ?>);
						function map_initialize() {
							geocoder = new google.maps.Geocoder();
							var latlng = new google.maps.LatLng(module_map_location_l, module_map_location_r);
							var mapOptions = {
								zoom: 7,
								center: latlng,
								mapTypeId: google.maps.MapTypeId.ROADMAP
							}
							google_map = new google.maps.Map(document.getElementById('ux-pb-map-canvas'), mapOptions);
							var marker = new google.maps.Marker({
								position: latlng,
								map: google_map
							});
							marker.setAnimation(google.maps.Animation.BOUNCE);
							markers.push(marker);
							google.maps.event.addListener(google_map, 'click', function(event) {
								map_addMarker(event.latLng);
							});
							
						}
						
						function map_addMarker(location) {
							map_deleteMarkers();
							var marker = new google.maps.Marker({
								position: location,
								map: google_map
							});
							marker.setAnimation(google.maps.Animation.BOUNCE);
							markers.push(marker);
							jQuery('[name=module_googlemap_canvas]').val(location);
						}
						
						function map_clearMarkers() {
							map_setAllMap(null);
						}
						
						function map_showMarkers() {
							map_setAllMap(google_map);
						}
						
						function map_deleteMarkers() {
							map_clearMarkers();
							markers = [];
						}
						
						function map_setAllMap(map) {
							for (var i = 0; i < markers.length; i++) {
								markers[i].setMap(map);
							}
						}
					
						function map_codeAddress(address){
							geocoder.geocode( { 'address': address}, function(results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									google_map.setCenter(results[0].geometry.location);
									map_deleteMarkers();
									var marker = new google.maps.Marker({
										map: google_map,
										position: results[0].geometry.location
									});
									marker.setAnimation(google.maps.Animation.BOUNCE);
									markers.push(marker);
									jQuery('[name=module_googlemap_canvas]').val(results[0].geometry.location);
								} else {
									alert('Geocode was not successful for the following reason: ' + status);
								}
							});
						}
						map_initialize();
						
						jQuery('[name=module_googlemap_address]').change(function(){
							map_codeAddress(jQuery(this).val());
						});
					});
				
				</script>
			<?php
			break;
			
			case 'message':
				if($moduleid == 'latest-tweets'){
					$plugin_name = "Rotating Tweets";
					$plugin_slug = "rotatingtweets/rotatingtweets.php";
					$plugin_url = 'http://wordpress.org/plugins/rotatingtweets/';
						
					if(!is_plugin_active($plugin_slug)){ ?>
						<div class="error">
                            <p><em><?php printf(__('You Need to install the %s %s','ux'), '<a href="' . esc_url($plugin_url) . '" target="_blank" title="' . esc_attr($plugin_name) . '">' . esc_attr($plugin_name) . '</a>', esc_html__('WordPress plugin and setup your Twitter API before working with this module.!','ux')); ?></em></p>
                        </div>
					<?php
                    }
				}
			break;
			
			case 'foreground': ?>
                <p><button type="button" class="btn btn-info btn-sm foreground-add"><span class="glyphicon glyphicon-plus"></span></button></p>
                <div class="foreground-template">
                    <div class="row foreground-item">
                        <div class="col-xs-10">
                            <div class="row">
                                <div class="input-group ux-pb-upload col-xs-12 input-group-sm">
                                    <input type="text" name="<?php echo esc_attr($name. '[image][]'); ?>" class="form-control" value="" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-default ux-pb-upload-image" type="button"><?php esc_html_e('Upload Image','ux'); ?></button>
                                        <button class="btn btn-danger ux-pb-remove-image" type="button"><?php esc_html_e('Remove','ux'); ?></button>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group col-xs-12 input-group-sm">
                                    <select class="form-control" name="<?php echo esc_attr($name. '[ratio][]'); ?>">
                                        <?php foreach($select_fields['module_fullwidth_background_ratio'] as $select){ ?>
                                            <option value="<?php echo esc_attr($select['value']); ?>"><?php echo esc_attr($select['title']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-danger btn-sm foreground-remove"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </div>
                </div>
                <div class="foreground-content">
					<?php if($get_value){
                        $foreground_image = $get_value['image'];
						foreach($foreground_image as $num => $image){
							$ratio = $get_value['ratio'][$num]; ?>
                            
                            <div class="row foreground-item">
                                <div class="col-xs-10">
                                    <div class="row">
                                        <div class="input-group ux-pb-upload col-xs-12 input-group-sm">
                                            <input type="text" name="<?php echo esc_attr($name. '[image][]'); ?>" class="form-control" value="<?php echo esc_attr($image); ?>" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-default ux-pb-upload-image" type="button"><?php esc_html_e('Upload Image','ux'); ?></button>
                                                <button class="btn btn-danger ux-pb-remove-image" type="button"><?php esc_html_e('Remove','ux'); ?></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-group col-xs-12 input-group-sm">
                                            <select class="form-control" name="<?php echo esc_attr($name. '[ratio][]'); ?>">
                                                <?php foreach($select_fields['module_fullwidth_background_ratio'] as $select){ ?>
                                                    <option value="<?php echo esc_attr($select['value']); ?>" <?php selected(esc_attr($ratio), $select['value']); ?>><?php echo esc_attr($select['title']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <button type="button" class="btn btn-danger btn-sm foreground-remove"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                            </div>
							
						<?php	
						}
                    } ?>
                </div>
            <?php
			break;
			
			case 'none': break;
		}
	}
}

//pagebuilder subcontrol
function ux_pb_getfield_subcontrol($name){
	$module_fields = ux_pb_module_fields();
	
	$subcontrol_fields = array();
	foreach($module_fields as $field){
		if(isset($field['item'])){
			foreach($field['item'] as $item){
				if(isset($item['subcontrol'])){
					$subcontrol = explode('|', $item['subcontrol']);
					$subcontrol_name = $subcontrol[0];
					$subcontrol_type = $subcontrol[1];
					if($subcontrol_name == $name){
						$subcontrol_fields[$item['name']]['type'] = $item['type'];
						$subcontrol_fields[$item['name']]['value'] = $subcontrol_type;
					}
				}
			}
		}
	}
	$subcontrol_fields = count($subcontrol_fields) ? $subcontrol_fields : false;
	return $subcontrol_fields;
}

//pagebuilder items template
function ux_pb_getfield_items_template($name, $get_value){
	$title       = isset($get_value['title'])       ? $get_value['title']       : false;
	$button_text = isset($get_value['button_text']) ? $get_value['button_text'] : false;
	$button_link = isset($get_value['button_link']) ? $get_value['button_link'] : false;
	$upload      = isset($get_value['upload'])      ? $get_value['upload']      : false;
	$select      = isset($get_value['select'])      ? $get_value['select']      : false;
	$select2     = isset($get_value['select2'])     ? $get_value['select2']     : false;
	$bgcolor     = isset($get_value['bgcolor'])     ? $get_value['bgcolor']     : false;
	$bgcolor2    = isset($get_value['bgcolor2'])    ? $get_value['bgcolor2']    : false;
	$percent     = isset($get_value['percent'])     ? $get_value['percent']     : 0;
	$price       = isset($get_value['price'])       ? $get_value['price']       : 0;
	$value       = isset($get_value['value'])       ? $get_value['value']       : false;
	$switch      = isset($get_value['switch'])      ? $get_value['switch']      : false;
	$icons       = isset($get_value['icons'])       ? $get_value['icons']       : false;
	$textarea    = isset($get_value['textarea'])    ? $get_value['textarea']    : false; ?>
	<a href="#" class="list-group-item">
        <?php /*?><i class="<?php echo esc_attr($icons); ?>"></i><?php */?>
        <span><?php echo esc_html($title); ?></span>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-info btn-xs ux-pb-items-edit"><span class="glyphicon glyphicon-edit"></span></button>
            <button type="button" class="btn btn-danger btn-xs ux-pb-items-remove"><span class="glyphicon glyphicon-remove"></span></button>
        </div>
        <div class="field-group">
			<input type="text" name="<?php echo esc_attr($name . '[items]'); ?>" />
			<?php $get_subcontrol = ux_pb_getfield_subcontrol($name);
			if($get_subcontrol){
				foreach($get_subcontrol as $subcontrol => $field){
					$field_value = $field['value'];
					switch($field_value){
						case 'title':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($title). '" />';
						break;
						
						case 'content':
							echo '<textarea name="' .esc_attr($name . '[ux-pb-module-content]'). '" data-fieldname="ux-pb-module-content">' .esc_textarea($value). '</textarea>';
						break;
						
						case 'icons':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($icons). '" />';
						break;
						
						case 'textarea':
							echo '<textarea name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '">' .esc_textarea($textarea). '</textarea>';
						break;
						
						case 'percent':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($percent). '" />';
						break;
						
						case 'bgcolor':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($bgcolor). '" />';
						break;
						
						case 'bgcolor2':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($bgcolor2). '" />';
						break;
						
						case 'price':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($price). '" />';
						break;
						
						case 'button_text':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($button_text). '" />';
						break;
						
						case 'button_link':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($button_link). '" />';
						break;

						case 'upload':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($upload). '" />';
						break;
						
						case 'select':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($select). '" />';
						break;
						
						case 'select2':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($select2). '" />';
						break;
						
						case 'switch':
							echo '<input type="text" name="' .esc_attr($name . '[' . $subcontrol . ']'). '" data-fieldname="' .esc_attr($subcontrol). '" value="' .esc_attr($switch). '" />';
						break;
						
					}
				}
			} ?>
        </div>
    </a>
<?php	
}

//pagebuilder tabs template
function ux_pb_getfield_tabs_template($name, $title, $value, $placeholder){ ?>
    <div class="row ux-pb-tabs">
        <div class="input-group input-group-sm col-xs-10">
            <span class="input-group-addon"><?php echo esc_html($title); ?></span>
            <input type="text" name="<?php echo esc_attr($name); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" class="form-control" value="<?php echo esc_attr($value); ?>" />
            <span class="input-group-btn">
                <button type="button" class="btn btn-info btn-sm ux-pb-tabs-add"><span class="glyphicon glyphicon-plus"></span></button>
                <button type="button" class="btn btn-danger btn-sm ux-pb-tabs-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
            </span>
        </div>
    </div>
<?php	
}

?>