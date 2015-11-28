<?php
/****************************************************************/
/*
/* Template archive
/*
/****************************************************************/

//Template Archive loop
function ux_interface_archive_loop(){
	ux_get_template_part('archive/loop', false);
}

/****************************************************************/
/*
/* Template page
/*
/****************************************************************/

//Template Page content before
function ux_interface_page_content_before(){
	ux_get_template_part('page/content', 'before');
}

//Template Page content after
function ux_interface_page_content_after(){
	ux_get_template_part('page/content', 'after');
}

//Template page content
function ux_interface_page_content(){

	$arvhive = ux_get_post_meta(get_the_ID(), 'theme_meta_show_archive');

	if(!ux_enable_pb() && !ux_enable_page_template()){
		ux_get_template_part('page/content', false);
	}
	
	if(ux_enable_page_template()){
		ux_get_template_part('page/content', 'template');
	}

	if($arvhive && !ux_enable_page_template()) {
		ux_get_template_part('page/content', 'archive');
	}
}

//Template Page Title
function ux_interface_page_content_title(){
	ux_get_template_part('page/content', 'title');
}

//Template Page Gallery Navi
function ux_interface_page_gallery_navi(){
	ux_get_template_part('page/content', 'gallery-navi');
}

/****************************************************************/
/*
/* Template single
/*
/****************************************************************/

//Template single content before
function ux_interface_single_content_before(){
	ux_get_template_part('single/content', 'before');
}

//Template single content after
function ux_interface_single_content_after(){
	ux_get_template_part('single/content', 'after');
}

//Template Single content
function ux_interface_single_content(){
	
	//** post format
	if(is_singular('post') && !ux_enable_pb()){
		$post_format = !get_post_format() ? 'standard' : get_post_format();
		ux_get_template_part('single/format', $post_format);
	}

	//** post type for clients, faqs, jobs, testimonials team
	if(!is_singular('post')){
		ux_get_template_part('single/type', get_post_type());
	}
}

//Template Single content
function ux_interface_single_comment(){
	comments_template();
}

//Template Single author
function ux_interface_single_author(){
	if(is_singular('post')){
		ux_get_template_part('single/content', 'author');
	}
}

//Template Single Related
function ux_interface_single_related(){
	if(is_singular('post')){
		ux_get_template_part('single/content', 'related');
	}
}

//Template Single Title
function ux_interface_single_content_title(){
	ux_get_template_part('single/content', 'title');
}

//Template Single Gallery Navi
function ux_interface_single_gallery_navi(){
	ux_get_template_part('single/content', 'gallery-navi');
}


/****************************************************************/
/*
/* Template global
/*
/****************************************************************/

//Template jplayer
function ux_interface_jplayer(){
	ux_get_template_part('global/site', 'jplayer');
}

//Template Page Loading
function ux_interface_page_loading(){
	ux_get_template_part('global/page', 'loading');
}

//Template Wrap Outer before
function ux_interface_wrap_outer_before(){
	ux_get_template_part('global/wrapouter', 'before');
}

//Template Wrap Outer after
function ux_interface_wrap_outer_after(){
	ux_get_template_part('global/wrapouter', 'after');
}

//Template Content before
function ux_interface_content_before(){
	ux_get_template_part('global/content', 'before');
}

//Template Content after
function ux_interface_content_after(){
	ux_get_template_part('global/content', 'after');
}

//Template Sidebar Weiget
function ux_interface_sidebar_widget(){
	ux_get_template_part('global/sidebar', 'widget');
}

//Template Aside Navi
function ux_interface_aside_navi(){
	ux_get_template_part('global/aside', 'navi');
}

//Template search popup
function ux_interface_search_popup(){
	$enable_search_field = ux_get_option('theme_option_enable_search_field');
	if($enable_search_field){
		ux_get_template_part('global/search', 'popup');
	}
}

//Template social bar
function ux_interface_social_bar($module_post = false){
	$show_share = true;
	$share_buttons = array('facebook', 'twitter', 'google-plus', 'pinterest', 'digg', 'reddit', 'linkedin', 'stumbleupon', 'tumblr', 'mail');
	
	$enable_share_buttons = ux_get_option('theme_option_enable_share_buttons_for_posts');
	$share_buttons = ux_get_option('theme_option_share_buttons');
	if(!$enable_share_buttons){
		$show_share = false;
	}
	
	if($module_post){
		$enable_share_buttons = get_post_meta($module_post, 'module_blog_show_share', true);
		$get_this_buttons = get_post_meta($module_post, 'module_blog_share_buttons', true);
		if(!$enable_share_buttons){
			$show_share = false;
		}elseif(!$get_this_buttons){
			$show_share = false;
		}
		
		if(is_array($get_this_buttons)){
			$share_buttons = $get_this_buttons;
		}else{
			$share_buttons = array($get_this_buttons);
		}
	}
	
	if($show_share){ ?>
	
		<div class="social-bar">
			<ul class="post_social post-meta-social">
				<?php if(is_array($share_buttons)){
	
					$post_link = get_permalink();
					$post_link_pure = preg_replace('#^https?://#', '', rtrim($post_link,'/'));
	
					//facebook
					if(in_array('facebook', $share_buttons)){ ?>
				
						<li class="post-meta-social-li">
							<a class="share postshareicon-facebook-wrap" href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($post_link); ?>" onclick="window.open('http://www.facebook.com/sharer.php?u=<?php echo esc_url($post_link); ?>','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;">
							<span class="fa fa-facebook postshareicon-facebook"></span>
							</a>
						</li>
					
					<?php }
					
					//twitter
					if(in_array('twitter', $share_buttons)){ ?>
					
						<li class="post-meta-social-li">
							<a class="share postshareicon-twitter-wrap" href="http://twitter.com/share?url=<?php echo esc_url($post_link); ?>&amp;text=<?php the_title(); ?>" onclick="window.open('http://twitter.com/share?url=<?php echo esc_url($post_link); ?>&amp;text=<?php the_title(); ?>','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" >
							<span class="fa fa-twitter postshareicon-twitter"></span>
							</a>
						</li>
					
					<?php }
					
					//google-plus
					if(in_array('google-plus', $share_buttons)){ ?>
			
						<li class="post-meta-social-li">
							<a class="share postshareicon-googleplus-wrap" href="https://plus.google.com/share?url=<?php echo esc_url($post_link); ?>" onclick="window.open('https://plus.google.com/share?url=<?php echo esc_url($post_link); ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
							<span class="fa fa-google-plus postshareicon-googleplus"></span>
							</a>
						</li>
					
					<?php }
					
					//pinterest
					if(in_array('pinterest', $share_buttons)){
						$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
						$thumbnail = $image ? $image[0] : false; ?>
						
						<li class="post-meta-social-li">
							<a class="share postshareicon-pinterest-wrap" href="javascript:;" onclick="javascript:window.open('http://pinterest.com/pin/create/bookmarklet/?url=<?php echo esc_url($post_link); ?>&amp;is_video=false&amp;media=<?php echo esc_url($thumbnail); ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
							<span class="fa fa-pinterest  postshareicon-pinterest"></span>
							</a>
						</li>
				
					<?php }
	
					//Digg
					if(in_array('digg', $share_buttons)){ ?>
			
						<li class="post-meta-social-li">
							<a class="share postshareicon-digg-wrap" href="http://www.digg.com/submit?url=<?php echo esc_url($post_link); ?>" onclick="window.open('http://www.digg.com/submit?url=<?php echo esc_url($post_link); ?>','Digg','width=715,height=330,left='+(screen.availWidth/2-357)+',top='+(screen.availHeight/2-165)+''); return false;">
							<span class="fa fa-digg postshareicon-digg"></span>
							</a>
						</li>
					
					<?php }
	
					//Readdit
					if(in_array('reddit', $share_buttons)){ ?>
			
						<li class="post-meta-social-li">
							<a class="share postshareicon-reddit-wrap" href="http://reddit.com/submit?url=<?php echo esc_url($post_link); ?>&amp;title=<?php the_title(); ?>" onclick="window.open('http://reddit.com/submit?url=<?php echo esc_url($post_link); ?>&amp;title=<?php the_title(); ?>','Reddit','width=617,height=514,left='+(screen.availWidth/2-308)+',top='+(screen.availHeight/2-257)+''); return false;">
							<span class="fa fa-reddit postshareicon-reddit"></span>
							</a>
						</li>
					
					<?php }
	
					//linkedin
					if(in_array('linkedin', $share_buttons)){ ?>
			
						<li class="post-meta-social-li">
							<a class="share postshareicon-linkedin-wrap" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($post_link); ?>" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($post_link); ?>','Linkedin','width=863,height=500,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;">
							<span class="fa fa-linkedin postshareicon-linkedin"></span>
							</a>
						</li>
					
					<?php }
	
					//stumbleupon
					if(in_array('stumbleupon', $share_buttons)){ ?>
			
						<li class="post-meta-social-li">
							<a class="share postshareicon-stumbleupon-wrap" href="http://www.stumbleupon.com/submit?url=<?php echo esc_url($post_link); ?>&amp;title=<?php the_title(); ?>" onclick="window.open('http://www.stumbleupon.com/submit?url=<?php echo esc_url($post_link); ?>&amp;title=<?php the_title(); ?>','Stumbleupon','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;">
							<span class="fa fa-stumbleupon postshareicon-stumbleupon"></span>
							</a>
						</li>
					
					<?php }
	
					//tumblr
					if(in_array('tumblr', $share_buttons)){ ?>
			
						<li class="post-meta-social-li">
							<a class="share postshareicon-tumblr-wrap" href="http://www.tumblr.com/share/link?url=<?php echo esc_attr($post_link_pure); ?>&amp;name=<?php the_title(); ?>" onclick="window.open('http://www.tumblr.com/share/link?url=<?php  echo esc_attr($post_link_pure); ?>&amp;name=<?php the_title(); ?>','Tumblr','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;">
							<span class="fa fa-tumblr postshareicon-tumblr"></span>
							</a>
						</li>
					
					<?php }
	
					//mail
					if(in_array('mail', $share_buttons)){ ?>
			
						<li class="post-meta-social-li">
							<a class="share postshareicon-mail-wrap" href="mailto:?Subject=<?php the_title(); ?>&amp;Body=<?php echo esc_url($post_link); ?>" >
							<span class="fa fa-envelope-o postshareicon-mail"></span>
							</a>
						</li>
					
					<?php }
	
				} ?>
			</ul>
		</div>
	
	<?php }else{ ?>
	
		<div class="break-line"></div>
	
	<?php
	}
}

//Template footer
function ux_interface_footer(){
	ux_get_template_part('global/footer', false);
}

//Template footer widget
function ux_interface_footer_widget(){
	ux_get_template_part('global/footer', 'widget');
}

//Template photoswipe
function ux_interface_photoswipe(){
	ux_get_template_part('global/photoswipe', false);
}

?>