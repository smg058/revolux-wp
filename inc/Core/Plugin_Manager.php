<?php
/**
 * Revolux
 *
 * A modern, modular and multi-purpose WordPress theme.
 *
 * @version     0.2.0
 * @package     revolux
 * @author      Chayson Media <dev@chayson.com>
 * @filesource  Plugin_Manager.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/themes/wp/revolux/
 *
 * Created on 11/6/2025 at 10:25 AM.
 */

namespace Revolux\Core;

/**
 * Plugin Manager class.
 *
 * Handles TGMPA integration for required and recommended plugins.
 *
 * @since 0.2.0
 */
class Plugin_Manager {

	/**
	 * Plugin Manager instance.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @static
	 * @var Plugin_Manager|null
	 */
	protected static ?Plugin_Manager $instance = null;

	/**
	 * Required plugins.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var array
	 */
	private array $required_plugins = [];

	/**
	 * Recommended plugins.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var array
	 */
	private array $recommended_plugins = [];

	/**
	 * Get Plugin Manager Instance.
	 *
	 * @since  0.2.0
	 * @access public
	 * @static
	 * @return Plugin_Manager
	 */
	public static function instance(): Plugin_Manager {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @since  0.2.0
	 * @access private
	 */
	private function __construct() {
		$this->setup_plugins();
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function init_hooks(): void {
		add_action( 'tgmpa_register', [ $this, 'register_plugins' ] );
	}

	/**
	 * Setup plugin arrays.
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function setup_plugins(): void {

		// Required plugins.
		$this->required_plugins = [
			[
				'name'     => esc_html__( 'Revolux Core Plugin', 'revolux' ),
				'slug'     => 'revolux-core',
				'source'   => REVOLUX_PLUGINS . 'revolux-core.zip',
				'required' => true,
			],
			[
				'name'     => esc_html__( 'Kirki Customizer Framework', 'revolux' ),
				'slug'     => 'kirki',
				'required' => true,
			],
			[
				'name'     => esc_html__( 'Elementor Page Builder', 'revolux' ),
				'slug'     => 'elementor',
				'required' => true,
			],
		];

		// Recommended plugins.
		$this->recommended_plugins = [
			[
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => false,
			],
			[
				'name'     => 'Mailchimp for WordPress',
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'Contact Form 7', 'revolux' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'Yoast SEO', 'revolux' ),
				'slug'     => 'wordpress-seo',
				'required' => false,
			],
			[
				'name'     => esc_html__( 'One Click Demo Import', 'revolux' ),
				'slug'     => 'one-click-demo-import',
				'required' => false,
			],
		];

		/**
		 * Filter required plugins.
		 *
		 * @since 0.2.0
		 *
		 * @param array $required_plugins Array of required plugin configurations.
		 */
		$this->required_plugins = apply_filters( 'revolux_required_plugins', $this->required_plugins );

		/**
		 * Filter recommended plugins.
		 *
		 * @since 0.2.0
		 *
		 * @param array $recommended_plugins Array of recommended plugin configurations.
		 */
		$this->recommended_plugins = apply_filters( 'revolux_recommended_plugins', $this->recommended_plugins );
	}

	/**
	 * Register plugins with TGMPA.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function register_plugins(): void {

		// Combine required and recommended plugins.
		$plugins = array_merge( $this->required_plugins, $this->recommended_plugins );

		// TGMPA configuration.
		$config = [
			'id'           => 'revolux',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
			'strings'      => [
				'page_title'                      => esc_html__( 'Install Required Plugins', 'revolux' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'revolux' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'revolux' ),
				'updating'                        => esc_html__( 'Updating Plugin: %s', 'revolux' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'revolux' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'revolux'
				),
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'revolux'
				),
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'revolux'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'revolux'
				),
				'notice_can_activate_required'    => _n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'revolux'
				),
				'notice_can_activate_recommended' => _n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'revolux'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'revolux'
				),
				'update_link'                     => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'revolux'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'revolux'
				),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'revolux' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'revolux' ),
				'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'revolux' ),
				'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'revolux' ),
				'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'revolux' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'revolux' ),
				'dismiss'                         => esc_html__( 'Dismiss this notice', 'revolux' ),
				'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'revolux' ),
				'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'revolux' ),
				'nag_type'                        => 'updated',
			],
		];

		tgmpa( $plugins, $config );
	}

	/**
	 * Get required plugins.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return array
	 */
	public function get_required_plugins(): array {
		return $this->required_plugins;
	}

	/**
	 * Get recommended plugins.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return array
	 */
	public function get_recommended_plugins(): array {
		return $this->recommended_plugins;
	}

	/**
	 * Check if a plugin is active.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param string $plugin_slug Plugin slug to check.
	 *
	 * @return bool
	 */
	public function is_plugin_active( string $plugin_slug ): bool {
		$plugin_path = $this->get_plugin_path( $plugin_slug );

		if ( ! $plugin_path ) {
			return false;
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return is_plugin_active( $plugin_path );
	}

	/**
	 * Get plugin path from slug.
	 *
	 * @since  0.2.0
	 * @access private
	 *
	 * @param string $plugin_slug Plugin slug.
	 *
	 * @return string|false Plugin path or false if not found.
	 */
	private function get_plugin_path( string $plugin_slug ): string|false {
		$plugin_paths = [
			'kirki'                   => 'kirki/kirki.php',
			'elementor'               => 'elementor/elementor.php',
			'revolux-core'            => 'revolux-core/revolux-core.php',
			'contact-form-7'          => 'contact-form-7/wp-contact-form-7.php',
			'mailchimp-for-wordpress' => 'mailchimp-for-wp/mailchimp-for-wp.php',
			'wordpress-seo'           => 'wordpress-seo/wp-seo.php',
		];

		return $plugin_pathsp[ $plugin_slug ] ?? false;
	}

	/**
	 * Clone prevention.
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function __clone(): void {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden.', 'revolux' ), REVOLUX_VERSION );
	}

	/**
	 * Unserialize prevention.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function __wakeup(): void {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing is forbidden.', 'revolux' ), REVOLUX_VERSION );
	}
}
