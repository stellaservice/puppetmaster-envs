<div class="archive-custom">
    <div class="archive-custom-list">
    	<h2 class="archive-custom-title"><?php esc_html_e('lAST 10 POSTS','ux'); ?></h2>
    	<ul class="archive-custom-list-ul">
        <?php wp_get_archives('type=postbypost&limit=10'); ?>
        </ul>
        <h2 class="archive-custom-title"><?php esc_html_e('ARCHIVES BY MONTH','ux'); ?></h2>
        <ul class="archive-custom-list-ul">
        <?php wp_get_archives(); ?>
        </ul>
        <ul class="archive-custom-list-ul last-item">
        <h2 class="archive-custom-title"><?php esc_html_e('ARCHIVES BY CATEGORY','ux'); ?></h2>
        <?php wp_list_categories(); ?>
        </ul>
    </div>
</div>