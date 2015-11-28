<?php
$visible = 'visible';

//** enable page loading
$ux_enable_fadein_effect = ux_get_option('theme_option_enable_fadein_effect');

if($ux_enable_fadein_effect){ ?>

    <div class="page-loading loading-mask1 <?php echo esc_attr($visible); ?>">
        <div class="page-loading-inn">
            <div class="page-loading-transform">
            	<?php ux_interface_logo('loading'); ?>
        	</div>
        </div>
    </div>

    <div class="page-loading loading-mask2">
        <div class="page-loading-inn">
            <div class="page-loading-transform">
            	<?php ux_interface_logo('loading'); ?>
        	</div>
        </div>
    </div>

<?php } ?>