<?php
/****************************************************************/
/*
/* Functions
/*
/****************************************************************/

//Function more...
function twentyten_continue_reading_link() {
	return '';
}
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

//Function Web Title
function ux_interface_wp_title($title, $sep){
	global $paged, $page;

	if(is_feed() || is_search()){
		return $title;
	}

	$title .= get_bloginfo('name');

	$site_description = get_bloginfo('description', 'display');
	if($site_description &&(is_home() || is_front_page())){
		$title = "$title $sep $site_description";
	}

	if($paged >= 2 || $page >= 2){
		$title = "$title $sep " . sprintf(__('Page %s','ux'), max($paged, $page));
	}

	return esc_attr($title);
}

//Function Web Head Viewport
function ux_interface_webhead_viewport(){
	$enable_responsive = ux_get_option('theme_option_mobile_enable_responsive');
	
	if($enable_responsive){ ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	}
}

//function
function ux_interface_equiv_meta(){ ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php 
}


//Function Web Head Favicon
function ux_interface_webhead_favicon(){
	$favicon_icon = ux_get_option('theme_option_custom_favicon');
	$mobile_icon  = ux_get_option('theme_option_mobile_icon');
	
	$favicon_icon = $favicon_icon ? $favicon_icon : UX_LOCAL_URL . '/img/favicon.ico';
	$mobile_icon  = $mobile_icon ? $mobile_icon : UX_LOCAL_URL . '/img/favicon.ico'; ?>
    
    <link rel="shortcut icon" href="<?php echo esc_url($favicon_icon); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo esc_url($mobile_icon); ?>">
<?php
}

//Function body class
function ux_interface_body_class(){
	$responsive = ux_get_option('theme_option_mobile_enable_responsive') ? 'responsive-ux' : false;
	$navigation_bar = ux_get_option('theme_option_navigation_bar');
	$navigation_class = $navigation_bar == 'navigation_on_top' ? 'navi-top-layout' : 'navi-side-layout';
	
	$page_template_class = ux_enable_page_template() ? 'page-template-slider' : false;
	
	body_class(sanitize_html_class($responsive). ' ' .sanitize_html_class($navigation_class). ' ' .sanitize_html_class($page_template_class). ' preload');
}

//Function Logo
function ux_interface_logo($key = ''){
	$home_url           = home_url();
	$enable_text_logo   = ux_get_option('theme_option_enable_text_logo');
	$text_logo          = ux_get_option('theme_option_text_logo');
	$text_logo          = $text_logo ? '<h1 class="logo-h1">' .balanceTags($text_logo). '</h1>' : '<h1 class="logo-h1">'. get_bloginfo('name'). '</h1>';
	$custom_logo        = ux_get_option('theme_option_custom_logo');
	$custom_logo        = $custom_logo ? '<img class="logo-image" src="' .esc_url($custom_logo). '" alt="' .get_bloginfo('name'). '" />' : false;
	$foot_custom_logo   = ux_get_option('theme_option_custom_footer_logo');
	$foot_custom_logo   = $foot_custom_logo ? '<div id="logo-footer"><a class="logo-footer-a" href="' .esc_url($home_url). '" title="' .get_bloginfo('name'). '"><img class="logo-footer-img" src="' .esc_url($foot_custom_logo). '" alt="' .esc_attr(get_bloginfo('name')). '" /></a></div>' : false;
	$custom_load_logo   = ux_get_option('theme_option_custom_logo_for_loading');
	$custom_load_logo   = $custom_load_logo ? '<img src="' .esc_url($custom_load_logo). '" alt="' .get_bloginfo('name'). '" />' : false;
	$output             = '';
	
	switch($key){
		case 'loading':
			$output .= '<div class="site-loading-logo">';
			$output .= $enable_text_logo ? $text_logo : $custom_load_logo;
			$output .= '</div>';
		break;

		case 'footer': 
			$output .= $enable_text_logo ? $text_logo : $foot_custom_logo;
		break;
		
		default:       
			$output .= '<div id="logo"><a class="logo-a" href="' . $home_url . '" title="' . get_bloginfo('name') . '">';
			$output .= $enable_text_logo ? $text_logo : '<h1 class="logo-h1 logo-not-show-txt">' . get_bloginfo('name') . '</h1>'.$custom_logo;
			$output .= '</a></div><!--End logo-->';
		break;
		
	}
	
	echo balanceTags($output,false);
}

//Function theme get option
function ux_get_option($key){
	$get_option = get_option('ux_theme_option');
	$return = false;
	
	if($get_option){
		if(isset($get_option[$key])){
			if($get_option[$key] != ''){
				switch($get_option[$key]){
					case 'true': $return = true; break;
					case 'false': $return = false; break;
					default: $return = $get_option[$key]; break;
				}
			}
		}else{
			switch($key){
				case 'theme_option_enable_fadein_effect': $return = true; break;
				case 'theme_option_enable_search_field': $return = true; break;
				case 'theme_option_enable_search_button': $return = true; break;
				case 'theme_option_enable_footer_logo': $return = true; break;
				case 'theme_option_enable_meta_post_page': $return = true; break;
				case 'theme_option_posts_showmeta': $return = array('date', 'length', 'category', 'tag', 'author', 'comments'); break;
				case 'theme_option_mobile_enable_responsive': $return = true; break;
				case 'theme_option_enable_share_buttons_for_posts': $return = true; break;
				case 'theme_option_share_buttons': $return = array('facebook', 'twitter', 'google-plus', 'pinterest'); break;
				case 'theme_option_enable_footer_widget_for_pages': $return = true; break;
				case 'theme_option_enable_footer_widget_for_post': $return = true; break;
				case 'theme_option_enable_footer_enable_copyright': $return = true; break;
				
			}
		}
	}else{
		$return = ux_theme_option_default($key);
		
		switch($key){
			case 'theme_option_enable_fadein_effect': $return = true; break;
			case 'theme_option_enable_search_field': $return = true; break;
			case 'theme_option_enable_search_button': $return = true; break;
			case 'theme_option_enable_footer_logo': $return = true; break;
			case 'theme_option_enable_meta_post_page': $return = true; break;
			case 'theme_option_posts_showmeta': $return = array('date', 'length', 'category', 'tag', 'author', 'comments'); break;
			case 'theme_option_mobile_enable_responsive': $return = true; break;
			case 'theme_option_enable_share_buttons_for_posts': $return = true; break;
			case 'theme_option_share_buttons': $return = array('facebook', 'twitter', 'google-plus', 'pinterest'); break;
			case 'theme_option_enable_footer_widget_for_pages': $return = true; break;
			case 'theme_option_enable_footer_widget_for_post': $return = true; break;
			case 'theme_option_enable_footer_enable_copyright': $return = true; break;
		}
	}
	
	return $return;
}

//Function pagination
function ux_interface_pagination($pages = '', $range = 3){
	global $wp_query, $wp_rewrite;
	
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1; 
	
	echo '<div class="clearfix pagenums pagenums-default">';
	echo wp_kses_post(paginate_links( array(
		'base'      => @add_query_arg('paged','%#%'),
		'format'    => '',
		'current'   => $current,
		'prev_text' => esc_attr__('Previous','ux'),
		'next_text' => esc_attr__('Next','ux'),
		'total'     => $wp_query->max_num_pages,
		'mid_size'  => $range
	)));  
	echo '</div>';
}

//Function Copyright
function ux_interface_copyright(){
	$footer_copyright = ux_get_option('theme_option_copyright');
	$footer_copyright_enable = ux_get_option('theme_option_enable_footer_enable_copyright');
	$footer_copyright = $footer_copyright ? $footer_copyright : 'Copyright uiueux.com';
	if($footer_copyright_enable) { 
		echo wp_kses_post($footer_copyright);
	}
}

//Function Social
function ux_interface_social($key = false){
	$show_social_medias = ux_get_option('theme_option_show_social');
	$social_medias = ux_get_option('theme_option_show_social_medias');
	
	$social_class = $key == 'header' ? 'social-header' : false;
	
	if($show_social_medias && $social_medias && isset($social_medias['icontype'])){
		$icon_type = $social_medias['icontype']; ?>
		
		<ul class="socialmeida <?php echo sanitize_html_class($social_class); ?>">
			<?php foreach($icon_type as $num => $type){
				$icon = $social_medias['icon'][$num];
				$url = $social_medias['url'][$num];
				$tip = $social_medias['tip'][$num];  ?>
				
				<li class="socialmeida-li">
                    <a title="<?php echo esc_attr($tip); ?>" href="<?php echo esc_url($url); ?>" class="socialmeida-a">
                        <?php // if($type == 'fontawesome'){
                            
                        if($type == 'user'){
                            echo '<img src="' .esc_url($icon). '" alt="' .esc_attr($tip). '" /> ';
                        } else { 
                        	if($icon) { echo '<span class="' .esc_attr($icon). '"></span> '; }
                            echo esc_html($tip);
                        } ?>

                    </a>
                </li>
			<?php } ?>
		</ul>
	<?php

	} //End if $social_medias
}

//Function Language Flags
function ux_interface_language_flags(){
	if (function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			
				echo '<div class="wpml-translation">';
				echo '<ul class="wpml-language-flags clearfix">';
				foreach($languages as $l){
					echo '<li>';
					if($l['country_flag_url']){
						if(!$l['active']) {
							echo '<a href="'.esc_url($l['url']).'"><img src="'.esc_url($l['country_flag_url']).'" height="12" alt="'.esc_attr($l['language_code']).'" width="18" /></a>';
						} else {
							echo '<div class="current-language"><img src="'.esc_url($l['country_flag_url']).'" height="12" alt="'.esc_attr($l['language_code']).'" width="18" /></div>';
						}
					}
					echo '</li>';
				}
				echo '</ul>';
				echo '</div><!--End header-translation-->';
			
		}
	} else {
		echo "<p class='wpml-tip'>". esc_attr__('WPML not installed and activated.','ux') ."</p>";
	}
}

//Function Content wrap class
function ux_interface_content_class(){
	$ux_sidebar_class = 'span9';

	$output = $ux_sidebar_class;
	
	if(is_singular('post') || is_page() || is_singular('team_item')){
		$pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
		$sidebar   = ux_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
		switch($sidebar){
			case 'right-sidebar':   $output = $ux_sidebar_class; break;
			case 'left-sidebar':    $output = $ux_sidebar_class. ' pull-right'; break;
			case 'without-sidebar': $output = '';
		}
		
		if(ux_enable_page_template()){
			$output = false;
		}
	}
	
	if(ux_enable_team_template()){
		$output = false;
	}
	
	echo 'class="' .esc_attr($output). '"';
	
}

//Function Pagebuilder
function ux_interface_pagebuilder(){
	$switch = false;
	
		if(ux_enable_pb()){
			if(post_password_required()){
			 	echo get_the_password_form();
			 	return;
			}else{
			$switch = true;
			}
		}
		
	$enable_paid = false;
	//$enable_paid = ux_get_option('theme_option_enable_paid_content');
	if($enable_paid){
		if(function_exists('pmpro_has_membership_access')){
			$hasaccess = pmpro_has_membership_access(NULL, NULL, true);
			if(is_array($hasaccess)){
				//returned an array to give us the membership level values
				$post_membership_levels_ids = $hasaccess[1];
				$post_membership_levels_names = $hasaccess[2];
				$hasaccess = $hasaccess[0];
			}
			if($hasaccess){
				$switch = true;
			}else{
				$switch = false;
			}
		}
	}
	
	if(!ux_enable_page_template()){
		if($switch){
			echo '<div class="pagebuilder-wrap">';
			do_action('ux-theme-single-pagebuilder');
			echo '</div>';
		}else{
			if(ux_enable_pb()){
				the_excerpt();
			}
			
		}
	}
}

//Function search list ajax
function ux_interface_search_list_load($keyword, $paged){
	$the_search = new WP_Query('s=' .$keyword. '&paged=' .$paged);
	
	if($the_search->have_posts()){
		while($the_search->have_posts()){ $the_search->the_post(); ?>
            <section class="search-result-unit">
                <h1 class="blog-unit-tit"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <?php if(get_the_excerpt()){ ?>		
                    <div class="blog-unit-excerpt"><?php the_excerpt(); ?></div>
                <?php } ?>
                <div class="blog-unit-meta">
                    <?php ux_interface_blog_show_meta('date'); ?><?php ux_interface_blog_show_meta('category'); ?>
                </div>
            </section>
		<?php
        }
		wp_reset_postdata();
		
		$next_paged = (int) $paged + 1;
		
		if((int) $paged < $the_search->max_num_pages){
			echo '<div class="clearfix pagenums tw_style page_twitter">';
			echo '<a class="tw-style-a ux-btn container-inn" data-paged="' .esc_attr($next_paged). '" href="#">' . esc_attr__('Load More','ux'). '</a>';
			echo '</div>';
		}
	}else{
		echo '<section class="search-result-unit">';
		esc_attr_e('Sorry, no result.','ux');
		echo '</section>';
	}
}

//Function page template load
function ux_interface_page_template_load($post_id, $paged){
	//config
	$category    = ux_get_post_meta($post_id, 'theme_meta_page_template_blog_category');
	$orderby     = ux_get_post_meta($post_id, 'theme_meta_orderby');
	$order       = ux_get_post_meta($post_id, 'theme_meta_order');
	
	$per_page    = -1;
	
	$arg = array(
		'posts_per_page' => $per_page,
		'orderby'        => $orderby,
		'paged'          => $paged,
		'order'          => $order,
		'category__in'   => $category
	);
	
	$get_posts = get_posts($arg);
	
	if($get_posts){
		global $post;
		
		foreach($get_posts as $post){ setup_postdata($post);
		
			//** Post format
			$get_post_format = (!get_post_format()) ? 'standard' : get_post_format();
            
            //** Template Archive loop item
            ux_get_template_part('archive/loop-item', esc_attr($get_post_format));
		}
		wp_reset_postdata();
	}
}

//Function blog excerpt
function ux_interface_blog_list_excerpt($module_post = false){
	$show_summary = false;
	$summary_word = 200;
	
	$option_show_summary = ux_get_option('theme_option_archive_list_page_summary');
	$option_summary_word = ux_get_option('theme_option_archive_list_page_summary_word');
	
	if($module_post){
		$option_show_summary = get_post_meta($module_post, 'module_blog_show_summary', true);
		$option_summary_word = get_post_meta($module_post, 'module_blog_summary_words', true);
	}
	
	if($option_show_summary){
		$show_summary = true;
	}
	
	if($option_summary_word){
		$summary_word = $option_summary_word;
	}
	
	//$enable_paid = ux_get_option('theme_option_enable_paid_content');
	$enable_paid = false;
	$paid_span = false;
	if($enable_paid && function_exists('pmpro_has_membership_access')){
		$hasaccess = pmpro_has_membership_access(NULL, NULL, true);
		if(is_array($hasaccess)){
			//returned an array to give us the membership level values
			$post_membership_levels_ids = $hasaccess[1];
			$post_membership_levels_names = $hasaccess[2];
			$hasaccess = $hasaccess[0];
		}
		if(!$hasaccess){
			$paid_span = '<span class="member-tip">' .__('PREMIUM', 'ux'). '</span>';
		}
	}
	
	global $post;
	if($enable_paid && function_exists('pmpro_has_membership_access') && has_shortcode(get_the_content(), 'membership')){
		$content = explode('[membership', get_the_content(), 2);
		//$content = force_balance_tags($content[0]);
		$content = prepend_attachment(shortcode_unautop(wpautop(convert_chars(convert_smilies(wptexturize($content[0]))))));
		echo '<div class="entry">' .do_shortcode(balanceTags($content)). balanceTags($paid_span). '</div>';
    }elseif(preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches)){
		$content = explode($matches[0], $post->post_content, 2);
		//$content = force_balance_tags($content[0]);
		$content = prepend_attachment(shortcode_unautop(wpautop(convert_chars(convert_smilies(wptexturize($content[0]))))));
		echo '<div class="entry">' .do_shortcode(balanceTags($content)). balanceTags($paid_span). '</div>';
	}elseif($show_summary && has_excerpt()){ ?>
        <div class="entry container-inn"><?php echo get_the_excerpt(); ?><?php echo balanceTags($paid_span); ?></div>
    <?php
	}elseif($show_summary && !has_excerpt()){ 
		$content = html_entity_decode(ux_limit_words(htmlentities($post->post_content), esc_attr($summary_word)));
		//$content = force_balance_tags(html_entity_decode(ux_limit_words(htmlentities(get_the_content()), $summary_word)));
		$content = prepend_attachment(shortcode_unautop(wpautop(convert_chars(convert_smilies(wptexturize($content)))))); 
		echo '<div class="entry">' .do_shortcode(balanceTags($content)). balanceTags($paid_span). '</div>';
	}else{ ?>
        <div class="entry"><?php the_content(); ?><?php echo balanceTags($paid_span); ?></div>
    <?php
	}
}

//Function Limit words
function ux_limit_words($string, $word_limit){
	$words = explode(' ', $string);
	return implode(' ', array_slice($words, 0, $word_limit));
}

//Function blog show meta
function ux_interface_blog_min_read($post_id = false){
	$time = 2;
	$content = get_the_content();
	
	if($post_id){
		global $post;
		$post = get_post($post_id);
		setup_postdata($post);
		$content = get_the_content();
		wp_reset_postdata(); 
	}
	
	if($content){
		$length = mb_strlen($content);
		$time = $length / 200;
	}
	
	return ceil($time);
}

//Function blog show meta
function ux_interface_blog_show_meta($meta, $container = false, $this_postid = false, $module_post = false){
	$showmeta = array();
	
	if(is_single()){
		$showmeta = ux_get_option('theme_option_posts_showmeta');
	}
	
	if(is_archive()||is_home()){
		$showmeta = array('date',  'category', 'tag', 'author', 'continue-reading');
	}
	
	if($module_post){ 
		$get_this_meta = get_post_meta($module_post, 'module_blog_posts_showmeta', true);
		if(is_array($get_this_meta)){
			$showmeta = $get_this_meta;
		}else{
			$showmeta = array($get_this_meta);
		}
	}
	
	if(count($showmeta)){
		//date
		if($meta == 'date' && in_array($meta, $showmeta)){
			if($container == 'article'){
				echo '<span class="article-meta-unit">' .get_the_time('M j, Y'). '</span>';
			}
		}
		
		//length
		if($meta == 'length' && in_array($meta, $showmeta)){
			$pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
			$read_length = ux_get_post_meta(get_the_ID(), 'theme_meta_post_length');

			if($read_length) {

				if($container == 'article'){
					echo '<span class="article-meta-unit">' .esc_html($read_length). ' ' .esc_html__(' min read','ux'). '</span>';
				}elseif($container == 'navi'){
					echo '<div class="post-navi-meta">' .esc_html($read_length). ' ' .esc_html__(' min read','ux'). '</div>';
				}

			}else{
				if($pb_switch != 'pagebuilder'){
					
					if($container == 'article'){
						echo '<span class="article-meta-unit">' .esc_html(ux_interface_blog_min_read()). ' ' .esc_html__(' min read','ux'). '</span>';
					}elseif($container == 'navi'){
						echo '<div class="post-navi-meta">' .esc_html(ux_interface_blog_min_read($this_postid)). ' ' .esc_html__(' min read','ux'). '</div>';
					}
				}
			}
		}
		
		//category
		if($meta == 'category' && in_array($meta, $showmeta) && has_category()){
			if($container == 'article'){
				echo '<span class="article-meta-unit">' .esc_attr__('In: ','ux'); the_category('  '); echo '</span>';
			}
		}
		
		//tag
		if($meta == 'tag' && in_array($meta, $showmeta) && has_tag()){
			if($container == 'article'){
				echo '<span class="article-meta-unit">' .esc_attr__('Tags: ','ux'); the_tags('  '); echo '</span>';
			}
		}
		
		//author
		if($meta == 'author' && in_array($meta, $showmeta)){
			if($container == 'article'){
				echo '<span class="article-meta-unit">' .esc_attr__('By: ','ux'); the_author(); echo '</span>';
			}
		}
		
		//comments
		if($meta == 'comments' && in_array($meta, $showmeta)){
			$comments_count = wp_count_comments(get_the_ID());
			if($container == 'article'){ ?>
                <span class="article-meta-unit"><?php comments_number(esc_attr__('0 Comment', "ux"), esc_attr__('1 Comment', "ux"), esc_attr__('% Comments', "ux") ); ?></span>
			<?php
            }
		}
		
		//Continue Reading
		if($meta == 'continue-reading' && in_array($meta, $showmeta)){
			if($container == 'article'){
				echo '<div class="blog-unit-more"><a href="' .get_permalink(). '" class="blog-unit-more-a"><span class="blog-unit-more-txt">' .esc_html__('Continue Reading','ux'). '</span> <span class="fa fa-long-arrow-right"></span></a></div>';
			}
		}		
	}
}

//Function video popup
function ux_interface_video_popup(){ ?>
    <div class="video-overlay modal">
        <span class="video-close fa fa-times"></span>
    </div><!--end video-overlay-->
<?php
}

//ux dynamic sidebar
function ux_dynamic_sidebar($index = 1, $count = 1){
	global $wp_registered_sidebars, $wp_registered_widgets;

	if(is_int($index)){
		$index = "sidebar-$index";
	}else{
		$index = sanitize_title($index);
		foreach((array) $wp_registered_sidebars as $key => $value){
			if(sanitize_title($value['name']) == $index){
				$index = $key;
				break;
			}
		}
	}

	$sidebars_widgets = wp_get_sidebars_widgets();
	if(empty($wp_registered_sidebars[ $index ]) || empty($sidebars_widgets[ $index ]) || ! is_array($sidebars_widgets[ $index ])){
		do_action('dynamic_sidebar_before', $index, false);
		do_action('dynamic_sidebar_after',  $index, false);
		return apply_filters('dynamic_sidebar_has_widgets', false, $index);
	}
	

	do_action('dynamic_sidebar_before', $index, true);
	$sidebar = $wp_registered_sidebars[$index];
	
	$widget_count = count((array) $sidebars_widgets[$index]);
	
	$col_class = 'span4';
	if($widget_count == 1){
		$col_class = 'span12';
	}elseif($widget_count == 2){
		$col_class = 'span6';
	}
	
	$did_one = false;
	foreach((array) $sidebars_widgets[$index] as $num => $id){
		
		if($num < $count){

			if(!isset($wp_registered_widgets[$id])) continue;
	
			$params = array_merge(
				array(array_merge($sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']))),
				(array) $wp_registered_widgets[$id]['params']
			);
	
			$classname_ = '';
			foreach((array) $wp_registered_widgets[$id]['classname'] as $cn){
				if(is_string($cn))
					$classname_ .= '_' . $cn;
				elseif(is_object($cn))
					$classname_ .= '_' . get_class($cn);
			}
			$classname_ = ltrim($classname_, '_');
			$params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);
			
			$params = apply_filters('dynamic_sidebar_params', $params);
			
			$params[0]['before_widget'] = str_replace('span4', $col_class, $params[0]['before_widget']);
	
			$callback = $wp_registered_widgets[$id]['callback'];
	
			do_action('dynamic_sidebar', $wp_registered_widgets[ $id ]);
	
			if(is_callable($callback)){
				call_user_func_array($callback, $params);
				$did_one = true;
			}
		}
	}

	do_action('dynamic_sidebar_after', $index, true);

	$did_one = apply_filters('dynamic_sidebar_has_widgets', $did_one, $index);

	return $did_one;
}

//ux title wrap
function ux_interface_title_wrap(){
	if(is_day()){
		printf(__('Daily Archives: %s','ux'), get_the_date());
	}elseif(is_month()){
		printf(__('Monthly Archives: %s','ux'), get_the_date(_x('F Y', 'monthly archives date format', 'ux')));
	}elseif(is_year()){
		printf(__('Yearly Archives: %s','ux'), get_the_date(_x('Y', 'yearly archives date format', 'ux')));
	}elseif(is_home()){
		printf(__('Archives: Home','ux'));
	}elseif(is_404()){
		printf(__('404','ux'));	
	}elseif(is_tag()){
		printf(__('Tag: %s','ux'), single_tag_title('', false));
	}elseif(is_author()){
		printf(__('Author: %s','ux'), get_the_author());
	}elseif(is_category()){
		printf(__('Category: %s','ux'), single_cat_title('', false));
	}elseif(is_archive()){
		printf(__('Archives: ','ux'));
	}elseif(is_search()){
		printf( __( 'Search Results for: %s', 'ux' ), get_search_query() );
	}
}

?>