<?php $search_text = __('Enter a Key Word Here','ux'); ?>
<div id="search-overlay">
    <form action="" method="get" class="container-inn search-overlay-form">
        <input type="text" name="s" class="search-overlay-input-text" onblur="if (this.value == '') {this.value = '<?php echo esc_attr($search_text); ?>';}" onfocus="if (this.value == '<?php echo esc_attr($search_text); ?>') {this.value = '';}" value="<?php echo esc_attr($search_text); ?>">
    </form>
    <div id="search-result" class="container-inn"></div><!--End search-result-->
    <div id="search-overlay-close"><span class="fa fa-times"></span></div>
</div>