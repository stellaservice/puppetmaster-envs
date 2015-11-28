<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-unit-tit-wrap">
        <h1 class="blog-unit-tit"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="blog-unit-meta"><?php ux_get_template_part('global/content', 'meta'); ?></div>
    </div>
    
    <div class="blog-unit-img-wrap " style=""><a class="blog-unit-video-play" href="<?php the_permalink(); ?>"><span class="fa fa-play"></span></a>
		<?php if(has_post_thumbnail()){    
            $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
            <img alt="<?php the_title(); ?>" src="<?php echo esc_url($thumb[0]); ?>" class="blog-unit-img">
        <?php } ?>
        <div class="video-wrap hidden">
            <?php $video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');
            if($video_embeded_code){
                if(strstr($video_embeded_code, "youtu") && !(strstr($video_embeded_code, "iframe"))){ ?>
                    <iframe src="http://www.youtube.com/embed/<?php echo esc_attr(ux_theme_get_youtube($video_embeded_code));?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent" width="1500" height="844" frameborder="0" allowfullscreen=""></iframe>
                <?php
                }elseif(strstr($video_embeded_code, "vimeo") && !(strstr($video_embeded_code, "iframe"))){ ?>
                    <iframe src="http://player.vimeo.com/video/<?php echo esc_attr(ux_theme_get_vimeo($video_embeded_code)); ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0" width="1500" height="844" frameborder="0" allowfullscreen=""></iframe>
                <?php	
                }else{
                    echo balanceTags($video_embeded_code);
                }
            } ?>
        </div>
    </div>
    
    <?php ux_interface_blog_list_excerpt();
	
	ux_interface_blog_show_meta('continue-reading', 'article');
	
	//** Do Hook Archive Loop Item
	/**
	 * @hooked  ux_interface_social_bar - 10
	 */
	do_action('ux_interface_loop_item_after'); ?>

</article>