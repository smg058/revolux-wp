<?php
/**
 *
 * Revolux
 *
 * A modern, modular, and multipurpose professional WordPress theme.
 *
 * @version     0.2.0
 * @package     revolux
 * @author      Chayson Media <dev@chayson.com>
 * @filesource  utilities.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/6/2025 at 12:48 AM.
 */

declare( strict_types=1 );
defined( 'ABSPATH' ) || exit;

/**
 * Get the asset URL.
 *
 * Helper to get full URL for theme assets.
 *
 * @since 0.2.0
 *
 * @param string $path Path relative to assets directory.
 *
 * @return string Full asset URL.
 */
function revolux_asset( string $path ): string {
	return trailingslashit( REVOLUX_ASSETS_URI ) . ltrim( $path, '/' );
}

/**
 * Get image URL.
 *
 * Helper to get full URL for theme images.
 *
 * @since 0.2.0
 *
 * @param string $filename Image filename.
 *
 * @return string Full image URL.
 */
function revolux_image( string $filename ): string {
	return revolux_asset( 'images/' . $filename );
}

/**
 * Get icon.
 *
 * Returns an icon HTML element.
 *
 * @since 0.2.0
 *
 * @param string $icon Icon name.
 * @param array  $args Optional arguments.
 *
 * @return string
 */
function revolux_get_icon( string $icon, array $args = [] ): string {
	$defaults = [
		'class' => '',
		'title' => '',
	];

	$args = wp_parse_args( $args, $defaults );

	$classes = [ 'ph', "ph-{$icon}" ];

	if ( ! empty( $args['class'] ) ) {
		$classes[] = $args['class'];
	}

	$title_attr = ! empty( $args['title'] ) ? ' title="' . esc_attr( $args['title'] ) . '"' : '';

	return sprintf(
		'<i class="%s"%s></i>',
		esc_attr( implode( ' ', $classes ) ),
		$title_attr,
	);
}

/**
 * Display icon.
 *
 * @since 0.2.0
 *
 * @param string $icon Icon name.
 * @param array  $args Optional arguments.
 *
 * @return void
 */
function revolux_icon( string $icon, array $args = [] ): void {
	echo revolux_get_icon( $icon, $args ); // phpcs:ignore
}

/**
 * Sanitize checkbox value.
 *
 * @since 0.2.0
 *
 * @param mixed $value Value to sanitize.
 *
 * @return bool
 */
function revolux_sanitize_checkbox( mixed $value ): bool {
	return (bool) $value;
}

/**
 * Sanitize select field.
 *
 * @since 0.2.0
 *
 * @param string $value   Value to sanitize.
 * @param array  $choices Valid choices.
 *
 * @return string
 */
function revolux_sanitize_select( string $value, array $choices ): string {
	return array_key_exists( $value, $choices ) ? $value : '';
}

/**
 * Sanitize HTML content.
 *
 * @since 0.2.0
 *
 * @param string $content Content to sanitize.
 *
 * @return string
 */
function revolux_sanitize_html( string $content ): string {
	$allowed_tags = wp_kses_allowed_html( 'post' );

	// Add iframe for video embeds.
	$allowed_tags['iframe'] = [
		'src'             => true,
		'width'           => true,
		'height'          => true,
		'frameborder'     => true,
		'allowfullscreen' => true,
		'loading'         => true,
	];

	return wp_kses( $content, $allowed_tags );
}

/**
 * Get excerpt by character count.
 *
 * @since 0.2.0
 *
 * @param int    $char_count Character count limit.
 * @param string $more       More text to append.
 * @param int    $post_id    $post_id Optional post ID.
 *
 * @return string
 */
function revolux_get_excerpt_by_chars( int $char_count = 100, string $more = '...', int $post_id = 0 ): string {
	$post_id = $post_id ? $post_id : get_the_ID();
	$excerpt = get_the_excerpt( $post_id );

	if ( mb_strlen( $excerpt ) > $char_count ) {
		$excerpt = mb_substr( $excerpt, 0, $char_count ) . $more;
	}

	return $excerpt;
}

/**
 * Get reading time.
 *
 * Calculate estimated reading time for post content.
 *
 * @since 0.2.0
 *
 * @param int $post_id Optional post ID.
 * @param int $wpm     Words per minute (default 200).
 *
 * @return int
 */
function revolux_get_reading_time( int $post_id = 0, int $wpm = 200 ): int {
	$post_id      = $post_id ? $post_id : get_the_ID();
	$content      = get_post_field( 'post_content', $post_id );
	$word_count   = str_word_count( wp_strip_all_tags( $content ) );
	$reading_time = ceil( $word_count / $wpm );

	return max( 1, $reading_time );
}

/**
 * Display reading time.
 *
 * @since 0.2.0
 *
 * @param int $post_id Optional post ID.
 *
 * @return void
 */
function revolux_reading_time( int $post_id = 0 ): void {
	$reading_time = revolux_get_reading_time( $post_id );

	printf(
		'<span class="rev-reading-time"><i class="ph ph-clock"></i>%s</span>',
		sprintf(
		/* translators: %d is the reading time. */
			esc_html( _n( '%d min read', '%d mins read', $reading_time, 'revolux' ) ),
			$reading_time, // phpcs:ignore
		)
	);
}

/**
 * Get attachment ID from URL.
 *
 * @since 0.2.0
 *
 * @param string $url Attachment URL.
 *
 * @return int
 */
function revolux_get_attachment_id_from_url( string $url ): int {
	global $wpdb;

	$attachment_id = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE guid = %s",
			$url
		)
	);

	return (int) $attachment_id;
}

/**
 * Get image dimensions from attachment ID.
 *
 * @since 0.2.0
 *
 * @param int $attachment_id Attachment ID.
 *
 * @return array|false Array with 'width' and 'height' or false.
 */
function revolux_get_image_dimensions( int $attachment_id ) {
	$meta = wp_get_attachment_metadata( $attachment_id );

	if ( ! $meta || ! isset( $meta['width'], $meta['height'] ) ) {
		return false;
	}

	return [
		'width'  => $meta['width'],
		'height' => $meta['height'],
	];
}

/**
 * Get responsive image HTML.
 *
 * @since 0.2.0
 *
 * @param int    $attachment_id Attachment ID.
 * @param string $size          Image size.
 * @param array  $args          Optional arguments.
 *
 * @return string
 */
function revolux_get_responsive_image( int $attachment_id, string $size = 'full', array $args = [] ): string {
	$defaults = [
		'class'   => '',
		'loading' => 'lazy',
		'alt'     => '',
	];

	$args = wp_parse_args( $args, $defaults );

	return wp_get_attachment_image(
		$attachment_id,
		$size,
		false,
		[
			'class'   => $args['class'],
			'loading' => $args['loading'],
			'alt'     => $args['alt'] ? $args['alt'] : get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
		]
	);
}

/**
 * Get first image from content.
 *
 * @since 0.2.0
 *
 * @param int $post_id Optional post ID.
 *
 * @return string|false Image URL or false.
 */
function revolux_get_first_image( int $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );

	preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );

	return ! empty( $matches[1] ) ? $matches[1] : false;
}

/**
 * Truncate text.
 *
 * @since 0.2.0
 *
 * @param string $text   Text to truncate.
 * @param int    $length Max length.
 * @param string $more   More indicator.
 *
 * @return string Truncated text.
 */
function revolux_truncate( string $text, int $length = 100, string $more = '...' ): string {
	if ( mb_strlen( $text ) <= $length ) {
		return $text;
	}

	return mb_substr( $text, 0, $length ) . $more;
}

/**
 * Format number with K/M suffix.
 *
 * @since 0.2.0
 *
 * @param int $number Number to format.
 *
 * @return string Formatted number.
 */
function revolux_format_number( int $number ): string {
	if ( $number >= 1000000 ) {
		return round( $number / 1000000, 1 ) . 'M';
	}

	if ( $number >= 1000 ) {
		return round( $number / 1000, 1 ) . 'K';
	}

	return (string) $number;
}

/**
 * Get term IDs from term slugs.
 *
 * @since 0.2.0
 *
 * @param array  $slugs    Term slugs.
 * @param string $taxonomy Taxonomy name.
 *
 * @return array Term IDs.
 */
function revolux_get_term_ids_from_slugs( array $slugs, string $taxonomy ): array {
	$term_ids = [];

	foreach ( $slugs as $slug ) {
		$term = get_term_by( 'slug', $slug, $taxonomy );
		if ( $term ) {
			$term_ids[] = $term->term_id;
		}
	}

	return $term_ids;
}

/**
 * Generate CSS from array of styles.
 *
 * @since 0.2.0
 *
 * @param array $styles Associative array of CSS properties and values.
 *
 * @return string CSS string.
 */
function revolux_generate_css( array $styles ): string {
	$css = [];

	foreach ( $styles as $property => $value ) {
		if ( ! empty( $value ) ) {
			$css[] = sprintf( '%s: %s', esc_attr( $property ), esc_attr( $value ) );
		}
	}

	return implode( '; ', $css );
}

/**
 * Convert HEX color to RGB.
 *
 * @since 0.2.0
 *
 * @param string $hex HEX color.
 *
 * @return array RGB values.
 */
function revolux_hex_to_rgb( string $hex ): array {
	$hex = ltrim( $hex, '#' );

	if ( 3 === strlen( $hex ) ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}

	return [
		'r' => $r,
		'g' => $g,
		'b' => $b,
	];
}

/**
 * Lighten or darken a color.
 *
 * @since 0.2.0
 *
 * @param string $hex     HEX color.
 * @param int    $percent Percentage to lighten (positive) or darken (negative).
 *
 * @return string Modified HEX color.
 */
function revolux_adjust_brightness( string $hex, int $percent ): string {
	$rgb = revolux_hex_to_rgb( $hex );

	foreach ( $rgb as $key => $value ) {
		$value       = $value + ( $value * $percent / 100 );
		$value       = min( 255, max( 0, $value ) );
		$rgb[ $key ] = round( $value );
	}

	return sprintf( '#%02x%02x%02x', $rgb['r'], $rgb['g'], $rgb['b'] );
}

/**
 * Get posts for AJAX loading.
 *
 * @since 0.2.0
 *
 * @param array $args WP_Query arguments.
 *
 * @return array Posts data.
 */
function revolux_get_ajax_posts( array $args ): array {
	$defaults = [
		'post_type'      => 'post',
		'posts_per_page' => 6,
		'paged'          => 1,
	];

	$args  = wp_parse_args( $args, $defaults );
	$query = new WP_Query( $args );
	$posts = [];

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$posts[] = [
				'id'        => get_the_ID(),
				'title'     => get_the_title(),
				'permalink' => get_permalink(),
				'excerpt'   => get_the_excerpt(),
				'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
				'date'      => get_the_date(),
				'author'    => get_the_author(),
			];
		}
		wp_reset_postdata();
	}

	return [
		'posts'       => $posts,
		'max_pages'   => $query->max_num_pages,
		'found_posts' => $query->found_posts,
	];
}

/**
 * Minify CSS.
 *
 * @since 0.2.0
 *
 * @param string $css CSS string.
 *
 * @return string Minified CSS.
 */
function revolux_minify_css( string $css ): string {
	// Remove comments.
	$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );

	// Remove whitespace.
	$css = str_replace( [ "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ], '', $css );

	return $css;
}

/**
 * Get page templates.
 *
 * @since 0.2.0
 * @return array Page templates.
 */
function revolux_get_page_templates(): array {
	return wp_get_theme()->get_page_templates();
}

/**
 * Check if string starts with substring.
 *
 * @since 0.2.0
 *
 * @param string $haystack String to search in.
 * @param string $needle   String to search for.
 *
 * @return bool True if starts with.
 */
function revolux_starts_with( string $haystack, string $needle ): bool {
	return 0 === strncmp( $haystack, $needle, strlen( $needle ) );
}

/**
 * Check if string ends with substring.
 *
 * @since 0.2.0
 *
 * @param string $haystack String to search in.
 * @param string $needle   String to search for.
 *
 * @return bool True if ends with.
 */
function revolux_ends_with( string $haystack, string $needle ): bool {
	$length = strlen( $needle );
	if ( 0 === $length ) {
		return true;
	}

	return substr( $haystack, - $length ) === $needle;
}

/**
 * Array insert at position.
 *
 * @since 0.2.0
 *
 * @param array $the_array Original array.
 * @param mixed $insert    Value to insert.
 * @param int   $position  Position to insert at.
 *
 * @return array Modified array.
 */
function revolux_array_insert( array $the_array, $insert, int $position ): array {
	return array_slice( $the_array, 0, $position, true ) + (array) $insert + array_slice( $the_array, $position, null, true );
}
