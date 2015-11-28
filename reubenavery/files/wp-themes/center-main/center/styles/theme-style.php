<?php
header("Content-type: text/css; charset: UTF-8");
require_once('../../../../wp-load.php');


//Global Colors

//Heighlight Color
$ux_color_theme_main = esc_attr(ux_get_option('theme_option_color_theme_main'));
if($ux_color_theme_main){ ?>
	.blog-unit-tit a:hover,.count-box,.social-like .wpulike .counter a.image:before,.post-meta-social .count,.entry .pmpro_box p a:hover, .list-author-unit .socialmeida-a:hover,.height-light-ux,.post-categories a,
	a:hover,.entry p a,.sidebar_widget a:hover,#footer a:hover,.archive-tit a:hover,.text_block a,.post_meta > li a:hover, #sidebar a:hover, #comments .comment-author a:hover,#comments .reply a:hover,.fourofour-wrap a,.archive-meta-unit a:hover,.post-meta-unit a:hover,#back-top:hover,.heighlight,.archive-meta-item a,.author-name,.archive-unit-h2 a:hover,
	.carousel-wrap a:hover,.blog-item-main h2 a:hover,.related-post-wrap h3:hover a,.ux-grid-tit-a:hover,.iconbox-a .iconbox-h3:hover,.iconbox-a:hover,.iocnbox:hover .icon_wrap i.fa,.blog-masony-item .item-link:hover:before,.clients_wrap .carousel-btn .carousel-btn-a:hover:before,
	.blog_meta a:hover,.breadcrumbs a:hover,.link-wrap a:hover,.archive-wrap h3 a:hover,.more-link:hover,.post-color-default,.latest-posts-tags a:hover,.pagenums .current,.page-numbers.current,.fullwidth-text-white .fullwrap-with-tab-nav-a:hover,.fullwrap-with-tab-nav-a:hover,.fullwrap-with-tab-nav-a.full-nav-actived,.fullwidth-text-white .fullwrap-with-tab-nav-a.full-nav-actived
	{ 
		color:<?php echo esc_attr($ux_color_theme_main); ?>; 
	}
	.post-meta-social-li .share:hover:before,#footer .socialmeida-a:hover:before,
	.tw-style-a:hover,button:hover, input[type="submit"]:hover,.pmpro_btn:hover,#content_wrap .pmpro_content_message a:hover,.archive-list .pmpro_content_message a:hover,.member-tip,.team-item-con-back,
	.tagcloud a:hover,.related-post-wrap h3:before,#back-top:hover .back-top-icon:before,#back-top:hover .back-top-icon:after, #back-top:hover:before, #back-top:hover:after,.single-image-mask,
	input.idi_send:hover,.ux-hover-icon-wrap,.iconbox-content-hide .icon_text,.process-bar,.nav-tabs > li > a:hover,.portfolio-caroufredsel-hover
	{ 
		background-color:<?php echo esc_attr($ux_color_theme_main); ?>;
	}

	
<?php }


// Auxiliary Color
$ux_color_second_auxiliary = esc_attr(ux_get_option('theme_option_color_second_auxiliary'));
if($ux_color_second_auxiliary){ ?>
	textarea, select, input[type="text"],input[type="password"],input[type="email"],input[type="url"],.post-meta-social-li .share:before,.post_social:before, .post_social:after,.break-line,.tagcloud a,.gallery-list-contiune,
	.slider-panel,#main_title_wrap,.nav-tabs > li,.promote-wrap,.process-bar-wrap,.post_meta,.pagenumber a,.countdown_section,.standard-blog-link-wrap,.blog-item.quote,.portfolio-standatd-tit-wrap:before,.quote-wrap,.entry pre,.text_block pre,.isotope-item.quote .blog-masony-item,.blog-masony-item .item-link-wrap,
	.pagenumber span,.testimenials,.testimenials .arrow-bg,.accordion-heading,.testimonial-thum-bg,.single-feild,.fullwidth-text-white .iconbox-content-hide .icon_wrap
	{ 
		background-color: <?php echo esc_attr($ux_color_second_auxiliary); ?>; 
	}
	.progress_bars_with_image_content .bar .bar_noactive.grey 
	{
	  color: <?php echo esc_attr($ux_color_second_auxiliary); ?>; 
	}
	.border-style2,.border-style3,.nav-tabs > li > a,.tab-content,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tabs-v,.single-feild,.archive-unit,.widget_footer,
	.list-author-unit,li.commlist-unit,textarea,select, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input
	{ 
		border-color: <?php echo esc_attr($ux_color_second_auxiliary); ?>; 
	}
	
	.nav.nav-tabs, .tabs-v .nav-tabs > li:last-child.active>a {
		border-bottom-color: <?php echo esc_attr($ux_color_second_auxiliary); ?>; 
	}
	.tab-content.tab-content-v,blockquote {
		border-left-color: <?php echo esc_attr($ux_color_second_auxiliary); ?>; 
	}
	.blog-unit,.search-result-unit,
	.tabs-v .nav-tabs > .active > a {
		border-top-color: <?php echo esc_attr($ux_color_second_auxiliary); ?>; 
	}
	
<?php }



//Logo Text Color
$ux_color_logo = esc_attr(ux_get_option('theme_option_color_logo'));
if($ux_color_logo){ ?>
	
	.logo-h1  { 
		color:<?php echo esc_attr($ux_color_logo); ?> 
	}
	#qLbar,#site-loading-mask {
		background-color: <?php echo esc_attr($ux_color_logo); ?>!important; 
	}
	
<?php }

//Logo-in-Footer Text Color
$ux_color_logo_foot = esc_attr(ux_get_option('theme_option_color_footer_logo'));
if($ux_color_logo_foot){ ?>
	
	#footer .logo-h1  { 
		color:<?php echo esc_attr($ux_color_logo_foot); ?> 
	}
	
<?php }


//Menu Bar

//Menu Item Text Color
$ux_color_menu_item_text = esc_attr(ux_get_option('theme_option_color_menu_item_text'));
if($ux_color_menu_item_text){ ?>

	#navi a,
	#navi .current-menu-item.anchor-in-current-page>a,
	#header-main .socialmeida-a,
	.social-header-triggle, 
	#header-main .socialmeida-a:hover,
	.gallery-navi-a,
	.search-top-btn-class { 
		color: <?php echo esc_attr($ux_color_menu_item_text); ?>; 
	}
	
	.menu-item-has-children>a:before {
		background-color: <?php echo esc_attr($ux_color_menu_item_text); ?>; 
	}

<?php }

//Activated Item Text Color
$ux_color_menu_activated_item_text = esc_attr(ux_get_option('theme_option_color_menu_activated_item_text'));
if($ux_color_menu_activated_item_text){ ?>

	#navi .current-menu-item > a,
	#navi .current-menu-item.anchor-in-current-page.current>a,
	#navi a:hover,
	#navi ul.sub-menu a:hover,
	.gallery-navi-a:hover,
    #main-navi-inn li.gallery-navi-li-active a,
	#navi>div>ul li.current-menu-parent>a,
	#navi>div>ul>li.current-menu-ancestor>a,
	#navi .sub-menu li.current-menu-item>a,
	#header-main .socialmeida-a:hover,
	.search-top-btn-class:hover
	{ 
		color:<?php echo esc_attr($ux_color_menu_activated_item_text); ?>; 
	}
	.menu-item-has-children>a:hover:before,
	#navi .current-menu-item.menu-item-has-children > a:before,
	#navi>div>ul li.current-menu-parent.menu-item-has-children>a:before,
	#navi>div>ul>li.current-menu-ancestor.menu-item-has-children>a:before,
	#navi .sub-menu li.current-menu-item.menu-item-has-children>a:before {
		background-color: <?php echo esc_attr($ux_color_menu_activated_item_text); ?>;
	}
	

<?php }
//Submenu BG Color
$ux_color_submenu_bg = esc_attr(ux_get_option('theme_option_color_submenu_bg'));
if($ux_color_submenu_bg){ ?>

	#navi .sub-menu { background-color:<?php echo esc_attr($ux_color_submenu_bg); ?>; }

<?php }

//Submenu Text Color
$ux_color_submenu_text = esc_attr(ux_get_option('theme_option_color_submenu_text'));
if($ux_color_submenu_text){ ?>

	#navi ul.sub-menu a { color:<?php echo esc_attr($ux_color_submenu_text); ?>; }

<?php }

//Submenu - Activated Item Text Color
$ux_color_submenu_text_active = esc_attr(ux_get_option('theme_option_color_submenu_activated_item'));
if($ux_color_submenu_text_active){ ?>

	#navi ul.sub-menu a:hover,
	#navi>div>ul .sub-menu li.current-menu-parent>a,
	#navi .sub-menu li.current-menu-item>a { color:<?php echo esc_attr($ux_color_submenu_text_active); ?>; }

<?php }


//Posts & Pages

//Heading Color  
$theme_option_color_heading = esc_attr(ux_get_option('theme_option_color_heading'));
if($theme_option_color_heading){ ?>
	
	.blog-unit-tit a,.main-title,.site-loading-logo .logo-h1,#comments .comment-author a,h1,h2,h3,h4,h5,h6,.archive-tit a,.blog-item-main h2 a,.item-title-a,#sidebar .social_active i:hover,.countdown_amount,.ux-grid-tit-a,.filters.filters-nobg li a:hover,.filters.filters-nobg li.active a,.portfolio-standatd-tit-a,.portfolio-standatd-tags a[rel*="tag"],.archive-unit-h2 a,.archive-date,
	.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.accordion-heading .accordion-toggle,.post-navi-a,.moudle .ux-btn,
	.jqbar.vertical span,.team-item-con-back a,.team-item-con-back i,.team-item-con-h p,.slider-panel-item h2.slider-title a,.bignumber-item.post-color-default,.blog-item .date-block,
	input[type="text"],input[type="password"], textarea,.mfp-title,.mfp-arrow-right:before,.mfp-arrow-left:before,.clients_wrap .carousel-btn .carousel-btn-a,.gallery-info-property-item
	{ 
		color:<?php echo esc_attr($theme_option_color_heading); ?>; 
	}
	
	.gallery-wrap-fullwidth .gallery-info-property,.accordion-heading,.title-ux.line_under_over,.gallery-info-property, .gallery-wrap-sidebar .entry, .social-share,
	.moudle .ux-btn:hover { 
		border-color: <?php echo esc_attr($theme_option_color_heading); ?>; 
	}
	
	h1.main-title:before,.team-item-con,.ux-btn:hover,.title-ux.line_both_sides:before,.title-ux.line_both_sides:after,.audio_player_list,.galleria-info,#float-bar-triggler,.float-bar-inn,.short_line:after,
	button, input[type="submit"],.promote-button:hover,#content_wrap .pmpro_content_message a,.archive-list .pmpro_content_message a,.accordion-style-b .accordion-heading a:before,.accordion-style-b .accordion-heading a:after,.separator_inn.bg- 
	{
	  background-color: <?php echo esc_attr($theme_option_color_heading); ?>;
	}
	#qLpercentage {
		color:<?php echo esc_attr($theme_option_color_heading); ?>!important; 
	}

<?php }

// Content text Color 
$ux_color_content = esc_attr(ux_get_option('theme_option_color_content_text'));
if($ux_color_content){ ?>
	.ux-mobile #navi,.magazine-unit.magazine-bgcolor-default,.magazine-unit.magazine-bgcolor-default a,.entry .pmpro_box p a,.gallery-info-property-con,.text_block,
	body,a,.entry p a:hover,.text_block a:hover,#content_wrap,#comments,.blog-item-excerpt,.archive-unit-excerpt,.mfp-image-holder .mfp-close, .mfp-iframe-holder .mfp-close,.archive-meta-item a:hover,.entry code,.text_block code,
	h3#reply-title small, #comments .nav-tabs li.active h3#reply-title .logged,#comments .nav-tabs li a:hover h3 .logged,.testimonial-thum-bg i.fa,
	.header-info-mobile,.carousel-wrap a.disabled:hover { 
	  color: <?php echo esc_attr($ux_color_content); ?>; 
	}
	.filters.filters-nobg li a:before,.blog-item-more-a:hover,.tw-style-a:before,.tw-style-a:after
	{
		background-color: <?php echo esc_attr($ux_color_content); ?>; 
	}
	.blog-item-more-a:hover {
		border-color: <?php echo esc_attr($ux_color_content); ?>; 
	}
	
<?php }

//meta text Color 
$ux_color_auxiliary_content = esc_attr(ux_get_option('theme_option_color_auxiliary_content'));
if($ux_color_auxiliary_content){ ?>
	.post-navi-unit-a,.related-posts-date,.list-author-unit .socialmeida-a,.mfp-counter,.blog-unit-meta, .blog-unit-meta a,.gallery-list-contiune,
	.post_meta>li,.post_meta>li a,.post-meta, .post-meta a,.archive-meta-unit,.archive-meta-unit a,.latest-posts-tags a,.latest-posts-date,#comments .comment-meta .comment-reply-link,#comments .comment-meta .date,
	#mobile-header-meta p,.bbp-meta,.bbp-meta a,.bbp-author-role,.bbp-pagination-count,span.bbp-author-ip,.bbp-forum-content,.infrographic-subtit,.blog_meta,.blog_meta a,.more-link,.blog-item-excerpt .wp-caption-text,
	textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"],.uneditable-input
	{ 
	  color:<?php echo esc_attr($ux_color_auxiliary_content); ?>; 
	}
	.comment-author:after {
		background-color: <?php echo esc_attr($ux_color_auxiliary_content); ?>; 
	}
	
<?php }


//Selected Text Bg Color
$ux_color_selected_text_bg = esc_attr(ux_get_option('theme_option_color_selected_text_bg'));
if($ux_color_selected_text_bg){ ?>

    ::selection { background: <?php echo esc_attr($ux_color_selected_text_bg); ?>; }
	::-moz-selection { background: <?php echo esc_attr($ux_color_selected_text_bg); ?>; }
	::-webkit-selection { background: <?php echo esc_attr($ux_color_selected_text_bg); ?>; }

<?php
}

// Content BG Color
$ux_bg_page_post = esc_attr(ux_get_option('theme_option_bg_page_post'));
if($ux_bg_page_post){ ?>
	
	#header-inn-main,.page-loading,#search-overlay,.navi-top-layout:not(.ux-mobile) #main-navi,
	body,#wrap-outer,#top-wrap,#main,.separator h4, .carousel-control,
	.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tab-content,.filters.filter-floating li a:before,.standard-list-item:hover .portfolio-standatd-tit-wrap:before,.ux-mobile #main-navi-inn,
	.mfp-bg,.mfp-figure:after,.mfp-figure 
	{ 
	  background-color: <?php echo esc_attr($ux_bg_page_post); ?>;
	}
	.testimenials span.arrow,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus { 
		border-bottom-color: <?php echo esc_attr($ux_bg_page_post); ?>; 
	}
	.tabs-v .nav-tabs > .active > a
	{ 
	  border-right-color: <?php echo esc_attr($ux_bg_page_post); ?>; 
	}
	.post-meta-social-li .share:hover,.tw-style-a,.tw-style-a:hover,.quote-wrap, .mouse-icon,
	.carousel-control,.moudle .ux-btn:hover,button, input[type="submit"],#content_wrap .pmpro_content_message a,.archive-list .pmpro_content_message a, .audio_player_list {
	  color: <?php echo esc_attr($ux_bg_page_post); ?>; 
	}
	
	
<?php }

//Sidebar
//Sidebar Widget Title Color
$ux_color_sidebar_widget_title = esc_attr(ux_get_option('theme_option_color_sidebar_widget_title'));
if($ux_color_sidebar_widget_title){ ?>
	
	.sidebar_widget h3.widget-title,
	.sidebar_widget h3.widget-title a { 
	  color: <?php echo esc_attr($ux_color_sidebar_widget_title); ?>;
	}
	
<?php }

//Sidebar Widget content Color
$ux_color_sidebar_con_color = esc_attr(ux_get_option('theme_option_color_sidebar_content_color'));
if($ux_color_sidebar_con_color){ ?>
	
	.sidebar_widget,
	.sidebar_widget a { 
	  color: <?php echo esc_attr($ux_color_sidebar_con_color); ?>; 
	}

<?php }

//Footer Text Color
$ux_color_footer_text = esc_attr(ux_get_option('theme_option_footer_text_color'));
if($ux_color_footer_text){ ?>
	
	#footer,#footer a,
	.copyright, .copyright a,
	#footer .widget-title,#footer .widget-title a { 
	  color: <?php echo esc_attr($ux_color_footer_text); ?>; 
	}
	#footer .socialmeida-a:before {
		background-color: <?php echo esc_attr($ux_color_footer_text); ?>; 
	}
	

<?php }

// Footer Widget Content Color
$ux_footer_widget_content_color = esc_attr(ux_get_option('theme_option_footer_widget_content_color'));
if($ux_footer_widget_content_color){ ?>
	
	.widget_footer_unit { 
	  color: <?php echo esc_attr($ux_footer_widget_content_color); ?>; 
	}

<?php }

// Footer Widget Title Colour
$ux_footer_widget_title_color = esc_attr(ux_get_option('theme_option_footer_widget_title_color'));
if($ux_footer_widget_title_color){ ?>
	
	.widget_footer_unit .widget-title { 
	  color: <?php echo esc_attr($ux_footer_widget_title_color); ?>; 
	}

<?php }


//## Font ########################################################################################

//heading font
$ux_heading_font = ux_get_option('theme_option_font_family_heading');
$ux_heading_font = $ux_heading_font != -1 ? $ux_heading_font : false;
if($ux_heading_font){
	$ux_heading_font = str_replace('+', ' ', $ux_heading_font); ?>
	h1,h2,h3,h4,h5,h6,#content_wrap .infrographic p,#content_wrap .promote-mod p,.ux-btn { 
		font-family: <?php echo esc_attr($ux_heading_font); ?>; 
	}
<?php }
//heading style
$ux_heading_font_style = ux_get_option('theme_option_font_style_heading');
if($ux_heading_font_style){ ?>
    h1,h2,h3,h4,h5,h6,#content_wrap .infrographic p,#content_wrap .promote-mod p { 
    <?php echo esc_attr(ux_theme_google_font_style($ux_heading_font_style)); ?>
}
<?php }

//main font : menu, button, meta, sidebar, footer
$ux_main_font = ux_get_option('theme_option_font_family_main');
$ux_main_font = $ux_main_font != -1 ? $ux_main_font : false;
if($ux_main_font){
	$ux_main_font = str_replace('+', ' ', $ux_main_font); ?>
	body, input, textarea, select, button, div.bbp-template-notice p,legend,.gallery-info-property-con,.text_block { 
		font-family: <?php echo esc_attr($ux_main_font); ?>; 
	}
<?php }

//main style
$ux_main_font_style = ux_get_option('theme_option_font_style_main');
if($ux_main_font_style){ ?>
    body, input, textarea, select, button, div.bbp-template-notice p,legend,.gallery-info-property-con,.text_block { 
	    <?php echo esc_attr(ux_theme_google_font_style($ux_main_font_style)); ?>
	}
<?php }


//logo font
$ux_logo_font = ux_get_option('theme_option_font_family_logo');
$ux_logo_font = $ux_logo_font != -1 ? $ux_logo_font : false;
if($ux_logo_font){
	$ux_logo_font = str_replace('+', ' ', $ux_logo_font); ?>
	.logo-h1 { font-family: <?php echo esc_attr($ux_logo_font); ?>;}
<?php }
//logo size
$ux_logo_font_size = ux_get_option('theme_option_font_size_logo');
if($ux_logo_font_size && $ux_logo_font_size!='Select'){ ?>
    .logo-h1 { font-size: <?php echo esc_attr($ux_logo_font_size); ?>;}
<?php }
//logo style
$ux_logo_font_style = ux_get_option('theme_option_font_style_logo');
if($ux_logo_font_style){ ?>
    .logo-h1 { <?php echo esc_attr(ux_theme_google_font_style($ux_logo_font_style)); ?>}
<?php }


//menu
$ux_menu_font_size = ux_get_option('theme_option_font_size_menu');
if($ux_menu_font_size && $ux_menu_font_size !='Select'){ ?>
    #navi a, #header-main .socialmeida-a, .gallery-navi-a, .search-top-btn-class { font-size: <?php echo esc_attr($ux_menu_font_size); ?>;}
<?php }

//copyright
$ux_copyright_font_size = ux_get_option('theme_option_font_size_copyright');
if($ux_copyright_font_size && $ux_copyright_font_size !='Select'){ ?>
    .copyright { font-size: <?php echo esc_attr($ux_copyright_font_size); ?>;}
<?php }

//Post & page Title size
$ux_post_page_title_font_size = ux_get_option('theme_option_font_size_post_page_title');
if($ux_post_page_title_font_size && $ux_post_page_title_font_size !='Select' ){ ?>
    .hot-top-tit,.blog-unit-tit,.title-h1 { font-size: <?php echo esc_attr($ux_post_page_title_font_size); ?>;}
<?php }

//Post & page Content size
$ux_post_page_content_font_size = ux_get_option('theme_option_font_size_post_page_content');
if($ux_post_page_content_font_size && $ux_post_page_content_font_size !='Select'){ ?>
    #content_wrap .entry,.height-no-auto > .container,.fullwidth-wrap-inn,.full-half-inn,.blog-unit-excerpt,.hot-top-excerpt,.gallery-info-property-con,.text_block { font-size: <?php echo esc_attr($ux_post_page_content_font_size); ?>;}
<?php }

//Post & page meta size
$ux_post_page_meta_font_size = ux_get_option('theme_option_font_size_post_page_meta');
if($ux_post_page_meta_font_size && $ux_post_page_meta_font_size !='Select'){ ?>
    .gallery-info-property,.blog-unit-meta-item,.content-post-meta-unit,.top-unit-meta,.blog-unit-meta,.post-navi-meta,.post-navi-meta-icon,.post-categories { font-size: <?php echo esc_attr($ux_post_page_meta_font_size); ?>;}
<?php }

//Sidebar Widget Title size
$ux_sidebar_widget_title_font_size = ux_get_option('theme_option_font_size_post_page_widget_tit');
if($ux_sidebar_widget_title_font_size && $ux_sidebar_widget_title_font_size != 'Select'){ ?>
    .widget-title { font-size: <?php echo esc_attr($ux_sidebar_widget_title_font_size); ?>; }
<?php }

//Sidebar Widget Content size
$ux_sidebar_widget_content_font_size = ux_get_option('theme_option_font_size_post_page_widget_content');
if($ux_sidebar_widget_content_font_size && $ux_sidebar_widget_content_font_size != 'Select'){ ?>
    .widget-container { font-size: <?php echo esc_attr($ux_sidebar_widget_content_font_size); ?>;}
<?php }


//Global  

//Custom css
$ux_custom_css = ux_get_option('theme_option_custom_css');
if($ux_custom_css){ 
	echo esc_attr($ux_custom_css);
}
?>