<?php
//** current post id
$post_id = get_the_ID();

//** post data
$get_posts = array();

//** processing tags
$tags = array();
$get_tags = get_the_tags();
if($get_tags){
	foreach($get_tags as $num => $tag){
		array_push($tags, $tag->term_id);
	}
	
	if(count($tags)){
		$get_posts = get_posts(array(
			'posts_per_page' => 3,
			'meta_key' => '_thumbnail_id',
			'tag__in' => $tags,
			'post__not_in' => array($post_id),
			'orderby' => 'rand'
		));
	}
}

if(count($get_posts) < 3){
	//** processing category
	$category = array();
	$category_parents = array();
	$get_categories = get_the_category();
	
	foreach($get_categories as $cat){
		array_push($category, $cat->term_id);
		if($cat->parent){
			array_push($category_parents, $cat->parent);
		}
	}
	
	if(count($category)){
		$get_posts = get_posts(array(
			'posts_per_page' => 3,
			'meta_key' => '_thumbnail_id',
			'category__in' => $category,
			'post__not_in' => array($post_id),
			'orderby' => 'rand'
		)); 
	}
	
	if(count($get_posts) < 3 && count($category_parents)){
		$get_posts = get_posts(array(
			'posts_per_page' => 3,
			'meta_key' => '_thumbnail_id',
			'category__in' => $category_parents,
			'post__not_in' => array($post_id),
			'orderby' => 'rand'
		));
	}
}

if($get_posts){

	global $post; ?>
    
    <div class="related-posts-carousel carousel-fadeIn clearfix">
        <div class="related-posts-carousel-in">
            <ul class="related-posts-carousel-ul">
                <?php foreach($get_posts as $post){ setup_postdata($post); ?>
                    <li class="related-posts-carousel-li"><a class="related-posts-a " title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('image-thumb', array('alt'=>get_the_title(),'class'=>'related-posts-img')); ?></a><h2 class="related-posts-tit"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><span class="related-posts-date"><?php echo get_the_time('M j, Y'); ?></span></li>
                <?php
                }
                wp_reset_postdata(); ?>
            </ul>
        </div>
    </div>
<?php } ?>
