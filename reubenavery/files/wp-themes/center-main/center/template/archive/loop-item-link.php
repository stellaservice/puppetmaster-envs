<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php $ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');
	if($ux_link_item){ ?>
        <ul class="blog-unit-link">
            <?php foreach($ux_link_item['name'] as $i => $name){
                $url = $ux_link_item['url'][$i]; ?>
                <li class="blog-unit-link-li"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($name); ?>" class="blog-unit-link-li"><?php echo esc_html($name); ?></a></li>
            <?php } ?>
        </ul>
    <?php edit_post_link('(Edit)'); 
	}
	
	//** Do Hook Archive Loop Item
	/**
	 * @hooked  ux_interface_social_bar - 10
	 */
	do_action('ux_interface_loop_item_after'); 
	?>
    
</article>