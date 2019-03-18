<?php
/**
 * Class Setting
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Mynote
 * @since 1.0.0
 * @version 1.0.0
 */

class Mynote_Setting extends Mynote_Backend_Abstract {

	public static $settings = array();
	public static $setting_api;

	/**
	 * Where the Mynote MD's setting menu displays on.
	 *
	 * @var string
	 */
	public $menu_position = 'plugins';

	/**
	 * Menu slug.
	 *
	 * @var string
	 */
	public $menu_slug = 'mynote-plugin';

	/**
	 * Constructer.
	 */
	public function __construct() {
		parent::__construct();

		if ( ! self::$setting_api ) {
			self::$setting_api = new Mynote_Settings_API();
		}
	}
	
	/**
	 * Initialize.
	 */
	public function init() {
		add_action( 'admin_init', array( $this, 'setting_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'setting_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ) );
		add_filter( 'plugin_action_links_' . $this->mynote_plugin_name, array( $this, 'plugin_action_links' ), 10, 5 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_extend_links' ), 10, 2 );
	}

	/**
	 * Load specfic CSS file for the Mynote setting page.
	 */
	public function admin_enqueue_styles( $hook_suffix ) {

		if ( false === strpos( $hook_suffix, 'mynote-plugin' ) ) {
			return;
		}
		wp_enqueue_style( 'custom_wp_admin_css', $this->mynote_plugin_url . 'assets/css/admin-setting.css', array(), $this->version, 'all' );
	}

	/**
	 * Register JS files.
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {

	}

	/**
	 * The Mynote setting page, sections and fields.
	 */
	public function setting_admin_init() {

		// set sections and fields.
		self::$setting_api->set_sections( $this->get_sections() );

		$settings = $this->get_fields();

		self::$setting_api->set_fields( $settings );
	 
		// initialize them.
		self::$setting_api->admin_init();

		self::$settings = $settings;
	}

	/**
	 * Setting sections.
	 *
	 * @return array
	 */
	public function get_sections() {
		return array(

			array(
				'id'    => 'mynote_post_types',
				'title' => __( 'Post types', 'mynote-plugin' ),
			),
			
			array(
				'id'    => 'mynote_widgets',
				'title' => __( 'Widgets', 'mynote-plugin' ),
			),

			array(
				'id'    => 'mynote_about',
				'title' => __( 'About', 'mynote-plugin' ),
			),
		);
	}

	/**
	 * Setting fields.
	 *
	 * @return array
	 */
	public function get_fields() {

		$support_post_types = get_post_types( array( 'public' => true ), 'objects' );

		$post_type_options = array();

		foreach($support_post_types as $post_type) {
			if( 'attachment' !== $post_type->name ) {
				$post_type_options[ $post_type->name ] = $post_type->label;
			}
		}

		return array(

			'mynote_post_types' => array(
				array(
					'name'    => 'mynote_post_type_repository',
					'label'   => __( 'GitHub Repository', 'mynote-plugin' ),
					'desc'    => __( 'Display the stars, forks, issues from your GitHub repository.', 'mynote-plugin' ),
					'type'    => 'radio',
					'default' => 'no',
					'options' => array(
						'yes' => __( 'Yes', 'mynote-plugin' ),
						'no'  => __( 'No', 'mynote-plugin' ),
					)
				),
			),

			'mynote_widgets' =>  array(
				array(
					'name'    => 'mynote_widget_bootstrap_toc',
					'label'   => __( 'Bootstrap 4 TOC', 'mynote-plugin' ),
					'desc'    => __( 'A widget that shows a Bootstrap 4 styled TOC deponds on your post content.', 'mynote-plugin' ),
					'type'    => 'radio',
					'default' => 'no',
					'options' => array(
						'yes' => __( 'Yes', 'mynote-plugin' ),
						'no'  => __( 'No', 'mynote-plugin' ),
					)
				),

			),

			'mynote_about' => array(

				array(
					'name'  => 'plugin_about_author',
					'label' => __( 'Author', 'mynote-plugin' ),
					'desc'  => 'Terry L.',
					'type'  => 'html'
				),

				array(
					'name'  => 'plugin_about_version',
					'label' => __( 'Version', 'mynote-plugin' ),
					'desc'  => MYNOTE_PLUGIN_VERSION . '<br /><br />' . __( 'This plugin only works with Mynote theme. More features made for Mynote theme are going to be added in this plugin.', 'mynote-plugin' ),
					'type'  => 'html'
				),

				array(
					'name'  => 'plugin_about_theme',
					'label' => __( 'Mynote Theme', 'mynote-plugin' ),
					'desc'  => '<a href="' . esc_url( 'https://github.com/terrylinooo/mynote' ) . '" target="_blank">https://github.com/terrylinooo/mynote</a>',
					'type'  => 'html'
				),

				array(
					'name'  => 'plugin_about_support',
					'label' => __( 'Support', 'mynote-plugin' ),
					'desc'  => '<a href="' . esc_url( 'https://github.com/terrylinooo/mynote-plugin' ) . '" target="_blank">https://github.com/terrylinooo/mynote-plugin</a>',
					'type'  => 'html'
				),
			),


			
		);
	}

	/**
	 * Register the plugin page.
	 */
	public function setting_admin_menu() {
		switch ( $this->menu_position ) {
			case 'menu':
			case 'plugins':
			case 'options':
			default:
				$menu_function = 'add_' . $this->menu_position . '_page';
				$menu_function(
					__( 'Mynote Admin', 'mynote-plugin' ),
					__( 'Mynote Admin', 'mynote-plugin' ),
					'manage_options',
					$this->menu_slug, 
					array( $this, 'setting_plugin_page' ),
					'dashicons-edit'
				);
				break;
		}
	}

	/**
	* Display the plugin settings options page.
	*/
	public function setting_plugin_page() {

		echo '<div class="wrap">';
		settings_errors();
	
		self::$setting_api->show_navigation();
		self::$setting_api->show_forms();
	
		echo '</div>';
	}

	/**
	 * Filters the action links displayed for each plugin in the Network Admin Plugins list table.
	 *
	 * @param  array  $links Original links.
	 * @param  string $file  File position.
	 * @return array Combined links.
	 */
	public function plugin_action_links( $links, $file ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return $links;
		}

		if ( $file == $this->mynote_plugin_name ) {
			$links[] = '<a href="' . admin_url( "plugins.php?page=" . $this->menu_slug ) . '">' . __( 'Settings', 'mynote-plugin' ) . '</a>';
			return $links;
		}
	}

	/**
	 * Add links to plugin meta information on plugin list page.
	 *
	 * @param  array  $links Original links.
	 * @param  string $file  File position.
	 * @return array Combined links.
	 */
	public function plugin_extend_links( $links, $file ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return $links;
		}

		if ( $file == $this->mynote_plugin_name ) {
			$links[] = '<a href="https://github.com/terrylinooo/mynote-plugin" target="_blank">' . __( 'View GitHub project', 'mynote-plugin' ) . '</a>';
			$links[] = '<a href="https://github.com/terrylinooo/mynote-plugin/issues" target="_blank">' . __( 'Report issues', 'mynote-plugin' ) . '</a>';
		}
		return $links;
	}
}
