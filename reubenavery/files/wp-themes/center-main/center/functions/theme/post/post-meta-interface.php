<?php
//theme meta interface
function ux_theme_post_meta_interface(){
	$ux_theme_post_meta_fields = ux_theme_post_meta_fields();
		
	if(!empty($ux_theme_post_meta_fields[get_post_type()])){
		$ux_theme_post_meta_posttype = $ux_theme_post_meta_fields[get_post_type()];
		foreach($ux_theme_post_meta_posttype as $option){
			$format = isset($option['format']) ? 'data-format="' .esc_attr($option['format']). '"' : false; ?>
            <div class="postbox ux-theme-box ux-theme-meta-box" <?php echo balanceTags(($format)); ?>>
                <h3 class="hndle"><span><?php echo esc_html($option['title']); ?></span></h3>
                <div class="inside">
                    <?php if(isset($option['action'])){
						do_action('ux-theme-post-meta-interface', esc_attr($option['id']));
					}else{
						if(isset($option['section'])){
							foreach($option['section'] as $section){
								$subclass = isset($section['subclass']) ? 'theme-option-item-body' : false;
								$title = isset($section['title']) ? $section['title'] : false;
								$super_control = isset($section['super-control']) ? 'data-super="' .esc_attr($section['super-control']['name']) . '" data-supervalue="' .esc_attr($section['super-control']['value']). '"' : false; ?>
                                
								<div class="theme-option-item" <?php echo balanceTags($super_control); ?>>
									<h4 class="theme-option-item-heading">
										<?php echo balanceTags('<span>' . $title . '</span>'); ?>
									</h4>
									<div class="<?php echo esc_attr($subclass); ?>">
										<?php if(isset($section['item'])){
											foreach($section['item'] as $item){
												$control = isset($item['control']) ? 'data-name="' .esc_attr($item['control']['name']). '" data-value="' .esc_attr($item['control']['value']). '"' : false; 
												$item_format = isset($item['format']) ? 'data-format="' .esc_attr($item['format']). '"' : false;
												if($item['type'] == 'divider' || $item['type'] == 'description' || $item['type'] == 'gallery'){
													ux_theme_option_getfield($item, 'ux_theme_meta');
												}else{ ?>
                                                    <div class="row <?php echo esc_attr($item['name']); ?>" <?php echo balanceTags($control); ?> <?php echo balanceTags($item_format); ?>>
                                                        <div class="col-xs-3">
                                                            <?php if(isset($item['title'])){ ?>
                                                                <h5><?php echo esc_html($item['title']); ?></h5>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-xs-9">
                                                            <?php if(isset($item['bind'])){
                                                                foreach($item['bind'] as $bind){
                                                                    if($bind['position'] == 'before'){
                                                                        ux_theme_option_getfield($bind, 'ux_theme_meta');
                                                                    }
                                                                }
                                                            }
                                                            
                                                            ux_theme_option_getfield($item, 'ux_theme_meta');
                                                            
                                                            if(isset($item['bind'])){
                                                                foreach($item['bind'] as $bind){
                                                                    if($bind['position'] == 'after'){
                                                                        ux_theme_option_getfield($bind, 'ux_theme_meta');
                                                                    }
                                                                }
                                                            } ?>
                                                            <?php if(isset($item['description'])){ ?>
                                                                <p class="text-muted"><?php echo esc_html($item['description']); ?></p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php
												}
											}
										} ?>
									</div>
								</div>
							<?php 
							}
						}
					} ?>
                </div>
            </div>
        <?php } ?>
        <div class="ux-theme-box"><?php ux_theme_option_modal(); ?></div>
        <input type="hidden" name="custom_meta_box_nonce" value="<?php echo esc_attr(wp_create_nonce(ABSPATH)); ?>" />
	<?php
    }
}
add_action('edit_form_after_editor', 'ux_theme_post_meta_interface');

?>