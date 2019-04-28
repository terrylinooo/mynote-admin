<?php
/**
 * Mynote_Post_Type_Carousel
 *
 * @package   Mynote
 * @author    Terry Lin <terrylinooo>
 * @license   GPLv3 (or later)
 * @link      https://terryl.in
 * @copyright 2018 Terry Lin
 */

/**
 * Mynote_Post_Type_Carousel
 */
class Mynote_Post_Type_Carousel {

	/**
	 * Constructer.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Register custom post type: Carousel
	 *
	 * @return void
	 */
	public function register_post_type() {
		register_post_type( 'carousel',
			array(
				'labels' => array(
					'name'               => __( 'Carousels', 'mynote-admin' ),
					'singular_name'      => __( 'Carousel', 'mynote-admin' ),
					'add_new'            => __( 'Add New', 'mynote-admin' ),
					'add_new_item'       => __( 'Add New Carosel', 'mynote-admin' ),
					'edit'               => __( 'Edit', 'mynote-admin' ),
					'edit_item'          => __( 'Edit Carousel', 'mynote-admin' ),
					'new_item'           => __( 'New Carousel', 'mynote-admin' ),
					'view'               => __( 'View Carousel', 'mynote-admin' ),
					'view_item'          => __( 'View Carousel', 'mynote-admin' ),
					'search_items'       => __( 'Search Carousel', 'mynote-admin' ),
					'not_found'          => __( 'No Carousel Posts found', 'mynote-admin' ),
					'not_found_in_trash' => __( 'No Carousel Posts found in Trash', 'mynote-admin' ),
				),
				'public'       => false,
				'hierarchical' => false,
				'has_archive'  => false,
				'can_export'   => true,
				'menu_icon'    => 'dashicons-images-alt2',
				'supports'     => array( 'title', 'custom-fields' ),
			)
		);

	}
}