<?php get_header(); ?>

	<div id="content">
        
		<?php while(have_posts()){ the_post(); ?>
        
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
                <?php //** Do Hook Page before
				/**
				 * @hooked  ux_interface_page_content_before - 10
				 */
				do_action('ux_interface_page_content_before'); ?>
                
                <div id="content_wrap" <?php ux_interface_content_class(); ?>>
                
                    <?php
					//** Do Hook Page Article before
					/**
					 * @hooked  ux_interface_page_content_title - 10
					 */
					do_action('ux_interface_page_article_before');
					
					//** Do Hook Page content
					/**
					 * @hooked  ux_interface_pagebuilder - 10
					 * @hooked  ux_interface_page_content - 20
					 */
					do_action('ux_interface_page_content');
					
					//** Do Hook Page Article after
					do_action('ux_interface_page_article_after'); ?>

                    
                </div><!--End content_wrap-->
    
                <?php //** Do Hook Sidebar Widget
                /**
                 * @hooked  ux_interface_sidebar_widget - 10
                 */
                do_action('ux_interface_sidebar_widget');
                    
                //** Do Hook Page after
				/**
				 * @hooked  ux_interface_page_content_after - 10
				 * @hooked  ux_interface_page_gallery_navi - 15
				 */
                do_action('ux_interface_page_content_after'); ?>   
            
            </div><!--end #postID-->    
        
        <?php } ?>      
    
    </div><!--End content-->
	
<?php get_footer(); ?>