<?php
/**
 * Class Mynote_Bootstrap_Carousel
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Mynote
 * @since 1.0.1
 * @version 1.0.1
 */

class Mynote_Bootstrap_Carousel extends Mynote_Backend_Abstract {

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
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	/**
	 * Initalize to WP `admin_init` hook.
	 */
	function admin_init() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );
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
        wp_enqueue_script( 'mynote-bootstrap4-carousel', $this->mynote_plugin_url . 'assets/js/mynote-admin-bootstrap-carousel.js', array(), $this->version, true );
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_localize_script( 'mynote-bootstrap4-carousel', 'meta_image',
            array(
                'title' => __( 'Choose or Upload Media', 'events' ),
                'button' => __( 'Use this media', 'events' ),
            )
        );
        wp_enqueue_script( 'mynote-bootstrap4-carousel' );
    }
	
	/**
	 * Create Custom meta box for Repository
	 *
	 * @return void
	 */
	public function add_meta_box() {
		add_meta_box(
			'bootstrap_carousel_meta_box',    // id.
			'Bootstrap Carousel',             // title.
			array( $this, 'show_meta_box' ),  // callback.
			null,                             // screen.
			'normal',                         // context.
			'high'                            // priority.
		);
	}

	/**
	 * Render the metabox
	 */
	function show_meta_box() {
        global $post;

		$results = get_post_meta( $post->ID, 'mynote_bootstrap_carousel', true );

		$image       = ( ! empty( $results[1]['image'] ) ) ? $results[1]['image'] : '';
		$image_full  = ( ! empty( $results[1]['image_full'] ) ) ? $results[1]['image_full'] : '';
		$title       = ( ! empty( $results[1]['title'] ) ) ? $results[1]['title'] : '';
		$description = ( ! empty( $results[1]['description'] ) ) ? $results[1]['description'] : '';
		
		?>
		<p>
			
			<button type="button" class="button" id="btn-add-mc"><?php _e( 'Add more images', 'mynote-admin' )?></button>
			
		</p>
		<div id="bootstrap-carousel-metabox">
			<div id="bmc-1" style="display: block; border: 1px #dddddd solid; border-radius: 4px; padding: 10px; margin-bottom: 10px;">
				<div style="display: flex;">
					<div style="flex: 1"><h3><?php _e( 'Image', 'mynote-admin' )?></h3></div>
					<div><button type="button" class="button" data-media-uploader-target="#mynote-carousel-image-1"><?php _e( 'Add Media', 'mynote-admin' )?></button></div>
				</div>
				<div style="display: flex; align-items: center;">
					<div style="padding: 3px; width: 150px"><strong><?php _e( 'Image URL', 'mynote-admin' )?></strong></div>
					<div style="padding: 3px; flex: 1">
						<input type="text" class="large-text mynote-carousel-image" name="mynote_carousel_image[1]" id="mynote-carousel-image-1" value="<?php esc_attr_e( $image ); ?>"><br />
					</div>
				</div>
				<div style="display: flex; align-items: center;">
					<div style="padding: 3px; width: 150px"><strong><?php _e( 'Link', 'mynote-admin' )?></strong></div>
					<div style="padding: 3px; flex: 1">
						<input type="text" class="large-text mynote-carousel-image" name="mynote_carousel_image_full[1]" id="mynote-carousel-image-1-full" value="<?php esc_attr_e( $image_full ); ?>">
					</div>
				</div>
				<div>
					<h3><?php _e( 'Caption', 'mynote-admin' )?></h3>
					<p><?php _e( "Leave the following fields blank if you don't use them.", 'mynote-admin' )?></p>
				</div>
				<div style="display: flex; align-items: center;">
					<div style="padding: 3px; width: 150px"><strong><?php _e( 'Title', 'mynote-admin' )?></strong></div>
					<div style="padding: 3px; flex: 1"><input type="text" class="large-text mynote-carousel-title" name="mynote_carousel_title[1]" value="<?php esc_attr_e( $title ); ?>"></div>
				</div>
				<div style="display: flex; align-items: center;">
					<div style="padding: 3px; width: 150px"><strong><?php _e( 'Description', 'mynote-admin' )?></strong></div>
					<div style="padding: 3px; flex: 1">
						<textarea name="mynote_carousel_description[1]" rows="3" class="mynote-carousel-description" style="width: 99%"><?php esc_html_e( $description ); ?></textarea>
					</div>
				</div>
			</div>
			<?php

			if ( ! empty( $results ) && is_array( $results ) ) {
				foreach ( $results as $i => $result ) {
					if ( $i > 1 ) {
						$image       = ( ! empty( $results[$i]['image'] ) ) ? $results[$i]['image'] : '';
						$image_full  = ( ! empty( $results[$i]['image_full'] ) ) ? $results[$i]['image_full'] : '';
						$title       = ( ! empty( $results[$i]['title'] ) ) ? $results[$i]['title'] : '';
						$description = ( ! empty( $results[$i]['description'] ) ) ? $results[$i]['description'] : '';
			?>

			<div id="bmc-<?php echo $i; ?>" style="display: block; border: 1px #dddddd solid; border-radius: 4px; padding: 10px; margin-bottom: 10px;">
				<div style="display: flex;">
					<div style="flex: 1"><h3><?php _e( 'Image', 'mynote-admin' )?></h3></div>
					<div><button type="button" class="button" data-media-uploader-target="#mynote-carousel-image-<?php echo $i; ?>"><?php _e( 'Add Media', 'mynote-admin' )?></button></div>
				</div>
				<div style="display: flex; align-items: center;">
					<div style="padding: 3px; width: 150px"><strong><?php _e( 'Image URL', 'mynote-admin' )?></strong></div>
					<div style="padding: 3px; flex: 1">
						<input type="text" class="large-text mynote-carousel-image" name="mynote_carousel_image[<?php echo $i; ?>]" id="mynote-carousel-image-<?php echo $i; ?>" value="<?php esc_attr_e( $image ); ?>">
					</div>
				</div>
				<div style="display: flex; align-items: center;">
					<div style="padding: 3px; width: 150px"><strong><?php _e( 'Link', 'mynote-admin' )?></strong></div>
					<div style="padding: 3px; flex: 1">
						<input type="text" class="large-text mynote-carousel-image" name="mynote_carousel_image_full[<?php echo $i; ?>]" id="mynote-carousel-image-<?php echo $i; ?>-full" value="<?php esc_attr_e( $image_full ); ?>">
					</div>
				</div>
				<div>
					<h3><?php _e( 'Caption', 'mynote-admin' )?></h3>
					<p><?php _e( "Leave the following fields blank if you don't use them.", 'mynote-admin' )?></p>
				</div>
				<div style="display: flex; align-items: center;">
					<div style="padding: 3px; width: 150px"><strong><?php _e( 'Title', 'mynote-admin' )?></strong></div>
					<div style="padding: 3px; flex: 1"><input type="text" class="large-text mynote-carousel-title" name="mynote_carousel_title[<?php echo $i; ?>]" value="<?php esc_attr_e( $title ); ?>"></div>
				</div>
				<div style="display: flex; align-items: center;">
					<div style="padding: 3px; width: 150px"><strong><?php _e( 'Description', 'mynote-admin' )?></strong></div>
					<div style="padding: 3px; flex: 1">
						<textarea name="mynote_carousel_description[<?php echo $i; ?>]" rows="3" class="mynote-carousel-description" style="width: 99%"><?php esc_html_e( $description ); ?></textarea>
					</div>
				</div>
			</div>

			<?php
					}

				}
			} 
			
			?>
		</div>
		<?php

		wp_nonce_field( 'mynote_form_edit_post', 'mynote_form_bootstrap_carousel' );
	}
	
	/**
	 * Save custom meta box for Repository
	 *
	 * @param integer $post_id Post's ID.
	 * @return integer if return.
	 */
	public function save_meta_box( $post_id ) {

		// verify nonce.
		if ( ! isset( $_POST['mynote_form_bootstrap_carousel'] ) || ! wp_verify_nonce( $_POST['mynote_form_bootstrap_carousel'], 'mynote_form_edit_post' )  ) {
			return $post_id;
		}

		// check autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// check permissions.
		if ( ! empty( $_POST['post_type'] ) ) {
			if ( 'page' === $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return $post_id;
				}
			}
		}

		// Store all data into an array.
		$new = array();

		if ( !empty( $_POST['mynote_carousel_image'] ) && is_array( $_POST['mynote_carousel_image'] ) ) {
			foreach ( $_POST['mynote_carousel_image'] as $k => $v ) {
				$new[$k]['image'] = esc_url( $v );
			}
		}

		if ( !empty( $_POST['mynote_carousel_image_full'] ) && is_array( $_POST['mynote_carousel_image_full'] ) ) {
			foreach ( $_POST['mynote_carousel_image_full'] as $k => $v ) {
				$new[$k]['image_full'] = esc_url( $v );
			}
		}

		if ( !empty( $_POST['mynote_carousel_title'] ) && is_array( $_POST['mynote_carousel_title'] ) ) {
			foreach ( $_POST['mynote_carousel_title'] as $k => $v ) {
				$new[$k]['title'] = esc_html( trim( $v ) );
			}
		}

		if ( !empty( $_POST['mynote_carousel_description'] ) && is_array( $_POST['mynote_carousel_description'] ) ) {
			foreach ( $_POST['mynote_carousel_description'] as $k => $v ) {
				$new[$k]['description'] = esc_html( trim( $v ) );
			}
		}

		if ( !empty( $_POST['mynote_carousel_image'] ) ) {
			$old = get_post_meta( $post_id, 'mynote_bootstrap_carousel', true );
			$old_hash = md5( serialize( $old ) );
			$new_hash = md5( serialize( $new ) );

			// Update this meta data when form data has been changed.
			if ( $new_hash !== $old_hash ) {
				update_post_meta( $post_id, 'mynote_bootstrap_carousel', $new );
			}
		}

		// Delete this meta data because there is no image URL on the first field.
		if ( empty( $_POST['mynote_carousel_image'][1] ) ) {
			delete_post_meta( $post_id, 'mynote_bootstrap_carousel', $old );
		}
	}
}