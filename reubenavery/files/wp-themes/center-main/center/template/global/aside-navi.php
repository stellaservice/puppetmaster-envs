<aside id="main-navi">

	<div class="container">

	<span id="menu_toggle" class="fa fa-bars"></span>

    <?php //** Function Logo for header
	ux_interface_logo('header'); ?>

    <div id="main-navi-inn">

        <?php if(ux_enable_page_template()){
			$show_navigation = ux_get_post_meta(get_the_ID(), 'theme_meta_show_navigation_on_sidebar');
			if($show_navigation){
				$category = ux_get_post_meta(get_the_ID(), 'theme_meta_page_template_blog_category');
				$orderby  = ux_get_post_meta(get_the_ID(), 'theme_meta_orderby');
				$order    = ux_get_post_meta(get_the_ID(), 'theme_meta_order');
				
				$blog_querys = get_posts(array(
					'posts_per_page' => -1,
					'category__in'   => $category,
					'orderby'        => $orderby,
					'order'          => $order,
					'meta_key'       => '_thumbnail_id',
				));
				
				if($blog_querys){ ?>
                    <nav class="gallery-navi">
                        <ul class="gallery-navi-ul">
                            <?php global $post;
                            foreach($blog_querys as $num => $post){ setup_postdata($post);
								$active = $num == 0 ? 'gallery-navi-li-active' : false; ?>
                                <li class="gallery-navi-li <?php echo sanitize_html_class($active); ?>"><a class="gallery-navi-a" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
                            <?php
                            }
							wp_reset_postdata(); ?>
                        </ul>
                    </nav>
				<?php
                }
			}
		} ?>
        
        <nav id="navi">
		<?php wp_nav_menu(array(
            'theme_location'  => 'primary',
            'container_id' => 'navi_wrap',
            'items_wrap' => '<ul class="%2$s clearfix">%3$s</ul>'
        )); ?><!--End #navi_wrap-->
        </nav>
        
        <?php //** Enable Search button
		$enable_search_button = ux_get_option('theme_option_enable_search_button');
		if($enable_search_button){ ?>
            <div id="search-top-btn" class="search-top-btn-class"><span class="fa fa-search"></span> <span class="search-top-btn-class-text"><?php esc_html_e('Search', 'ux'); ?></span></div>
        <?php }
		
		//** Enable Header social
		$enable_header_social = ux_get_option('theme_option_show_social_in_header');
		if($enable_header_social){
			ux_interface_social('header');
		} ?>
    </div><!--End #main-navi-inn-->

	</div>

</aside>