<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns:svg="http://www.w3.org/2000/svg">
  <head>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    
    <?php //** Do Hook Web Head
	/**
	 * @hooked  ux_interface_webhead_viewport - 10
	 * @hooked  ux_interface_webhead_favicon - 15
	 */
	do_action('ux_interface_webhead'); ?>
    
    <?php wp_head(); ?>
  </head>
  
  <body <?php ux_interface_body_class(); ?>>
      
      <?php //** Do Hook Wrap before
	  /**
	   * @hooked  ux_interface_page_loading - 15
	   * @hooked  ux_interface_jplayer - 20
	   * @hooked  ux_interface_wrap_outer_before - 25
	   */
	  do_action('ux_interface_wrap_before'); ?>
      
      <?php //** Do Hook header
	  /**
	   * @hooked  ux_interface_aside_navi - 10
	   */
	  do_action('ux_interface_header'); ?>
		
	  <?php //** Do Hook Content before
      /**
       * @hooked  ux_interface_content_before - 10
       */
      do_action('ux_interface_content_before'); ?>