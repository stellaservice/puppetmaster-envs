<?php
if(is_singular('post') || is_page()){
	
	$switch_sidebar = false;
	$sidebar_widget = false;
	
	if(is_singular('post')){
		$switch_sidebar = ux_get_option('theme_option_enable_footer_widget_for_post');
		$sidebar_widget = ux_get_option('theme_option_footer_widget_for_post');
	}elseif(is_page()){
		if(!ux_enable_page_template()){
			$switch_sidebar = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_footer_widget_for_pages');
			$sidebar_widget = ux_get_post_meta(get_the_ID(), 'theme_meta_footer_widget_for_pages');
		}
	}
	
	if($switch_sidebar){ ?>
        <!--Footer Widget-->
        <div class="widget_footer container">
            <div class="row-fluid">
                <?php if($sidebar_widget){
					ux_dynamic_sidebar($sidebar_widget, 3);
				} ?>
            </div><!--End row-fluid-->
        </div><!--End widget_footer-->
    
    <?php
	}
} ?>