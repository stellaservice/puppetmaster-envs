<?php
//** get sidebar meta
$sidebar       = ux_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
$sidebar_class = $sidebar == 'without-sidebar' ? 'fullwrap-layout' : 'two-cols-layout'; 
$layout_class  = $sidebar == 'without-sidebar' ? 'fullwrap-layout-inn' : 'container sidebar-layout';

?>
<div class="row-fluid content_wrap_outer <?php echo sanitize_html_class($sidebar_class); ?>">
<div class=" <?php echo esc_attr($layout_class); ?>">