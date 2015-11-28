<?php //** if enable sidebar
if(ux_enable_sidebar()){ ?>
	<aside id="sidebar-widget" class="span3" >
	
		<ul class="sidebar_widget">

			<?php
			$sidebar_widgets = 'sidebar_1';
			if(is_singular('post') || is_page()){
				$sidebar_widgets = ux_get_post_meta(get_the_ID(), 'theme_meta_sidebar_widgets');
			}
			
			dynamic_sidebar($sidebar_widgets); ?>

		</ul>	

	</aside>
	
<?php } ?>