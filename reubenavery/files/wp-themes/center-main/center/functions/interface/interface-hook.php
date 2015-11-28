<?php
/****************************************************************/
/*
/* Html
/*
/****************************************************************/

//Action Hook WP Title
add_filter('wp_title', 'ux_interface_wp_title', 10, 2);

//Action Web Head
add_action('ux_interface_webhead', 'ux_interface_webhead_viewport', 10);
//add_action('ux_interface_webhead', 'ux_interface_equiv_meta', 10);
add_action('ux_interface_webhead', 'ux_interface_webhead_favicon', 15);


/****************************************************************/
/*
/* Wrap
/*
/****************************************************************/

//Action Hook Wrap Before
add_filter('ux_interface_wrap_before', 'ux_interface_page_loading', 15);
add_filter('ux_interface_wrap_before', 'ux_interface_jplayer', 20);
add_filter('ux_interface_wrap_before', 'ux_interface_wrap_outer_before', 25);

//Action Hook Wrap After
add_filter('ux_interface_wrap_after', 'ux_interface_wrap_outer_after', 10);
add_filter('ux_interface_wrap_after', 'ux_interface_search_popup', 15);
add_filter('ux_interface_wrap_after', 'ux_interface_photoswipe', 20);


/****************************************************************/
/*
/* Content
/*
/****************************************************************/

//Action Hook Content Before
add_filter('ux_interface_content_before', 'ux_interface_content_before', 10);

//Action Hook Content After
add_filter('ux_interface_content_after', 'ux_interface_content_after', 10);


/****************************************************************/
/*
/* Sidebar
/*
/****************************************************************/

//Action Hook Sidebar Widget
add_action('ux_interface_sidebar_widget', 'ux_interface_sidebar_widget', 10);


/****************************************************************/
/*
/* Archive
/*
/****************************************************************/

//Action Hook Archive Loop
add_action('ux_interface_archive_loop', 'ux_interface_archive_loop', 10);

//Action Hook Archive Loop Item
add_action('ux_interface_loop_item_after', 'ux_interface_social_bar', 10);

//Action Hook Archive Pagination
add_action('ux_interface_archive_pagination', 'ux_interface_pagination', 10);


/****************************************************************/
/*
/* Page
/*
/****************************************************************/

//Action Hook Page Content Before
add_action('ux_interface_page_content_before', 'ux_interface_page_content_before', 10);

//Action Hook Page Content After
add_action('ux_interface_page_content_after', 'ux_interface_page_content_after', 10);
add_action('ux_interface_page_content_after', 'ux_interface_page_gallery_navi', 15);

//Action Hook Page Content
add_action('ux_interface_page_content', 'ux_interface_pagebuilder', 10);
add_action('ux_interface_page_content', 'ux_interface_page_content', 20);

//Action Hook Page Article Before
add_action('ux_interface_page_article_before', 'ux_interface_page_content_title', 10);



/****************************************************************/
/*
/* Single
/*
/****************************************************************/

//Action Hook Single Content Before
add_action('ux_interface_single_content_before', 'ux_interface_single_content_before', 10);

//Action Hook Single Content After
add_action('ux_interface_single_content_after', 'ux_interface_single_content_after', 10);
add_action('ux_interface_single_content_after', 'ux_interface_single_gallery_navi', 15);

//Action Hook Single Content
add_action('ux_interface_single_content', 'ux_interface_single_content', 10);
add_action('ux_interface_single_content', 'ux_interface_pagebuilder', 15);
add_action('ux_interface_single_content', 'ux_interface_social_bar', 20);
add_action('ux_interface_single_content', 'ux_interface_single_author', 27);
add_action('ux_interface_single_content', 'ux_interface_single_related', 31);
add_action('ux_interface_single_content', 'ux_interface_single_comment', 35);

//Action Hook Single Article Before
add_action('ux_interface_single_article_before', 'ux_interface_single_content_title', 10);


/****************************************************************/
/*
/* Header
/*
/****************************************************************/

//Action Hook Header
add_filter('ux_interface_header', 'ux_interface_aside_navi', 10);


/****************************************************************/
/*
/* Footer
/*
/****************************************************************/

//Action Hook Footer
add_action('ux_interface_footer', 'ux_interface_footer', 10);
add_action('ux_interface_footer', 'ux_interface_video_popup', 25);

	
?>