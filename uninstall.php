<?php
/**
 * Uninstall Mynote plugin.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Mynote
 * @since 1.0.0
 * @version 1.0.0
 */

// if uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

$options_names = array(
	'mynote_post_types',
	'mynote_widgets',
);

foreach ( $options_names as $option_name ) {
	delete_option( $option_name );
	delete_site_option( $option_name );
}


