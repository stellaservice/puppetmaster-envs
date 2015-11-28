<?php
//** get sidebar meta
$sidebar       = ux_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
$sidebar_class = $sidebar == 'without-sidebar' ? 'fullwrap-layout' : 'two-cols-layout'; 
$layout_class  = $sidebar == 'without-sidebar' ? 'fullwrap-layout-inn' : 'container sidebar-layout';

$spacer_class  = '';
$spacer_top    = ux_get_post_meta(get_the_ID(), 'theme_meta_show_top_spacer');
$spacer_bottom = ux_get_post_meta(get_the_ID(), 'theme_meta_show_bottom_spacer');

if($spacer_top){
	$spacer_class .= 'has-top-spacer'. ' ';
}

if($spacer_bottom){
	$spacer_class .= 'has-bottom-spacer'. ' ';
}

if(ux_enable_page_template()){
	$sidebar_class = 'fullwrap-layout';
	$layout_class = '';
	$spacer_class = '';
}

?>
<div class="row-fluid content_wrap_outer <?php echo sanitize_html_class($sidebar_class); ?>">
<div class="<?php echo esc_attr($layout_class); ?> <?php echo esc_attr($spacer_class); ?>">