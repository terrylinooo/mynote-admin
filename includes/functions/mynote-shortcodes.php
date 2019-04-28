<?php
/**
 * Add shortcode for Author bio textarea, I think we don't need a plugin for displaying
 * Facebook, Twitter, or othor links. Just use shortcode to do this thing.
 *
 * @package   WordPress
 * @author    Terry Lin <terrylinooo>
 * @license   GPLv3 (or later)
 * @link      https://terryl.in
 * @copyright 2018 Terry Lin
 */

$author_bio_icons = array(
	'github'        => '<i class="fab fa-github-alt"></i>',
	'gitlab'        => '<i class="fab fa-gitlab"></i>',
	'stackoverflow' => '<i class="fab fa-stack-overflow"></i>',
	'facebook'      => '<i class="fab fa-facebook-f"></i>',
	'twitter'       => '<i class="fab fa-twitter"></i>',
	'google'        => '<i class="fab fa-google"></i>',
	'instagram'     => '<i class="fab fa-instagram"></i>',
	'pinterest'     => '<i class="fab fa-pinterest-p"></i>',
	'youtube'       => '<i class="fab fa-youtube"></i>',
);

/**
 * Get anchor link with icon.
 *
 * @param string $type URL type.
 * @param string $link URL.
 * @return string
 */
function get_social_url( $type = '', $link = '' ) {
	global $author_bio_icons;
	return '<a href="' . $link . '" class="brand-link brand-' . $type . '">' . $author_bio_icons[ $type ] . '</a>';
}

/**
 * Short Code - Facebook icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Facebook Profile or Page URL.
 * @return string
 */
function mynote_facebook_sortcode( $atts, $link = '' ) {
	return get_social_url( 'facebook', $link );
}

add_shortcode( 'facebook', 'mynote_facebook_sortcode' );

/**
 * Short Code - Pinterest icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Facebook Profile or Page URL.
 * @return string
 */
function mynote_pinterest_sortcode( $atts, $link = '' ) {
	return get_social_url( 'pinterest', $link );
}

add_shortcode( 'pinterest', 'mynote_pinterest_sortcode' );

/**
 * Short Code - GitHub icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Facebook Profile or Page URL.
 * @return string
 */
function mynote_github_sortcode( $atts, $link = '' ) {
	return get_social_url( 'github', $link );
}

add_shortcode( 'github', 'mynote_github_sortcode' );

/**
 * Short Code - GitLab icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Facebook Profile or Page URL.
 * @return string
 */
function mynote_gitlab_sortcode( $atts, $link = '' ) {
	return get_social_url( 'gitlab', $link );
}

add_shortcode( 'gitlab', 'mynote_gitlab_sortcode' );

/**
 * Short Code - Stack Overflow icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Facebook Profile or Page URL.
 * @return string
 */
function mynote_stackoverflow_sortcode( $atts, $link = '' ) {
	return get_social_url( 'stackoverflow', $link );
}

add_shortcode( 'stackoverflow', 'mynote_stackoverflow_sortcode' );

/**
 * Short Code - Instagram icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Facebook Profile or Page URL.
 * @return string
 */
function mynote_instagram_sortcode( $atts, $link = '' ) {
	return get_social_url( 'instagram', $link );
}

add_shortcode( 'instagram', 'mynote_instagram_sortcode' );

/**
 * Short Code - Twitter icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Facebook Profile or Page URL.
 * @return string
 */
function mynote_twitter_sortcode( $atts, $link = '' ) {
	return get_social_url( 'twitter', $link );
}

add_shortcode( 'twitter', 'mynote_twitter_sortcode' );

/**
 * Short Code - Google icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Google Plus URL.
 * @return string
 */
function mynote_google_sortcode( $atts, $link = '' ) {
	return get_social_url( 'google', $link );
}

add_shortcode( 'google', 'mynote_google_sortcode' );

/**
 * Short Code - Youtube icon and link.
 *
 * @param array  $atts Just leave it blank.
 * @param string $link Your Youtube Page URL.
 * @return string
 */
function mynote_youtube_sortcode( $atts, $link = '' ) {
	return get_social_url( 'youtube', $link );
}

add_shortcode( 'youtube', 'mynote_youtube_sortcode' );

/**
 * Short Code - Bootstrap 4 Caroucel.
 *
 * @param array  $atts Just leave it blank.
 * @return string
 */
function mynote_bootstrap_caroucel_sortcode( $atts ) {
	global $post;

	if ( empty( $post->ID ) ) {
		return;
	}

	extract( shortcode_atts( array(
		'post_id'    => 0,
		'max'        => 10,
		'caption'    => true,
		'indicator'  => true,
		'control'    => true,
		'interval'   => 500,
		'autoplay'   => true,
	), $atts) );
 
	if ( empty( $post_id ) ) {
		$post_id = $post->ID;
	}

	$post_id   = ( int )  $post_id;
	$max       = ( int )  $max;
	$interval  = ( int )  $interval;
	$caption   = ( bool ) $caption;
	$indicator = ( bool ) $indicator;
	$control   = ( bool ) $control;
	$autoplay  = ( bool ) $autoplay;

	$results = get_post_meta( $post_id, 'mynote_bootstrap_carousel', true );
	$count   = count( $results );
	$max     = ( $max > $count ) ? $count : $max;

	ob_start();

	?>
	<div class="mynote-bootstrap-carousel">
		<div id="mynote-bootstrap-carousel-<?php echo $post_id; ?>" style="overflow: hidden" class="carousel slide" data-ride="carousel">
			<?php if ( $indicator ) : ?>
			<ol class="carousel-indicators">
				<?php for ( $i = 1; $i <= $max; $i++ ) : ?>
				<li style="margin: 0 2px" data-target="#mynote-bootstrap-carousel-<?php echo $post_id; ?>" data-slide-to="<?php echo $i ?>" class="<?php echo ( ( $i == 1 ) ? 'active' : '' ); ?>"></li>
				<?php endfor; ?>
			</ol>
			<?php endif; ?>
			<div class="carousel-inner">
				<?php for ( $i = 1; $i <= $max; $i++ ) : ?>
				<div class="carousel-item <?php echo ( ( $i == 1 ) ? 'active' : '' ); ?>">
					<img class="d-block w-100" src="<?php echo esc_url( $results[$i]['image'] ); ?>">
					<?php if ( $caption ) : ?>
					<div class="carousel-caption d-none d-md-block">
						<?php if ( ! empty( $results[$i]['title'] ) ) : ?>
						<h4 class="caption-title"><?php esc_html_e( $results[$i]['title'] ); ?></h4>
						<?php endif; ?>
						<?php if ( ! empty( $results[$i]['description'] ) ) : ?>
						<p class="caption-text"><?php esc_html_e( $results[$i]['description'] ); ?></p>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endfor; ?>
			</div>
			<?php if ( $control ) : ?>
			<a class="carousel-control-prev" href="#mynote-bootstrap-carousel-<?php echo $post_id; ?>" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only"><?php _e( 'Previous', 'mynote-admin' ) ?></span>
			</a>
			<a class="carousel-control-next" href="#mynote-bootstrap-carousel-<?php echo $post_id; ?>" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only"><?php _e( 'Next', 'mynote-admin' ) ?></span>
			</a>
			<?php endif; ?>
		</div>
		<script>
			(function($) {
				$(function() {
					$('#mynote-bootstrap-carousel-<?php echo $post_id; ?>').carousel();
				});
			})(jQuery);
		</script>
	</div>
	<?php

	return ob_get_clean();
}

add_shortcode( 'mynote_caroucel', 'mynote_bootstrap_caroucel_sortcode' );

