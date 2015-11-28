<?php get_header(); ?>
   
    <div id="main-wrap">
    
        <div id="main">
        
            <div id="content" class="container">
            
                <div id="content_wrap" class="fourofour-wrap">
                
                    <h1><?php esc_html_e('PAGE NOT FOUND','ux'); ?></h1><h4><?php esc_html_e('STAY CALM AND DON\'T FREAK OUT!','ux'); ?></h4>
                    
                    <p><?php esc_html_e('Unfortunately, the page you are looking for is unavailable. Trying visit our','ux'); ?> <a href="'.home_url().'"><?php esc_html_e('Homepage','ux'); ?></a><?php esc_html_e(' and starting from there.','ux'); ?></p>
                    
                    
                </div><!--End fourofour-wrap-->
                
            </div><!--End content-->
    
        </div><!--End #main-->
    
    </div><!--End #main-wrap-->
  
<?php get_footer(); ?>