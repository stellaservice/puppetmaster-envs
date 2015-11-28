<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-unit-tit-wrap">
        <h1 class="blog-unit-tit"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="blog-unit-meta"><?php ux_get_template_part('global/content', 'meta'); ?></div>
    </div>
    
    <?php if(has_post_thumbnail()){
        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
        
        <div class="post-featured-img">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img src="<?php echo esc_url($thumb[0]); ?>" alt="<?php the_title(); ?>" class="" /></a>
        </div>
        
    <?php }
	
	ux_interface_blog_list_excerpt();
	
	ux_interface_blog_show_meta('continue-reading', 'article');
	
	//** Do Hook Archive Loop Item
	/**
	 * @hooked  ux_interface_social_bar - 10
	 */
	do_action('ux_interface_loop_item_after'); ?>

</article>