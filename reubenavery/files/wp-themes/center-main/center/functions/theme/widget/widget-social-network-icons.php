<?php 
class UXSocialNetworkInons extends WP_Widget
{
	function UXSocialNetworkInons(){
		
		$widget_ops = array('description' => esc_attr__('Shows Social Network Icons in your blog', 'ux-social-icons') );
		parent::__construct('UXSocialNetworkInons', esc_attr__('Social Network Icons', 'ux-social-icons'), $widget_ops);
	}
	
	function widget($args, $instance){
		$title = esc_attr(apply_filters('widget_title', $instance['title']));

		echo balanceTags($args['before_widget']);
		if(!empty($title)){
			echo balanceTags($args['before_title'] . $title . $args['after_title']);
		}
		
		if($instance && isset($instance['icontype'])){ ?>
            <div class="icon clearfix">
				<?php $icon_type = $instance['icontype'];
				foreach($icon_type as $num => $type){
					$icon = $instance['icon'][$num];
					$url = $instance['url'][$num];
					$tip = $instance['tip'][$num]; ?>
                    <a class="social_active" href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($tip); ?>">
						<?php if($type == 'fontawesome'){ ?>
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        <?php }elseif($type == 'user'){ ?>
                            <img src="<?php echo esc_url($icon); ?>" />
                        <?php } ?>
                    </a>
				<?php } ?>
            </div>
        <?php	
		}
		echo balanceTags($args['after_widget']);
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		
		$instance['icon'] = $new_instance['icon'];
		$instance['icontype'] = $new_instance['icontype'];
		$instance['url'] = $new_instance['url'];
		$instance['tip'] = $new_instance['tip'];
		$instance['title'] = strip_tags($new_instance['title']);
		
		return $instance;
		
	}
	
	function form($instance){
		$title = isset($instance['title']) ? $instance['title'] : false; ?>
        <div class="ux-theme-box">
            <div class="ux-widget-social-network-icons">
                <label><?php esc_attr_e('Title','ux'); ?></label>
                <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" class="form-control" value="<?php echo esc_attr($title); ?>" />
            </div>
            
            <div class="ux-theme-new-social-medias ux-widget-social-network-icons">
				<?php if($instance && isset($instance['icontype'])){
                    $icon_type = $instance['icontype'];
                    foreach($icon_type as $num => $type){
                        $icon = $instance['icon'][$num];
                        $url = $instance['url'][$num];
                        $tip = $instance['tip'][$num];
                        $button_remove = $num == 0 ? 'hidden' : false;
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
                                <input type="hidden" name="<?php echo esc_attr($this->get_field_name('icon')); ?>[]" value="<?php echo esc_attr($icon); ?>" />
                                <input type="hidden" name="<?php echo esc_attr($this->get_field_name('icontype')); ?>[]" value="<?php echo esc_attr($type); ?>" />
                            </div>
                            <div class="clearfix"></div>
                            <div class="new-media-col-url">
                                <input type="text" name="<?php echo esc_attr($this->get_field_name('url')); ?>[]" class="form-control input-sm pull-left" value="<?php echo esc_attr($url); ?>" placeholder="<?php esc_attr_e('Enter the social media url','ux'); ?>" />
                                <input type="text" name="<?php echo esc_attr($this->get_field_name('tip')); ?>[]" class="form-control input-sm pull-right" value="<?php echo esc_attr($tip); ?>" placeholder="<?php esc_attr_e('Tip for mouseover','ux'); ?>" />
                            </div>
                            <div class="new-media-col-remove pull-right <?php echo sanitize_html_class($button_remove); ?>">
                                <button type="button" class="btn btn-danger btn-sm social-medias-remove"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <div class="new-media-col-add pull-right <?php echo sanitize_html_class($button_add); ?>">
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
                            <input type="hidden" name="<?php echo esc_attr($this->get_field_name('icon')); ?>[]" value="" />
                            <input type="hidden" name="<?php echo esc_attr($this->get_field_name('icontype')); ?>[]" value="" />
                        </div>
                        <div class="clearfix"></div>
                        <div class="new-media-col-url">
                            <input type="text" name="<?php echo esc_attr($this->get_field_name('url')); ?>[]" class="form-control input-sm pull-left" value="" placeholder="<?php esc_attr_e('Enter the social media url','ux'); ?>" />
                            <input type="text" name="<?php echo esc_attr($this->get_field_name('tip')); ?>[]" class="form-control input-sm pull-right" value="" placeholder="<?php esc_attr_e('Tip for mouseover','ux'); ?>" />
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
        </div>
    <?php
    }
}
add_action( 'widgets_init', create_function('', 'return register_widget("UXSocialNetworkInons");') ); ?>