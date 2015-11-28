<?php get_header(); ?>
   
    <div id="content">
    
        <div class="row-fluid content_wrap_outer fullwrap-layout">
            <div class="title-wrap">
                <h1 class="title-h1"><?php ux_interface_title_wrap(); ?></h1>
            </div>
            <div class="container sidebar-layout">
                <div id="content_wrap" class=""> 
                
    				<?php //** Do Hook Archive loop
                    /**
                     * @hooked  ux_interface_archive_loop - 10
                     */
                    do_action('ux_interface_archive_loop'); ?>
                
                </div>
            </div>    
        </div>
    
    </div><!--End content-->
  
<?php get_footer(); ?>