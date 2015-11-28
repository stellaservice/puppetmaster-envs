<?php
/**
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class UX_Walker_Nav_Menu_Edit extends Walker_Nav_Menu {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)','ux' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)','ux'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		$submenu_text = '';
		if ( 0 == $depth )
			$submenu_text = 'style="display: none;"';

		?>
		<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_attr( $title ); ?></span> <span class="is-submenu" <?php echo balanceTags($submenu_text); ?>><?php esc_html_e( 'sub item','ux' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_attr( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo esc_url(wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => esc_attr($item_id),
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								));
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo esc_url(wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => esc_attr($item_id),
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								));
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="<?php echo esc_attr('edit-' .$item_id); ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
							echo esc_url(( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' .esc_attr($item_id) ) ) ));
						?>"><?php esc_html_e( 'Edit Menu Item','ux' ); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="<?php echo esc_attr('menu-item-settings-' .$item_id); ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="<?php echo esc_attr('edit-menu-item-url-' .$item_id); ?>">
							<?php esc_html_e( 'URL','ux' ); ?><br />
							<input type="text" id="<?php echo esc_attr('edit-menu-item-url-' .$item_id); ?>" class="widefat code edit-menu-item-url" name="<?php echo esc_attr('menu-item-url[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="<?php echo esc_attr('edit-menu-item-title-' .$item_id); ?>">
						<?php esc_html_e( 'Navigation Label','ux' ); ?><br />
						<input type="text" id="<?php echo esc_attr('edit-menu-item-title-' .$item_id); ?>" class="widefat edit-menu-item-title" name="<?php echo esc_attr('menu-item-title[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="<?php echo esc_attr('edit-menu-item-attr-title-' .$item_id); ?>">
						<?php esc_html_e( 'Title Attribute','ux' ); ?><br />
						<input type="text" id="<?php echo esc_attr('edit-menu-item-attr-title-' .$item_id); ?>" class="widefat edit-menu-item-attr-title" name="<?php echo esc_attr('menu-item-attr-title[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="<?php echo esc_attr('edit-menu-item-target-' .$item_id); ?>">
						<input type="checkbox" id="<?php echo esc_attr('edit-menu-item-target-' .$item_id); ?>" value="_blank" name="<?php echo esc_attr('menu-item-target[' .$item_id. ']'); ?>"<?php checked( esc_attr($item->target), '_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new window/tab','ux' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="<?php echo esc_attr('edit-menu-item-classes-' .$item_id); ?>">
						<?php esc_html_e( 'CSS Classes (optional)','ux' ); ?><br />
						<input type="text" id="<?php echo esc_attr('edit-menu-item-classes-' .$item_id); ?>" class="widefat code edit-menu-item-classes" name="<?php echo esc_attr('menu-item-classes[' .$item_id. ']'); ?>" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="<?php echo esc_attr('edit-menu-item-xfn-' .$item_id); ?>">
						<?php esc_html_e( 'Link Relationship (XFN)','ux' ); ?><br />
						<input type="text" id="<?php echo esc_attr('edit-menu-item-xfn-' .$item_id); ?>" class="widefat code edit-menu-item-xfn" name="<?php echo esc_attr('menu-item-xfn[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
                
                <?php do_action('ux_nav_menu_field', $item); ?>
                
				<p class="field-description description description-wide">
					<label for="<?php echo esc_attr('edit-menu-item-description-' .$item_id); ?>">
						<?php esc_html_e( 'Description','ux' ); ?><br />
						<textarea id="<?php echo esc_attr('edit-menu-item-description-' .$item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="<?php echo esc_attr('menu-item-description[' .$item_id. ']'); ?>]"><?php echo esc_textarea( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.','ux'); ?></span>
					</label>
				</p>

				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php esc_html_e( 'Move','ux' ); ?></span>
						<a href="#" class="menus-move-up"><?php esc_html_e( 'Up one','ux' ); ?></a>
						<a href="#" class="menus-move-down"><?php esc_html_e( 'Down one','ux' ); ?></a>
						<a href="#" class="menus-move-left"></a>
						<a href="#" class="menus-move-right"></a>
						<a href="#" class="menus-move-top"><?php esc_html_e( 'To the top','ux' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original: %s','ux'), '<a href="' . esc_attr( $item->url ) . '">' . esc_attr( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="<?php echo esc_attr('delete-' .$item_id); ?>" href="<?php
					echo esc_url(wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => esc_attr($item_id),
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . esc_attr($item_id)
					)); ?>"><?php esc_html_e( 'Remove','ux' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="<?php echo esc_attr('cancel-' .$item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel','ux'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="<?php echo esc_attr('menu-item-db-id[' .$item_id. ']'); ?>" value="<?php echo esc_attr($item_id); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="<?php echo esc_attr('menu-item-object-id[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="<?php echo esc_attr('menu-item-object[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="<?php echo esc_attr('menu-item-parent-id[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="<?php echo esc_attr('menu-item-position[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="<?php echo esc_attr('menu-item-type[' .$item_id. ']'); ?>" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}

} // Walker_Nav_Menu_Edit


?>