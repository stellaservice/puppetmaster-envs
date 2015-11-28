<?php
//theme option getfield
function ux_theme_option_getfield($item, $key){
	$select_fields   = ux_theme_options_config_select_fields();
	$fonts_size      = ux_theme_options_fonts_size();
	$fonts_style     = ux_theme_options_fonts_style();
	$social_networks = ux_theme_social_networks();
	$theme_color     = ux_theme_color();
	
	$type            = isset($item['type'])        ? $item['type'] : false;
	$name            = isset($item['name'])        ? $item['name'] : false;
	$title           = isset($item['title'])       ? $item['title'] : false;
	$size            = isset($item['size'])        ? $item['size'] : false;
	$button          = isset($item['button'])      ? $item['button'] : false;
	$default         = isset($item['default'])     ? $item['default'] : false;
	$control         = isset($item['control'])     ? $item['control'] : false;
	$special         = isset($item['special'])     ? $item['special'] : false;
	$placeholder     = isset($item['placeholder']) ? $item['placeholder'] : false;
	$description     = isset($item['description']) ? $item['description'] : false;
	$col_size        = isset($item['col_size'])    ? $item['col_size'] : false;
	$col_style       = isset($item['col_style'])   ? $item['col_style'] : false;
	$scheme_name     = isset($item['scheme-name']) ? $item['scheme-name'] : false;
	$notice          = isset($item['notice'])      ? $item['notice'] : false;
	$taxonomy        = isset($item['taxonomy'])    ? $item['taxonomy'] : 'category';
	$mod             = isset($item['mod'])         ? $item['mod'] : 'options';
	
	if($key == 'ux_theme_option'){
		$get_option = get_option($key);
	}else{
		$get_option = get_post_meta(get_the_ID(), $key, true);
	}
	
	$get_value   = isset($get_option[$name]) ? $get_option[$name] : $default;
	$control     = $control ? 'data-name="' .esc_attr($control['name']). '" data-value="' .esc_attr($control['value']). '"' : false;
	$scheme_name = $scheme_name ? 'data-scheme="scheme_' .esc_attr($scheme_name). '"' : false;
		
	if($type){
		switch($type){
			case 'description': ?>
				<div class="row">
                    <div class="col-xs-12 text-muted"><?php echo balanceTags($description); ?></div>
                </div>
			<?php
            break;
			
			case 'color-scheme':
				if($get_value){
					$color_scheme = $get_value;
				}else{
					$get_option['theme_option_color_scheme'] = ux_theme_options_color_scheme();
					update_option('ux_theme_option', $get_option);
					$get_option = get_option('ux_theme_option');
					$color_scheme = isset($get_option[$name]) ? $get_option[$name] : $default;
				}
				
				$current_scheme = isset($get_option[$name . '_current']) ? $get_option[$name . '_current'] : 'scheme-1';
				
				if(count($color_scheme)){ ?>
                    <ul class="nav nav-pills ux-theme-color-scheme">
						<?php foreach($color_scheme as $id => $schemes){
							$theme_main_color = false;
							$page_bg_color = false;
							foreach($schemes as $scheme){
								if($scheme['name'] == 'theme_main_color'){
									$theme_main_color = $scheme['value'];
								}
								if($scheme['name'] == 'page_post_bg_color'){
									$page_bg_color = $scheme['value'];
								}
							}
							
							$active = $current_scheme == $id ? 'active' : false; ?>
                            
                            <li class="scheme-item <?php echo esc_attr($active); ?>" style="background-color: <?php echo esc_attr($theme_main_color); ?>" data-scheme-id="<?php echo esc_attr($id); ?>">
								<?php foreach($schemes as $i => $scheme){ ?>
                                    <input type="hidden" name="<?php echo esc_attr('ux_theme_option[theme_option_color_scheme][' .$id. '][' .$i. '][name]'); ?>" value="<?php echo esc_attr($scheme['name']); ?>" />
                                    <input type="hidden" name="<?php echo esc_attr('ux_theme_option[theme_option_color_scheme][' .$id. '][' .$i. '][value]'); ?>" data-name="<?php echo esc_attr('scheme_' .$scheme['name']); ?>" value="<?php echo esc_attr($scheme['value']); ?>" />
                                <?php } ?>
                                <span class="selected" style="border-color: #fff"></span>
                                <div class="triangle" style="display:none; border-bottom-color: <?php echo esc_attr($theme_main_color); ?>"></div>
                            </li>
                        <?php } ?>
                    </ul>
                    <input type="hidden" name="<?php echo esc_attr($key. '[' .$name. '_current]'); ?>" value="<?php echo esc_attr($current_scheme); ?>" />
                <?php     
				}
			break;
			
			case 'bg-color':
				if(count($theme_color) > 0){ ?>
                    <ul class="nav nav-pills ux-theme-color">
						<?php foreach($theme_color as $color){ ?>
                            <li><button type="button" class="btn" data-value="<?php echo esc_attr($color['id']); ?>" style="background-color: <?php echo esc_attr($color['rgb']); ?>"><span class="glyphicon glyphicon-ok"></span></button></li>
                        <?php } ?>
                        <li><button type="button" class="btn btn-cancelcolor"></button></li>
                    </ul>
                    <input type="hidden" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" value="<?php echo esc_attr($get_value); ?>">
				<?php
                }
			break;
			
			case 'divider': ?>
				<div class="ux-theme-divider"></div>
			<?php
            break;
			
			case 'button':
				$button_title   = isset($button['title']) ? $button['title'] : false;
				$button_type    = isset($button['type']) ? $button['type'] : false;
				$button_loading = isset($button['loading']) ? $button['loading'] : false;
				$button_class   = isset($button['class']) ? $button['class'] : false;
				$button_url     = isset($button['url']) ? $button['url'] : false;
				
				$data_url       = $button_url ? 'data-url="' .esc_url($button_url). '"' : false;
				$demo_data      = false;
				$data_notice    = $notice ? 'data-notice="' .esc_attr($notice). '"' : false;
				
				if($button_type == 'import-demo-data'){
					wp_nonce_field('import-wordpress');
				} ?>
                <button type="button" class="btn <?php echo esc_attr($button_class); ?>" data-ux-button="<?php echo esc_attr($button_type); ?>" data-loading-text="<?php echo esc_attr($button_loading); ?>" <?php echo balanceTags($data_url); ?> <?php echo balanceTags($demo_data); ?> <?php echo balanceTags($data_notice); ?>><?php echo esc_attr($button_title); ?></button>
                
                <?php if($button_type == 'generate-thumbs'){ ?>
					<div id="generate-thumbs-content"></div>
				<?php
				}
			break;
			
			case 'text': ?>
				<div class="form-group" style=" <?php echo esc_attr($col_style); ?>">
                    <input type="text" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" class="form-control" value="<?php echo esc_attr(stripslashes($get_value)); ?>" style=" <?php echo esc_attr($col_size); ?>" />
                </div>
			<?php
			break;
			
			case 'textarea': ?>
                <div class="form-group">
                    <textarea rows="4" class="form-control" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>"><?php echo esc_textarea(stripslashes($get_value)); ?></textarea>
                </div>
            <?php
			break;
			
			case 'checkbox': ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="make-checkbox"> <?php echo esc_attr($title); ?>
                        <input type="hidden" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" value="<?php echo esc_attr($get_value); ?>">
                    </label>
                </div>
            <?php
			break;
			
			case 'checkbox-group':
				if($select_fields[$name]){ ?>
                    <ul class="nav nav-pills ux-theme-checkbox-group" <?php echo balanceTags($control); ?>>
                        <?php foreach($select_fields[$name] as $i => $select){
							$value = false;
							if(is_array($get_value)){
								$value = (in_array($select['value'], $get_value)) ? $select['value'] : false;
							} ?>
                            <li>
                                <input type="checkbox" name="<?php echo esc_attr($key. '[' .$name. '][]'); ?>" value="<?php echo esc_attr($select['value']); ?>" <?php checked(esc_attr($value), esc_attr($select['value'])); ?>>
                                <span class="pull-left"><?php echo esc_attr($select['title']); ?></span>
                            </li>
                        <?php } ?>
                    </ul>
				<?php
				}
			break;
			
			case 'switch': ?>
                <div class="switch make-switch" data-on="success" data-off="danger">
                    <input type="checkbox" value="true" <?php checked(esc_attr($get_value), 'true'); ?> />
                    <input type="hidden" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" data-class="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($get_value); ?>" data-value="<?php echo esc_attr($get_value); ?>" />
                </div>
            <?php
			break; 
			
			case 'switch-color': ?>
                <div class="row" style="margin-bottom:0px;">
                    <?php if($mod == 'options'){ ?>
                        <h5 class="col-sm-8"><?php echo esc_html($title); ?></h5>
                    <?php } ?>
                    <div class="form-group ux-theme-switch-color col-sm-4" <?php echo balanceTags($scheme_name); ?>>
                        <input type="text" class="form-control switch-color" data-position="bottom left" value="<?php echo esc_attr($get_value); ?>" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" />
                        <span class="ux-theme-remove-color"></span>
                    </div>
                </div>
            <?php
			break;
			
			case 'upload': ?>
                <div class="input-group theme-option-upload">
                    <input type="text" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" class="form-control" value="<?php echo esc_attr($get_value); ?>" />
                    <span class="input-group-btn">
                        <button class="btn btn-default ux-theme-upload-image" type="button" data-toggle="modal" data-target="#ux-theme-modal" data-title="<?php echo esc_attr($title); ?>"><?php esc_html_e('Upload Image','ux'); ?></button>
                        <button class="btn btn-danger ux-theme-remove-image" type="button"><?php esc_html_e('Remove','ux'); ?></button>
                    </span>
                </div>
            <?php
			break; 
			
			case 'select':
				if($select_fields[$name]){ ?>
                    <select class="form-control input-sm" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" <?php echo balanceTags($control); ?> style=" <?php echo esc_attr($col_size); ?>" data-selected="<?php echo esc_attr($get_value); ?>" data-class="<?php echo esc_attr($name); ?>" data-value="<?php echo esc_attr($get_value); ?>">
                        <?php foreach($select_fields[$name] as $select){ ?>
                            <option value="<?php echo esc_attr($select['value']); ?>" <?php selected(esc_attr($get_value), esc_attr($select['value'])); ?>><?php echo esc_attr($select['title']); ?></option>
                        <?php } ?>
                    </select>
                <?php
				}
			break;
			
			case 'select-front':
				$get_pages = get_pages();
				$show_on_front = get_option('show_on_front');
				$page_on_front = get_option('page_on_front');
				if($show_on_front == 'page'){
					$get_value = $page_on_front;
				} ?>
				<select class="form-control input-sm" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>">
                    <option value="-1"><?php esc_attr_e('Homepage','ux') ?></option>
					<?php foreach($get_pages as $page){ ?>
                        <option value="<?php echo esc_attr($page->ID); ?>" <?php selected(esc_attr($get_value), esc_attr($page->ID)); ?>><?php echo esc_attr($page->post_title); ?></option>
                    <?php } ?>
				</select>
			<?php
            break;
			
			case 'select-images':
				$get_value = get_option('ux_theme_option_icons_custom'); ?>
                <div class="input-group theme-option-select-images">
                    <button type="button" class="btn btn-primary ux-theme-select-images" data-name="<?php echo esc_attr($name); ?>"><?php esc_html_e('Select Images','ux'); ?></button>
                </div>
                <div class="theme-option-select-images-content">
                    <ul class="nav nav-pills">
						<?php if($get_value){
                            foreach($get_value as $portfolio){
                                $image_src = wp_get_attachment_image_src($portfolio); ?>
                                <li><img src="<?php echo esc_url($image_src[0]); ?>" /><input type="hidden" name="<?php echo esc_attr($key. '[' .$name. '][]'); ?>" value="<?php echo esc_attr($portfolio); ?>"/><span class="glyphicon glyphicon-remove"></span></li>
                            <?php
                            }
                        } ?>
                    
                    </ul>
                </div>
            <?php
			break;
			
			case 'image-select':
				if($select_fields[$name]){
					$sizes = explode(':', $size);
					$width_size = (isset($sizes[0])) ? 'width: ' . $sizes[0] . 'px;' : false;
					$height_size = (isset($sizes[1])) ? 'height: ' . $sizes[1] . 'px;' : false; ?>
                    <div class="ux-theme-image-select">
                        <ul class="nav nav-pills">
                            <?php foreach($select_fields[$name] as $select){
								$active = ($get_value == $select['value']) ? 'active' : false; ?>
                                <li class="<?php echo esc_attr($active); ?>" style=" <?php echo esc_attr($width_size); ?> <?php echo esc_attr($height_size); ?>">
                                    <a href="#" class="<?php echo esc_attr($select['value']); ?>" style=" <?php echo esc_attr($width_size); ?> <?php echo esc_attr($height_size); ?>"></a>
                                    <span class="selected"></span>
                                </li>
                            <?php } ?>
                        </ul>
                        <input type="hidden" data-value="<?php echo esc_attr($get_value); ?>" data-class="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" value="<?php echo esc_attr($get_value); ?>">
                    </div>
                <?php
				}
			break;
			
			case 'fonts-family': ?>
                <div class="col-sm-5 ux-theme-no-col">
                    <select class="form-control input-sm ux-theme-font-family" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>">
                        <option value="-1"><?php esc_attr_e('-- Select Font --','ux'); ?></option>
                        <?php $json = get_option('ux_theme_googlefont');
						if($json){
							$fonts_object = json_decode($json);
							if($fonts_object && is_object($fonts_object)){
								if($fonts_object->items && is_array($fonts_object->items)){
									$fonts = $fonts_object->items;
									foreach($fonts as $item){
										$family_val = str_replace(' ', '+', $item->family); ?>
										<option value="<?php echo esc_attr($family_val); ?>" <?php selected(esc_attr($get_value), esc_attr($family_val)); ?>><?php echo esc_attr($item->family); ?></option>
									<?php
									}
								}
							}
						} ?>
                    </select>
                </div>
            <?php
			break;
			
			case 'fonts-size': ?>
                <div class="col-sm-2 ux-theme-no-col">
                    <select class="form-control input-sm ux-theme-font-size" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>">
                        <?php foreach($fonts_size as $size){ ?>
                            <option value="<?php echo esc_attr($size); ?>" <?php selected(esc_attr($get_value), esc_attr($size)); ?>><?php echo esc_attr($size); ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php
			break;
			
			case 'fonts-style': ?>
                <div class="col-sm-4 ux-theme-no-col">
                    <select class="form-control input-sm ux-theme-font-style" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>" data-value="<?php echo esc_attr($get_value); ?>">
                        <?php foreach($fonts_style as $style){ ?>
                            <option value="<?php echo esc_attr($style['value']); ?>" <?php selected(esc_attr($get_value), esc_attr($style['value'])); ?>><?php echo esc_attr($style['value']); ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php
			break;
			
			case 'new-social-medias': ?>
                <div class="ux-theme-new-social-medias" <?php echo balanceTags($control); ?>>
                    <?php if($get_value && isset($get_value['icontype'])){
                        $icon_type = $get_value['icontype'];
                        foreach($icon_type as $num => $type){
                            $icon = esc_attr($get_value['icon'][$num]);
                            $url = esc_url($get_value['url'][$num]);
                            $tip = esc_attr($get_value['tip'][$num]);
							$button_remove = $num == 0 ? 'hidden' : false;
							$button_remove_style = $num == 0 ? false : 'style="right: 40px;"';
							$button_add = $num != 0 ? 'hidden' : false; ?>
                            
                            <div class="ux-theme-social-medias" rel="<?php echo esc_attr($num); ?>">
                                <div class="new-media-col-select-icon pull-left">
                                    <button type="button" class="btn btn-default btn-sm" data-title="<?php esc_attr_e('Select Icon','ux'); ?>"><i class="fa fa-ellipsis-h"></i></button>
                                </div>
                                <div class="new-media-col-icon pull-left">
                                    <div class="icon-content">
										<?php if($type == 'fontawesome'){ ?>
                                            <i class="<?php echo esc_attr($icon); ?>"></i>
                                        <?php }elseif($type == 'user'){ ?>
                                            <img src="<?php echo esc_url($icon); ?>" />
                                        <?php } ?>
                                    </div>
                                    <input type="hidden" name="<?php echo esc_attr($key. '[' .$name. '][icon][]'); ?>" value="<?php echo esc_attr($icon); ?>" />
                                    <input type="hidden" name="<?php echo esc_attr($key. '[' .$name. '][icontype][]'); ?>" value="<?php echo esc_attr($type); ?>" />
                                </div>
                                <div class="new-media-col-url">
                                    <input type="text" name="<?php echo esc_attr($key. '[' .$name. '][url][]'); ?>" class="form-control input-sm pull-left" value="<?php echo esc_attr($url); ?>" placeholder="<?php esc_attr_e('Enter the social media url','ux'); ?>" />
                                    <input type="text" name="<?php echo esc_attr($key. '[' .$name. '][tip][]'); ?>" class="form-control input-sm pull-right" value="<?php echo esc_attr($tip); ?>" placeholder="<?php esc_attr_e('Social media name','ux'); ?>" />
                                </div>
                                <div class="new-media-col-remove pull-right <?php echo esc_attr($button_remove); ?>" <?php echo balanceTags($button_remove_style); ?>>
                                    <button type="button" class="btn btn-danger btn-sm social-medias-remove"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                                <div class="new-media-col-add pull-right <?php echo esc_attr($button_add); ?>">
                                    <button type="button" class="btn btn-info btn-sm social-medias-add "><span class="glyphicon glyphicon-plus"></span></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php
                        }
                    }else{ ?>
                        <div class="ux-theme-social-medias" rel="0">
                            <div class="new-media-col-select-icon pull-left">
                                <button type="button" class="btn btn-default btn-sm" data-title="<?php esc_attr_e('Select Icon','ux'); ?>"><i class="fa fa-ellipsis-h"></i></button>
                            </div>
                            <div class="new-media-col-icon pull-left">
                                <div class="icon-content"></div>
                                <input type="hidden" name="<?php echo esc_attr($key. '[' .$name. '][icon][]'); ?>" value="" />
                                <input type="hidden" name="<?php echo esc_attr($key. '[' .$name. '][icontype][]'); ?>" value="" />
                            </div>
                            <div class="new-media-col-url">
                                <input type="text" name="<?php echo esc_attr($key. '[' .$name. '][url][]'); ?>" class="form-control input-sm pull-left" value="" placeholder="<?php esc_attr_e('Enter the social media url','ux'); ?>" />
                                <input type="text" name="<?php echo esc_attr($key. '[' .$name. '][tip][]'); ?>" class="form-control input-sm pull-right" value="" placeholder="<?php esc_attr_e('Social media name','ux'); ?>" />
                            </div>
                            <div class="new-media-col-remove pull-right hidden">
                                <button type="button" class="btn btn-danger btn-sm social-medias-remove"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <div class="new-media-col-add pull-right">
                                <button type="button" class="btn btn-info btn-sm social-medias-add "><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                </div>
			<?php
            break;
			
			case 'social-medias': ?>
                <div class="ux-theme-social-medias-lists" <?php echo balanceTags($control); ?>>
					<?php 
					$placeholder_name = isset($placeholder[0]) ? $placeholder[0] : false;
					$placeholder_url  = isset($placeholder[1]) ? $placeholder[1] : false;
					if($get_value){
						foreach($get_value['name'] as $i => $m_name){
							$m_url = esc_url($get_value['url'][$i]);
							$hidden_add = ($i == 0) ? false : 'hidden';
							$hidden_remove = ($i != 0) ? false : 'hidden'; ?>
							<div class="ux-theme-social-medias">
								<div class="col-sm-3 ux-theme-no-col">
									<?php if($special == 'mp3'){ ?>
										<input type="text" name="<?php echo esc_attr($key. '[' .$name. '][name][]'); ?>" class="form-control input-sm" value="<?php echo esc_attr($m_name); ?>" placeholder="<?php echo esc_attr($placeholder_name); ?>" />
									<?php }else{ ?>
                                        <select class="form-control input-sm" name="<?php echo esc_attr($key. '[' .$name. '][name][]'); ?>">
                                            <?php foreach($social_networks as $social){ ?>
                                                <option value="<?php echo esc_attr($social['slug']); ?>" <?php selected(esc_attr($m_name), esc_attr($social['slug'])); ?>><?php echo esc_attr($social['slug']); ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
								</div>
								<div class="col-sm-6 ux-theme-no-col">
									<input type="text" name="<?php echo esc_attr($key. '[' .$name. '][url][]'); ?>" class="form-control input-sm" value="<?php echo esc_attr($m_url); ?>" placeholder="<?php echo esc_attr($placeholder_url); ?>" />
								</div>
								<div class="col-sm-3 ux-theme-no-col">
									<button type="button" class="btn btn-info btn-sm social-medias-add <?php echo esc_attr($hidden_add); ?>"><span class="glyphicon glyphicon-plus"></span></button>
									<button type="button" class="btn btn-danger btn-sm social-medias-remove <?php echo esc_attr($hidden_remove); ?>"><span class="glyphicon glyphicon-remove"></span></button>
								</div>
								<div class="clearfix"></div>
							</div>
						<?php 
						}
					}else{ ?>
                        <div class="ux-theme-social-medias">
                            <div class="col-sm-3 ux-theme-no-col">
                                <?php if(esc_attr($special) == 'mp3'){ ?>
                                    <input type="text" name="<?php echo esc_attr($key. '[' .$name. '][name][]'); ?>" class="form-control input-sm" value="" placeholder="<?php echo esc_attr($placeholder_name); ?>" />
                                <?php }else{ ?>
                                    <select class="form-control input-sm" name="<?php echo esc_attr($key. '[' .$name. '][name][]'); ?>">
                                        <?php foreach($social_networks as $social){ ?>
                                            <option value="<?php echo esc_attr($social['slug']); ?>" <?php selected(esc_attr($default), esc_attr($social['slug'])); ?>><?php echo esc_attr($social['slug']); ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6 ux-theme-no-col">
                                <input type="text" name="<?php echo esc_attr($key. '[' .$name. '][url][]'); ?>" class="form-control input-sm" value="" placeholder="<?php echo esc_attr($placeholder_url); ?>" />
                            </div>
                            <div class="col-sm-3 ux-theme-no-col">
                                <button type="button" class="btn btn-info btn-sm social-medias-add"><span class="glyphicon glyphicon-plus"></span></button>
                                <button type="button" class="btn btn-danger btn-sm social-medias-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                </div>
			<?php
			break;
			
			case 'gallery': ?>
                 <div class="row">
                     <div class="col-xs-12"><button type="button" class="btn btn-primary ux-theme-gallery-select-images"><?php esc_attr_e('Select Images','ux'); ?></button></div>
                 </div>
                
                <div class="row ux-theme-gallery-select">
                    <div class="col-xs-12">
                        <ul class="nav nav-pills">
                        <?php if(is_array($get_value)){
							foreach($get_value as $image){
								$image_full = wp_get_attachment_image_src($image, 'thumbnail'); ?>
                                
								<li><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button><a href="#" class="thumbnail"><span class="border"></span><img src="<?php echo esc_url($image_full[0]); ?>" /></a><input type="hidden" name="ux_theme_meta[theme_meta_portfolio][]" value="<?php echo esc_attr($image); ?>" /></li>
							<?php
                            }
						} ?>
                        </ul>
                    </div>
                </div>
            <?php
			break;
			
			case 'ratio': ?>
                <div data-id="ux-theme-ratio" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" name="<?php echo esc_attr($key. '[' .$name. '][1]'); ?>" value="<?php echo esc_attr($get_value[1]); ?>">
                    </div>
                    <div class="form-group">:</div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="<?php echo esc_attr($key. '[' .$name. '][2]'); ?>" value="<?php echo esc_attr($get_value[2]); ?>">
                    </div>
                </div>
            <?php
			break;
			
			case 'category': ?>
                <div style=" <?php echo balanceTags($col_size); ?>">
                    <?php $categories = get_categories(array(
                        'type'     => 'any',
                        'taxonomy' => esc_attr($taxonomy)
                    ));
                    
                    if($categories){
                        wp_dropdown_categories(array(
                            'show_option_all'  => esc_attr_('All Categories','ux'),
                            'class'            => 'form-control', 
                            'name'             => esc_attr($key . '[' . $name . ']'),
                            'id'               => esc_attr('ux-theme-options-' . $name),
                            'show_count'       => 1,
                            'taxonomy'         => esc_attr($taxonomy),
                            'selected'         => esc_attr($get_value)
                        ));
                    }else{ ?>
                        <select class="form-control" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>">
                            <option selected="selected" value="0"><?php esc_attr_e('No Categories','ux'); ?></option>
                        </select>
                    <?php } ?>
                </div>
			<?php
			break;
			
			case 'category-multiple':
				$categories = get_categories(array(
					'type'     => 'any',
					'taxonomy' => esc_attr($taxonomy)
				)); ?>
                
                <div class="ux-theme-category-multiple" style=" <?php echo esc_attr($col_size); ?>">
                    <div class="ux-theme-category-multiple-option">
						<?php if($categories){ ?>
                            <ul class="nav nav-pills ux-theme-checkbox-group" <?php echo balanceTags($control); ?>>
                                <?php foreach($categories as $category){
                                    $value = false;
                                    if($get_value && is_array($get_value)){
                                        foreach($get_value as $cat_ID){
                                            if($category->cat_ID == $cat_ID){
                                                $value = $category->cat_ID;
                                            }
                                        }
                                    } ?>
                                    
                                    <li>
                                        <input type="checkbox" name="<?php echo esc_attr($key. '[' .$name. '][]'); ?>" value="<?php echo esc_attr($category->cat_ID); ?>" <?php checked(esc_attr($value), esc_attr($category->cat_ID)); ?>>
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
				<div style=" <?php echo esc_attr($col_size); ?>">
                    <div class="form-group row">
                        <div class="col-xs-6">
                            <?php if(isset($select_fields[$name])){ ?>
                                <select class="form-control" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>">
                                    <?php foreach($select_fields[$name] as $select){ ?>
                                        <option value="<?php echo esc_attr($select['value']); ?>" <?php selected(esc_attr($get_value), esc_attr($select['value'])); ?>><?php echo esc_attr($select['title']); ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </div>
                        <div class="col-xs-6">
                            <?php $name = 'theme_meta_order';
                            $get_value = isset($get_option[$name]) ? $get_option[$name] : 'DESC';
                            if(isset($select_fields[$name])){ ?>
                                <select class="form-control" name="<?php echo esc_attr($key. '[' .$name. ']'); ?>">
                                    <?php foreach($select_fields[$name] as $select){ ?>
                                        <option value="<?php echo esc_attr($select['value']); ?>" <?php selected(esc_attr($get_value), esc_attr($select['value'])); ?>><?php echo esc_attr($select['title']); ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                </div>
			<?php
			break;
			
			case 'property':
				$placeholder_title = isset($placeholder[0]) ? $placeholder[0] : false;
				$placeholder_content  = isset($placeholder[1]) ? $placeholder[1] : false;
				
				if($get_value){
					foreach($get_value['title'] as $i => $this_title){
						$this_content = $get_value['content'][$i];
						$hidden_add = ($i == 0) ? false : 'hidden';
						$hidden_remove = ($i != 0) ? false : 'hidden'; ?>
                        
                        <div class="row property-item">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon"><?php echo esc_attr($placeholder_title); ?></span>
                                            <input type="text" class="form-control input-sm" name="<?php echo esc_attr($key. '[' .$name. '][title][]'); ?>" placeholder="<?php echo esc_attr($placeholder_title); ?>" value="<?php echo esc_attr($this_title); ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon"><?php echo esc_attr($placeholder_content); ?></span>
                                            <textarea class="form-control property-content" rows="4" name="<?php echo esc_attr($key. '[' .$name. '][content][]'); ?>"><?php echo esc_textarea($this_content); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <button type="button" class="btn btn-info btn-sm property-add <?php echo esc_attr($hidden_add); ?>"><span class="glyphicon glyphicon-plus"></span></button>
                                <button type="button" class="btn btn-danger btn-sm property-remove <?php echo esc_attr($hidden_remove); ?>"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                        </div>
				
					 <?php
					 }
					 
				}else{ ?>
                
                    <div class="row property-item">
                        <div class="col-xs-10">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon"><?php echo esc_attr($placeholder_title); ?></span>
                                        <input type="text" class="form-control input-sm" name="<?php echo esc_attr($key. '[' .$name. '][title][]'); ?>" placeholder="<?php echo esc_attr($placeholder_title); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon"><?php echo esc_attr($placeholder_content); ?></span>
                                        <textarea class="form-control property-content" rows="4" name="<?php echo esc_attr($key. '[' .$name. '][content][]'); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-info btn-sm property-add"><span class="glyphicon glyphicon-plus"></span></button>
                            <button type="button" class="btn btn-danger btn-sm property-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </div>
                <?php
				}
            break;
			
			case 'layout-builder':
				if($get_value && is_array($get_value)){
					foreach($get_value as $i => $layout){
						$hidden_add = $i == 0 ? false : 'hidden';
						$hidden_remove = $i > 0 ? false : 'hidden'; ?>
						<div class="ux-theme-layout-builder" data-thisname="<?php echo esc_attr($name); ?>">
                            <ul class="nav nav-pills">
                                <?php foreach($select_fields[$name] as $num => $select){
                                    $active = $select['value'] == $layout ? 'active' : false; ?>
                                    <li class="<?php echo esc_attr($active); ?>">
                                        <a href="#" class="<?php echo esc_attr($select['value']); ?>"></a>
                                        <span class="selected"></span>
                                    </li>
                                <?php } ?>
                                <li>
                                    <button type="button" class="btn btn-info btn-xs layout-builder-add <?php echo esc_attr($hidden_add); ?>"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button type="button" class="btn btn-danger btn-xs layout-builder-remove <?php echo esc_attr($hidden_remove); ?>"><span class="glyphicon glyphicon-remove"></span></button>
                                </li>
                            </ul>
                            <input type="hidden" value="<?php echo esc_attr($layout); ?>">
                        </div>
					<?php
                    }
				}else{ ?>
					<div class="ux-theme-layout-builder" data-thisname="<?php echo esc_attr($name); ?>">
                        <ul class="nav nav-pills">
                            <?php foreach($select_fields[$name] as $num => $select){
								$active = $num == 0 ? 'active' : false; ?>
                                <li class="<?php echo esc_attr($active); ?>">
                                    <a href="#" class="<?php echo esc_attr($select['value']); ?>"></a>
                                    <span class="selected"></span>
                                </li>
                            <?php } ?>
                            <li>
                                <button type="button" class="btn btn-info btn-xs layout-builder-add"><span class="glyphicon glyphicon-plus"></span></button>
                                <button type="button" class="btn btn-danger btn-xs layout-builder-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
                            </li>
                        </ul>
                        <input type="hidden" value="<?php echo esc_attr($default); ?>">
                    </div>
				<?php	
				}
			break;
		}
	}
}
?>