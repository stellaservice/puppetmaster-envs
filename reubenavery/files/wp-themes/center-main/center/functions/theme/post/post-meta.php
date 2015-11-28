<?php
//theme meta select fields
function ux_theme_meta_select_fields($fields){
	$fields['theme_meta_sidebar'] = array(
		array('title' => __('Right Sidebar','ux'),                         'value' => 'right-sidebar'),
		array('title' => __('Left Sidebar','ux'),                          'value' => 'left-sidebar'),
		array('title' => __('Without Sidebar','ux'),                       'value' => 'without-sidebar')
	);
	$fields['theme_meta_title_bar_slider_value'] = array(
		array('title' => __('Select a slider','ux'),                       'value' => '-1')
	);
	$fields['theme_meta_audio_type'] = array(
		array('title' => __('Self Hosted Audio','ux'),                     'value' => 'self-hosted-audio'),
		array('title' => __('Soundcloud','ux'),                            'value' => 'soundcloud')
	);
	$fields['theme_meta_video_ratio'] = array(
		array('title' => __('4:3','ux'),                                   'value' => '4:3'),
		array('title' => __('16:9','ux'),                                  'value' => '16:9'),
		array('title' => __('Custom','ux'),                                'value' => 'custom')
	);
	
	$fields['theme_meta_sidebar_widgets'] = ux_theme_register_sidebar('sidebars');
	
	$fields['theme_meta_orderby'] = array(
		array('title' => __('Please Select','ux'),                         'value' => 'none'),
		array('title' => __('Title','ux'),                                 'value' => 'title'),
		array('title' => __('Date','ux'),                                  'value' => 'date'),
		array('title' => __('ID','ux'),                                    'value' => 'id'),
		array('title' => __('Modified','ux'),                              'value' => 'modified'),
		array('title' => __('Author','ux'),                                'value' => 'author'),
		array('title' => __('Comment count','ux'),                         'value' => 'comment_count')
	);
	
	$fields['theme_meta_order'] = array(
		array('title' => __('Ascending','ux'),                             'value' => 'ASC'),
		array('title' => __('Descending','ux'),                            'value' => 'DESC')
	);
	
	$fields['theme_meta_thumbnail_size'] = array(
		array('title' => __('Small','ux'),                                 'value' => 'imagebox-thumb'),
		array('title' => __('Big','ux'),                                   'value' => 'image-thumb-1'),
		array('title' => __('Long','ux'),                                  'value' => 'standard-blog-thumb'),
		array('title' => __('Height','ux'),                                'value' => 'image-thumb-2')
	);
	
	$fields['theme_meta_enable_portfolio_list_layout_builder'] = array(
		array('title' => __('Layout 1','ux'),                              'value' => 'list_layout_1'),
		array('title' => __('Layout 2','ux'),                              'value' => 'list_layout_2'),
		array('title' => __('Layout 3','ux'),                              'value' => 'list_layout_3'),
		array('title' => __('Layout 4','ux'),                              'value' => 'list_layout_4')
	);
	
	$fields['theme_meta_page_template_pagination'] = array(
	array('title' => __('Load More Button','ux'),                          'value' => 'twitter'),
	array('title' => __('Page Number','ux'),                               'value' => 'page_number')
	);
	
	$fields['theme_meta_footer_widget_for_pages']                 = ux_theme_register_sidebar('footer_widget');
	
	$fields['page_template_share_buttons'] = array(
	array('title' => __('Facebook','ux'),                      'value' => 'facebook'),
	array('title' => __('Twitter','ux'),                       'value' => 'twitter'),
	array('title' => __('Google Plus','ux'),                   'value' => 'google-plus'),
	array('title' => __('Pinterest','ux'),                     'value' => 'pinterest'),
	array('title' => __('Digg','ux'),                    	 	'value' => 'digg'),
	array('title' => __('Reddit','ux'),                    	 	'value' => 'reddit'),
	array('title' => __('Linkedin','ux'),                    	'value' => 'linkedin'),
	array('title' => __('Stumbleupon','ux'),                    'value' => 'stumbleupon'),
	array('title' => __('Tumblr','ux'),                    	 	'value' => 'tumblr'),
	array('title' => __('Mail','ux'),                    	 	'value' => 'mail')
	);
	
	return $fields;
}
add_filter('theme_config_select_fields', 'ux_theme_meta_select_fields');

//theme meta fields
function ux_theme_post_meta_fields(){
	$ux_theme_post_meta_fields = array(
		
		// Page
		'page' => array(
			array(
				'id'      => 'page-options',
				'title'   => __('Page Options','ux'),
				'section' => array(

					array(/* Enable Page Template */
						'item' => array(
							
							// Enable Page Template
							array('title'       => __('Enable Slide Page Template','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_enable_page_template',
								  'default'     => 'false'))),
					
					array(/* Sidebar */
						'super-control' => array(
							'name'  => 'theme_meta_enable_page_template',
							'value' => 'false'
						),
						'item' => array(
							
							// Sidebar
							array('title'       => __('Sidebar','ux'),
								  'description' => '',
								  'type'        => 'image-select',
								  'name'        => 'theme_meta_sidebar',
								  'size'        => '126:80',
								  'default'     => 'without-sidebar',
								  'bind'        => array(
									  array('type'     => 'select',
											'name'     => 'theme_meta_sidebar_widgets',
											'col_size' => 'width:200px;',
											'position' => 'after'))))),
					
					array(/* Enable Page Template is true */
						'super-control' => array(
							'name'  => 'theme_meta_enable_page_template',
							'value' => 'true'
						),
						'item' => array(
							
							array('type'        => 'divider'),
								  
							// Select Blog Category
							array('title'       => __('Select Blog Category','ux'),
								  'description' => '',
								  'type'        => 'category-multiple',
								  'name'        => 'theme_meta_page_template_blog_category',
								  'default'     => 0,
								  'col_size'    => 'width:50%;'),
								  
							// Select Blog Category Order
							array('title'       => __('Order','ux'),
								  'description' => '',
								  'type'        => 'orderby',
								  'name'        => 'theme_meta_orderby',
								  'default'     => 'date',
								  'col_size'    => 'width:50%;'),
							
							// Enable Mouse Scroll
							array('title'       => __('Disable Mouse Scroll Animation Effect','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_enable_mouse_scroll_disable',
								  'default'     => 'false'),
							
							// Show Post Navigation On Sidebar
							array('title'       => __('Show Post Navigation On Sidebar','ux'),
								  'description' => __('Works for "Navigation on Left" layout','ux'),
								  'type'        => 'switch',
								  'name'        => 'theme_meta_show_navigation_on_sidebar',
								  'default'     => 'true')
							)
						),
					
					array(/* Other */
						'super-control' => array(
							'name'  => 'theme_meta_enable_page_template',
							'value' => 'false'
						),
						'item' => array(
							
							array('type'        => 'divider'),

							// Show Page Title
							array('title'       => __('Show Page Title','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_show_title',
								  'default'     => 'true'),
							
							// Show Excerpt
							array('title'       => __('Show Excerpt','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_show_excerpt',
								  'default'     => 'false'),

							// Enable Footer Widget
							array('title'       => __('Enable Footer Widget','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_enable_footer_widget_for_pages',
								  'default'     => 'true'),
	
							// Select Footer Widget
							array('title'       => __('Select Footer Widget','ux'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_footer_widget_for_pages',
								  'control'     => array('name'  => 'theme_meta_enable_footer_widget_for_pages',
														 'value' => 'true')),
							
							// Show Top Spacer
							array('title'       => __('Show Top Spacer','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_show_top_spacer',
								  'default'     => 'true'),
							
							// Show Bottom Spacer
							array('title'       => __('Show Bottom Spacer','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_show_bottom_spacer',
								  'default'     => 'true'),

							// archive template
							array('title'       => __('Enable Archive Template','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_show_archive',
								  'default'     => 'false'),

							// Onepage
							array('title'       => __('Enable Onepage','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_show_onepage',
								  'default'     => 'false')

							))
					
				)
			)
		),
		
		// Single Post
		'post' => array(
			
			/* Select Images */
			array(
				'id'      => 'select-images',
				'title'   => __('Select Images','ux'),
				'format'  => 'gallery',
				'section' => array(
					
					array(/* Format Gallery */
						'item' => array(
							
							// gallery
							array('type'        => 'gallery',
								  'description' => '',
								  'name'        => 'theme_meta_portfolio')))
				)
			),
			
			/* Images Settings */
			array(
				'id'      => 'images-settings',
				'title'   => __('Images Settings','ux'),
				'format'  => 'image',
				'section' => array(
					
					array(/* Format Image */
						'item' => array(
							
							// Link
							array('title'       => __('Link','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_image_link')))
				)
			),
			
			/* Audio Settings */
			array(
				'id'      => 'audio-settings',
				'title'   => __('Audio Settings','ux'),
				'format'  => 'audio',
				'section' => array(
					
					array(/* Format Audio */
						'item' => array(
						
							// Audio Type
							array('title'       => __('Audio Type','ux'),
								  'description' => '',
								  'type'        => 'image-select',
								  'size'        => '106:43',
								  'default'     => 'self-hosted-audio',
								  'name'        => 'theme_meta_audio_type'),
								  
							array('type'        => 'divider'),
							
							// Artist
							array('title'       => __('Artist','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_audio_artist',
								  'control'     => array('name'  => 'theme_meta_audio_type',
														 'value' => 'self-hosted-audio')),
								  
							// MP3
							array('title'       => __('MP3','ux'),
								  'description' => '',
								  'type'        => 'social-medias',
								  'name'        => 'theme_meta_audio_mp3',
								  'special'     => 'mp3',
								  'placeholder' => array(__('Title','ux'), __('URL','ux')),
								  'control'     => array('name'  => 'theme_meta_audio_type',
														 'value' => 'self-hosted-audio')),
								  
							// Code for WP
							array('title'       => __('Code for WP','ux'),
								  'type'        => 'textarea',
								  'name'        => 'theme_meta_audio_soundcloud',
								  'description' => __('*Format: https://soundcloud.com/imam-lepast-konyol/maher-zain-always-be-there-1','ux'),
								  'control'     => array('name'  => 'theme_meta_audio_type',
														 'value' => 'soundcloud'))))
				)
			),
			
			/* Video Settings */
			array(
				'id'      => 'video-settings',
				'title'   => __('Video Settings','ux'),
				'format'  => 'video',
				'section' => array(
					
					array(/* Format Video */
						'item' => array(
							
							// Description
							array('description' => __('You could find the embed code on the source video page.','ux').'<div class="show-hide-guide-wrap"><a href="http://www.uiueux.com/a/newtea/documentation/video-guide.html" target="_blank"><span>?</span></a></div>',
								  'type'        => 'description'),
								  
							// Embeded Code
							array('title'       => __('Embeded Code','ux'),
								  'description' => '',
								  'type'        => 'textarea',
								  'name'        => 'theme_meta_video_embeded_code'),
								  
							// Ratio	  
							array('title'       => __('Ratio','ux'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_video_ratio',
								  'default'     => '4:3'),
								  
							// Custom Ratio	  
							array('type'        => 'ratio',
								  'name'        => 'theme_meta_video_custom_ratio',
								  'description' => '',
								  'control'     => array('name'  => 'theme_meta_video_ratio',
														 'value' => 'custom'))))
				)
			),
			
			/* Quote Settings */
			array(
				'id' => 'quote-settings',
				'title' => __('Quote Settings','ux'),
				'format' => 'quote',
				'section' => array(
				
					array(/* Format Quote */
						'item' => array(
							
							// The Quote
							array('title'       => __('The Quote','ux'),
								  'description' => __('Write your quote in this field.','ux'),
								  'type'        => 'textarea',
								  'name'        => 'theme_meta_quote'),
							
							// Cite 
							array('title'       => __('Cite','ux'),
								  'description' => '',
								  'type'        => 'textarea',
								  'name'        => 'theme_meta_quote_cite')))
				)
			),
			
			/* Link Settings */
			array(
				'id' => 'link-settings',
				'title' => __('Link Settings','ux'),
				'format' => 'link',
				'section' => array(
					
					array(/* Format Link */
						'item' => array(
						
							// Link Item
							array('title'       => __('Link Item','ux'),
								  'description' => '',
								  'type'        => 'social-medias',
								  'name'        => 'theme_meta_link_item',
								  'special'     => 'mp3',
								  'placeholder' => array(__('Title','ux'), __('URL','ux')))
						)
					)
				)
			),
			
			/* Post Options */
			array(
				'id'      => 'post-options',
				'title'   => __('Post Options','ux'),
				'section' => array(
				
					array(
						'item' => array(
							
							// Featured Color
							array('title'       => __('Featured Color','ux'),
								  'description' => '',
								  'type'        => 'bg-color',
								  'name'        => 'theme_meta_bg_color'),
								  
							// Thumbnail Size
							array('title'       => __('Thumbnail Size','ux'),
								  'description' => __('Optional, for the Page Builder > Portfolio Module > List Type: Brick','ux'),
								  'type'        => 'image-select',
								  'name'        => 'theme_meta_thumbnail_size',
								  'size'        => '80:80',
								  'default'     => 'imagebox-thumb',
								  'format'      => 'gallery'), 
								  
							array('type'        => 'divider'),

							array('title'       => __('Read Length','ux'),
								  'description' => __('The number of minutes spent reading this article','ux'),
								  'type'        => 'text',
								  'name'        => 'theme_meta_post_length'))),
					
					array(/* use Portfolio Template is true */
						'item' => array(
							
							// List Layout Builder
							array('title'       => __('List Layout Builder','ux'),
								  'description' => '',
								  'type'        => 'layout-builder',
								  'name'        => 'theme_meta_enable_portfolio_list_layout_builder',
								  'format'      => 'gallery',
								  'default'     => 'list_layout_1'),
								  
							// Property
							array('title'       => __('Property','ux'),
								  'description' => '',
								  'type'        => 'property',
								  'name'        => 'theme_meta_enable_portfolio_property',
								  'format'      => 'gallery',
								  'placeholder' => array(__('Title','ux'), __('Content','ux'), __('URL','ux'))))),
					
					
					array(/* Sidebar */
						'item' => array(
							
							// Sidebar
							array('title'       => __('Sidebar','ux'),
								  'description' => '',
								  'type'        => 'image-select',
								  'name'        => 'theme_meta_sidebar',
								  'size'        => '126:80',
								  'default'     => 'right-sidebar',
								  'bind'        => array(
									  array('type'     => 'select',
											'name'     => 'theme_meta_sidebar_widgets',
											'col_size' => 'width:200px;',
											'position' => 'after'))))))
			)
		),
		
		/* Jobs Meta */
		'jobs_item' => array(
			array(
				'id'      => 'jobs-meta',
				'title'   => __('Jobs Meta','ux'),
				'section' => array(
					
					array(/* Jobs Meta */
						'item' => array(
							
							// Location
							array('title'       => __('Location','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_jobs_location'),
								
							// Number
							array('title'       => __('Number','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_jobs_number'))))
			)
		),
		
		/* Testimonials Meta */
		'testimonials_item' => array(
			array(
				'id'      => 'testimonials-meta',
				'title'   => __('Testimonials Meta','ux'),
				'section' => array(
				
					array(/* Testimonials Meta */
						'item' => array(
							
							// Testimonial Cite
							array('title'       => __('Testimonial Cite','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_testimonial_cite'),
								  
							// Position
							array('title'       => __('Position','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_testimonial_position'),
								  
							// Link
							array('title'       => __('Link','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_testimonial_link_title',
								  'placeholder' => __('Title','ux'),
								  'col_style'   => 'width:30%;margin-right:5%;float:left;',
								  'bind'        => array(
									  array('type'        => 'text',
											'name'        => 'theme_meta_testimonial_link',
											'position'    => 'after',
											'placeholder' => __('Link','ux'),
											'col_style'   => 'width:65%;float:left;'))))))
			)
		),
		
		/* Clients Meta */
		'clients_item' => array(
			array(
				'id' => 'clients-meta',
				'title' => __('Clients Meta','ux'),
				'section' => array(
				
					array(/* Clients Meta */
						'item' => array(
							
							//Client Link
							array('title'       => __('Client Link','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_client_link'))))
			)
		),
		
		/* Team Meta */
		'team_item' => array(
			array(
				'id' => 'team-meta',
				'title' => __('Team Meta','ux'),
				'section' => array(
					
					array(/* Team Meta */
						'item' => array(
							
							//use team template
							array('title'       => __('use team template','ux'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_enable_team_template',
								  'default'     => 'true'))),
					
					
					array(/* Sidebar */
						'super-control' => array(
							'name'  => 'theme_meta_enable_team_template',
							'value' => 'false'
						),
						'item' => array(
							
							// Sidebar
							array('title'       => __('Sidebar','ux'),
								  'description' => '',
								  'type'        => 'image-select',
								  'name'        => 'theme_meta_sidebar',
								  'size'        => '126:80',
								  'default'     => 'without-sidebar',
								  'bind'        => array(
									  array('type'     => 'select',
											'name'     => 'theme_meta_sidebar_widgets',
											'col_size' => 'width:200px;',
											'position' => 'after') )),
								  
							array('type'        => 'divider'))),
					
					
					array(/** Team Template is true */
						'super-control' => array(
							'name'  => 'theme_meta_enable_team_template',
							'value' => 'true'
						),
						'item' => array(
							
							// Position
							array('title'       => __('Position','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_team_position'),
								  
							// Email
							array('title'       => __('Email','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_team_email'),
								  
							// Phone Number
							array('title'       => __('Phone Number','ux'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_team_phone_number'),
								  
							// Social Networks
							array('title'       => __('Social Networks','ux'),
								  'description' => '',
								  'type'        => 'new-social-medias',
								  'name'        => 'theme_meta_team_social_medias'))))
			)
		)
	);
	$ux_theme_post_meta_fields = apply_filters('ux_theme_post_meta_fields', $ux_theme_post_meta_fields);
	return $ux_theme_post_meta_fields;
}

//require theme meta interface
require_once locate_template('/functions/theme/post/post-meta-interface.php');
?>