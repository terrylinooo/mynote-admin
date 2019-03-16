<?php
/**
 * Class Register
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Mynote
 * @since 1.0.0
 * @version 1.6.2
 */

class Mynote_Register extends Mynote_Backend_Abstract {

	/**
	 * Constructer.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Initialize.
	 */
	public function init() {

		// add_action( 'admin_init', array( $this, 'admin_init' ) );

		$this->register_hooks();

		$this->add_post_types();
		$this->add_widgets();
	}

	/**
	 * Initalize to WP `admin_init` hook.
	 */
	function admin_init() {

	}

	/**
	 * Register CSS style files.
	 */
	public function admin_enqueue_styles( $hook_suffix ) {

	}

	/**
	 * Register JS files.
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {

	}
	
	/**
	 * Activate Mynote plugin.
	 */
	public function activate_plugin() {
		global $current_user;

		$mynote_post_types = array(
			'mynote_post_type_repository' => 'no',
		);

		$mynote_widgets = array(
			'mynote_widget_bootstrap_toc' => 'yes',
		);

		// Add default setting. Only execute this action at the first time activation.
		if ( false === get_option( 'mynote_post_types' ) ) {
			update_option( 'mynote_post_types', $mynote_post_types, '', 'yes' );
		}

		if ( false === get_option( 'mynote_widgets' ) ) {
			update_option( 'mynote_widgets', $mynote_widgets, '', 'yes' );
		}
	}

	/**
	 * Deactivate Mynote plugin.
	 */
	public function deactivate_plugin() {
		// Nothing to do, currently.
	}

	/**
	 * Initialize Mynote widgets.
	 */
	public function add_widgets() {
		if ( 'yes' === mynote_get_option( 'mynote_widget_bootstrap_toc', 'mynote_widgets' ) ) {
			add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		}
	}

	/**
	 * Register Githuber widgets. (Triggered by $this->add_widgets).
	 */
	public function register_widgets() {
		register_widget( 'Mynote_Widget_Toc' );
	}

	/**
	 * Register post typees.
	 */
	public function add_post_types() {
		if ( 'yes' === mynote_get_option( 'mynote_post_type_repository', 'mynote_post_types' ) ) {
			new Mynote_Post_Type_Repository();
		}
	}

	/**
	 * Register hooks.
	 */
	public function register_hooks() {
		register_activation_hook( $this->mynote_plugin_path, array( $this , 'activate_plugin' ) );
		register_deactivation_hook( $this->mynote_plugin_path, array( $this , 'deactivate_plugin' ) );
	}
}
