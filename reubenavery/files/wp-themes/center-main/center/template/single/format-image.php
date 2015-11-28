<?php 
$image_link = ux_get_post_meta(get_the_ID(), 'theme_meta_image_link');
if(has_post_thumbnail()){ ?>
	<div class="post-featured-img">
        <a title="<?php the_title(); ?>" href="<?php echo esc_url($image_link); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?></a>
	</div>
<?php }

if(get_the_content()){ ?>
    <div class="entry"><?php the_content(); wp_link_pages(); ?></div>
<?php } ?>