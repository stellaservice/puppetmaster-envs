<?php 
$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote');
$ux_quote_cite = ux_get_post_meta(get_the_ID(), 'theme_meta_quote_cite'); ?>

<div class="blog-unit-quote"><?php echo wp_kses_post($ux_quote); ?>
	<?php if($ux_quote_cite) { ?>
	<cite><span class="cite-line">&mdash;</span> <?php echo wp_kses_post($ux_quote_cite); ?></cite>
	<?php } ?> 
</div>

<?php if(get_the_content()){ ?>
    <div class="entry"><?php the_content(); wp_link_pages(); ?></div><!--End entry-->
<?php } ?>