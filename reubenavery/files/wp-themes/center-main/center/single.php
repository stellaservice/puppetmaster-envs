<?php get_header(); ?>

	<div id="content">

		<?php while(have_posts()){ the_post(); ?>
        
            <?php //** Do Hook Single summary
			do_action('ux_interface_single_summary'); ?>
            
            
			<?php //** Do Hook Single before
            /**
             * @hooked  ux_interface_single_content_before 10
             */
            do_action('ux_interface_single_content_before'); ?>
            
            <div id="content_wrap" <?php ux_interface_content_class(); ?>>
                
                <?php //** Do Hook Single Article before
				/**
				 * @hooked  ux_interface_single_content_title 10
				 */
				do_action('ux_interface_single_article_before'); ?>
                
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('container'); ?>>
                
                    <?php //** Do Hook Page content
					/**
					 * @hooked  ux_interface_single_content - 10
					 * @hooked  ux_interface_pagebuilder - 15
					 * @hooked  ux_interface_social_bar - 20
					 * @hooked  ux_interface_single_author - 27
					 * @hooked  ux_interface_single_related - 31
					 * @hooked  ux_interface_single_comment - 35
					 */
					do_action('ux_interface_single_content'); ?>
                    
                </article><!--end article-->
                
                 <?php //** Do Hook Single Article after
				do_action('ux_interface_single_article_after'); ?>

            </div><!--End content_wrap-->

            <?php //** Do Hook Sidebar Widget
            /**
             * @hooked  ux_interface_sidebar_widget - 10
             */
            do_action('ux_interface_sidebar_widget'); ?>
                
            <?php //** Do Hook Single after
            /**
             * @hooked  ux_interface_single_content_after 10
             * @hooked  ux_interface_single_gallery_navi 15
             */
            do_action('ux_interface_single_content_after'); ?>
        
        <?php } ?>
    
    </div><!--End content-->
	
<?php get_footer(); ?>