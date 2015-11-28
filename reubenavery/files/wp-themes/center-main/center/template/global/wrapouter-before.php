<?php $onepage = ux_get_post_meta(get_the_ID(), 'theme_meta_show_onepage'); 
$onepage_class = $onepage ? 'enbale-onepage' : false; 
?>
<div id="wrap-outer" class="<?php echo esc_html($onepage_class); ?>">
	<div id="top"></div>