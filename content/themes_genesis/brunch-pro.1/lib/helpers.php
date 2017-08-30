<?php
/**
 * Layout helper functions.
 *
 * @package   BrunchPro\Functions\Helpers
 * @copyright Copyright (c) 2017, Feast Design Co.
 * @license   GPL-2.0+
 * @since     1.0.0
 */

/**
 * Return layout key 'full-width-slim'.
 *
 * Used as shortcut second parameter for `add_filter()`.
 *
 * @since  1.0.0
 * @access public
 * @return string 'full-width-slim'
 */
function brunch_pro_return_full_width_slim() {
	return 'full-width-slim';
}

/**
 * Return layout key 'alt-sidebar-content'.
 *
 * Used as shortcut second parameter for `add_filter()`.
 *
 * @since  1.0.0
 * @access public
 * @return string 'alt-sidebar-content'
 */
function brunch_pro_return_alt_sidebar_content() {
	return 'alt-sidebar-content';
}

/**
 * Check to see if the current blog page has the blog grid layout enabled.
 *
 * @since  1.0.0
 * @param  int $post_id The post ID to use when checking for an enabled grid.
 * @return bool true if the grid is enabled, false otherwise.
 */
function brunch_pro_blog_page_is_grid_enabled( $post_id = false ) {
	static $enabled;

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( null === $enabled ) {
		$enabled = get_post_meta( $post_id, '_brunch_pro_enable_blog_grid', true );

		if ( empty( $enabled ) ) {
			$enabled = 'yes';
		}
	}

	return 'yes' === $enabled;
}

/**
 * Determine if we're viewing a "plural" page.
 *
 * Note that this is similar to, but not quite the same as `! is_singular()`,
 * which wouldn't account for the 404 page.
 *
 * @since  1.0.0
 * @access public
 * @return bool True if we're on any page which displays multiple entries.
 */
function brunch_pro_is_plural() {
	if ( genesis_is_blog_template() ) {
		return brunch_pro_blog_page_is_grid_enabled();
	}

	return is_archive() || is_search();
}

/**
 * Determine if we're within a blog section archive.
 *
 * @since  1.0.0
 * @access public
 * @return bool True if we're on a blog archive page.
 */
function brunch_pro_is_blog_archive() {
	return brunch_pro_is_plural() && ! ( is_post_type_archive() || is_tax() );
}

/**
 * Determine if we're anywhere within the blog section of a Genesis site.
 *
 * @since  1.0.0
 * @access public
 * @return bool True if we're on any section of the blog.
 */
function brunch_pro_is_blog() {
	return brunch_pro_is_blog_archive() || is_singular( 'post' );
}

/**
 * Add post classes for a simple grid loop.
 *
 * @since  1.0.0
 * @access public
 * @param  int $columns The number of grid items desired.
 * @return array $classes The grid classes
 */
function brunch_pro_grid( $columns ) {
	if ( ! in_array( $columns, array( 2, 3, 4, 6 ), true ) ) {
		return array();
	}

	global $wp_query;

	$classes = array( 'simple-grid' );

	$column_classes = array(
		2 => 'one-half',
		3 => 'one-third',
		4 => 'one-fourth',
		6 => 'one-sixth',
	);

	$classes[] = $column_classes[ absint( $columns ) ];

	if ( ( $wp_query->current_post + 1 ) % 2 ) {
		$classes[] = 'odd';
	}

	if ( 0 === $wp_query->current_post || 0 === $wp_query->current_post % $columns ) {
		$classes[] = 'first';
	}

	return $classes;
}

/**
 * Set up a grid of one-half elements for use in a post_class filter.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function brunch_pro_grid_one_half( $class ) {
	return array_merge( brunch_pro_grid( 2 ), $class );
}

/**
 * Add a one half grid class to posts within the main query.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function brunch_pro_grid_one_half_main( $class ) {
	return in_the_loop() && is_main_query() ? brunch_pro_grid_one_half( $class ) : $class;
}

/**
 * Set up a grid of one-third elements for use in a post_class filter.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function brunch_pro_grid_one_third( $class ) {
	return array_merge( brunch_pro_grid( 3 ), $class );
}

/**
 * Add a one third grid class to posts within the main query.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function brunch_pro_grid_one_third_main( $class ) {
	return in_the_loop() && is_main_query() ? brunch_pro_grid_one_third( $class ) : $class;
}

/**
 * Set up a grid of one-fourth elements for use in a post_class filter.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function brunch_pro_grid_one_fourth( $class ) {
	return array_merge( brunch_pro_grid( 4 ), $class );
}

/**
 * Add a one fourth grid class to posts within the main query.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function brunch_pro_grid_one_fourth_main( $class ) {
	return in_the_loop() && is_main_query() ? brunch_pro_grid_one_fourth( $class ) : $class;
}

/**
 * Set up a grid of one-sixth elements for use in a post_class filter.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function brunch_pro_grid_one_sixth( $class ) {
	return array_merge( brunch_pro_grid( 6 ), $class );
}

/**
 * Add a one sixth grid class to posts within the main query.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function brunch_pro_grid_one_sixth_main( $class ) {
	return in_the_loop() && is_main_query() ? brunch_pro_grid_one_sixth( $class ) : $class;
}

/**
 * Helper function to determine if the requested grid function exists.
 *
 * @since  1.0.0
 * @access public
 * @param  string $grid the grid type to check.
 * @return bool|string false if no grid function exists, grid name otherwise.
 */
function brunch_pro_grid_exists( $grid ) {
	return function_exists( "brunch_pro_grid_{$grid}" ) ? $grid : false;
}
