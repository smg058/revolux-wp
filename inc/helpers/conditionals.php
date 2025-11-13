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
 * @filesource  conditionals.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/6/2025 at 12:47 AM.
 */

declare( strict_types=1 );
defined( 'ABSPATH' ) || exit;

/**
 * Check if blog page.
 *
 * @since 0.2.0
 * @return bool
 */
function revolux_is_blog(): bool {
	return ( is_home() || is_archive() || is_search() ) && ! is_front_page();
}

/**
 * Check if sidebar should be displayed.
 *
 * @since 0.2.0
 *
 * @param string $context Optional context (blog, page, etc).
 *
 * @return bool True if sidebar should be shown.
 */
function revolux_show_sidebar( string $context = '' ): bool {
	// Already have this function in customizer-helpers,
	// this is an alias for backwards compatibility.
	return revolux_has_sidebar( $context );
}

/**
 * Check if current page is using full width template.
 *
 * @since 0.2.0
 * @return bool True if full width.
 */
function revolux_is_full_width(): bool {
	if ( ! is_singular() ) {
		return false;
	}

	$template = get_page_template_slug();

	$full_width_templates = [
		'templates/full-width.php',
		'templates/blank.php',
		'elementor_header_footer',
		'elementor_canvas',
	];

	return in_array( $template, $full_width_templates, true );
}

/**
 * Check if page has page title.
 *
 * @since 0.2.0
 * @return bool True if should show page title.
 */
function revolux_show_page_title(): bool {
	if ( ! is_singular() ) {
		return true;
	}

	// Check for meta override.
	$hide_title = get_post_meta( get_the_ID(), '_revolux_hide_title', true );

	if ( $hide_title ) {
		return false;
	}

	// Check if Elementor is editing this page.
	if ( class_exists( '\Elementor\Plugin' ) ) {
		$document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
		if ( $document && $document->get_settings( 'hide_title' ) === 'yes' ) {
			return false;
		}
	}

	return apply_filters( 'revolux_show_page_title', true );
}

/**
 * Check if current post type supports feature.
 *
 * @since 0.2.0
 *
 * @param string $feature   Feature name.
 * @param string $post_type Optional post type.
 *
 * @return bool True if supported.
 */
function revolux_post_type_supports( string $feature, string $post_type = '' ): bool {
	if ( empty( $post_type ) ) {
		$post_type = get_post_type();
	}

	return post_type_supports( $post_type, $feature );
}

/**
 * Check if WooCommerce is active and on a WooCommerce page.
 *
 * @since 0.2.0
 * @return bool True if on WooCommerce page.
 */
function revolux_is_woocommerce_page(): bool {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return false;
	}

	return is_woocommerce() || is_cart() || is_checkout() || is_account_page();
}

/**
 * Check if Elementor is active and editing.
 *
 * @since 0.2.0
 * @return bool True if Elementor is editing.
 */
function revolux_is_elementor_editor(): bool {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	return \Elementor\Plugin::$instance->editor->is_edit_mode() ||
	       \Elementor\Plugin::$instance->preview->is_preview_mode();
}

/**
 * Check if current page is using Elementor.
 *
 * @since 0.2.0
 *
 * @param int $post_id Optional post ID.
 *
 * @return bool True if built with Elementor.
 */
function revolux_is_elementor_page( int $post_id = 0 ): bool {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	$post_id = $post_id ? $post_id : get_the_ID();

	return \Elementor\Plugin::$instance->documents->get( $post_id )->is_built_with_elementor();
}

/**
 * Check if mobile menu should be displayed.
 *
 * @since 0.2.0
 * @return bool True if mobile menu active.
 */
function revolux_is_mobile_menu_active(): bool {
	$breakpoint = revolux_get_option( 'mobile_menu_breakpoint', '991' );

	// This is a server-side check, actual breakpoint handled by CSS/JS.
	// Always return true as menu should be in DOM.
	return true;
}

/**
 * Check if top bar should be displayed.
 *
 * @since 0.2.0
 * @return bool True if top bar is enabled.
 */
function revolux_show_topbar(): bool {
	return revolux_is_option_enabled( 'topbar_enable' );
}

/**
 * Check if header is sticky.
 *
 * @since 0.2.0
 * @return bool True if sticky header enabled.
 */
function revolux_is_sticky_header(): bool {
	$sticky = revolux_is_option_enabled( 'sticky_header_enable' );

	// Check if mobile sticky is disabled and user is on mobile.
	if ( $sticky && ! revolux_is_option_enabled( 'sticky_header_mobile' ) && wp_is_mobile() ) {
		return false;
	}

	return $sticky;
}

/**
 * Check if transparent header should be used.
 *
 * @since 0.2.0
 * @return bool True if transparent header.
 */
function revolux_use_transparent_header(): bool {
	// Already have this in customizer-helpers.
	// Alias for consistency.
	return revolux_is_header_transparent();
}

/**
 * Check if breadcrumbs should be displayed.
 *
 * @since 0.2.0
 * @return bool True if breadcrumbs should show.
 */
function revolux_show_breadcrumbs(): bool {
	// Don't show on front page.
	if ( is_front_page() ) {
		return false;
	}

	// Check for meta override.
	if ( is_singular() ) {
		$hide_breadcrumbs = get_post_meta( get_the_ID(), '_revolux_hide_breadcrumbs', true );
		if ( $hide_breadcrumbs ) {
			return false;
		}
	}

	return apply_filters( 'revolux_show_breadcrumbs', true );
}

/**
 * Check if comments should be displayed.
 *
 * @since 0.2.0
 * @return bool True if comments should show.
 */
function revolux_show_comments(): bool {
	if ( ! is_singular() ) {
		return false;
	}

	if ( post_password_required() ) {
		return false;
	}

	if ( ! comments_open() && 0 === get_comments_number() ) {
		return false;
	}

	return apply_filters( 'revolux_show_comments', true );
}

/**
 * Check if post meta should be displayed.
 *
 * @since 0.2.0
 * @return bool True if post meta should show.
 */
function revolux_show_post_meta(): bool {
	if ( ! is_singular( 'post' ) && ! revolux_is_blog() ) {
		return false;
	}

	return apply_filters( 'revolux_show_post_meta', true );
}

/**
 * Check if author box should be displayed.
 *
 * @since 0.2.0
 * @return bool True if author box should show.
 */
function revolux_show_author_box(): bool {
	if ( ! is_singular( 'post' ) ) {
		return false;
	}

	if ( ! revolux_is_option_enabled( 'single_show_author_box' ) ) {
		return false;
	}

	return apply_filters( 'revolux_show_author_box', true );
}

/**
 * Check if related posts should be displayed.
 *
 * @since 0.2.0
 * @return bool True if related posts should show.
 */
function revolux_show_related_posts(): bool {
	if ( ! is_singular( 'post' ) ) {
		return false;
	}

	if ( ! revolux_is_option_enabled( 'single_show_related' ) ) {
		return false;
	}

	return apply_filters( 'revolux_show_related_posts', true );
}

/**
 * Check if social share should be displayed.
 *
 * @since 0.2.0
 * @return bool True if social share should show.
 */
function revolux_show_social_share(): bool {
	if ( ! is_singular() ) {
		return false;
	}

	if ( ! revolux_is_option_enabled( 'single_show_share' ) ) {
		return false;
	}

	return apply_filters( 'revolux_show_social_share', true );
}

/**
 * Check if footer widgets are enabled.
 *
 * @since 0.2.0
 * @return bool True if footer widgets enabled.
 */
function revolux_show_footer_widgets(): bool {
	if ( ! revolux_is_option_enabled( 'footer_widgets_enable' ) ) {
		return false;
	}

	// Check if any footer widget area has widgets.
	$columns = revolux_get_option( 'footer_widget_columns', '4' );

	for ( $i = 1; $i <= $columns; $i ++ ) {
		if ( is_active_sidebar( "footer-{$i}" ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Check if footer bottom bar should be displayed.
 *
 * @since 0.2.0
 * @return bool True if bottom bar enabled.
 */
function revolux_show_footer_bottom(): bool {
	return revolux_is_option_enabled( 'footer_bottom_enable' );
}

/**
 * Check if we're on a custom post type archive.
 *
 * @since 0.2.0
 *
 * @param string|array $post_types Optional post type(s) to check.
 *
 * @return bool True if on CPT archive.
 */
function revolux_is_cpt_archive( $post_types = '' ): bool {
	if ( ! is_post_type_archive() ) {
		return false;
	}

	if ( empty( $post_types ) ) {
		return true;
	}

	$post_types        = (array) $post_types;
	$current_post_type = get_query_var( 'post_type' );

	return in_array( $current_post_type, $post_types, true );
}

/**
 * Check if current view should have archive layout options.
 *
 * @since 0.2.0
 * @return bool True if archive layout applies.
 */
function revolux_is_archive_view(): bool {
	return is_home() || is_archive() || is_search();
}

/**
 * Check if current device is mobile.
 *
 * @since 0.2.0
 * @return bool True if mobile device.
 */
function revolux_is_mobile(): bool {
	return wp_is_mobile();
}

/**
 * Check if AJAX request.
 *
 * @since 0.2.0
 * @return bool True if AJAX request.
 */
function revolux_is_ajax(): bool {
	return wp_doing_ajax();
}

/**
 * Check if REST request.
 *
 * @since 0.2.0
 * @return bool True if REST request.
 */
function revolux_is_rest(): bool {
	return defined( 'REST_REQUEST' ) && REST_REQUEST;
}

/**
 * Check if user can edit current post.
 *
 * @since 0.2.0
 *
 * @param int $post_id Optional post ID.
 *
 * @return bool True if user can edit.
 */
function revolux_user_can_edit( int $post_id = 0 ): bool {
	$post_id = $post_id ? $post_id : get_the_ID();

	if ( ! $post_id ) {
		return false;
	}

	$post_type        = get_post_type( $post_id );
	$post_type_object = get_post_type_object( $post_type );

	if ( ! $post_type_object ) {
		return false;
	}

	return current_user_can( $post_type_object->cap->edit_post, $post_id );
}

/**
 * Check if current page is AMP.
 *
 * @since 0.2.0
 * @return bool True if AMP page.
 */
function revolux_is_amp(): bool {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * Check if page uses boxed layout.
 *
 * @since 0.2.0
 * @return bool True if boxed layout.
 */
function revolux_is_boxed_layout(): bool {
	$container_type = revolux_get_option( 'container_type', 'standard' );

	return 'boxed' === $container_type;
}

/**
 * Check if RTL mode is active.
 *
 * @since 0.2.0
 * @return bool True if RTL.
 */
function revolux_is_rtl(): bool {
	return is_rtl();
}
