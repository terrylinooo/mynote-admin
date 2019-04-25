<?php

/**
 * Class Mynote_Backend_Abstract
 * 
 * Controllers are specifically used for admin (backend) use.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Mynote
 * @since 1.0.0
 * @version 1.0.0
 */

abstract class Mynote_Backend_Abstract {

	/**
	 * Version.
	 *
	 * @var string
	 */
	public $version;

	/**
	 * Text domain for transation.
	 *
	 * @var string
	 */
	public $text_domain;

	/**
	 * The plugin url.
	 *
	 * @var string
	 */
	public $mynote_plugin_url;

	/**
	 * The plugin directory.
	 *
	 * @var string
	 */
	public $mynote_plugin_dir;

	/**
	 * The plugin loader's path.
	 *
	 * @var string
	 */
	public $mynote_plugin_path;

	/**
	 * Plugin's name.
	 *
	 * @var string
	 */
	public $mynote_plugin_name;

	/**
	 * Constructer.
	 * 
	 * @return void
	 */
	public function __construct() {
		/**
		 * Basic plugin information. Mapping from the Constant in the plugin loader script.
		 */
		$this->mynote_plugin_name = MYNOTE_PLUGIN_NAME;
		$this->mynote_plugin_url  = MYNOTE_PLUGIN_URL;
		$this->mynote_plugin_dir  = MYNOTE_PLUGIN_DIR;
		$this->mynote_plugin_path = MYNOTE_PLUGIN_PATH;
		$this->version            = MYNOTE_PLUGIN_VERSION;
	}

	/**
	 * Initialize.
	 *
	 * @return void
	 */
	abstract public function init();
	
	/**
	 * Register CSS style files.
	 * 
	 * @param string Hook suffix string.
	 * @return void
	 */
	abstract public function admin_enqueue_styles( $hook_suffix );

	/**
	 * Register JS files.
	 * 
	 * @param string Hook suffix string.
	 * @return void
	 */
	abstract public function admin_enqueue_scripts( $hook_suffix );
}
