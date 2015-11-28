<?php
//theme icons
function ux_theme_icons_fields(){

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path =  get_template_directory().'/functions/theme/css/font-awesome.min.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	//$icons[$match[1]] = $match[2];
	array_push($icons, 'fa ' . $match[1]);
}
$icons = apply_filters('ux_theme_icons_fields', $icons);

return $icons;


}

function ux_wp_get_nav_menus(){
	$output = array();
	$menus = wp_get_nav_menus();
	
	array_push($output, array(
		'title' => __('Select menu', 'ux'),
		'value' => 0
	));
	
	if($menus){
		foreach($menus as $menu){
			array_push($output, array(
				'title' => $menu->name,
				'value' => $menu->term_id
			));
		}
	}
	return $output;
}

//theme color
function ux_theme_color(){
	$theme_color = array(
		array('id' => 'color1', 'value' => 'theme-color-1', 'rgb' => '#DE5F4C'),
		array('id' => 'color2', 'value' => 'theme-color-2', 'rgb' => '#be9ecd'),
		array('id' => 'color3', 'value' => 'theme-color-3', 'rgb' => '#f67bb5'),
		array('id' => 'color4', 'value' => 'theme-color-4', 'rgb' => '#8FC4E0'),
		array('id' => 'color5', 'value' => 'theme-color-5', 'rgb' => '#5a6b7f'),
		array('id' => 'color6', 'value' => 'theme-color-6', 'rgb' => '#b8b69d'),
		array('id' => 'color7', 'value' => 'theme-color-7', 'rgb' => '#2ECC80'),
		array('id' => 'color8', 'value' => 'theme-color-8', 'rgb' => '#e8b900'),
		array('id' => 'color9', 'value' => 'theme-color-9', 'rgb' => '#ce671e'),
		array('id' => 'color10', 'value' => 'theme-color-10', 'rgb' => '#28282E')
	);	
	return $theme_color;
}

//theme config social networks
function ux_theme_social_networks(){
	$theme_config_social_networks = array(
		array(
			'name' => __('Facebook','ux'),
			'icon' => 'fa fa-facebook-square',
			'icon2' => 'fa fa-facebook-square',
			'slug' => 'facebook',
			'dec'  => __('Visit Facebook page','ux')
		),
		array(
			'name' => __('Twitter','ux'),
			'icon' => 'fa fa-twitter-square',
			'icon2' => 'fa fa-twitter-square',
			'slug' => 'twitter',
			'dec'  => __('Visit Twitter page','ux')
		),
		array(
			'name' => __('Google+','ux'),
			'icon' => 'fa fa-google-plus-square',
			'icon2' => 'fa fa-google-plus-square',
			'slug' => 'googleplus',
			'dec'  => __('Visit Google Plus page','ux')
		),
		array(
			'name' => __('Youtube','ux'),
			'icon' => 'fa fa-youtube-square',
			'icon2' => 'fa fa-youtube-square',
			'slug' => 'youtube',
			'dec'  => __('Visit Youtube page','ux')
		),
		array(
			'name' => __('Vimeo','ux'),
			'icon' => 'fa fa-vimeo-square',
			'icon2' => 'fa fa-vimeo-square',
			'slug' => 'vimeo',
			'dec'  => __('Visit Vimeo page','ux')
		),
		array(
			'name' => __('Tumblr','ux'),
			'icon' => 'fa fa-tumblr-square',
			'icon2' => 'fa fa-tumblr-square',
			'slug' => 'tumblr',
			'dec'  => __('Visit Tumblr page','ux')
		),
		array(
			'name' => __('RSS','ux'),
			'icon' => 'fa fa-rss-square',
			'icon2' => 'fa fa-rss-square',
			'slug' => 'rss',
			'dec'  => __('Visit Rss','ux')
		),
		array(
			'name' => __('Pinterest','ux'),
			'icon' => 'fa fa-pinterest-square',
			'icon2' => 'fa fa-pinterest-square',
			'slug' => 'pinterest',
			'dec'  => __('Visit Pinterest page','ux')
		),
		array(
			'name' => __('Linkedin','ux'),
			'icon' => 'fa fa-linkedin-square',
			'icon2' => 'fa fa-linkedin-square',
			'slug' => 'linkedin',
			'dec'  => __('Visit Linkedin page','ux')
		),
		array(
			'name' => __('Instagram','ux'),
			'icon' => 'fa fa-instagram',
			'icon2' => 'fa fa-instagram',
			'slug' => 'instagram',
			'dec'  => __('Visit Instagram page','ux')
		),
		array(
			'name' => __('Github','ux'),
			'icon' => 'fa fa-github-square',
			'icon2' => 'fa fa-github-square',
			'slug' => 'github',
			'dec'  => __('Visit Github page','ux')
		),
		array(
			'name' => __('Xing','ux'),
			'icon' => 'fa fa-xing-square',
			'icon2' => 'fa fa-xing-square',
			'slug' => 'xing',
			'dec'  => __('Visit Xing page','ux')
		),
		array(
			'name' => __('Flickr','ux'),
			'icon' => 'fa fa-flickr',
			'icon2' => 'fa fa-flickr',
			'slug' => 'flickr',
			'dec'  => __('Visit Flickr page','ux')
		),
		array(
			'name' => __('VK','ux'),
			'icon' => 'fa fa-vk square-radiu',
			'icon2' => 'fa fa-vk square-radiu',
			'slug' => 'vk',
			'dec'  => __('Visit VK page','ux')
		),
		array(
			'name' => __('Weibo','ux'),
			'icon' => 'fa fa-weibo square-radiu',
			'icon2' => 'fa fa-weibo square-radiu',
			'slug' => 'weibo',
			'dec'  => __('Visit Weibo page','ux')
		),
		array(
			'name' => __('Renren','ux'),
			'icon' => 'fa fa-renren square-radiu',
			'icon2' => 'fa fa-renren square-radiu',
			'slug' => 'renren',
			'dec'  => __('Visit Renren page','ux')
		),
		array(
			'name' => __('Bitbucket','ux'),
			'icon' => 'fa fa-bitbucket-square',
			'icon2' => 'fa fa-bitbucket-square',
			'slug' => 'bitbucket',
			'dec'  => __('Visit Bitbucket page','ux')
		),
		array(
			'name' => __('Foursquare','ux'),
			'icon' => 'fa fa-foursquare square-radiu',
			'icon2' => 'fa fa-foursquare square-radiu',
			'slug' => 'foursquare',
			'dec'  => __('Visit Foursquare page','ux')
		),
		array(
			'name' => __('Skype','ux'),
			'icon' => 'fa fa-skype square-radiu',
			'icon2' => 'fa fa-skype square-radiu',
			'slug' => 'skype',
			'dec'  => __('Skype','ux')
		),
		array(
			'name' => __('Dribbble','ux'),
			'icon' => 'fa fa-dribbble square-radiu',
			'icon2' => 'fa fa-dribbble square-radiu',
			'slug' => 'dribbble',
			'dec'  => __('Visit Dribbble page','ux')
		)
	);	
	
	return $theme_config_social_networks;
	
}

//theme config fonts size
function ux_theme_options_fonts_size(){
	$theme_config_fonts_size = array('Select','10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '22px', '24px', '26px', '28px', '30px', '32px', '36px', '38px', '40px', '46px', '50px', '56px', '60px', '66px', '72px');
	
	return $theme_config_fonts_size;
}

//theme config fonts style
function ux_theme_options_fonts_style(){
	$theme_config_fonts_style = array(
		array('title' => 'Select', 'value' => ''),
		array('title' => 'Light', 'value' => 'light'),
		array('title' => 'Normal', 'value' => 'regular'),
		array('title' => 'Bold', 'value' => 'bold'),
		array('title' => 'Italic', 'value' => 'italic')
	);
	
	return $theme_config_fonts_style;
}

//theme config color scheme
function ux_theme_options_color_scheme(){
	
	$color_scheme = array(
		'scheme-1' => array(
		array('name' => 'theme_main_color',                     'value' => '#F3B45D'),
		array('name' => 'second_auxiliary_color',               'value' => '#EEEEEE'), 
		array('name' => 'logo_text_color',                      'value' => '#313139'), 
		array('name' => 'logo_text_color_footer',               'value' => '#313139'), 
		array('name' => 'menu_item_text_color',                 'value' => '#6D6D78'), 
		array('name' => 'menu_activated_item_text_color',       'value' => '#F3B45D'), 
		array('name' => 'submenu_text_color',                   'value' => '#6D6D78'),
		array('name' => 'submenu_bg_color',                     'value' => '#FFFFFF'),
		array('name' => 'heading_color',                        'value' => '#28282E'), 
		array('name' => 'content_text_color',                   'value' => '#6D6D78'), 
		array('name' => 'auxiliary_content_color',              'value' => '#999999'),  
		array('name' => 'selected_text_bg_color',               'value' => '#F3B45D'), 
		array('name' => 'page_post_bg_color',                   'value' => '#FFFFFF'), 
		array('name' => 'sidebar_widget_title_color',           'value' => '#28282E'),
		array('name' => 'sidebar_content_color',                'value' => '#999999'),
		array('name' => 'footer_text_color',                    'value' => '#999999'),
		array('name' => 'footer_widget_title_color',            'value' => '#28282E'), 
		array('name' => 'footer_widget_content_color',          'value' => '#999999')
		),
		'scheme-2' => array(
		array('name' => 'theme_main_color',                     'value' => '#EE7164'),
		array('name' => 'second_auxiliary_color',               'value' => '#EEEEEE'), 
		array('name' => 'logo_text_color',                      'value' => '#313139'), 
		array('name' => 'logo_text_color_footer',               'value' => '#313139'), 
		array('name' => 'menu_item_text_color',                 'value' => '#6D6D78'), 
		array('name' => 'menu_activated_item_text_color',       'value' => '#EE7164'), 
		array('name' => 'submenu_text_color',                   'value' => '#6D6D78'),
		array('name' => 'submenu_bg_color',                     'value' => '#FFFFFF'),
		array('name' => 'heading_color',                        'value' => '#28282E'), 
		array('name' => 'content_text_color',                   'value' => '#6D6D78'), 
		array('name' => 'auxiliary_content_color',              'value' => '#999999'),  
		array('name' => 'selected_text_bg_color',               'value' => '#EE7164'), 
		array('name' => 'page_post_bg_color',                   'value' => '#FFFFFF'), 
		array('name' => 'sidebar_widget_title_color',           'value' => '#28282E'),
		array('name' => 'sidebar_content_color',                'value' => '#999999'),
		array('name' => 'footer_text_color',                    'value' => '#999999'),
		array('name' => 'footer_widget_title_color',            'value' => '#28282E'), 
		array('name' => 'footer_widget_content_color',          'value' => '#999999')
		),
		'scheme-3' => array(
		array('name' => 'theme_main_color',                     'value' => '#69996E'),
		array('name' => 'second_auxiliary_color',               'value' => '#EEEEEE'), 
		array('name' => 'logo_text_color',                      'value' => '#313139'), 
		array('name' => 'logo_text_color_footer',               'value' => '#313139'), 
		array('name' => 'menu_item_text_color',                 'value' => '#6D6D78'), 
		array('name' => 'menu_activated_item_text_color',       'value' => '#69996E'), 
		array('name' => 'submenu_text_color',                   'value' => '#6D6D78'),
		array('name' => 'submenu_bg_color',                     'value' => '#FFFFFF'),
		array('name' => 'heading_color',                        'value' => '#28282E'), 
		array('name' => 'content_text_color',                   'value' => '#6D6D78'), 
		array('name' => 'auxiliary_content_color',              'value' => '#999999'),  
		array('name' => 'selected_text_bg_color',               'value' => '#69996E'), 
		array('name' => 'page_post_bg_color',                   'value' => '#FFFFFF'), 
		array('name' => 'sidebar_widget_title_color',           'value' => '#28282E'),
		array('name' => 'sidebar_content_color',                'value' => '#999999'),
		array('name' => 'footer_text_color',                    'value' => '#999999'),
		array('name' => 'footer_widget_title_color',            'value' => '#28282E'), 
		array('name' => 'footer_widget_content_color',          'value' => '#999999')
		),
		'scheme-4' => array(
		array('name' => 'theme_main_color',                     'value' => '#E07B48'),
		array('name' => 'second_auxiliary_color',               'value' => '#EEEEEE'), 
		array('name' => 'logo_text_color',                      'value' => '#313139'), 
		array('name' => 'logo_text_color_footer',               'value' => '#313139'), 
		array('name' => 'menu_item_text_color',                 'value' => '#6D6D78'), 
		array('name' => 'menu_activated_item_text_color',       'value' => '#E07B48'), 
		array('name' => 'submenu_text_color',                   'value' => '#6D6D78'),
		array('name' => 'submenu_bg_color',                     'value' => '#FFFFFF'),
		array('name' => 'heading_color',                        'value' => '#28282E'), 
		array('name' => 'content_text_color',                   'value' => '#6D6D78'), 
		array('name' => 'auxiliary_content_color',              'value' => '#999999'),  
		array('name' => 'selected_text_bg_color',               'value' => '#E07B48'), 
		array('name' => 'page_post_bg_color',                   'value' => '#FFFFFF'), 
		array('name' => 'sidebar_widget_title_color',           'value' => '#28282E'),
		array('name' => 'sidebar_content_color',                'value' => '#999999'),
		array('name' => 'footer_text_color',                    'value' => '#999999'),
		array('name' => 'footer_widget_title_color',            'value' => '#28282E'), 
		array('name' => 'footer_widget_content_color',          'value' => '#999999')
		),
		'scheme-5' => array(
		array('name' => 'theme_main_color',                     'value' => '#2ECC80'),
		array('name' => 'second_auxiliary_color',               'value' => '#EEEEEE'), 
		array('name' => 'logo_text_color',                      'value' => '#313139'), 
		array('name' => 'logo_text_color_footer',               'value' => '#313139'), 
		array('name' => 'menu_item_text_color',                 'value' => '#6D6D78'), 
		array('name' => 'menu_activated_item_text_color',       'value' => '#2ECC80'), 
		array('name' => 'submenu_text_color',                   'value' => '#6D6D78'),
		array('name' => 'submenu_bg_color',                     'value' => '#FFFFFF'),
		array('name' => 'heading_color',                        'value' => '#28282E'), 
		array('name' => 'content_text_color',                   'value' => '#6D6D78'), 
		array('name' => 'auxiliary_content_color',              'value' => '#999999'),  
		array('name' => 'selected_text_bg_color',               'value' => '#2ECC80'), 
		array('name' => 'page_post_bg_color',                   'value' => '#FFFFFF'), 
		array('name' => 'sidebar_widget_title_color',           'value' => '#28282E'),
		array('name' => 'sidebar_content_color',                'value' => '#999999'),
		array('name' => 'footer_text_color',                    'value' => '#999999'),
		array('name' => 'footer_widget_title_color',            'value' => '#28282E'), 
		array('name' => 'footer_widget_content_color',          'value' => '#999999')
		),
		'scheme-6' => array(
		array('name' => 'theme_main_color',                     'value' => '#FA6746'),
		array('name' => 'second_auxiliary_color',               'value' => '#EEEEEE'), 
		array('name' => 'logo_text_color',                      'value' => '#313139'), 
		array('name' => 'logo_text_color_footer',               'value' => '#313139'), 
		array('name' => 'menu_item_text_color',                 'value' => '#6D6D78'), 
		array('name' => 'menu_activated_item_text_color',       'value' => '#FA6746'), 
		array('name' => 'submenu_text_color',                   'value' => '#6D6D78'),
		array('name' => 'submenu_bg_color',                     'value' => '#FFFFFF'),
		array('name' => 'heading_color',                        'value' => '#28282E'), 
		array('name' => 'content_text_color',                   'value' => '#6D6D78'), 
		array('name' => 'auxiliary_content_color',              'value' => '#999999'),  
		array('name' => 'selected_text_bg_color',               'value' => '#FA6746'), 
		array('name' => 'page_post_bg_color',                   'value' => '#FFFFFF'), 
		array('name' => 'sidebar_widget_title_color',           'value' => '#28282E'),
		array('name' => 'sidebar_content_color',                'value' => '#999999'),
		array('name' => 'footer_text_color',                    'value' => '#999999'),
		array('name' => 'footer_widget_title_color',            'value' => '#28282E'), 
		array('name' => 'footer_widget_content_color',          'value' => '#999999')
		),
		'scheme-7' => array(
		array('name' => 'theme_main_color',                     'value' => '#8FC4E0'),
		array('name' => 'second_auxiliary_color',               'value' => '#EEEEEE'), 
		array('name' => 'logo_text_color',                      'value' => '#313139'), 
		array('name' => 'logo_text_color_footer',               'value' => '#313139'), 
		array('name' => 'menu_item_text_color',                 'value' => '#6D6D78'), 
		array('name' => 'menu_activated_item_text_color',       'value' => '#8FC4E0'), 
		array('name' => 'submenu_text_color',                   'value' => '#6D6D78'),
		array('name' => 'submenu_bg_color',                     'value' => '#FFFFFF'),
		array('name' => 'heading_color',                        'value' => '#28282E'), 
		array('name' => 'content_text_color',                   'value' => '#6D6D78'), 
		array('name' => 'auxiliary_content_color',              'value' => '#999999'),  
		array('name' => 'selected_text_bg_color',               'value' => '#8FC4E0'), 
		array('name' => 'page_post_bg_color',                   'value' => '#FFFFFF'), 
		array('name' => 'sidebar_widget_title_color',           'value' => '#28282E'),
		array('name' => 'sidebar_content_color',                'value' => '#999999'),
		array('name' => 'footer_text_color',                    'value' => '#999999'),
		array('name' => 'footer_widget_title_color',            'value' => '#28282E'), 
		array('name' => 'footer_widget_content_color',          'value' => '#999999')
		),
		'scheme-8' => array(
		array('name' => 'theme_main_color',                     'value' => '#EDC46B'),
		array('name' => 'second_auxiliary_color',               'value' => '#EEEEEE'), 
		array('name' => 'logo_text_color',                      'value' => '#313139'), 
		array('name' => 'logo_text_color_footer',               'value' => '#313139'), 
		array('name' => 'menu_item_text_color',                 'value' => '#6D6D78'), 
		array('name' => 'menu_activated_item_text_color',       'value' => '#EDC46B'), 
		array('name' => 'submenu_text_color',                   'value' => '#6D6D78'),
		array('name' => 'submenu_bg_color',                     'value' => '#FFFFFF'),
		array('name' => 'heading_color',                        'value' => '#28282E'), 
		array('name' => 'content_text_color',                   'value' => '#6D6D78'), 
		array('name' => 'auxiliary_content_color',              'value' => '#999999'),  
		array('name' => 'selected_text_bg_color',               'value' => '#EDC46B'), 
		array('name' => 'page_post_bg_color',                   'value' => '#FFFFFF'), 
		array('name' => 'sidebar_widget_title_color',           'value' => '#28282E'),
		array('name' => 'sidebar_content_color',                'value' => '#999999'),
		array('name' => 'footer_text_color',                    'value' => '#999999'),
		array('name' => 'footer_widget_title_color',            'value' => '#28282E'), 
		array('name' => 'footer_widget_content_color',          'value' => '#999999')
		)
	);
	return $color_scheme;
	
}

//theme config select fields
function ux_theme_options_config_select_fields(){
	$theme_config_select_fields = array(
		'theme_option_posts_showmeta' => array(
		array('title' => __('Date','ux'),                       'value' => 'date'),
		array('title' => __('Length','ux'),                     'value' => 'length'),
		array('title' => __('Category','ux'),                   'value' => 'category'),
		array('title' => __('Tag','ux'),                        'value' => 'tag'),
		array('title' => __('Author','ux'),                     'value' => 'author'),
		array('title' => __('Comments','ux'),                   'value' => 'comments')
		),
		
		'theme_meta_demo_site' => array(  
		array('title' => __('Default Demo','ux'),               'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo-data.xml'),
		array('title' => __('Onepage Demo','ux'),               'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo-data-onepage.xml')
		),
		
		'theme_option_share_buttons' => array(
		array('title' => __('Facebook','ux'),                   'value' => 'facebook'),
		array('title' => __('Twitter','ux'),                    'value' => 'twitter'),
		array('title' => __('Google Plus','ux'),                'value' => 'google-plus'),
		array('title' => __('Pinterest','ux'),                  'value' => 'pinterest'),
		array('title' => __('Digg','ux'),                       'value' => 'digg'),
		array('title' => __('Reddit','ux'),                    	'value' => 'reddit'),
		array('title' => __('Linkedin','ux'),                   'value' => 'linkedin'),
		array('title' => __('Stumbleupon','ux'),                'value' => 'stumbleupon'),
		array('title' => __('Tumblr','ux'),                    	'value' => 'tumblr'),
		array('title' => __('Mail','ux'),                    	'value' => 'mail')
		),
		
		'theme_option_header_layout' => array(
		array('title' => __('Transparent Menu','ux'),           'value' => 'transparent-menu'),
		array('title' => __('Hidden menu','ux'),                'value' => 'hidden-menu')
		),
		
		'theme_option_navigation_bar' => array(
		array('title' => __('Navigation On Left','ux'),         'value' => 'navigation_on_left'),
		array('title' => __('Navigation On Top','ux'),          'value' => 'navigation_on_top')
		
		),
		
		'theme_option_footer_widget_for_post'                   => ux_theme_register_sidebar('footer_widget'),
		
		'theme_option_footer_menu'                              => ux_wp_get_nav_menus()
		
	);
	
	$theme_config_select_fields = apply_filters('theme_config_select_fields', $theme_config_select_fields);
	return $theme_config_select_fields;
}

//theme config fields
function ux_theme_options_config_fields(){
	$theme_config_fields = array(
		array(
			'id'      => 'options-theme',
			'name'    => __('Theme Options','ux'),
			'section' => array(
				
				array(/* Import Demo Data */
					'id'    => 'import-export',
					'title' => __('Import Demo Data','ux'),
					'item'  => array(
						array('description' => __('if you are new to WordPress or have problems creating posts or pages that look like the theme demo, you could import dummy posts and pages here that will definitely help to understand how those tasks are done','ux'),
							  'button'      => array('title'   => __('Import Demo Data','ux'),
													 'loading' => __('Loading data, don&acute;t close the page please.','ux'),
													 'type'    => 'import-demo-data',
													 'class'   => 'btn-info',
													 'url'     => admin_url('admin.php?import=wordpress&step=2', 'http')),
							  'notice'      => __('The demo content will be import including post/pages and sliders, the images in sliders could only be use as placeholder and could not be use in your finally website due to copyright reasons.','ux'),
							  'type'        => 'button',
							  'name'        => 'theme_option_import_demo'),
								  
						array('type'        => 'select',
							  'description' => '',
							  'name'        => 'theme_meta_demo_site',
							  'col_size'    => 'width: 300px;'),
						
						array('description' => __('export your current data to a file and save it on your computer','ux'),
							  'button'      => array('title' => __('Export Current Data','ux'),
													 'type'  => 'export-current-data',
													 'class' => 'btn-default',
													 'url'   => admin_url('export.php?download=true')),
							  'type'        => 'button',
							  'name'        => 'theme_option_export_current_data'),
								  
						array('description' => __('import a data file you have saved','ux'),
							  'button'      => array('title' => __('Import My Saved Data','ux'),
													 'type'  => 'import-mysaved-data',
													 'class' => 'btn-default',
													 'url'   => admin_url('admin.php?import=wordpress')),
							  'type'        => 'button',
							  'name'        => 'theme_option_import_mysaved_data'))),
							  
				array(/* FrontPage */
					'id'   => 'frontpage',
					'item' => array(
						array('title'       => __('FrontPage','ux'),
							  'description' => __('select which page to display on your FrontPage, if left blank the Blog will be displayed','ux'),
							  'type'        => 'select-front',
							  'name'        => 'theme_option_frontpage'))),
							  
				array(/* Generate New Thumbs for This Theme */
					'id'   => 'generate-thumbs',
					'item' => array(
						array('title'       => __('Generate New Thumbs for This Theme','ux'),
							  'description' => __('if you have many posts and had assigned some Featured Image for them before using this theme, this button could help you adapt these feature images to appropriate size for this theme','ux'),
							  'button'      => array('title'   => __('Generate New Thumbnails','ux'),
													 'loading' => __('Processing, don&acute;t close the page please.','ux'),
													 'type'    => 'generate-thumbs',
													 'class'   => 'btn-default'),
							  'type'        => 'button',
							  'name'        => 'theme_option_generate_thumbs')))
			)
		),
		array(
			'id'      => 'options-general',
			'name'    => __('General Settings','ux'),
			'section' => array(    

				array(/* Logo */
					'id'    => 'logo',
					'title' => __('Logo','ux'),
					'item'  => array(        
						
						// Enable Plain Text Logo
						array('title'       => __('Enable Plain Text Logo','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_text_logo',
							  'default'     => 'false'),

						// Logo Text
						array('title'       => __('Logo Text','ux'),
							  'type'        => 'text',
							  'name'        => 'theme_option_text_logo',
							  'description' => '',
							  'default'     => '',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'true')),

						// Costom Logo
						array('title'       => __('Custom Logo','ux'),
							  'description' => __('the container for custom logo is 160px(width) * 80px(hight), you could upload a double size logo image to meet the needs of retina screens','ux'),
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_logo',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'false')),

						// Custom Logo For Loading Page
						array('title'       => __('Custom Logo For Loading Page','ux'),
							  'description' => '',
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_logo_for_loading',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'false')),

						// Costom Footer Logo
						array('title'       => __('Custom Footer Logo','ux'),
							  'description' => '',
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_footer_logo',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'false')))),
				
				array(/* Descriptions */
					'id'    => 'descriptions',
					'title' => __('Descriptions','ux'),
					'item'  => array(

						// Leave a Comment
                        array('title'       => __('Comment Title','ux'),
                               'description' => __('Comments in posts','ux'),
                               'type'        => 'text',
                               'default'     => __('Leave a Comment','ux'),
                               'name'        => 'theme_option_descriptions_comment_title'),

						// Your message
                        array('title'       => __('Comment Box Placeholder','ux'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => __('Your Message','ux'),
                               'name'        => 'theme_option_descriptions_your_message'),

                        // Send
                        array('title'       => __('Comment Submit Button Name','ux'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => __('Send','ux'),
                               'name'        => 'theme_option_descriptions_comment_submit')

						)),
				
				array(/* Copyright */
					'id'    => 'copyright',
					'title' => __('Copyright','ux'),
					'item'  => array(
						
						// Copyright Information
						array('title'       => __('Copyright Information','ux'),
							  'description' => __('enter the copyright information, it would be placed on the bottom of the pages','ux'),
							  'type'        => 'text',
							  'name'        => 'theme_option_copyright',
							  'default'     => 'Copyright © 2015 Your Company Name.'))),
							  
				array(/* Track Code */
					'id'    => 'track-code',
					'title' => __('Track Code','ux'),
					'item'  => array(
						
						// Track Code
						array('title'       => __('Track Code','ux'),
							  'description' => '',
							  'type'        => 'textarea',
							  'name'        => 'theme_option_track_code'))),
							  
				array(/* Icon */
					'id'    => 'icon',
					'title' => __('Icon','ux'),
					'item'  => array(
						
						// Custom Favicon
						array('title'       => __('Custom Favicon','ux'),
							  'description' => __('upload the favicon for your website, it would be shown on the tab of the browser','ux'),
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_favicon',
							  'default'     => UX_LOCAL_URL . '/img/favicon.ico'),
							  
						// Custom Mobile Icon
						array('title'       => __('Custom Mobile Icon','ux'),
							  'description' => __('upload the icon for the shortcuts on mobile devices','ux'),
							  'type'        => 'upload',
							  'name'        => 'theme_option_mobile_icon',
							  'default'     => UX_LOCAL_URL . '/img/apple-touch-icon-114x114.png'))),
				/* Effects */			  
				array(
					'title' => __('Effects','ux'),
					'id'    => 'options-page-setting',
					'item'  => array(
						
						// Enable Fade-in Loading Efect
						array('title'       => __('Enable Fade-in Loading Effect','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_fadein_effect',
							  'default'     => 'true')

						)),
							
				array(/* Custom CSS */
					'title' => __('Custom CSS','ux'),
					'id'    => 'custom-css',
					'title' => __('Custom CSS','ux'),
					'item'  => array(
						
						// Please enter your Custom CSS (Optional)
						array('title'       => __('Please enter your Custom CSS (Optional)','ux'),
							  'description' => '',
							  'type'        => 'textarea',
							  'name'        => 'theme_option_custom_css')))
			)
		),
		array(
			'id'      => 'options-social-networks',
			'name'    => __('Social Networks','ux'),
			'section' => array(
				
				array(/* Your Social Media Links */
					'id'    => 'social-media-links',
					'title' => __('Your Social Media Links','ux'),
					'item'  => array(

						// Enable Social Media Links
						array('title'       => __('Enable Social Media Links','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_social',
							  'default'     => 'false',
							  'bind'        => array(
								  array('title'    => __('Social Medias','ux'),
										'type'     => 'new-social-medias',
										'name'     => 'theme_option_show_social_medias',
										'position' => 'after',
										'control'  => array('name'  => 'theme_option_show_social',
															'value' => 'true')))),
							  
						// Show Social Icons in header
						array('title'       => __('Show Social Icons in header','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'default'     => 'false',
							  'name'        => 'theme_option_show_social_in_header',
							  'control'     => array('name'  => 'theme_option_show_social',
													 'value' => 'true')),
							  
						// Show Social Links in footer
						array('title'       => __('Show Social Icons in footer','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'default'     => 'false',
							  'name'        => 'theme_option_show_social_in_footer',
							  'control'     => array('name'  => 'theme_option_show_social',
													 'value' => 'true')))),				 
				
				array(/* Share Buttons For Post */
					'id'    => 'social-media-buttons',
					'title' => __('Share Buttons For Post','ux'),
					'item'  => array(
											 
					    // Enable Share Buttons for Posts
						array('title'       => __('Enable Share Buttons for Posts','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_share_buttons_for_posts',
							  'default'     => 'true',
							  'bind'        => array(
								  array('type'     => 'checkbox-group',
										'name'     => 'theme_option_share_buttons',
										'position' => 'after',
										'default'  => array('facebook', 'twitter', 'google-plus', 'pinterest'),
										'control'  => array('name'  => 'theme_option_enable_share_buttons_for_posts',
															'value' => 'true'))))
					)
				)
			)
		),
		array(
			'id'      => 'options-schemes',
			'name'    => __('Schemes','ux'),
			'section' => array(
				
				array(/* Color Setting */
					'id'    => 'color-scheme',
					'title' => __('Color Setting','ux'),
					'item'  => array(
						
						// Select Color Scheme
						array('title'       => __('Select a predefined color scheme ','ux'),
							  'description' => '',
							  'type'        => 'color-scheme',
							  'name'        => 'theme_option_color_scheme'))),
							  
				array(/* Global */
					'id'    => 'color-main',
					'title' => __('Global','ux'),
					'item'  => array(
						
						// Highlight Color
						array('title'       => __('Highlight Color','ux'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_theme_main',
							  'scheme-name' => 'theme_main_color',
							  'default'     => '#F3B45D'),
							  
						//** Auxiliary Color
						array('title'       => __('Auxiliary Color','ux'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_second_auxiliary',
							  'scheme-name' => 'second_auxiliary_color',
							  'default'     => '#EEEEEE'))),
                                
				array(/* Logo */
					'id'    => 'color-logo',
					'title' => __('Logo','ux'),
					'item'  => array(
						
						// Logo Text Color
						array('title'       => __('Logo Text Color','ux'),
							  'description' => __('color for plain text logo','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_logo',
							  'scheme-name' => 'logo_text_color',
							  'default'     => '#313139'),
	  
						// Logo Text Color for Footer
						array('title'       => __('Logo Text Color for Footer','ux'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_footer_logo',
							  'scheme-name' => 'logo_text_color_footer',
							  'default'     => '#313139'),
	  
					)
				),
							  
				array(/* Menu */
					'id'    => 'color-menu',
					'title' => __('Menu','ux'),
					'item'  => array(
										  
						// Menu Item Text Color
						array('title'       => __('Menu Item Text Colour','ux'),
							  'description' => __('color for menu item text','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_menu_item_text',
							  'scheme-name' => 'menu_item_text_color',
							  'default'     => '#6D6D78'),
								  
						// Activated Item Text Color
						array('title'       => __('Activated Item Text Colour','ux'),
							  'description' => __('color for text of menu item linked the curren','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_menu_activated_item_text',
							  'scheme-name' => 'menu_activated_item_text_color',
							  'default'     => '#F3B45D'),
								  
						// Submenu Text Color
						array('title'       => __('Submenu Text Colour','ux'),
							  'description' => __('color for submenu item text','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_submenu_text',
							  'scheme-name' => 'submenu_text_color',
							  'default'     => '#6D6D78'),
								  
						// Submenu bg Color
						array('title'       => __('Submenu Bg Colour','ux'),
							  'description' => __('color for submenu item text','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_submenu_bg',
							  'scheme-name' => 'submenu_bg_color',
							  'default'     => '#FFFFFF')
								  
						)),
							  
				array(/* Posts & Pages */
					'id'    => 'color-post-page',
					'title' => __('Posts & Pages','ux'),
					'item'  => array(

						// Heading Text Color
						array('title'       => __('Heading Text Color','ux'),
							  'description' => __('the color for post/archive title text','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_heading',
							  'scheme-name' => 'heading_color',
							  'default'     => '#28282E'),
							  
						// Content Text Color
						array('title'       => __('Content Text Color','ux'),
							  'description' => __('the color for content text ','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_content_text',
							  'scheme-name' => 'content_text_color',
							  'default'     => '#6D6D78'),
							  
						// Auxiliary Text Color
						array('title'       => __('Auxiliary Text Color','ux'),
							  'description' => __('the color for auxiliary content text, such as meta of a post','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_auxiliary_content',
							  'scheme-name' => 'auxiliary_content_color',
							  'default'     => '#999999'),
							  
						// Selected Text Bg Color
						array('title'       => __('Selected Text Bg Color','ux'),
							  'description' => __('the color for selected text background','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_selected_text_bg',
							  'scheme-name' => 'selected_text_bg_color',
							  'default'     => '#F3B45D'),
							  
						// Page Post Bg Color
						array('title'       => __('Page/Post Bg Color','ux'),
							  'description' => __('background color for the page area','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_bg_page_post',
							  'scheme-name' => 'page_post_bg_color',
							  'default'     => '#ffffff'))),
				
				array(/* Sidebar */
					'id'    => 'color-sidebar',
					'title' => __('Sidebar','ux'),
					'item'  => array(
                                                
						// Sidebar Widget Title Color
						array('title'       => __('Page/Post Sidebar Widget Title Color','ux'),
							  'description' => __('color for sidebar widget title text','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_sidebar_widget_title',
							  'scheme-name' => 'sidebar_widget_title_color',
							  'default'     => '#28282E'),
							  
						// Sidebar Widget Content Color
						array('title'       => __('Page/Post Sidebar Widget Content Color','ux'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_sidebar_content_color',
							  'scheme-name' => 'sidebar_content_color',
							  'default'     => '#999999'))),
							  
				array(/* Header & Footer */
					'id'    => 'color-header-and-footer',
					'title' => __('Footer','ux'),
					'item'  => array( 
							  
						// Footer Text Color
						array('title'       => __('Footer Text Color','ux'),
                              'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_footer_text_color',
							  'scheme-name' => 'footer_text_color',
							  'default'     => '#999999'),
							 
							  
						// Footer Widget Title Colour
						array('title'       => __('Footer Widget Title Colour','ux'),
                              'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_footer_widget_title_color',
							  'scheme-name' => 'footer_widget_title_color',
							  'default'     => '#28282E'),
							  
						// Footer Widget Content Color
						array('title'       => __('Footer Widget Content Color','ux'),
                              'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_footer_widget_content_color',
							  'scheme-name' => 'footer_widget_content_color',
							  'default'     => '#999999')))
			)
		),
		
		array(
			'id'      => 'options-font',
			'name'    => __('Font Settings','ux'),
			'section' => array(
				
				array(/* Synchronous */
					'id'    => 'font-synchronous',
					'title' => __('Synchronous','ux'),
					'item'  => array(
						
						// Update to new Google Font Data
						array('description' => '',
							  'button'      => array('title'   => __('Update to new Google Font Data','ux'),
													 'loading' => __('Updating ...','ux'),
													 'type'    => 'font-synchronous',
													 'class'   => 'btn-primary'),
							  'type'        => 'button',
							  'name'        => 'theme_option_font_synchronous'))),
							  
				array(/* Cole Fonts */
					'id' => 'font-main',
					'item' => array(
							  
						// Heading Font
						array('title'       => __('Heading Font','ux'),
							  'description' => __('font for titles','ux'),
							  'type'        => 'fonts-family',
							  'default'     => 'Alike',
							  'name'        => 'theme_option_font_family_heading',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_heading',
										'default'  => 'regular',
										'position' => 'after'))),
						// Main Font
						array('title'       => __('Main Font','ux'),
							  'description' => __('menu, button, meta, sidebar, footer','ux'),
							  'type'        => 'fonts-family',
							  'default'     => 'Alike',
							  'name'        => 'theme_option_font_family_main',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_main',
										'default'  => 'regular',
										'position' => 'after')))
						//Content Font
						// array('title'       => __('Content Font','ux'),
						// 	  'description' => '',
						// 	  'type'        => 'fonts-family',
						// 	  'default'     => 'Playfair+Display',
						// 	  'name'        => 'theme_option_font_family_content',
						// 	  'bind'        => array(
						// 		  array('type'     => 'fonts-style',
						// 				'name'     => 'theme_option_font_style_content',
						// 				'default'  => 'regular',
						// 				'position' => 'after')))
					)
				),

				array(/* Logo Font */
					'id'   => 'font-logo',
					'item' => array(
						
						// Logo Font
						array('title'       => __('Logo Font','ux'),
							  'description' => __('font for plaint text logo','ux'),
							  'type'        => 'fonts-family',
							  'default'     => 'Permanent+Marker',
							  'name'        => 'theme_option_font_family_logo',
							  'bind'        => array(
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_logo',
										'default'  => '46px',
										'position' => 'after'),
										
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_logo',
										'default'  => 'normal',
										'position' => 'after')
								)
						)
					)
				),
										
				
										
                array(/* Menu Font */
					'id'   => 'menu-font',
					'item' => array(
						
						//Menu
						array('title'       => __('Menu','ux'),
							  'description' => '',
							  'type'        => 'fonts-size',
							  'name'        => 'theme_option_font_size_menu',
							  'default'     => '14px'))),


                array(/* Copyright Font */
					'id'   => 'copyright',
					'item' => array(
						
						//Copyright
						array('title'       => __('Copyright','ux'),
							  'description' => '',
							  'type'        => 'fonts-size',
							  'name'        => 'theme_option_font_size_copyright',
							  'default'     => ''))),
							  
				array(/* Page Post Font */
					'id'   => 'font-post-page',
					'item' => array(
						
						// Post Page Title Font
						array('title'       => __('Post/Page Title Font','ux'),
							  'description' => __('font for post/page title text','ux'),
							  'type'        => 'fonts-size',
							  'name'        => 'theme_option_font_size_post_page_title',
							  'default'     => '24px'),
							  
						// Post Page Content Font	  
						array('title'       => __('Post/Page Content Font','ux'),
							  'description' => __('font for post/page content text','ux'),
							  'type'        => 'fonts-size',
							  'name'        => 'theme_option_font_size_post_page_content',
							  'default'     => '14px'),

						// Post Page Meta Font
						array('title'       => __('Post/Page Meta Font','ux'),
							  'description' => __('font for post/page meta text','ux'),
							  'type'        => 'fonts-size',
							  'name'        => 'theme_option_font_size_post_page_meta',
							  'default'     => '14px'),
							  
						// Post Page Sidebar Widget Title Font
						array('title'       => __('Post/Page Widget Title Font','ux'),
							  'description' => '',
							  'type'        => 'fonts-size',
							  'name'        => 'theme_option_font_size_post_page_widget_tit',
							  'default'     => '18px'),
							  
						// Post Page Sidebar Widget Content Font
						array('title'       => __('Post/Page Widget Content Font','ux'),
							  'description' => '',
							  'type'        => 'fonts-size',
							  'name'        => 'theme_option_font_size_post_page_widget_content',
							  'default'     => '14px')
					))
			)
		),
		
		array(
			'id'      => 'options-icons',
			'name'    => __('Icons','ux'),
			'section' => array(
				
				array(/* Upload Icons */
					'id'    => 'icons-upload',
					'title' => __('Upload Icons','ux'),
					'item'  => array(
						
						// Upload Icons
						array('description' => __('select images for your icons from Media Library, it is recommended to upload 48*48 images','ux'),
							  'type'        => 'select-images',
							  'name'        => 'theme_option_icons_custom')))
			)
		),	
			
		array(
			'id'      => 'options-layout',
			'name'    => __('Layout','ux'),
			'section' => array(
                         
				array( 
					'title' => __('Global','ux'),
					'item'  => array(

                        // Navigation Bar
						array('title'       => __('Navigation Bar','ux'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_navigation_bar',
							  'default'     => 'navigation_on_left'),

                        // Enable Search Button
						array('title'       => __('Enable Search Button','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_search_button',
							  'default'     => 'true'))),
                         
				array(/* Header */
					'title' => __('Header','ux'),
					'item'  => array(

                        // Layout
						// array('title'       => __('Layout','ux'),
						// 	  'description' => '',
						// 	  'type'        => 'select',
						// 	  'name'        => 'theme_option_header_layout',
						// 	  'default'     => 'transparent-menu'),

                        // Select a Widget Group for Sidebar on Hidden Panel
						// array('title'       => __('Select a Widget Group for Sidebar on Hidden Panel','ux'),
						// 	  'description' => '',
						// 	  'type'        => 'select',
						// 	  'name'        => 'theme_option_header_hidden_panel_widget',
						// 	  'control'     => array('name'  => 'theme_option_header_layout',
						// 							 'value' => 'hidden-menu')),

						// Enable Search Field
						array('title'       => __('Enable Search Field','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_search_field',
							  'default'     => 'true')
				)),
							  
				array(/* Footer */
					'title' => __('Footer','ux'),
					'item'  => array(

						// Enable Footer Logo
						array('title'       => __('Enable Footer Logo','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_footer_logo',
							  'default'     => 'true'),

						// Enable Footer Logo
						array('title'       => __('Enable Copyright','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_footer_enable_copyright',
							  'default'     => 'true'),

						// Enable Menu For Footer
						array('title'       => __('Enable Menu For Footer','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_footer_menu',
							  'default'     => 'true'),

                        // Select Menu
						array('title'       => __('Select Menu','ux'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_footer_menu',
							  'control'     => array('name'  => 'theme_option_enable_footer_menu',
													 'value' => 'true')),

                        // Enable Foot WPML
						array('title'       => __('Enable Foot WPML','ux'),
							  'description' => __('the WPML switcher (flags) would be shown on menu bar when this option is on','ux'),
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_footer_WPML',
							  'default'     => 'false'),

						// Enable RTL
						array('title'       => __('Enable RTL','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_rtl',
							  'default'     => 'false')
						)),
							  
				array(/* Page Post */
					'title' => __('Page/Post','ux'),
					'item' => array(
					
						  // Show Summary of Content
						  array('title'       => __('Show Summary of Content (Archive List Page)','ux'),
								'description' => '',
								'type'        => 'switch',
								'default'     => 'false',
								'name'        => 'theme_option_archive_list_page_summary'),
								
						  // Words to Show on List
						  array('title'       => __('Words to Show on List (Archive List Page)','ux'),
								'description' => '',
								'type'        => 'text',
								'name'        => 'theme_option_archive_list_page_summary_word',
								'default'     => 200,
								'control'     => array('name'  => 'theme_option_archive_list_page_summary',
													   'value' => 'true')),
													 
					    // Show Meta On Post Page
						array('title'       => __('Show Meta On Post Content Page','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_meta_post_page',
							  'default'     => 'true',
							  'bind'        => array(
								  array('type'     => 'checkbox-group',
										'name'     => 'theme_option_posts_showmeta',
										'position' => 'after',
										'default'  => array('date', 'length', 'category', 'tag', 'author', 'comments'),
										'control'  => array('name'  => 'theme_option_enable_meta_post_page',
															'value' => 'true')))),

						// Show Author Information On Post Content page
						array('title'       => __('Show Author Information On Post Content page','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_post_author_information',
							  'default'     => 'false'),

						// EEnable Footer Widget For Post Content Pages
						array('title'       => __('Enable Footer Widget For Post Content Pages','ux'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_footer_widget_for_post',
							  'default'     => 'true'),

                        // Footer Widget For Post Content Pages
						array('title'       => __('Footer Widget For Post Content Pages','ux'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_footer_widget_for_post',
							  'control'     => array('name'  => 'theme_option_enable_footer_widget_for_post',
													 'value' => 'true')))),
			)
		),
		
		array(
			'id' => 'options-mobile',
			'name' => __('Mobile','ux'),
			'section' => array(
				
				array(/* Mobile Responsive */
					'id' => 'mobile-responsive',
					'title' => __('Responsive','ux'),
					'item' => array(
						
						// Enable Mobile Layout
						array('title'       => __('Enable Mobile Layout','ux'),
							  'description' => __('disable this option if you want to display the same with PC end','ux'),
							  'type'        => 'switch',
							  'name'        => 'theme_option_mobile_enable_responsive',
							  'default'     => 'true'))))
		)
	);
	
	return $theme_config_fields;
}


?>