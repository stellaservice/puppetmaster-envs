<footer id="footer">

	<?php //** If Theme Option footer logo
    $ux_enable_footer_logo = ux_get_option('theme_option_enable_footer_logo');
    if($ux_enable_footer_logo){
        //** Function Logo for footer
        ux_interface_logo('footer');
    }
	
	//** Foot Menu
	$ux_enable_footer_menu = ux_get_option('theme_option_enable_footer_menu');
	if($ux_enable_footer_menu){
		$ux_footer_menu = ux_get_option('theme_option_footer_menu');
		if($ux_footer_menu){
			wp_nav_menu(array(
				'menu' => $ux_footer_menu,
				'container' => 'div',
				'container_class' => 'footer-menu',
				'items_wrap' => '<ul>%3$s</ul>'
			));
		}
	}
	
    //** If Theme Option show social in footer
    $ux_enable_footer_social = ux_get_option('theme_option_show_social_in_footer');
    if($ux_enable_footer_social){
        //** Function Social
        ux_interface_social();
    }
    
    //** If Theme Option enable WPML
    $ux_enablee_footer_WPML = ux_get_option('theme_option_enable_footer_WPML');
    if($ux_enablee_footer_WPML){
        //** Function Language flags
        ux_interface_language_flags();
    }
	
	//** Function Copyright ?>
    <div class="copyright">
        <?php ux_interface_copyright(); ?>
    </div>
        
</footer>

<?php if(is_front_page() || is_home()){ ?>
<div id="site-loading-mask"></div>
<?php } ?>