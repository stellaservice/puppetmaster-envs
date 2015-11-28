<?php
function ux_theme_profile_socialmeida($contactmethods){
	$contactmethods['ux_facebook'] = 'Facebook';
	$contactmethods['ux_twitter'] = 'Twitter';
	$contactmethods['ux_googleplus'] = 'Google Plus';
	$contactmethods['ux_linkedin'] = 'Linkedin';
	$contactmethods['ux_youtube'] = 'Youtube';
	$contactmethods['ux_pinterest'] = 'Pinterest';
	$contactmethods['ux_github_alt'] = 'Github';
	
	return $contactmethods;
}
add_filter('user_contactmethods', 'ux_theme_profile_socialmeida', 10, 1);

?>