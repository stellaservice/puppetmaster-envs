<?php
//ux customize controls scripts
function ux_theme_customize_controls_scripts(){
	wp_enqueue_script('ux-admin-customize-controls');
}
add_action('customize_controls_print_scripts', 'ux_theme_customize_controls_scripts');

//ux customize controls styles
function ux_theme_customize_controls_styles(){
	wp_enqueue_style('style-customize', esc_url(UX_THEME . '/css/customize-controls.css'));
}
add_action('customize_controls_enqueue_scripts', 'ux_theme_customize_controls_styles');

//ux customize register
function ux_theme_customize_register($wp_customize){
	
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	
	//Color Scheme
	$color_scheme = ux_get_option('theme_option_color_scheme');
	
	if(!$color_scheme){
		$get_option = get_option('ux_theme_option');
		$get_option['theme_option_color_scheme'] = ux_theme_options_color_scheme();
		update_option('ux_theme_option', $get_option);
		$color_scheme =  ux_get_option('theme_option_color_scheme');
	}
	
	$customize_scheme = array(__('select scheme','ux'));
	
	if($color_scheme){
		foreach($color_scheme as $id => $schemes){
			$customize_scheme[$id] = $id; ?>
            
			<div id="<?php echo esc_attr('customize_scheme-' .$id); ?>">
				<?php foreach($schemes as $i => $scheme){ ?>
                    <input type="hidden" name="<?php echo esc_attr($scheme['name']); ?>" value="<?php echo esc_attr($scheme['value']); ?>" />
                <?php } ?>
			</div>
            
		<?php
		}
	}
	
	$wp_customize->add_section('ux_color_scheme', array(
		'title'    => esc_attr__('Color Scheme','ux'),
		'priority' => 899,
	));
	
	$wp_customize->add_setting('ux_theme_color_scheme', array(
		'default'    => 0,
		'capability' => 'edit_theme_options',
        'type'       => 'option',
		'transport'  => 'postMessage',
    ));
	
    $wp_customize->add_control('ux_color_scheme_select', array(
        'settings' => 'ux_theme_color_scheme',
        'label'    => esc_attr__('Select a predefined color scheme','ux'),
        'section'  => 'ux_color_scheme',
        'type'     => 'select',
        'choices'  => $customize_scheme
    ));
	
	$theme_config_fields = ux_theme_options_config_fields();
	if($theme_config_fields){
		foreach($theme_config_fields as $config){
			if($config['id'] == 'options-schemes' && isset($config['section'])){
				foreach($config['section'] as $section){
					if($section['id'] != 'color-scheme' && isset($section['item'])){
						$section_title = isset($section['title']) ? $section['title'] : false;
						$section_id    = isset($section['id']) ? $section['id'] : false;
						
						$key = 900;
						$wp_customize->add_section($section_id, array(
							'title'    => $section_title,
							'priority' => $key++,
						));
						
						foreach($section['item'] as $item){
							$item_title   = isset($item['title']) ? $item['title'] : false;
							$item_name    = isset($item['name']) ? $item['name'] : false;
							$item_default = isset($item['default']) ? $item['default'] : false;
							$item_type    = isset($item['type']) ? $item['type'] : false;
							$scheme_name  = isset($item['scheme-name']) ? $item['scheme-name'] : false;
							
							switch($item_type){
								case 'switch-color': 
								
									$wp_customize->add_setting(esc_attr('ux_theme_option[' . $item_name . ']'), array(
										'default'           => esc_attr($item_default),
										'sanitize_callback' => 'sanitize_hex_color',
										'capability'        => 'edit_theme_options',
										'transport'         => 'postMessage',
										'type'              => 'option'
								 
									));
								 
									$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 
										esc_attr($scheme_name), array(
											'label'    => esc_attr($item_title),
											'section'  => esc_attr($section_id),
											'settings' => esc_attr('ux_theme_option[' . $item_name . ']'))
									));
									
								break;
								
								case 'upload':
								
									$wp_customize->add_setting(esc_attr('ux_theme_option[' . $item_name . ']'), array(
										'default'    => esc_attr($item_default),
										'capability' => 'edit_theme_options',
										'transport'  => 'postMessage',
										'type'       => 'option'
									));
								 
									$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,
										esc_attr($scheme_name), array(
											'label'    => esc_attr($item_title),
											'section'  => esc_attr($section_id),
											'settings' => esc_attr('ux_theme_option[' . $item_name . ']'))
									));
								
								break;
								
								case 'select':
								
									$wp_customize->add_setting(esc_attr('ux_theme_option[' . $item_name . ']'), array(
										'default'    => esc_attr($item_default),
										'capability' => 'edit_theme_options',
										'transport'  => 'postMessage',
										'type'       => 'option'
									));
									
									$wp_customize->add_control($scheme_name, array(
										'settings' => esc_attr('ux_theme_option[' . $item_name . ']'),
										'label'    => esc_attr($item_title),
										'section'  => esc_attr($section_id),
										'type'     => 'select',
										'choices'  => ux_theme_customize_select_fields($item_name)
									));
								
								break;
							}
						}
					}
				}
			}
		}
	}
	
	//ux customize live preview function action
	if($wp_customize->is_preview()){
		add_action('wp_footer', 'ux_theme_customize_preview', 21);
	}
}
add_action('customize_register', 'ux_theme_customize_register');

//ux customize jquery live preview
function ux_theme_customize_preview(){ ?>
	<script type="text/javascript">
		(function($){
			//Main Colors
			//Theme Main Color
			wp.customize('ux_theme_option[theme_option_color_theme_main]', function(value){
				value.bind(function(val){
					$('a:hover,.entry p a,.sidebar_widget a:hover,#footer a:hover,.archive-tit a:hover,.text_block a,.post_meta > li a:hover, #sidebar a:hover, #comments .comment-author a:hover,#comments .reply a:hover,.fourofour-wrap a,.archive-meta-unit a:hover,.post-meta-unit a:hover,#back-top:hover,.heighlight,.carousel-wrap a:hover,.blog-item-main h2 a:hover,.related-post-wrap h3:hover a,.latest-posts-tit-a:hover,.iconbox-a .iconbox-h3:hover,.iconbox-a:hover,.iocnbox:hover .icon_wrap i.fa,.blog-masony-item .item-link:hover:before,.blog_meta a:hover,.breadcrumbs a:hover,.link-wrap a:hover,.archive-wrap h3 a:hover,.post-color-default,.latest-posts-tags a:hover,.pagenums .current,.page-numbers.current').css('color', val);
					$('.sidebar_widget .tagcloud a:hover,.related-post-wrap h3:before,.header-slider-item-more:hover,#back-top:hover .back-top-icon:before,#back-top:hover .back-top-icon:after, #back-top:hover:before, #back-top:hover:after,.single-image-mask,.sidebar_widget .widget_uxconatactform input#idi_send:hover,input.idi_send:hover,#bbp-user-navigation li a:hover,.ux-hover-icon-wrap,.team-item-con-back,.iconbox-content-hide .icon_text,.process-bar,.nav-tabs > li > a:hover,.testimenials:hover,.testimenials:hover .arrow-bg,.brick-with-img:hover .brick-inside,.portfolio-caroufredsel-hover').css('background-color', val);
					$('textarea:focus,input[type="text"]:focus,input[type="password"]:focus,input[type="datetime"]:focus,input[type="datetime-local"]:focus,input[type="date"]:focus,input[type="month"]:focus,input[type="time"]:focus,input[type="week"]:focus,input[type="number"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="color"]:focus,.uneditable-input:focus,.sidebar_widget .widget_uxconatactform textarea:focus,.sidebar_widget .widget_uxconatactform input[type="text"]:focus,#respondwrap textarea:focus,#respondwrap input:focus,.contact_form textarea:focus,.contact_form input[type="text"]:focus,input.search_top_form_text[type="search"]:focus,input.search_top_form_text[type="text"]:focus').css('border-color', val);
				});
			});

			// Auxiliary Color
			wp.customize('ux_theme_option[theme_option_color_second_auxiliary]', function(value){
				value.bind(function(val){
					$('.slider-panel,#main_title_wrap,.nav-tabs > li,.promote-wrap,.process-bar-wrap,.post_meta,.pagenumber a,.countdown_section,.interlock-item,.standard-blog-link-wrap,.blog-item.quote,.portfolio-standatd-tit,.pagenumber span,.testimenials,.testimenials .arrow-bg,.accordion-heading,.testimonial-thum-bg,.single-feild,.iconbox-content-hide .icon_wrap').css('background-color', val);
					$('.progress_bars_with_image_content .bar .bar_noactive.grey').css('color', val);
					$('.border-style2,.border-style3,.nav-tabs > li > a,.tab-content,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tabs-v,.single-feild').css('border-color', val);
					$('.nav.nav-tabs, .tabs-v .nav-tabs > li:last-child.active>a').css('border-bottom-color', val);
					$('.tab-content.tab-content-v').css('border-left-color', val);
					$('.tabs-v .nav-tabs > .active > a').css('border-top-color', val);
				});
			});
			

			//Logo Color
			
			wp.customize('ux_theme_option[theme_option_color_logo]', function(value){
				value.bind(function(val){
					$('.logo-h1').css('color', val);
				});
			});


			//Menu bar
			//Menu bar BG
			wp.customize('ux_theme_option[theme_option_bg_left_menu_bar]', function(value){
				value.bind(function(val){
					$('#sidebar,.site-loading,.page-loading,#navi ul li ul.sub-menu li, #navi ul li:hover,.brick-grey').css('background-color', val);
				});
			});

			//Menu Item Text Color
			wp.customize('ux_theme_option[theme_option_color_menu_item_text]', function(value){
				value.bind(function(val){
					$('#navi a,#mobile-advanced a,.menu-icon i,#navi ul li ul.sub-menu:before,input[type="text"].textboxsearch,.submit-wrap i,.icons-sidebar-unit').css('color', val);
				});
			});
			
			//Activated Item Text Color
			wp.customize('ux_theme_option[theme_option_color_menu_activated_item_text]', function(value){
				value.bind(function(val){
					$('#navi ul li:hover>a,#navi ul li.current-menu-item>a,#navi ul li.current-menu-ancestor>a,#mobile-advanced li>a:hover,#mobile-advanced li.current-menu-item>a,#mobile-advanced li.current-menu-ancestor>a,.icons-sidebar-unit:hover i').css('color', val);
					$('#navi ul li a:before').css('background-color', val);
				});
			});
			
			
			//Submenu Font Color
			wp.customize('ux_theme_option[theme_option_color_submenu_text]', function(value){
				value.bind(function(val){
					$('#navi ul.sub-menu a').css('color', val);
				});
			});

			//copyright text
			wp.customize('ux_theme_option[theme_option_color_copyright]', function(value){
				value.bind(function(val){
					$('.copyright,.copyright a').css('color', val);
				});
			});
			
			
			//Posts & Pages
			//Title Color
			wp.customize('ux_theme_option[theme_option_color_title]', function(value){
				value.bind(function(val){
					$('body.page .main-title, body.page .post-expert').css('color', val);
				});
			});

			//Heading color
			wp.customize('ux_theme_option[theme_option_color_heading]', function(value){
				value.bind(function(val){
					$('.main-title,#comments .comment-author a,h1,h2,h3,h4,h5,h6,.archive-tit a,.blog-item-main h2 a,.item-title-a,#sidebar .social_active i:hover,.countdown_amount,.latest-posts-tit a,.filters.filters-nobg li a:hover,.filters.filters-nobg li.active a,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.accordion-heading .accordion-toggle,.post-navi-a,.jqbar.vertical span,.team-item-con-back a,.team-item-con-back i,.team-item-con-h p,.slider-panel-item h2.slider-title a,.bignumber-item.post-color-default,.blog-item .date-block,#respondwrap textarea, #respondwrap input, .contactform input[type="text"], .contactform textarea,.mfp-title,.mfp-arrow-right:before,.mfp-arrow-left:before').css('color', val);
					$('.gallery-wrap-fullwidth .gallery-info-property,.accordion-heading,.title-ux.line_under_over,.gallery-info-property, .gallery-wrap-sidebar .entry, .social-share,.post-navi-a,#respondwrap textarea, #respondwrap input, .contactform input[type="text"], .contactform textarea,#respondwrap input#submit,.contactform input[type="submit"],.widget_uxconatactform input#idi_send,.entry .contactform input.idi_send, #respond input#submit, input.wpcf7-form-control.wpcf7-submit,input#idi_send,.widget-container .user-submit,button#bbp_reply_submit').css('border-color', val);
					$('h1.main-title:before,body.page #top-wrap,.team-item-con,.ux-btn:hover,#respondwrap input#submit:hover,.contactform input[type="submit"]:hover,.title-ux.line_both_sides:before,.title-ux.line_both_sides:after,.galleria-info,#float-bar-triggler,.float-bar-inn,.comm-reply-title:after,.sidebar_widget .widget_search input[type="submit"], .sidebar_widget .widget_display_search input[type="submit"],.short_line:after,.post-navi-a:hover,.filter-floating-triggle,.filter-floating ul li,.promote-button:hover,.accordion-style-b .accordion-heading a:before,.accordion-style-b .accordion-heading a:after,.separator_inn.bg-,.carousel-indicators li,.sidebar_widget .widget_search input[type="submit"], .sidebar_widget .widget_display_search input[type="submit"]').css('background-color', val);
				});
			});
			
			//Content Text Color
			wp.customize('ux_theme_option[theme_option_color_content_text]', function(value){
				value.bind(function(val){
					$('body,a,.entry p a:hover,.text_block a:hover,#content_wrap,#comments,.blog-item-excerpt,.gallery-wrap-slider .flex-direction-nav a[class*="flex-"],.mfp-image-holder .mfp-close, .mfp-iframe-holder .mfp-close,h3#reply-title small, #comments .nav-tabs li.active h3#reply-title .logged,#comments .nav-tabs li a:hover h3 .logged,.testimonial-thum-bg i.fa,.blog_meta,.blog_meta a,.header-info-mobile,.carousel-wrap a.disabled:hover,#respondwrap input#submit,.contactform input[type="submit"]').css('color', val);
					$('.filters.filters-nobg li a:before,.blog-item-more-a:hover').css('background-color', val);
					$('.blog-item-more-a:hover').css('border-color', val);
				});
			});
		
			
			//Meta Content Color
			wp.customize('ux_theme_option[theme_option_color_auxiliary_content]', function(value){
				value.bind(function(val){
					$('.post_meta>li,.post_meta>li a,.post-meta, .post-meta a,.archive-meta-unit,.archive-meta-unit a,.latest-posts-tags a,.latest-posts-date,#comments .comment-meta .comment-reply-link,#comments .comment-meta .date,#mobile-header-meta p,.bbp-meta,.bbp-meta a,.bbp-author-role,.bbp-pagination-count,span.bbp-author-ip,.bbp-forum-content,.infrographic-subtit').css('color', val);
					$('li.commlist-unit').css('border-color', val);
					$('.quote-wrap,.comment-author:after').css('background-color', val);
				});
			});
			
			//Selected text bg color
			wp.customize('ux_theme_option[theme_option_color_selected_text_bg]', function(value){
				value.bind(function(val){
					$('::selection').css('background-color', val);
					$('::-moz-selection').css('background-color', val);
					$('::-webkit-selection').css('background-color', val);
				});
			});

			//Page Bg Color
			wp.customize('ux_theme_option[theme_option_bg_page_post]', function(value){
				value.bind(function(val){
					$('#content,#top-wrap,#main,.separator h4,#respondwrap input#submit,.contactform input[type="submit"], .flex-direction-nav a[class*="flex-"],.sidebar_widget textarea, .sidebar_widget input[type="text"], .sidebar_widget input[type="email"],.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tab-content,.filters.filter-floating li a:before,.mfp-bg,.mfp-figure:after,.mfp-figure').css('background-color', val);
					$('.testimenials span.arrow,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus').css('border-bottom-color', val);
					$('.ramp-separator svg polygon,.footer-separator.ramp-separator svg polygon').css('fill', val);
					$('.tabs-v .nav-tabs > .active > a').css('border-right-color', val);
					$('#post-navi ,#post-navi a,#respondwrap input#submit:hover,.contactform input[type="submit"]:hover,.post-navi-a:hover,.sidebar_widget .widget_search input[type="submit"],.quote-wrap,.filter-floating a,.filter-floating a:hover,.filter-floating i,.galleria-counter,.bar-h1,.brick-with-img .brick-hover-mask .brick-title, .isotope-liquid-list .brick-hover .brick-hover-mask h3,.item_des .blog-item-more-a:hover').css('color', val);
				});
			});
			
			
			//Sidebar
			//Sidebar Widget Title Color
			wp.customize('ux_theme_option[theme_option_color_sidebar_widget_title]', function(value){
				value.bind(function(val){
					$('.sidebar_widget h3.widget-title,.sidebar_widget h3.widget-title a').css('color', val);
				});
			});
			
			//Sidebar Widget Content Color
			wp.customize('ux_theme_option[theme_option_color_sidebar_content_color]', function(value){
				value.bind(function(val){
					$('.sidebar_widget,.sidebar_widget a').css('color', val);
				});
			});

			//Header & Footer
			//Header BG
			wp.customize('ux_theme_option[theme_option_header_bg_color]', function(value){
				value.bind(function(val){
					$('body,.header-bg,.headerbg,#header.menu-default-hide,.page-loading-inn,.responsive-ux #mobile-header-meta,body.page #header.menu-default-hide,body.page #header.menu-default-hide #logo,#logo-loading').css('background-color', val);
				});
			});

			//Header mask
			wp.customize('ux_theme_option[theme_option_header_mask_color]', function(value){
				value.bind(function(val){
					$('.top-wrap-mask').css('background-color', val);
				});
			});

			//Footer Text Color
			wp.customize('ux_theme_option[theme_option_footer_text_color]', function(value){
				value.bind(function(val){
					$('#footer,#footer a,#footer .social-icons-footer .icons-unit,#footer .social-icons-footer .icons-unit:hover').css('color', val);
					$('.back-top-icon:before,.back-top-icon:after,#back-top:before,#back-top:after').css('background-color', val);
				});
			});

			//Footer bg Color
			/*wp.customize('ux_theme_option[theme_option_footer_bg_color]', function(value){
				value.bind(function(val){
					$('#footer').css('background-color', val);
				});
			});*/
			
			//Footer Widget Content Color
			wp.customize('ux_theme_option[theme_option_footer_widget_content_color]', function(value){
				value.bind(function(val){
					$('.widget_footer_unit').css('color', val);
				});
			});
			
			//Footer Widget Title Colour
			wp.customize('ux_theme_option[theme_option_footer_widget_title_color]', function(value){
				value.bind(function(val){
					$('.widget_footer_unit .widget-title').css('color', val);
				});
			});

		})(jQuery);
	</script>
<?php
}

//ux customize select fields
function ux_theme_customize_select_fields($name){
	$config_select_fields = ux_theme_options_config_select_fields();
	
	$select_fields = array();
	if(isset($config_select_fields[$name])){
		foreach($config_select_fields[$name] as $select){
			$select_fields[$select['value']] = $select['title'];
		}
	}
	
	return $select_fields;
}


?>