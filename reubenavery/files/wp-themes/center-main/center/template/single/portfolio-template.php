<div class="blog-unit-gallery-wrap">

	<?php
    //** get portfolio image
    $portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
    
    //** get portfolio list layout builder
    $layout_builder = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_list_layout_builder');
    
    $index = -1;
    
    if($portfolio){
        $portfolio_count = count($portfolio); ?>
        <div class="list-layout row-fluid lightbox-photoswipe">
            <?php foreach($layout_builder as $num => $layout){
                if($index + 1 <= $portfolio_count){
                    switch($layout){
                        case 'list_layout_1':
                            $i = 1; ?>
                            <!--Columns 1 list layout-->
                            <div class="list-layout-col list-layout-col1 clearfix">
                                <?php for($ii=0; $ii<$i; $ii++){ $index++;
                                    if(isset($portfolio[$index])){
                                        $thumb = wp_get_attachment_image_src(intval($portfolio[$index]), 'standard-thumb');
                                        $thumb_full = wp_get_attachment_image_src(intval($portfolio[$index]), 'full');
                                        $data_size = $thumb_full[1]. 'x' .$thumb_full[2]; ?>
                                        <div class="list-layout-col1-item list-layout-item" style="">
                                            <div class="list-layout-inside">
                                                <div class="single-image mouse-over" data-lightbox="true">
                                                    <a data-effect="mfp-zoom-in" rel="post-<?php the_ID(); ?>" title="<?php echo get_the_title(intval($portfolio[$index])); ?>" class="lightbox-item" href="<?php echo esc_url($thumb_full[0]); ?>" data-size="<?php echo $data_size; ?>">
                                                        <div class="single-image-mask"></div>
                                                        <img alt="<?php echo get_the_title(intval($portfolio[$index])); ?>" src="<?php echo esc_url($thumb[0]); ?>" width="800" class="list-layout-img gallery-images-img">
                                                    </a>
                                                </div>
                                            </div><!--End list-layout-inside-->	
                                        </div><!--End list-layout-item-->
                                    <?php
                                    }
                                } ?>
                            </div><!--End list-layout-col-->
                        <?php
                        break;
                        
                        case 'list_layout_2':
                            $i = 2; ?>
                            <!--Columns 2 list layout-->
                            <div class="list-layout-col list-layout-col2 clearfix">
                                <?php for($ii=0; $ii<$i; $ii++){ $index++;
                                    if(isset($portfolio[$index])){
                                        $thumb = wp_get_attachment_image_src(intval($portfolio[$index]), 'standard-thumb');
                                        $thumb_full = wp_get_attachment_image_src(intval($portfolio[$index]), 'full');
                                        $data_size = $thumb_full[1]. 'x' .$thumb_full[2]; ?>
                                        <div class="list-layout-col2-item list-layout-item" style="">
                                            <div class="list-layout-inside">
                                                <div class="single-image mouse-over" data-lightbox="true">
                                                    <a data-effect="mfp-zoom-in" rel="post-<?php the_ID(); ?>" title="<?php echo get_the_title(intval($portfolio[$index])); ?>" class="lightbox-item" href="<?php echo esc_url($thumb_full[0]); ?>" data-size="<?php echo $data_size; ?>">
                                                        <div class="single-image-mask"></div>
                                                        <img alt="<?php echo get_the_title(intval($portfolio[$index])); ?>" src="<?php echo esc_url($thumb[0]); ?>" width="800" class="list-layout-img gallery-images-img">
                                                    </a>
                                                </div>
                                            </div><!--End list-layout-inside-->	
                                        </div><!--End list-layout-item-->
                                    <?php
                                    }
                                } ?>
                            </div><!--End list-layout-col-->
                        <?php
                        break;
                        
                        case 'list_layout_3':
                            $i = 3; ?>
                            <!--Columns 3 list layout-->
                            <div class="list-layout-col list-layout-col3 clearfix">
                                <?php for($ii=0; $ii<$i; $ii++){ $index++;
                                    if(isset($portfolio[$index])){
                                        $thumb = wp_get_attachment_image_src(intval($portfolio[$index]), 'standard-thumb');
                                        $thumb_full = wp_get_attachment_image_src(intval($portfolio[$index]), 'full');
                                        $data_size = $thumb_full[1]. 'x' .$thumb_full[2]; ?>
                                        <div class="list-layout-col3-item list-layout-item" style="">
                                            <div class="list-layout-inside">
                                                <div class="single-image mouse-over" data-lightbox="true">
                                                    <a data-effect="mfp-zoom-in" rel="post-<?php the_ID(); ?>" title="<?php echo get_the_title(intval($portfolio[$index])); ?>" class="lightbox-item" href="<?php echo esc_url($thumb_full[0]); ?>" data-size="<?php echo $data_size; ?>">
                                                        <div class="single-image-mask"></div>
                                                        <img alt="<?php echo get_the_title(intval($portfolio[$index])); ?>" src="<?php echo esc_url($thumb[0]); ?>" width="800" class="list-layout-img gallery-images-img">
                                                    </a>
                                                </div>
                                            </div><!--End list-layout-inside-->	
                                        </div><!--End list-layout-item-->
                                    <?php
                                    }
                                } ?>
                            </div><!--End list-layout-col-->
                        <?php
                        break;
                        
                        case 'list_layout_4':
                            $i = 4; ?>
                            <!--Columns 4 list layout-->
                            <div class="list-layout-col list-layout-col4 clearfix">
                                <?php for($ii=0; $ii<$i; $ii++){ $index++;
                                    if(isset($portfolio[$index])){
                                        $thumb = wp_get_attachment_image_src(intval($portfolio[$index]), 'standard-thumb');
                                        $thumb_full = wp_get_attachment_image_src(intval($portfolio[$index]), 'full');
                                        $data_size = $thumb_full[1]. 'x' .$thumb_full[2]; ?>
                                        <div class="list-layout-col4-item list-layout-item" style="">
                                            <div class="list-layout-inside">
                                                <div class="single-image mouse-over" data-lightbox="true">
                                                    <a data-effect="mfp-zoom-in" rel="post-<?php the_ID(); ?>" title="<?php echo get_the_title(intval($portfolio[$index])); ?>" class="lightbox-item" href="<?php echo esc_url($thumb_full[0]); ?>" data-size="<?php echo $data_size; ?>">
                                                        <div class="single-image-mask"></div>
                                                        <img alt="<?php echo get_the_title(intval($portfolio[$index])); ?>" src="<?php echo esc_url($thumb[0]); ?>" width="800" class="list-layout-img gallery-images-img">
                                                    </a>
                                                </div>
                                            </div><!--End list-layout-inside-->	
                                        </div><!--End list-layout-item-->
                                    <?php
                                    }
                                } ?>
                            </div><!--End list-layout-col-->
                        <?php
                        break;
                    }
                }
            }
            
            
            
            foreach($portfolio as $num => $image){
                if($num > $index){
                    $thumb = wp_get_attachment_image_src(intval($image), 'standard-thumb');
                    $thumb_full = wp_get_attachment_image_src(intval($portfolio[$index]), 'full');
                    $data_size = $thumb_full[1]. 'x' .$thumb_full[2]; ?>
                    <div class="list-layout-col list-layout-col1 clearfix">
                        <div class="list-layout-col1-item list-layout-item" style="">
                            <div class="list-layout-inside">
                                <div class="single-image mouse-over" data-lightbox="true">
                                    <a rel="post-<?php the_ID(); ?>" title="<?php echo get_the_title(intval($portfolio[$num])); ?>" class="lightbox-item" href="<?php echo esc_url($thumb_full[0]); ?>" data-size="<?php echo $data_size; ?>">
                                        <div class="single-image-mask"></div>
                                        <img title="<?php echo get_the_title(intval($image)); ?>" src="<?php echo esc_url($thumb[0]); ?>" width="800" class="list-layout-img gallery-images-img">
                                    </a>
                                </div>
                            </div><!--End list-layout-inside-->	
                        </div><!--End list-layout-item-->
                    </div><!--End list-layout-col-->
                <?php
                }
            } ?>
        </div>
    <?php } ?>
</div>