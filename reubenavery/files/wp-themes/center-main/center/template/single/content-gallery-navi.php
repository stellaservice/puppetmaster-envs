<?php 
$prev_post = get_previous_post(true);
$next_post = get_next_post(true);

//first post
$get_first_post = get_posts(array(
	'posts_per_page' => 1,
	'order'          => 'ASC'
)); 

$first_post = $get_first_post ? $get_first_post[0] : false; 

//last post
$get_last_post = get_posts(array(
	'posts_per_page' => 1,
	'order'          => 'DESC'
)); 

$last_post = $get_last_post ? $get_last_post[0] : false; 


$enable_left = false;
$enable_right = false;

if(!empty($prev_post)){
	$enable_left = true;
	$left_post = $prev_post;
}
// elseif($last_post){
// 	$enable_left = true;
// 	$left_post = $last_post;
// }

if(!empty($next_post)){
	$enable_right = true;
	$right_post = $next_post;
}
// elseif($first_post){
// 	$enable_right = true;
// 	$right_post = $first_post;
// }

?>

<div class="gallery-navi-post">
    <?php if($enable_left){
		echo '<input id="gallery-navi-prev" type="hidden" value="' .sanitize_text_field($left_post->ID). '" />';
		echo '<div class="gallery-navi-prev"><a href="' .get_permalink($left_post->ID). '" title="' .esc_attr($left_post->post_title). '"><span class="fa fa-angle-left"></span></a></div>';
	}
	
	if($enable_right){
		echo '<input id="gallery-navi-next" type="hidden" value="' .sanitize_text_field($right_post->ID). '" />';
		echo '<div class="gallery-navi-next"><a href="' .get_permalink($right_post->ID). '" title="' .esc_attr($right_post->post_title). '"><span class="fa fa-angle-right"></span></a></div>';
	} ?>
</div>