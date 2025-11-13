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
 * @filesource  hooks.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/6/2025 at 12:46 AM.
 */

declare( strict_types=1 );
defined( 'ABSPATH' ) || exit;

/**
 * HTML Head Hooks
 *
 * Fired in the <head> section.
 */

/**
 * Before wp_head hook.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_wp_head' );

/**
 * After wp_head hook.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_wp_head' );

/**
 * HTML Body Hooks
 *
 * Fired in various locations within the body.
 */

/**
 * Before site wrapper.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_site' );

/**
 * After site wrapper.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_site' );

/**
 * Header Hooks
 *
 * Fired in header-related locations.
 */

/**
 * Before header.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_header' );

/**
 * Header start (inside header tag).
 *
 * @since 0.2.0
 */
do_action( 'revolux_header_start' );

/**
 * Header end (inside header tag).
 *
 * @since 0.2.0
 */
do_action( 'revolux_header_end' );

/**
 * After header.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_header' );

/**
 * Top bar content.
 *
 * @since 0.2.0
 */
do_action( 'revolux_topbar_content' );

/**
 * Before navigation menu.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_nav' );

/**
 * After navigation menu.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_nav' );

/**
 * Content Hooks
 *
 * Fired in content-related locations.
 */

/**
 * Before main content.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_content' );

/**
 * After main content.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_content' );

/**
 * Before page header.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_page_header' );

/**
 * After page header.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_page_header' );

/**
 * Entry Hooks
 *
 * Fired for individual post/page entries.
 */

/**
 * Before entry.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_entry' );

/**
 * Entry top (inside article tag).
 *
 * @since 0.2.0
 */
do_action( 'revolux_entry_top' );

/**
 * Before entry header.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_entry_header' );

/**
 * After entry header.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_entry_header' );

/**
 * Before entry content.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_entry_content' );

/**
 * After entry content.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_entry_content' );

/**
 * Entry bottom (inside article tag).
 *
 * @since 0.2.0
 */
do_action( 'revolux_entry_bottom' );

/**
 * After entry.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_entry' );

/**
 * Sidebar Hooks
 *
 * Fired in sidebar locations.
 */

/**
 * Before sidebar.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_sidebar' );

/**
 * After sidebar.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_sidebar' );

/**
 * Before widget area.
 *
 * @since 0.2.0
 *
 * @param string $sidebar_id Sidebar ID.
 *
 * @example
 * do_action( 'revolux_before_widget_area', $sidebar_id );
 */

/**
 * After widget area.
 *
 * @since 0.2.0
 *
 * @param string $sidebar_id Sidebar ID.
 *
 * @example
 * do_action( 'revolux_after_widget_area', $sidebar_id );
 */

/**
 * Footer Hooks
 *
 * Fired in footer-related locations.
 */

/**
 * Before footer.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_footer' );

/**
 * Footer start (inside footer tag).
 *
 * @since 0.2.0
 */
do_action( 'revolux_footer_start' );

/**
 * Footer end (inside footer tag).
 *
 * @since 0.2.0
 */
do_action( 'revolux_footer_end' );

/**
 * After footer.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_footer' );

/**
 * Before footer widgets.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_footer_widgets' );

/**
 * After footer widgets.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_footer_widgets' );

/**
 * Footer bottom bar content.
 *
 * @since 0.2.0
 */
do_action( 'revolux_footer_bottom_content' );

/**
 * Comment Hooks
 *
 * Fired in comment-related locations.
 */

/**
 * Before comments.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_comments' );

/**
 * After comments.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_comments' );

/**
 * Before comment form.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_comment_form' );

/**
 * After comment form.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_comment_form' );

/**
 * Archive Hooks
 *
 * Fired on archive pages.
 */

/**
 * Before archive header.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_archive_header' );

/**
 * After archive header.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_archive_header' );

/**
 * Before posts loop.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_loop' );

/**
 * After posts loop.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_loop' );

/**
 * No posts found.
 *
 * @since 0.2.0
 */
do_action( 'revolux_no_posts_found' );

/**
 * 404 Hooks
 *
 * Fired on 404 pages.
 */

/**
 * 404 content.
 *
 * @since 0.2.0
 */
do_action( 'revolux_404_content' );

/**
 * Search Hooks
 *
 * Fired on search pages.
 */

/**
 * Before search form.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_search_form' );

/**
 * After search form.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_search_form' );

/**
 * Before search results.
 *
 * @since 0.2.0
 */
do_action( 'revolux_before_search_results' );

/**
 * After search results.
 *
 * @since 0.2.0
 */
do_action( 'revolux_after_search_results' );

/**
 * WooCommerce Hooks (if WooCommerce is active)
 *
 * Additional hooks for WooCommerce integration.
 */

if ( class_exists( 'WooCommerce' ) ) {

	/**
	 * Before shop loop.
	 *
	 * @since 0.2.0
	 */
	do_action( 'revolux_before_shop_loop' );

	/**
	 * After shop loop.
	 *
	 * @since 0.2.0
	 */
	do_action( 'revolux_after_shop_loop' );

	/**
	 * Before single product.
	 *
	 * @since 0.2.0
	 */
	do_action( 'revolux_before_single_product' );

	/**
	 * After single product.
	 *
	 * @since 0.2.0
	 */
	do_action( 'revolux_after_single_product' );
}

/**
 * =============================
 * FILTER HOOKS
 * =============================
 */

/**
 * Filter body classes.
 *
 * @since 0.2.0
 *
 * @param array $classes Body classes.
 *
 * @example
 * apply_filters( 'revolux_body_classes', $classes );
 */

/**
 * Filter post classes.
 *
 * @since 0.2.0
 *
 * @param array $classes Post classes.
 *
 * @example
 * apply_filters( 'revolux_post_classes', $classes );
 */

/**
 * Filter excerpt length.
 *
 * @since 0.2.0
 *
 * @param int $length Excerpt length.
 *
 * @example
 * apply_filters( 'revolux_excerpt_length', $length );
 */

/**
 * Filter excerpt more text.
 *
 * @since 0.2.0
 *
 * @param string $more More text.
 *
 * @example
 * apply_filters( 'revolux_excerpt_more', $more );
 */

/**
 * Filter pagination arguments.
 *
 * @since 0.2.0
 *
 * @param array $args Pagination arguments.
 *
 * @example
 * apply_filters( 'revolux_pagination_args', $args );
 */

/**
 * Filter sidebar position.
 *
 * @since 0.2.0
 *
 * @param string $position Sidebar position.
 * @param string $context  Context.
 *
 * @example
 * apply_filters( 'revolux_sidebar_position', $position, $context );
 */

/**
 * Filter whether to show breadcrumbs.
 *
 * @since 0.2.0
 *
 * @param bool $show Whether to show breadcrumbs.
 *
 * @example
 * apply_filters( 'revolux_show_breadcrumbs', $show );
 */

/**
 * Filter whether to show page title.
 *
 * @since 0.2.0
 *
 * @param bool $show Whether to show page title.
 *
 * @example
 * apply_filters( 'revolux_show_page_title', $show );
 */

/**
 * Filter whether to show author box.
 *
 * @since 0.2.0
 *
 * @param bool $show Whether to show author box.
 *
 * @example
 * apply_filters( 'revolux_show_author_box', $show );
 */

/**
 * Filter whether to show related posts.
 *
 * @since 0.2.0
 *
 * @param bool $show Whether to show related posts.
 *
 * @example
 * apply_filters( 'revolux_show_related_posts', $show );
 */

/**
 * Filter whether to show social share.
 *
 * @since 0.2.0
 *
 * @param bool $show Whether to show social share.
 *
 * @example
 * apply_filters( 'revolux_show_social_share', $show );
 */

/**
 * Filter customizer option value.
 *
 * @since 0.2.0
 *
 * @param mixed  $value       Option value.
 * @param string $option_name Option name.
 *
 * @examples
 * apply_filters( 'revolux_get_option', $value, $option_name );
 */

/**
 * Filter social links.
 *
 * @since 0.2.0
 *
 * @param array $links Social links.
 *
 * @examples
 * apply_filters( 'revolux_social_links', $links );
 */

/**
 * Filter copyright text.
 *
 * @since 0.2.0
 *
 * @param string $copyright Copyright text.
 *
 * @examples
 * apply_filters( 'revolux_copyright', $copyright );
 */

/**
 * Filter context classes.
 *
 * @since 0.2.0
 *
 * @param array $context Context classes.
 *
 * @example
 * apply_filters( 'revolux_context', $context );
 */

/**
 * Filter widget areas array.
 *
 * @since 0.2.0
 *
 * @param array $widget_areas Widget areas configuration.
 *
 * @example
 * apply_filters( 'revolux_widget_areas', $widget_areas );
 */

/**
 * Filter navigation menu arguments.
 *
 * @since 0.2.0
 *
 * @param array  $args     Menu arguments.
 * @param string $location Menu location.
 *
 * @example
 * apply_filters( 'revolux_nav_menu_args', $args, $location );
 */

/**
 * Filter image sizes array.
 *
 * @since 0.2.0
 *
 * @param array $sizes Image sizes.
 *
 * @example
 * apply_filters( 'revolux_image_sizes', $sizes );
 */

/**
 * Filter content width.
 *
 * @since 0.2.0
 *
 * @param int $content_width Content width in pixels.
 *
 * @example
 * apply_filters( 'revolux_content_width', $content_width );
 */

/**
 * Filter asset URL.
 *
 * @since 0.2.0
 *
 * @param string $url  Asset URL.
 * @param string $path Asset path.
 *
 * @example
 * apply_filters( 'revolux_asset_url', $url, $path );
 */

/**
 * Filter generated CSS.
 *
 * @since 0.2.0
 *
 * @param string $css Generated CSS.
 *
 * @example
 * apply_filters( 'revolux_customizer_css', $css );
 */

/**
 * Filter meta generator tag.
 *
 * @since 0.2.0
 *
 * @param string $generator Generator tag HTML.
 *
 * @example
 * apply_filters( 'revolux_meta_generator', $generator );
 */

/**
 * =============================
 * USAGE EXAMPLES
 * =============================
 *
 * Adding content via action hooks (in child theme or plugin):
 *
 * add_action( 'revolux_before_header', function() {
 *     echo '<div class="promo-banner">Special Offer!</div>';
 * });
 *
 * Modifying values via filter hooks:
 *
 * add_filter( 'revolux_excerpt_length', function( $length ) {
 *     return 50;
 * });
 *
 * Conditional hooks:
 *
 * add_action( 'revolux_entry_top', function() {
 *     if ( is_singular( 'post' ) ) {
 *         echo '<div class="featured-label">Featured</div>';
 *     }
 * });
 */
