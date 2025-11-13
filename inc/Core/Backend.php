<?php
/**
 * Revolux
 *
 * A modern, modular and multi-purpose WordPress theme.
 *
 * @version     0.2.0
 * @package     revolux
 * @author      Chayson Media <dev@chayson.com>
 * @filesource  Backend.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/themes/wp/revolux/
 *
 * Created on 11/6/2025 at 12:39 AM.
 */

namespace Revolux\Core;

use WP_Customize_Manager;

/**
 * Backend class.
 *
 * @since 0.2.0
 */
class Backend {

	/**
	 * The single instance of the class.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @static
	 * @var Backend|null $instance
	 */
	protected static ?Backend $instance = null;

	/**
	 * Customizer configuration.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var array
	 */
	protected array $config = [];

	/**
	 * Theme identifier for Kirki
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var string
	 */
	protected string $theme_id = 'revolux';

	/**
	 * Guard to avoid adding the same Kirki config multiple times.
	 *
	 * @since  0.1.0
	 * @access private
	 * @static
	 * @var bool
	 */
	private static bool $kirki_config_added = false;

	/**
	 * Main backend instance.
	 *
	 * @since  0.2.0
	 * @access public
	 * @static
	 * @return Backend
	 */
	public static function instance(): Backend {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Backend constructor
	 *
	 * @since  0.2.0
	 * @access private
	 */
	private function __construct() {
		$this->load_config();
		$this->init_hooks();
	}

	/**
	 * Load customizer configuration.
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function load_config(): void {
		// Load main configuration.
		$config_file = REVOLUX_INC . 'backend/customizer-config.php';

		if ( file_exists( $config_file ) ) {
			$this->config = require $config_file;
		}

		// Allow filtering of configuration.
		$this->config = apply_filters( 'revolux_customizer_config', $this->config );
	}

	/**
	 * Initialize hooks
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function init_hooks(): void {
		add_action( 'customize_register', [ $this, 'register_kirki' ], 0 );
		add_action( 'customize_register', [ $this, 'modify_default_sections' ], 20 );
	}

	/**
	 * Register Kirki configuration
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function register_kirki( WP_Customize_Manager $wp_customize ): void {

		// Bail if Kirki is not available.
		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		// Add theme configuration.
		if ( ! self::$kirki_config_added ) {
			\Kirki::add_config(
				$this->theme_id,
				[
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				]
			);
			self::$kirki_config_added = true;
		}

		// Register panels.
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel_id => $panel_settings ) {
				\Kirki::add_panel( $panel_id, $panel_settings );
			}
		}

		// Register sections.
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section_id => $section_settings ) {
				\Kirki::add_section( $section_id, $section_settings );
			}
		}

		// Register fields.
		if ( ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $field_id => $field_settings ) {
				// Auto-set settings key if not provided.
				if ( ! isset( $field_settings['settings'] ) ) {
					$field_settings['settings'] = $field_id;
				}

				\Kirki::add_field( $this->theme_id, $field_settings );
			}
		}
	}

	/**
	 * Modify default WordPress customizer sections
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 *
	 * @return void
	 */
	public function modify_default_sections( WP_Customize_Manager $wp_customize ): void {

		$general_panel_id = 'general';

		if ( class_exists( 'Kirki' ) && ! $wp_customize->get_panel( $general_panel_id ) ) {
			\Kirki::add_panel( $general_panel_id, [
				'title'    => esc_html__( 'General', 'revolux' ),
				'priority' => 5,
			] );
		}

		// Move the default sections to a general panel.
		if ( $wp_customize->get_section( 'title_tagline' ) ) {
			$wp_customize->get_section( 'title_tagline' )->panel = 'general';
		}

		if ( $wp_customize->get_section( 'static_front_page' ) ) {
			$wp_customize->get_section( 'static_front_page' )->panel = 'general';
		}
	}

	/**
	 * Get theme ID.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return string
	 */
	public function get_theme_id(): string {
		return $this->theme_id;
	}

	/**
	 * Get option value
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param string $option_name Option name.
	 *
	 * @return mixed
	 */
	public function get_option( string $option_name ): mixed {
		$default = $this->get_default( $option_name );

		if ( class_exists( 'Kirki' ) ) {
			return \Kirki::get_option( $this->theme_id, $option_name );
		}

		return get_theme_mod( $option_name, $default );
	}

	/**
	 * Get default value for option.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param string $option_name Option name.
	 *
	 * @return mixed
	 */
	public function get_default( string $option_name ): mixed {
		if ( ! isset( $this->config['fields'][ $option_name ] ) ) {
			return false;
		}

		return $this->config['fields'][ $option_name ]['default'] ?? false;
	}

	/**
	 * Clone prevention
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden.', 'revolux' ), REVOLUX_VERSION ); // phpcs:ignore
	}

	/**
	 * Unserialize prevention
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing is forbidden.', 'revolux' ), REVOLUX_VERSION ); // phpcs:ignore
	}
}
