<?php
//config
$category       = ux_get_post_meta(get_the_ID(), 'theme_meta_page_template_blog_category');
$orderby        = ux_get_post_meta(get_the_ID(), 'theme_meta_orderby');
$order          = ux_get_post_meta(get_the_ID(), 'theme_meta_order');
$disable_scroll = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_mouse_scroll_disable');
$disable_class  = $disable_scroll ? 'disable-scroll' : false;

$blog_querys = get_posts(array(
	'posts_per_page' => -1,
	'category__in'   => $category,
	'orderby'        => $orderby,
	'order'          => $order,
	'meta_key'       => '_thumbnail_id',
));

if($blog_querys){ ?>
    <div class="gallery-list-slider modify <?php echo $disable_class; ?>" id="top-slider">
        <div class="flexslider" data-control="false" data-direction="false" data-speed="4">
            <ul class="slides">
                <?php global $post;
				foreach($blog_querys as $post){ setup_postdata($post);
					$thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					$thumb_url = $thumb_src[0];
                    if (!$disable_scroll) {
					   echo '<li class="slide-item" style="background-image:url(' .esc_url($thumb_url). ')" data-id="' .esc_attr($post->ID). '" data-permalink="' .get_permalink(). '" title="' .esc_attr($post->post_title). '"></li>';
                    } else {
                        echo '<li class="slide-item" style="background-image:url(' .esc_url($thumb_url). ')" data-id="' .esc_attr($post->ID). '" data-permalink="' .get_permalink(). '" title="' .esc_attr($post->post_title). '"><a class="disable-scroll-a" href="'.get_permalink().'"></a></li>';

                    }
				}
				wp_reset_postdata(); ?>
            </ul>
        </div>
        <?php if(!$disable_scroll) { ?>
        <div id="gallery-list-more" class="center-ux">
            <span id="gallery-list-title"></span>
            <!-- <span class="gallery-list-contiune"><?php // esc_html_e('Continue Reading', 'ux'); ?> <span class="fa fa-angle-down"></span></span> -->
        </div>
        <div class="mouse-icon center-ux"><span class="mouse-dot"></span></div>
        <?php } ?>
    </div>
    <div id="gallery-wrap-ajax-content" class="container"></div>
    <div id="gallery-wrap-ajax-mask" class="visible">
        <div class="loading_text">
            <div class="loader">
              <div class="big"></div>
              <div class="small"></div>
            </div>
        </div>
    </div>
<?php } ?>