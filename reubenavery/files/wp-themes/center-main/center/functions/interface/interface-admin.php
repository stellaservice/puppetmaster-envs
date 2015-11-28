<?php
define('UX_LOCAL_URL', get_template_directory_uri());
define('UX_INTERFACE', get_template_directory_uri(). '/functions/interface' );

//UX Theme Text Domain 
if(!function_exists('ux_theme_lang_setup')){
	add_action('after_setup_theme', 'ux_theme_lang_setup');
	function ux_theme_lang_setup(){
		$lang = get_template_directory()  . '/languages';
		load_theme_textdomain('ux', $lang);
	}
}

//UX Theme Get Template
function ux_get_template_part($key, $name){
	get_template_part('template/' . $key, $name);
}


//theme interface get post meta
function ux_get_post_meta($post_id, $key){
	$get_post_meta = get_post_meta($post_id, 'ux_theme_meta', true);
	$return = false;
	
	if($get_post_meta){
		if(isset($get_post_meta[$key])){
			if($get_post_meta[$key] != ''){
				switch($get_post_meta[$key]){
					case 'true': $return = true; break;
					case 'false': $return = false; break;
					default: $return = $get_post_meta[$key]; break;
				}
			}
		}
	}else{
		$return = ux_theme_post_meta_default($key);
	}
	
	return $return;
}



//theme front scripts
function ux_front_enqueue_scripts(){
	global $wp_styles;
	$onepage = ux_get_post_meta(get_the_ID(), 'theme_meta_show_onepage');
	$enable_rtl = ux_get_option('theme_option_enable_rtl');
	
	//RUN CSS
	wp_enqueue_style('ux-interface-bootstrap');
	wp_enqueue_style('font-awesome');
	wp_enqueue_style('ux-interface-pagebuild');
	wp_enqueue_style('ux-interface-style');
	wp_enqueue_style('ux-googlefont-Playfair');
	wp_enqueue_style('ux-googlefont-alike');
	wp_enqueue_style('ux-googlefont-Droid');
	if(ux_has_module('price')||ux_has_module('progress-bar')){
		wp_enqueue_style('ux-googlefont-lato');
	}	
	wp_enqueue_style('ux-interface-theme-style');
	if($enable_rtl) {
		wp_enqueue_style('ux-interface-style-rtl');
	}
	wp_enqueue_style('ux-interface-photoswipe');
	wp_enqueue_style('ux-interface-photoswipe-default-skin');

	//RUN JS
	if(ux_has_module('liquid-list') || ux_has_module('blog') || is_single() || is_home() || is_archive() || ux_enable_page_template()){
		wp_enqueue_script('ux-interface-jplayer');
	}
	if(ux_has_module('progress-bar')){
		wp_enqueue_script('ux-interface-infographic');
	}
	if(ux_has_module('count-down')){
		wp_enqueue_script('ux-interface-countdown');
	}
	if(ux_has_module('carousel') || ux_has_module('client') || ux_has_module('portfolio')){
		wp_enqueue_script('ux-interface-caroufredsel');
	}	
	if(is_single()){
		wp_enqueue_script('comment-reply');
	}
	wp_enqueue_script('ux-interface-main');
	
	if($onepage) {
		wp_enqueue_script('ux-interface-onepage');
	}
	
	wp_enqueue_script('ux-interface-theme');
	
	if(ux_has_module('google-map')){
		wp_enqueue_script('ux-interface-googlemap');
	}

	
	
}
add_action('wp_enqueue_scripts', 'ux_front_enqueue_scripts',101);

//theme google font family
function ux_theme_options_enqueue_googlefonts(){
	$get_option = get_option('ux_theme_option'); 
	$fonts_data = array();
	
	$main_font = false;
	if(isset($get_option['theme_option_font_family_main'])){
		$main_font = $get_option['theme_option_font_family_main'];
		array_push($fonts_data, $main_font);
	}
	
	$heading_font = false;
	if(isset($get_option['theme_option_font_family_heading'])){
		$heading_font = $get_option['theme_option_font_family_heading'];
		array_push($fonts_data, $heading_font);
	}
	
	$logo_font = false;
	if(isset($get_option['theme_option_font_family_logo'])){
		$logo_font = $get_option['theme_option_font_family_logo'];
		array_push($fonts_data, $logo_font);
	}
	
	$menu_font = false;
	if(isset($get_option['theme_option_font_family_menu'])){
		$menu_font = $get_option['theme_option_font_family_menu'];
		array_push($fonts_data, $menu_font);
	}
	
	$fonts_data = array_unique($fonts_data);
	if(count($fonts_data)){
		foreach($fonts_data as $font){
			if($font != -1){
				wp_enqueue_style('google-fonts-' . $font);
			}
		}
	}
}
add_action('wp_enqueue_scripts','ux_theme_options_enqueue_googlefonts');

//theme front scripts for ie
function ux_theme_head(){ ?>
	<script type="text/javascript">
	var JS_PATH = "<?php echo esc_url(UX_LOCAL_URL. '/js');?>";
    </script>
    
    <!-- IE hack -->
    <!--[if lte IE 9]>
	<link rel='stylesheet' id='cssie9'  href='<?php echo esc_url(UX_LOCAL_URL. '/styles/ie.css'); ?>' type='text/css' media='screen' />
	<![endif]-->

	<!--[if lte IE 9]>
	<script type="text/javascript" src="<?php echo esc_url(UX_LOCAL_URL. '/js/ie.js'); ?>"></script>
	<![endif]-->
	
	<!--[if lte IE 8]>
	<div style="width: 100%;" class="messagebox_orange">Your browser is obsolete and does not support this webpage. Please use newer version of your browser or visit <a href="<?php echo esc_url('http://www.ie6countdown.com/'); ?>" target="_new">Internet Explorer 6 countdown page</a>  for more information. </div>
	<![endif]-->

	
   
	<?php 
	
    
}
add_action('wp_head', 'ux_theme_head');

//theme footer
function ux_theme_footer(){
	$ux_track_code = ux_get_option('theme_option_track_code');
	echo balanceTags(stripslashes($ux_track_code));
}
add_action('wp_footer', 'ux_theme_footer', 20);



//require theme interface register
require_once locate_template('/functions/interface/interface-register.php');

//require theme interface functions
require_once locate_template('/functions/interface/interface-functions.php');

//require theme interface hook
require_once locate_template('/functions/interface/interface-hook.php');

//require theme interface template
require_once locate_template('/functions/interface/interface-template.php');

//require theme interface condition
require_once locate_template('/functions/interface/interface-condition.php');


?>