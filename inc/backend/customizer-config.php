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
 * @filesource  customizer-config.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/6/2025 at 12:51 AM.
 */

declare( strict_types=1 );
defined( 'ABSPATH' ) || exit;

// Load configuration modules.
$modules = [
	'general',
	'header',
	'footer',
	'layout',
	'typography',
	'colors',
	'blog',
];

$config = [
	'panels'   => [],
	'sections' => [],
	'fields'   => [],
];

// Load each module and merge configurations.
foreach ( $modules as $module ) {
	$module_file = trailingslashit( REVOLUX_INC . 'backend/modules' ) . $module . '.php';

	if ( file_exists( $module_file ) ) {
		$module_config = require $module_file;

		if ( is_array( $module_config ) ) {
			$config['panels']   = array_merge( $config['panels'], $module_config['panels'] ?? [] );
			$config['sections'] = array_merge( $config['sections'], $module_config['sections'] ?? [] );
			$config['fields']   = array_merge( $config['fields'], $module_config['fields'] ?? [] );
		}
	}
}

return $config;
