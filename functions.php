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
 * @filesource  functions.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/5/2025 at 1:25 PM.
 */

declare( strict_types=1 );
defined( 'ABSPATH' ) || exit;

/**
 * -------------------------------------------------------------------------------------------
 * Define Constants
 * -------------------------------------------------------------------------------------------
 */
$revolux_theme   = wp_get_theme( get_template() );
$revolux_version = $revolux_theme->get( 'Version' );

define( 'REVOLUX_VERSION', $revolux_version );
define( 'REVOLUX_DIR', trailingslashit( get_template_directory() ) );
define( 'REVOLUX_URI', trailingslashit( get_template_directory_uri() ) );
define( 'REVOLUX_INC', trailingslashit( REVOLUX_DIR . 'inc' ) );
define( 'REVOLUX_CORE', trailingslashit( REVOLUX_INC . 'Core' ) );
define( 'REVOLUX_LANG', REVOLUX_DIR . 'languages' );
define( 'REVOLUX_ASSETS_DIR', trailingslashit( REVOLUX_DIR . 'assets' ) );
define( 'REVOLUX_ASSETS_URI', trailingslashit( REVOLUX_URI . 'assets' ) );
define( 'REVOLUX_DEBUG', defined( 'WP_DEBUG' ) && WP_DEBUG );

// Bundled plugin directory.
define( 'REVOLUX_PLUGINS', trailingslashit( REVOLUX_INC . 'extend/plugins' ) );

// Autoloader with fallback.
require_once REVOLUX_CORE . 'Autoloader.php';

// Initialize autoloader.
$revolux_autoloader = new Revolux\Core\Autoloader();
$revolux_autoloader->register();

/**
 * Load helper functions
 *
 * Helper functions should be loaded before the theme initializes so
 * they're available throughout the theme.
 */
require_once REVOLUX_INC . 'helpers/customizer-helpers.php';

/**
 * Initializes the theme.
 *
 * Get the singleton instance of the Theme class.
 */
Revolux\Core\Theme::instance();
