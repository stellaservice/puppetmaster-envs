<?php
//animation lib
function ux_pb_animation_base($fields){
	$fields['module_scroll_animation_base'] = array(
		array('title' => __('Fade In','ux'),             'value' => 'fadein'),
		array('title' => __('Zoom In','ux'),             'value' => 'zoomin'),
		array('title' => __('Zoom Out','ux'),            'value' => 'zoomout'),
		array('title' => __('Fade In Left','ux'),        'value' => 'from-left-translate'),
		array('title' => __('Fade In Right','ux'),       'value' => 'from-right-translate'),
		array('title' => __('Fade In Top','ux'),         'value' => 'from-top-translate'),
		array('title' => __('Fade In Bottom','ux'),      'value' => 'from-bottom-translate'),
		array('title' => __('Bounce In Left','ux'),      'value' => 'bouncdein-left-translate'),
		array('title' => __('Bounce In Right','ux'),     'value' => 'bouncdein-right-translate'),
		array('title' => __('Bounce In Top','ux'),       'value' => 'bouncdein-top-translate'),
		array('title' => __('Bounce In Bottom','ux'),    'value' => 'bouncdein-bottom-translate'),
		array('title' => __('Flip X','ux'),              'value' => 'flip-x-translate'),
		array('title' => __('Flip Y','ux'),              'value' => 'flip-y-translate'),
		array('title' => __('Rotate In DownLeft','ux'),  'value' => 'rotate-downleft-translate'),
		array('title' => __('Rotate In DownRight','ux'), 'value' => 'rotate-downright-translate')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_animation_base');

function ux_pb_animation_end($anima){
	$return = 'fadeined';
	switch($anima){
		case 'fadein':                     $return = 'fadeined'; break;
		case 'zoomin':                     $return = 'zoomined'; break;
		case 'zoomout':                    $return = 'zoomouted'; break;
		case 'from-left-translate':        $return = 'from-left-translated'; break;
		case 'from-right-translate':       $return = 'from-right-translated'; break;
		case 'from-top-translate':         $return = 'from-top-translated'; break;
		case 'from-bottom-translate':      $return = 'from-bottom-translated'; break;
		case 'bouncdein-left-translate':   $return = 'bouncdein-left-translated'; break;
		case 'bouncdein-right-translate':  $return = 'bouncdein-right-translated'; break;
		case 'bouncdein-top-translate':    $return = 'bouncdein-top-translated'; break;
		case 'bouncdein-bottom-translate': $return = 'bouncdein-bottom-translated'; break;
		case 'flip-x-translate':           $return = 'flip-x-translated'; break;
		case 'flip-y-translate':           $return = 'flip-y-translated'; break;
		case 'rotate-downleft-translate':  $return = 'rotate-downleft-translated'; break;
		case 'rotate-downright-translate': $return = 'rotate-downright-translated'; break;
	}
	return $return;
}

function ux_pb_animation($module_fields){
	$animation = array(
		array('title' => __('Scroll in Animation','ux'),
			  'description' => __('enable to select Scroll in animation effect','ux'),
			  'type' => 'switch',
			  'name' => 'module_scroll_in_animation',
			  'default' => 'off',
			  'control' => array(
				  'name' => 'module_advanced_settings',
				  'value' => 'on'
			  )),
			  
		array('title' => __('Scroll in Animation Effect','ux'),
			  'description' => __('animation effect when the module enter the scene','ux'),
			  'type' => 'select',
			  'name' => 'module_scroll_animation_base',
			  'default' => 'fadein',
			  'control' => array(
				  'name' => 'module_scroll_in_animation',
				  'value' => 'on'
			  ))
	);
	
	if($module_fields){
		foreach($module_fields as $moduleid => $fields){
			if(isset($fields['animation'])){
				if($fields['animation']){
					foreach($animation as $anima){
						if($moduleid == 'icon-box'){
							$anima['modal-body'] = 'after';
						}
						array_push($module_fields[$moduleid]['item'], $anima);
					}
				}
			}
			
		}
	}
	
	return $module_fields;
}

?>