<?php
$show_title = ux_get_post_meta(get_the_ID(), 'theme_meta_show_title');
$show_excerpt = ux_get_post_meta(get_the_ID(), 'theme_meta_show_excerpt');

if(!ux_enable_page_template()){
	if($show_title || $show_excerpt){ ?>
		<div class="title-wrap">
			<?php if($show_title){ ?>
				<h1 class="title-h1"><?php the_title(); ?></h1>
			<?php
			}
			
			if($show_excerpt){ ?>
				<div class="page-excerpt"><?php the_excerpt(); ?></div>
			<?php } ?>
		</div>
	<?php
	}
}?>