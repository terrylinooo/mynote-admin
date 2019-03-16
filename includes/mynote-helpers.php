<?php
/**
 * Global helper functions.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Mynote
 * @since 1.0.0
 * @version 1.0.0
 */

/**
* Get the value of a settings field.
*
* @param string $option  settings field name.
* @param string $section the section name this field belongs to.
* @param string $default default text if it's not found.
* @return mixed
*/
function mynote_get_option( $option, $section, $default = '' ) {
	$options = get_option( $section );

	if ( isset( $options[ $option ] ) ) {
		return $options[ $option ];
	}
	return $default;
}

/**
 * Get current Post ID.
 *
 * @return int
 */
function mynote_get_current_post_id() {
	global $post;

	$post_id = null;

	if ( ! empty( $post ) )  {
		$post_id = $post->ID;
	} elseif ( ! empty( $_REQUEST['post'] ) ) {
		$post_id = $_REQUEST['post'];
	} else {

	}

	return $post_id;
}

/**
 * Check current user's permission.
 *
 * @param string $action User action.
 * @return bool
 */
function mynote_current_user_can( $action ) {
	global $post;

	if ( current_user_can( $action, $post->ID ) ) {
		return true;
	}
	return false;
}

/**
 * Load view files.
 *
 * @param string $template_path The specific template's path.
 * @param array  $data              Data is being passed to.
 * @return string
 */
function mynote_load_view( $template_path, $data = array() ) {
	$view_file_path = MYNOTE_PLUGIN_DIR . 'includes/views/' . $template_path . '.php';

	if ( ! empty( $data ) ) {
		extract( $data );
	}

	if ( file_exists( $view_file_path ) ) {
		ob_start();
		require $view_file_path;
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}
	return null;
}
