<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php 
    $ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote');
	$ux_quote_cite = ux_get_post_meta(get_the_ID(), 'theme_meta_quote_cite'); ?>
	
    <div class="blog-unit-quote"><?php echo wp_kses_post($ux_quote); ?>
        <?php if($ux_quote_cite) { ?>
        <cite><span class="cite-line">&mdash;</span> <?php echo wp_kses_post($ux_quote_cite); ?></cite>
        <?php } 
        ?> 
    </div>
    <?php edit_post_link('(Edit)'); ?>
    
    <?php //** Do Hook Archive Loop Item
	/**
	 * @hooked  ux_interface_social_bar - 10
	 */
	do_action('ux_interface_loop_item_after'); 
    ?>
    
</article>