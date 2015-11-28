<?php 
$audio_type       = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
$audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');
if($audio_type == 'soundcloud' && $audio_soundcloud){ ?>
    
    <div class="blog-unit-soundcloud center-ux">
         <iframe width="100%" height="120" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo esc_url($audio_soundcloud); ?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
    </div>

<?php }else{
	$audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
	$audio_mp3    = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3'); ?>

    <div class="content-audio">
        <?php if($audio_artist){ ?><cite class="content-audio-artist"><?php esc_html_e('Artist:','ux'); ?> <?php echo esc_html($audio_artist); ?></cite><?php } ?>
        <ul class="audio_player_list ">
            <?php foreach($audio_mp3['name'] as $i => $name){
                $url = $audio_mp3['url'][$i]; ?>
                <li class="audio-unit"><span id="audio-<?php echo get_the_ID() . '-' . $i; ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span><span class="songtitle" title="<?php echo esc_attr($name);?>"><?php echo esc_html($name);?></span></li>
            <?php } ?>
        </ul>
    </div>

<?php
}

if(get_the_content()){ ?>
    <div class="entry"><?php the_content(); wp_link_pages(); ?></div>
<?php } ?>