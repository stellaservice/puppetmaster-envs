<div class="title-wrap">
    <h1 class="title-h1"><?php the_title(); ?></h1>
    <?php $enable_meta = ux_get_option('theme_option_enable_meta_post_page');
	if($enable_meta){ ?>
        <div class="blog-unit-meta"><?php ux_get_template_part('global/content', 'meta'); ?></div>
    <?php } ?>
</div>