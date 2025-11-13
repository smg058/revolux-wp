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
 * @filesource  customizer-helpers.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/6/2025 at 12:44 AM.
 */

declare( strict_types=1 );

use Revolux\Core\Backend;

defined( 'ABSPATH' ) || exit;

/**
 * Get theme customizer option value
 *
 * This is a shorthand function for getting customizer option values.
 * It provides a simple API for accessing theme mod values with fallback
 * to default values defined in the configuration.
 *
 * @since  0.2.0
 *
 * @param string $option_name The option name to retrieve.
 * @param mixed  $default     Optional default value if option doesn't exist.
 *
 * @return mixed               The option value or default.
 */
function revolux_get_option( string $option_name, mixed $default = null ): mixed {

	// Get the Backend instance.
	$backend = Backend::instance();

	// Get the option value.
	$value = $backend->get_option( $option_name );

	// If value is false and a default was provided, use it.
	if ( false === $value && null !== $default ) {
		return $default;
	}

	// Allow filtering of the value.
	return apply_filters( 'revolux_get_option', $value, $option_name );
}

/**
 * Get default option value
 *
 * Retrieves the default value for a given option as defined
 * in the customizer configuration.
 *
 * @since  0.2.0
 *
 * @param string $option_name The option name.
 *
 * @return mixed               The default value or false.
 */
function revolux_get_option_default( string $option_name ): mixed {
	$backend = Backend::instance();

	return $backend->get_default( $option_name );
}

/**
 * Check if option is enabled
 *
 * Convenience function to check if a toggle option is enabled.
 *
 * @since  0.2.0
 *
 * @param string $option_name The option name to check.
 *
 * @return bool                True if enabled, false otherwise.
 */
function revolux_is_option_enabled( string $option_name ): bool {
	$value = revolux_get_option( $option_name );

	// Handle various truthy values.
	return in_array( $value, [ true, 1, '1', 'on', 'yes' ], true );
}

/**
 * Get color option
 *
 * Gets a color option value, with support for CSS variable output.
 *
 * @since  0.2.0
 *
 * @param string $option_name The option name.
 * @param bool   $css_var     Whether to return as CSS variable.
 *
 * @return string               The color value.
 */
function revolux_get_color( string $option_name, bool $css_var = false ): string {
	$color = revolux_get_option( $option_name );

	if ( $css_var && ! empty( $color ) ) {
		return sprintf( 'var(--rev-%s, %s)', str_replace( '_', '-', $option_name ), $color );
	}

	return $color;
}

/**
 * Get typography option
 *
 * Gets typography settings for an element.
 *
 * @since  0.2.0
 *
 * @param string $option_name The typography option name.
 *
 * @return array               Typography settings array.
 */
function revolux_get_typography( string $option_name ): array {
	$typography = revolux_get_option( $option_name );

	if ( ! is_array( $typography ) ) {
		return [];
	}

	return $typography;
}

/**
 * Output inline CSS from customizer
 *
 * Generates inline CSS based on customizer settings.
 * This is called by the Theme class when enqueueing styles.
 *
 * @since  0.2.0
 * @return string Generated CSS.
 */
function revolux_get_customizer_css(): string {
	$css = '';

	// Check if Kirki is available for auto-generated CSS.
	if ( class_exists( 'Kirki' ) ) {
		// Kirki handles most output CSS automatically.
		// Add any additional custom CSS here.
	}

	// Allow filtering of generated CSS.
	return apply_filters( 'revolux_customizer_css', $css );
}

/**
 * Get social links
 *
 * Retrieves configured social media links.
 *
 * @since  0.2.0
 *
 * @param string $context Context for social links (header, footer).
 *
 * @return array           Array of social links.
 */
function revolux_get_social_links( string $context = 'footer' ): array {
	$social_networks = [
		'facebook'  => esc_html__( 'Facebook', 'revolux' ),
		'twitter'   => esc_html__( 'Twitter/X', 'revolux' ),
		'linkedin'  => esc_html__( 'LinkedIn', 'revolux' ),
		'instagram' => esc_html__( 'Instagram', 'revolux' ),
		'youtube'   => esc_html__( 'YouTube', 'revolux' ),
		'yelp'      => esc_html__( 'Yelp', 'revolux' ),
	];

	$links = [];

	foreach ( $social_networks as $network => $label ) {
		$url = revolux_get_option( "{$context}_social_{$network}" );

		if ( ! empty( $url ) ) {
			$links[ $network ] = [
				'url'   => esc_url( $url ),
				'label' => $label,
				'icon'  => "fa-brands fa-{$network}",
			];
		}
	}

	return apply_filters( "revolux_{$context}_social_links", $links );
}


/**
 * Get copyright text
 *
 * Retrieves and processes the copyright text with dynamic placeholders.
 *
 * @since  0.2.0
 * @return string Processed copyright text.
 */
function revolux_get_copyright(): string {
	$copyright = revolux_get_option( 'footer_copyright' );

	if ( empty( $copyright ) ) {
		$copyright = sprintf(
			esc_html__( 'Copyright &copy; %1$s %2$s. All rights reserved.', 'revolux' ),
			'{year}',
			'{site}'
		);
	}

	// Replace placeholders.
	$copyright = str_replace(
		[ '{year}', '{site}' ],
		[ date( 'Y' ), get_bloginfo( 'name' ) ],
		$copyright
	);

	return apply_filters( 'revolux_copyright', $copyright );
}

/**
 * Check if header is transparent
 *
 * Determines if the header should be transparent based on settings
 * and current page context.
 *
 * @since  0.2.0
 * @return bool True if header should be transparent.
 */
function revolux_is_header_transparent(): bool {
	$is_transparent = revolux_is_option_enabled( 'header_transparent' );

	// Allow per-page override via meta.
	if ( is_singular() ) {
		$meta_override = get_post_meta( get_the_ID(), '_revolux_header_transparent', true );
		if ( '' !== $meta_override ) {
			$is_transparent = (bool) $meta_override;
		}
	}

	return apply_filters( 'revolux_is_header_transparent', $is_transparent );
}

/**
 * Get sidebar position
 *
 * Determines the sidebar position for the current page context.
 *
 * @since  0.2.0
 *
 * @param string $context Context (blog_archive, blog_single, page, etc).
 *
 * @return string          Sidebar position: 'left', 'right', or 'none'.
 */
function revolux_get_sidebar_position( string $context = '' ): string {
	// Auto-detect context if not provided.
	if ( empty( $context ) ) {
		if ( is_singular( 'post' ) ) {
			$context = 'single';
		} elseif ( is_home() || is_archive() ) {
			$context = 'blog_archive';
		} else {
			$context = 'page';
		}
	}

	$position = revolux_get_option( "{$context}_sidebar", 'right' );

	// Allow per-page override.
	if ( is_singular() ) {
		$meta_override = get_post_meta( get_the_ID(), '_revolux_sidebar_position', true );
		if ( ! empty( $meta_override ) ) {
			$position = $meta_override;
		}
	}

	return apply_filters( 'revolux_sidebar_position', $position, $context );
}

/**
 * Has sidebar
 *
 * Checks if the current page should display a sidebar.
 *
 * @since  0.2.0
 *
 * @param string $context Optional context.
 *
 * @return bool            True if sidebar should be displayed.
 */
function revolux_has_sidebar( string $context = '' ): bool {
	$position    = revolux_get_sidebar_position( $context );
	$has_sidebar = ( 'none' !== $position );

	return apply_filters( 'revolux_has_sidebar', $has_sidebar, $context );
}
