<?php
/**
 * Revolux
 *
 * A modern, modular and multi-purpose WordPress theme.
 *
 * @version     0.2.0
 * @package     revolux
 * @author      Chayson Media <dev@chayson.com>
 * @filesource  Autoloader.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/themes/wp/revolux/
 *
 * Created on 11/6/2025 at 12:20 AM.
 */

namespace Revolux\Core;

/**
 * Autoloader class.
 *
 * @since 0.2.0
 */
class Autoloader {

	/**
	 * Namespace prefix.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var string
	 */
	private string $namespace_prefix = 'Revolux\\';

	/**
	 * Base directory for the namespace prefix.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var string
	 */
	private string $base_dir;

	/**
	 * Constructor.
	 *
	 * @since  0.2.0
	 * @access public
	 */
	public function __construct() {
		$this->base_dir = REVOLUX_INC;
	}

	/**
	 * Register autoloader.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function register(): void {
		spl_autoload_register( [ $this, 'autoload' ] );
	}

	/**
	 * Autoload classes.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param string $the_class The fully-qualified class name.
	 *
	 * @return void
	 */
	public function autoload( string $the_class ): void {
		// Check if the class uses the namespace prefix.
		$len = strlen( $this->namespace_prefix );
		if ( strncmp( $this->namespace_prefix, $the_class, $len ) !== 0 ) {
			return;
		}

		// Get the relative class name.
		$relative_class = substr( $the_class, $len );

		// Replace namespace separator with directory separator.
		// Replace underscores with hyphens in file name.
		$file = $this->base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

		// If the file exists, require it.
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}

	/**
	 * Load file manually.
	 *
	 * Helper method to manually load a class file.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param string $class_name   Class name (without namespace).
	 * @param string $subdirectory Optional subdirectory within inc/.
	 *
	 * @return bool True if file was loaded, false otherwise.
	 */
	public function load_file( string $class_name, string $subdirectory = 'Core' ): bool {
		$file = $this->base_dir . $subdirectory . '/' . $class_name . '.php';

		if ( file_exists( $file ) ) {
			require_once $file;

			return true;
		}

		return false;
	}
}
