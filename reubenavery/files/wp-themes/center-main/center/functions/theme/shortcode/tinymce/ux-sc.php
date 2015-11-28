<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new ux_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="ux-popup">

	<div id="ux-shortcode-wrap">

		<div id="ux-sc-form-wrap">

			<?php
			$select_shortcode = array(
					'select' => esc_attr__('Choose a Shortcode','ux'),
					'button' => esc_attr__('Button','ux'),
					'line' => esc_attr__('Line','ux'),
					//'title' => esc_attr__('Title','ux'),
					'height_light' => esc_attr__('Highlight','ux'),
					'blank' => esc_attr__('Blank','ux'),
					'image' => esc_attr__('Image','ux'),
					'ux-gallery' => esc_attr__('Gallery','ux'),
					'dropcap' => esc_attr__('Dropcap','ux'),
					'columns' => esc_attr__('Columns','ux'),
					'fixedcolumns' => esc_attr__('Fixed Width Columns','ux'),
					'icon' => esc_attr__('Icon','ux'),
					'text' => esc_attr__('Text','ux'),
					'lists' => esc_attr__('Text List','ux'),
					'switching_word' => esc_attr__('Switching Word','ux')
			);
			?>
			<table id="ux-sc-form-table" class="ux-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label"><?php esc_html_e('Choose Shortcode','ux'); ?></td>
						<td class="field">
							<div class="ux-form-select-field">
							<div class="ux-shortcodes-arrow">&#xf107;</div>
								<select name="ux_select_shortcode" id="ux_select_shortcode" class="ux-form-select ux-input">
									<?php foreach($select_shortcode as $shortcode_key => $shortcode_value): ?>
									<?php if($shortcode_key == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<option value="<?php echo esc_attr($shortcode_key); ?>" <?php echo balanceTags($selected); ?>><?php echo esc_attr($shortcode_value); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<form method="post" id="ux-sc-form">

				<table id="ux-sc-form-table">

					<?php echo balanceTags($shortcode->output); ?>

					<tbody class="ux-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="#" class="ux-insert"><?php esc_html_e('Insert Shortcode','ux'); ?></a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#ux-sc-form-table -->

			</form>
			<!-- /#ux-sc-form -->

		</div>
		<!-- /#ux-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#ux-shortcode-wrap -->

</div>
<!-- /#ux-popup -->

</body>
</html>