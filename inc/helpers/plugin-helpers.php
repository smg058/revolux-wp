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
 * @filesource  plugin-helpers.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/6/2025 at 11:06 AM.
 */

declare( strict_types=1 );

use Revolux\Core\Plugin_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Check if Kirki is active.
 *
 * @since 0.2.0
 * @return bool
 */
function revolux_is_kirki_active(): bool {
	return class_exists( 'Kirki' );
}

/**
 * Check if Elementor is active.
 *
 * @since 0.2.0
 * @return int|null
 */
function revolux_is_elementor_active(): ?int {
	return did_action( 'elementor/loaded' );
}

/**
 * Check if Contact Form 7 is active.
 *
 * @since 0.2.0
 * @return bool
 */
function revolux_is_cf7_active(): bool {
	return class_exists( 'WPCF7' );
}

/**
 * Check if Mailchimp for WooCommerce is active.
 *
 * @since 0.2.0
 * @return bool
 */
function revolux_is_mailchimp_active(): bool {
	return class_exists( 'MailChimp_WordPress' );
}

/**
 * Check if Yoast SEO is active.
 *
 * @since 0.2.0
 * @return bool
 */
function revolux_is_yoast_active(): bool {
	return defined( 'WPSEO_VERSION' );
}

/**
 * Check if WooCommerce is active.
 *
 * @since 0.2.0
 * @return bool
 */
function revolux_is_woocommerce_active(): bool {
	return class_exists( 'WooCommerce' );
}

/**
 * Get plugin manager instance.
 *
 * @since 0.2.0
 * @return Plugin_Manager
 */
function revolux_plugin_manager(): Plugin_Manager {
	return Plugin_Manager::instance();
}

/**
 * Check if a specific plugin is active by slug.
 *
 * @since 0.2.0
 *
 * @param string $plugin_slug Plugin slug to check.
 *
 * @return bool
 */
function revolux_is_plugin_active( string $plugin_slug ): bool {
	return revolux_plugin_manager()->is_plugin_active( $plugin_slug );
}

/**
 * Get all required plugins.
 *
 * @since 0.2.0
 * @return array
 */
function revolux_get_required_plugins(): array {
	return revolux_plugin_manager()->get_required_plugins();
}

/**
 * Get all recommended plugins.
 *
 * @since 0.2.0
 * @return array
 */
function revolux_get_recommended_plugins(): array {
	return revolux_plugin_manager()->get_recommended_plugins();
}
