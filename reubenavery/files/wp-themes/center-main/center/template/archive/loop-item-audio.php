<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-unit-tit-wrap">
        <h1 class="blog-unit-tit"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="blog-unit-meta"><?php ux_get_template_part('global/content', 'meta'); ?></div>
    </div>
    
    <?php
    $audio_type       = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
	$audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');
	if($audio_type == 'soundcloud' && $audio_soundcloud){ ?>
    
        <div class="blog-unit-soundcloud">
            <iframe width="100%" height="160" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo esc_url($audio_soundcloud); ?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
        </div>
        
    <?php }else{
		$audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
		$audio_mp3    = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
		$first_name   = $audio_mp3['name'][0];
		$first_url    = $audio_mp3['url'][0]; ?>
        
        <div class="blog-unit-img-wrap " style="">
            <ul class="audio_player_list blog-list-audio">
                <li class="audio-unit"><span id="audio-<?php echo esc_attr(get_the_ID() . '-0'); ?>" class="audiobutton pause" rel="<?php echo esc_url($first_url); ?>"></span><span class="songtitle" title="<?php echo esc_attr($first_name); ?>"><?php echo esc_html($first_name); ?></span></li>
                <div class="blog-list-audio-artist"><?php esc_html_e('Artist:','ux'); ?> <?php echo esc_html($audio_artist); ?></div>
            </ul>
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