<?php
/**
 * Class Mynote
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Mynote
 * @since 1.0.0
 * @version 1.6.0
 */

class Mynote {

	/**
	 * Constructer.
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'load_textdomain' ) );
		// add_action( 'wp_enqueue_scripts', array( $this, 'front_enqueue_styles' ), 998 );
	}
	
	/**
	 * Initialize everything the Mynote plugin needs.
	 */
	public function init() {

		$register = new Mynote_Register();
		$register->init();

		if ( is_admin() ) {
			$setting = new Mynote_Setting();
			$setting->init();
		}
	}

	/**
	 * Register CSS style files for frontend use.
	 * 
	 * @return void
	 */
	public function front_enqueue_styles() {
		wp_enqueue_style( 'mynote-md-css', MYNOTE_PLUGIN_URL . 'assets/css/style.css', array(), MYNOTE_PLUGIN_VERSION, 'all' );
	}

	/**
	 * Load plugin textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( MYNOTE_PLUGIN_TEXT_DOMAIN, false, MYNOTE_PLUGIN_LANGUAGE_PACK ); 
	}
}

