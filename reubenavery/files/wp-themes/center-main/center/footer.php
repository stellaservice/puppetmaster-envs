      <?php //** Do Hook Content after
      /**
       * @hooked  ux_interface_content_after - 10
       */
      do_action('ux_interface_content_after'); ?>
  
	  <?php //** Do Hook Footer
	  /**
	   * @hooked  ux_interface_footer - 10
	   * @hooked  ux_pb_module_portfolio_ajaxwrap - 30
	   */
	  do_action('ux_interface_footer'); ?>
	  
	  <?php //** Do Hook Wrap after
	  /**
	   * @hooked  ux_interface_wrap_outer_after - 10
	   * @hooked  ux_interface_search_popup - 15
	   * @hooked  ux_interface_photoswipe - 20
	   */
	  do_action('ux_interface_wrap_after'); ?>

	  <?php wp_footer(); ?>

  </body>
</html>