<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-unit-tit-wrap">
        <h1 class="blog-unit-tit"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="blog-unit-meta"><?php ux_get_template_part('global/content', 'meta'); ?></div>
    </div>
   
    <?php 
    ux_interface_blog_list_excerpt();

    ux_get_template_part('single/portfolio', 'template'); 
	
	ux_interface_blog_show_meta('continue-reading', 'article');
	
	//** Do Hook Archive Loop Item
	/**
	 * @hooked  ux_interface_social_bar - 10
	 */
	do_action('ux_interface_loop_item_after'); ?>

</article>