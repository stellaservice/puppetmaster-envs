<?php $ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');
if($ux_link_item){ ?>
    <ul class="blog-unit-link">
        <?php foreach($ux_link_item['name'] as $i => $name){
            $url = $ux_link_item['url'][$i]; ?>
            <li class="blog-unit-link-li"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($name); ?>" class="blog-unit-link-li"><?php echo esc_html($name); ?></a></li>
        <?php } ?>
    </ul>
<?php }

if(get_the_content()){ ?>
    <div class="entry"><?php the_content(); wp_link_pages(); ?></div>
<?php } ?>