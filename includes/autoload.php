<?php

/**
 * Mynote Class autoloader.
 *
 * @package   Mynote
 * @author    Terry Lin <terrylinooo>
 * @license   GPLv3 (or later)
 * @link      https://terryl.in
 * @copyright 2018 Terry Lin
 */

/**
 * Class autoloader
 */
spl_autoload_register( function( $class_name ) {

	$include_path = '';

	$class_name = ltrim( $class_name, '\\' );

	$wp_utils_mapping = array(         
		'Mynote'                      => '../init',
		'Mynote_Backend_Abstract'     => 'backend/abstract',
		'Mynote_Register'             => 'backend/register',
		'Mynote_Setting'              => 'backend/setting',
		'Mynote_Bootstrap_Carousel'   => 'backend/bootstrap-carousel',
		'Mynote_Post_Type_Repository' => 'posttypes/repository',
		'Mynote_Widget_Toc'           => 'widgets/toc',
		'Mynote_Settings_API'         => 'utilities/settings-api',
	);

	if ( array_key_exists( $class_name, $wp_utils_mapping ) ) {
		$include_path = MYNOTE_PLUGIN_DIR . 'includes/classes/' . $wp_utils_mapping[ $class_name ] . '.php';

		if ( ! empty( $include_path ) && is_readable( $include_path ) ) {
			require $include_path;
		}
	}
});
