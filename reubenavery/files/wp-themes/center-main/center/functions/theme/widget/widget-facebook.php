<?php
/*
Plugin Name: Facbook widget
Plugin URI: http://www.uiueux.com/
Description: Show facebook profile
Author: uiueux
Version: 1.0
Author URI: http://www.uiueux.com/
*/
class UXFacebookWdiget extends WP_Widget
{
	function UXFacebookWdiget(){
		
		$widget_ops = array('description' => esc_attr__('Shows facebook page profile in your blog', 'ux') );
		parent::__construct('UXFacebookWdiget', esc_attr__('Facebook Page Profile', 'ux'), $widget_ops);
	}
	
	function widget($args, $instance){
		$title = apply_filters('widget_title', $instance['title']);
		$username = $instance['username'];
		echo balanceTags($args['before_widget']);
		if(!empty($title)){
			echo balanceTags($args['before_title'] . esc_attr($title) . $args['after_title']);
		} ?>
        <div class="textwidget"><iframe class="facebook-widget" src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/<?php echo esc_attr($username); ?>&amp;width=260&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;height=290&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden;  height:290px; width:100%; margin-left:-10px;background:#fff;" allowTransparency="true"></iframe></div>
        <?php	
		
		echo balanceTags($args['after_widget']);
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		return $instance;
		
	}
	
	function form($instance){
		$title = isset($instance['title']) ? $instance['title'] : false; 
		$username = isset($instance['username']) ? $instance['username'] : 'uiueux'; ?>

		<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title','ux'); ?>:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php esc_html_e('Enter your facebook username','ux'); ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id('username')); ?>" name="<?php echo esc_attr($this->get_field_name('username')); ?>" type="text" value="<?php echo esc_attr($username); ?>" size="10" /><br /></p>
        
    <?php
    }
}
add_action( 'widgets_init', create_function('', 'return register_widget("UXFacebookWdiget");') ); ?>