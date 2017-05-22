<?php
/**
 * Template to display the WP Featherlight admin sidebar meta box.
 *
 * @package   Cookd\Views
 * @copyright Copyright (c) 2016, Shay Bocks
 * @license   GPL-2.0+
 * @link      http://www.feastdesignco.com/cookd/
 * @since     1.0.0
 */

?>
<p><span class="description"><?php esc_html_e( 'These settings apply only to this recipe archive page.', 'cookd' ); ?></span></p>
<table class="form-table">
<tbody>

	<tr valign="top">
		<th scope="row"><?php esc_html_e( 'Display Category', 'cookd' ); ?></th>
		<td>
			<p>
				<label for="_cookd_recipe_options[cat]" class="screen-reader-text"><?php _e( 'Display which category:', 'cookd' ); ?></label>
				<?php
				wp_dropdown_categories( array(
					'selected'        => cookd_get_recipe_index_option( 'cat', $post->ID ),
					'name'            => '_cookd_recipe_options[cat]',
					'orderby'         => 'Name',
					'hierarchical'    => 1,
					'show_option_all' => __( 'All Categories', 'cookd' ),
					'hide_empty'      => '0',
				) );
				?>
			</p>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="_cookd_recipe_options[cat_exclude]"><?php esc_html_e( 'Exclude Categories', 'cookd' ); ?></label></th>
		<td>
			<p>
			<input type="text" name="_cookd_recipe_options[cat_exclude]" class="regular-text" id="_cookd_recipe_options[cat_exclude]" value="<?php echo esc_attr( cookd_get_recipe_index_option( 'cat_exclude', $post->ID ) ); ?>" />
			<br /><small><strong><?php esc_html_e( 'Category IDs, comma separated - 1,2,3 for example', 'cookd' ); ?></strong></small>
			</p>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="_cookd_recipe_options[cat_num]"><?php esc_html_e( 'Posts per Page', 'cookd' ); ?></label></th>
		<td>
			<input type="text" name="_cookd_recipe_options[cat_num]" id="_cookd_recipe_options[cat_num]" value="<?php echo esc_attr( cookd_get_recipe_index_option( 'cat_num', $post->ID ) ); ?>" size="2" />
		</td>
	</tr>

</tbody>
</table>
<?php wp_nonce_field( 'save_cookd_metabox', 'cookd_metabox_nonce' ); ?>
