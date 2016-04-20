<?php
/**
 * Admin Page Functions
 *
 * @package    Widget_Importer_Exporter
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, DreamDolphin Media, LLC
 * @link       https://github.com/stevengliebe/widget-importer-exporter
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.1
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add import/export page under Tools
 *
 * Also enqueue Stylesheet for this page only.
 *
 * @since 0.1
 */
function wie_add_import_export_page() {

	// Add page
	$page_hook = add_management_page(
		__( 'Widget Importer & Exporter', 'widget-importer-exporter' ), // page title
		__( 'Widget Importer & Exporter', 'widget-importer-exporter' ), // menu title
		'manage_options', // capability
		'widget-importer-exporter', // menu slug
		'wie_import_export_page_content' // callback for displaying page content
	);

	// Enqueue stylesheet
 	add_action( 'admin_print_styles-' . $page_hook, 'wie_enqueue_styles' );

}

add_action( 'admin_menu', 'wie_add_import_export_page' ); // register post type

/**
 * Enqueue stylesheets for import/export page
 *
 * @since 0.1
 */
function wie_enqueue_styles() {
	wp_enqueue_style( 'wie-main', WIE_URL . '/' . WIE_CSS_DIR . '/style.css', false, WIE_VERSION ); // bust cache on update
}

/**
 * Import/export page content
 *
 * @since 0.1
 */
function wie_import_export_page_content() {

	?>

	<div class="wrap">

		<?php screen_icon(); ?>

		<h2><?php _e( 'Widget Importer & Exporter', 'widget-importer-exporter' ); ?></h2>

		<?php
		// Show import results if have them
		if ( wie_have_import_results() ) {
			wie_show_import_results();
			return; // don't show content below
		}
		?>

		<h3 class="title"><?php _ex( 'Import Widgets', 'heading', 'widget-importer-exporter' ); ?></h3>

		<p>
			<?php _e( 'Please select a <b>.wie</b> file generated by this plugin.', 'widget-importer-exporter' ); ?>
		</p>

		<form method="post" enctype="multipart/form-data">

			<?php wp_nonce_field( 'wie_import', 'wie_import_nonce' ); ?>

			<input type="file" name="wie_import_file" id="wie-import-file" />

			<?php submit_button( _x( 'Import Widgets', 'button', 'widget-importer-exporter' ) ); ?>

		</form>

		<?php if ( ! empty( $wie_import_results ) ) : ?>
			<p id="wie-import-results">
				<?php echo $wie_import_results; ?>
			</p>
			<br />
		<?php endif; ?>

		<h3 class="title"><?php _ex( 'Export Widgets', 'heading', 'widget-importer-exporter' ); ?></h3>

		<p>
			<?php _e( 'Click below to generate a <b>.wie</b> file for all active widgets.', 'widget-importer-exporter' ); ?>
		</p>

		<p class="submit">
			<a href="<?php echo esc_url( admin_url( basename( $_SERVER['PHP_SELF'] ) . '?page=' . $_GET['page'] . '&export=1' ) ); ?>" id="wie-export-button" class="button button-primary"><?php _ex( 'Export Widgets', 'button', 'widget-importer-exporter' ); ?></a>
		</p>

	</div>

	<?php

}

/**
 * Have import results to show?
 *
 * @since 0.3
 * @global string $wie_import_results
 * @return bool True if have import results to show
 */
function wie_have_import_results() {

	global $wie_import_results;

	if ( ! empty( $wie_import_results ) ) {
		return true;
	}

	return false;

}

/**
 * Show import results
 *
 * This is shown in place of import/export page's regular content.
 *
 * @since 0.3
 * @global string $wie_import_results
 */
function wie_show_import_results() {

	global $wie_import_results;

	?>

	<h3 class="title"><?php _ex( 'Import Results', 'heading', 'widget-importer-exporter' ); ?></h3>

	<p>
		<?php
		printf(
			__( 'You can manage your <a href="%s">Widgets</a> or <a href="%s">Go Back</a>.', 'widget-importer-exporter' ),
			admin_url( 'widgets.php' ),
			admin_url( basename( $_SERVER['PHP_SELF'] ) . '?page=' . $_GET['page'] )
		);
		?>
	</p>

	<table id="wie-import-results">

		<?php
		// Loop sidebars
		$results = $wie_import_results;
		foreach ( $results as $sidebar ) :
		?>

			<tr class="wie-import-results-sidebar">
				<td colspan="2" class="wie-import-results-sidebar-name">
					<?php echo $sidebar['name']; // sidebar name if theme supports it; otherwise ID ?>
				</td>
				<td class="wie-import-results-sidebar-message wie-import-results-message wie-import-results-message-<?php echo $sidebar['message_type']; ?>">
					<?php echo $sidebar['message']; // sidebar may not exist in theme ?>
				</td>
			</tr>

			<?php
			// Loop widgets
			foreach ( $sidebar['widgets'] as $widget ) :
			?>

			<tr class="wie-import-results-widget">
				<td class="wie-import-results-widget-name">
					<?php echo $widget['name']; // widget name or ID if name not available (not supported by site) ?>
				</td>
				<td class="wie-import-results-widget-title">
					<?php echo $widget['title']; // shows "No Title" if widget instance is untitled ?>
				</td>
				<td class="wie-import-results-widget-message wie-import-results-message wie-import-results-message-<?php echo $widget['message_type']; ?>">
					<?php echo $widget['message']; // sidebar may not exist in theme ?>
				</td>
			</tr>

			<?php endforeach; ?>

			<tr class="wie-import-results-space">
				<td colspan="100%"></td>
			</tr>

		<?php endforeach; ?>

	</table>

	<?php

}
