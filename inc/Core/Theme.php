<?php
/**
 * Revolux
 *
 * A modern, modular and multi-purpose WordPress theme.
 *
 * @version     0.2.0
 * @package     revolux
 * @author      Chayson Media <dev@chayson.com>
 * @filesource  Theme.php
 * @license     LICENSE.md
 * @link        https://chayson.com/themes/wp/revolux/
 */

namespace Revolux\Core;

use WP_User;

/**
 * Main theme class.
 *
 * Singleton class that handles all frontend theme setup and functionality.
 *
 * @since 0.2.0
 */
final class Theme {

	/**
	 * Theme instance.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @static
	 * @var Theme|null
	 */
	protected static ?Theme $instance = null;

	/**
	 * Image sizes.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var array
	 */
	private array $image_sizes = [
		'revolux-featured'  => [ 1200, 675, true ],   // 16:9 aspect ratio
		'revolux-thumbnail' => [ 400, 300, true ],    // 4:3 aspect ratio
		'revolux-square'    => [ 600, 600, true ],    // Square for grid layouts
		'revolux-portrait'  => [ 600, 800, true ],    // Portrait for team members
		'revolux-wide'      => [ 1920, 600, true ],   // Wide for hero sections
	];

	/**
	 * Navigation menus.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var array
	 */
	private array $nav_menus = [
		'primary' => 'Primary Navigation',
		'mobile'  => 'Mobile Navigation',
		'footer'  => 'Footer Navigation',
		'top-bar' => 'Top Bar Navigation',
	];

	/**
	 * Widget areas.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var array
	 */
	private array $widget_areas = [
		'sidebar-primary' => [
			'name'        => 'Primary Sidebar',
			'description' => 'Main sidebar that appears on the right.',
		],
		'sidebar-shop'    => [
			'name'        => 'Shop Sidebar',
			'description' => 'Sidebar for shop pages.',
		],
		'footer-1'        => [
			'name'        => 'Footer Column 1',
			'description' => 'First footer widget area.',
		],
		'footer-2'        => [
			'name'        => 'Footer Column 2',
			'description' => 'Second footer widget area.',
		],
		'footer-3'        => [
			'name'        => 'Footer Column 3',
			'description' => 'Third footer widget area.',
		],
		'footer-4'        => [
			'name'        => 'Footer Column 4',
			'description' => 'Fourth footer widget area.',
		],
		'header-top'      => [
			'name'        => 'Header Top Bar',
			'description' => 'Widget area in the header top bar.',
		],
	];

	/**
	 * Get theme instance.
	 *
	 * @since  0.2.0
	 * @access public
	 * @static
	 * @return Theme
	 */
	public static function instance(): Theme {
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
		$this->load_dependencies();
		$this->init_hooks();
	}

	/**
	 * Load theme dependencies.
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function load_dependencies(): void {

		// Load TGMPA library.
		$tgmpa_path = REVOLUX_INC . 'extend/class-tgm-plugin-activation.php';
		if ( file_exists( $tgmpa_path ) ) {
			require_once $tgmpa_path;
		}

		// Load plugin helper functions.
		require_once REVOLUX_INC . 'helpers/plugin-helpers.php';

		// Initialize Plugin Manager.
		// Correct class name: TGM_Plugin_Activation.
		if ( class_exists( 'TGM_Plugin_Activation' ) ) {
			Plugin_Manager::instance();
		}
	}

	/**
	 * Initialize hooks.
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function init_hooks(): void {

		// Core theme setup.
		add_action( 'after_setup_theme', [ $this, 'setup_theme' ], 10 );
		add_action( 'after_setup_theme', [ $this, 'content_width' ], 0 );
		add_action( 'after_setup_theme', [ $this, 'load_backend' ], 0 );
		add_action( 'after_setup_theme', [ $this, 'load_textdomain' ], 15 );
		add_action( 'after_setup_theme', [ $this, 'load_helpers' ], 20 );

		// Register theme components.
		add_action( 'init', [ $this, 'register_menus' ], 5 );
		add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
		add_action( 'init', [ $this, 'add_image_sizes' ], 5 );

		// Frontend assets.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ], 10 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 10 );

		// Head
		add_action( 'wp_head', [ $this, 'meta_charset' ], 0 );
		add_action( 'wp_head', [ $this, 'meta_viewport' ], 1 );
		add_action( 'wp_head', [ $this, 'meta_generator' ], 1 );
		add_action( 'wp_head', [ $this, 'preload_assets' ], 2 );
		add_action( 'wp_head', [ $this, 'add_pingback' ], 3 );

		// Theme modifications (ensure correct accepted args).
		add_filter( 'body_class', [ $this, 'body_classes' ], 10, 2 );
		add_filter( 'post_class', [ $this, 'post_classes' ], 10, 3 );
		add_filter( 'comment_class', [ $this, 'comment_classes' ], 10, 4 );
		add_filter( 'excerpt_length', [ $this, 'excerpt_length' ] );
		add_filter( 'excerpt_more', [ $this, 'excerpt_more' ] );
		add_filter( 'upload_mimes', [ $this, 'custom_mime_types' ] );

		// Performance optimization.
		add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_unnecessary_assets' ], 100 );
		add_filter( 'wp_resource_hints', [ $this, 'resource_hints' ], 10, 2 );
		add_action( 'init', [ $this, 'disable_emojis' ] );

		// WooCommerce specific.
		if ( class_exists( 'WooCommerce' ) ) {
			add_action( 'after_setup_theme', [ $this, 'woocommerce_setup' ], 25 );
			add_action( 'woocommerce_enqueue_styles', '__return_empty_array' );
		}
	}

	/**
	 * Setup theme defaults and register support for various WordPress features.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function setup_theme(): void {

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		// Switch default core markup to output valid HTML5
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			]
		);

		// Add support for Block Styles
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embedded content
		add_theme_support( 'responsive-embeds' );

		// Add support for custom logo
		add_theme_support(
			'custom-logo',
			[
				'height'      => 100,
				'width'       => 350,
				'flex-height' => true,
				'flex-width'  => true,
			]
		);

		// Add support for customize selective refresh widgets
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for align wide blocks
		add_theme_support( 'align-wide' );

		// Add support for editor styles
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor-style.css' );

		// Starter content for new sites
		add_theme_support( 'starter-content', $this->get_starter_content() );
	}

	/**
	 * Set the content width in pixels.
	 *
	 * @global int $content_width
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function content_width(): void {
		$GLOBALS['content_width'] = apply_filters( 'revolux_content_width', 1200 );
	}

	/**
	 * Load theme textdomain for translations.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function load_textdomain(): void {
		load_theme_textdomain( 'revolux', REVOLUX_LANG );
	}

	/**
	 * Load helper functions.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function load_helpers(): void {

		// Helpers directory.
		$helpers_dir = trailingslashit( REVOLUX_INC . 'helpers' );

		// If helpers directory doesn't exist, bail.
		if ( ! is_dir( $helpers_dir ) ) {
			return;
		}

		$helper_files = [
			'template-tags.php',
			'utilities.php',
			'conditionals.php',
			'hooks.php',
		];

		foreach ( $helper_files as $file ) {
			$file_path = $helpers_dir . $file;
			if ( file_exists( $file_path ) ) {
				require_once $file_path;
			}
		}
	}

	/**
	 * Load backend / customizer.
	 *
	 * Initialize the Backend class for Kirki customizer integration.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function load_backend(): void {
		Backend::instance();
	}

	/**
	 * Register navigation menus.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function register_menus(): void {

		$menus = array_map(
			function ( $description ) {
				return esc_html__( $description, 'revolux' );
			},
			$this->nav_menus
		);

		register_nav_menus( $menus );
	}

	/**
	 * Register widget areas.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function register_sidebars(): void {

		foreach ( $this->widget_areas as $id => $args ) {
			register_sidebar(
				[
					'id'            => $id,
					'name'          => esc_html__( $args['name'], 'revolux' ),
					'description'   => esc_html__( $args['description'], 'revolux' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				]
			);
		}
	}

	/**
	 * Custom image sizes.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function add_image_sizes(): void {
		foreach ( $this->image_sizes as $name => $size ) {
			add_image_size( $name, $size[0], $size[1], $size[2] );
		}
	}

	/**
	 * Enqueue theme styles.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function enqueue_styles(): void {
		// Vendor styles (if any third-party CSS is bundled)
		if ( file_exists( REVOLUX_ASSETS_DIR . 'css/vendor.css' ) ) {
			wp_enqueue_style(
				'revolux-vendor',
				REVOLUX_ASSETS_URI . 'css/vendor.css',
				[],
				REVOLUX_VERSION
			);
		}

		// Main theme styles.
		wp_enqueue_style(
			'revolux-main',
			REVOLUX_ASSETS_URI . 'css/main.css',
			[ 'revolux-vendor' ],
			REVOLUX_VERSION
		);

		// WooCommerce Styles.
		if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product() || is_product_category() || is_cart() || is_checkout() || is_account_page() ) ) {
			wp_enqueue_style(
				'revolux-woocommerce',
				REVOLUX_ASSETS_URI . 'css/woocommerce.css',
				[ 'revolux-main' ],
				REVOLUX_VERSION
			);
		}

		// RTL Styles.
		if ( is_rtl() ) {
			wp_enqueue_style(
				'revolux-rtl',
				REVOLUX_ASSETS_URI . 'css/main-rtl.css',
				[ 'revolux-main' ],
				REVOLUX_VERSION
			);
		}
	}

	/**
	 * Enqueue theme scripts.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts(): void {
		// Skip link for keyboard navigation.
		wp_enqueue_script(
			'revolux-skip-link-focus-fix',
			REVOLUX_ASSETS_URI . 'js/skip-link-focus-fix.js',
			[],
			REVOLUX_VERSION,
			true
		);

		// Vendor Scripts.
		if ( file_exists( REVOLUX_ASSETS_DIR . 'js/vendor.js' ) ) {
			wp_enqueue_script(
				'revolux-vendor',
				REVOLUX_ASSETS_URI . 'js/vendor.js',
				[],
				REVOLUX_VERSION,
				true
			);
		}

		// Main theme scripts.
		wp_enqueue_script(
			'revolux-main',
			REVOLUX_ASSETS_URI . 'js/main.js',
			[ 'revolux-vendor' ],
			REVOLUX_VERSION,
			true
		);

		// Localize script with data.
		wp_localize_script(
			'revolux-main',
			'revoluxData',
			[
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'revolux-nonce' ),
				'isRtl'    => is_rtl(),
				'isMobile' => wp_is_mobile(),
				'strings'  => [
					'loading' => esc_html__( 'Loading...', 'revolux' ),
					'error'   => esc_html__( 'An error occurred. Please try again.', 'revolux' ),
					'success' => esc_html__( 'Success!', 'revolux' ),
				],
			]
		);

		// Comment reply.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Preload critical assets.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function preload_assets(): void {
		// Preload the main stylesheet.
		echo '<link rel="preload" href="' . esc_url( REVOLUX_ASSETS_URI . 'css/main.css' ) . '" as="style">' . "\n";

		// Google font preloads.
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	}

	/**
	 * Adds the meta charset to the header.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function meta_charset(): void {
		printf(
			'<meta charset="%s" />' . "\n",
			esc_attr( get_bloginfo( 'charset' ) )
		);
	}

	/**
	 * Adds the meta viewport to the header.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function meta_viewport(): void {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";
	}

	/**
	 * Add a meta generator to help with support.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function meta_generator(): void {
		$theme     = wp_get_theme( get_template() );
		$generator = sprintf(
			'<meta name="generator" content="%s %s" />' . "\n",
			esc_attr( $theme->get( 'Name' ) ),
			esc_attr( $theme->get( 'Version' ) )
		);

		echo apply_filters( 'revolux_meta_generator', $generator );
	}

	/**
	 * Add pingback link to head.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function add_pingback(): void {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">' . "\n";
		}
	}

	/**
	 * Main contextual function. This allows code to be used more than once without running hundreds of conditional checks.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return array
	 */
	public function get_context(): array {

		// Set some variables.
		$context   = [];
		$object    = get_queried_object();
		$object_id = get_queried_object_id();

		// Front page of the site.
		if ( is_front_page() ) {
			$context[] = 'home';
		}

		// Blog page.
		if ( is_home() ) {
			$context[] = 'blog';
		} elseif ( is_singular() && $object ) {
			$context[] = 'singular';
			if ( ! empty( $object->post_type ) ) {
				$context[] = "singular-{$object->post_type}";
				$context[] = "singular-{$object->post_type}-{$object_id}";
			}
		} elseif ( is_archive() ) {
			$context[] = 'archive';

			// Post type archives.
			if ( is_post_type_archive() ) {
				$post_type = get_query_var( 'post_type' );

				if ( is_array( $post_type ) ) {
					reset( $post_type );
					$post_type = current( $post_type );
				}

				if ( $post_type ) {
					$context[] = "archive-{$post_type}";
				}
			}

			// Taxonomy archives.
			if ( ( is_tax() || is_category() || is_tag() ) && $object ) {
				$context[] = 'taxonomy';
				if ( ! empty( $object->taxonomy ) ) {
					$context[] = "taxonomy-{$object->taxonomy}";

					$slug = 'post_format' === $object->taxonomy
						? str_replace( 'post-format-', '', $object->slug )
						: $object->slug;

					$context[] = "taxonomy-{$object->taxonomy}-" . sanitize_html_class( $slug, $object->term_id );
				}
			}

			// User/author archives.
			if ( is_author() ) {
				$user_id   = get_query_var( 'author' );
				$context[] = 'user';
				$context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', $user_id ), $user_id );
			}

			// Date archives.
			if ( is_date() ) {
				$context[] = 'date';
				if ( is_year() ) {
					$context[] = 'year';
				}
				if ( is_month() ) {
					$context[] = 'month';
				}
				if ( get_query_var( 'w' ) ) {
					$context[] = 'week';
				}
				if ( is_day() ) {
					$context[] = 'day';
				}
			}

			// Time archive.
			if ( is_time() ) {
				$context[] = 'time';
				if ( get_query_var( 'hour' ) ) {
					$context[] = 'hour';
				}
				if ( get_query_var( 'minute' ) ) {
					$context[] = 'minute';
				}
			}
		} elseif ( is_search() ) {
			$context[] = 'search';
		} elseif ( is_404() ) {
			$context[] = 'error-404';
		}

		return array_map( 'esc_attr', apply_filters( 'revolux_context', array_unique( $context ) ) );
	}

	/**
	 * Filter body_class.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param array        $classes Body classes.
	 * @param string|array $input_class
	 *
	 * @return array
	 */
	public function body_classes( array $classes, string|array $input_class = [] ): array {

		// Text direction.
		$classes[] = is_rtl() ? 'rtl' : 'ltr';

		// Add sidebar class.
		if ( is_active_sidebar( 'sidebar-primary' ) && ! is_page_template( 'templates/full-width.php' ) ) {
			$classes[] = 'has-sidebar';
		}

		// Locale.
		$locale    = get_locale();
		$classes[] = strtolower( str_replace( '_', '-', $locale ) );

		// Check if current theme is parent or child.
		$classes[] = is_child_theme() ? 'child-theme' : 'parent-theme';

		// Add rev-theme.
		$classes[] = 'rev-theme';

		// Multisite check.
		if ( is_multisite() ) {
			$classes[] = 'multisite';
			$classes[] = 'blog-' . get_current_blog_id();
		}

		// Multi Author.
		if ( is_multi_author() ) {
			$classes[] = 'multiauthor';
		}

		// Date classes.
		$time      = time() + ( get_option( 'gmt_offset' ) * 3600 );
		$classes[] = strtolower( gmdate( '\yY \mm \dd \hH l', $time ) );

		// Is the current user logged in.
		$classes[] = is_user_logged_in() ? 'logged-in' : 'logged-out';

		// WP admin bar.
		if ( is_admin_bar_showing() ) {
			$classes[] = 'admin-bar';
		}

		// Add custom background if option is used.
		if ( get_background_image() || get_background_color() ) {
			$classes[] = 'custom-background';
		}

		// Add the custom header class if option is used.
		if ( get_header_image() || ( display_header_text() && get_header_textcolor() ) ) {
			$classes[] = 'custom-header';
		}

		// Add the custom logo class if option is used.
		if ( has_custom_logo() ) {
			$classes[] = 'wp-custom-logo';
		}

		// Add the .display-header-text class if the user chose to display it.
		if ( display_header_text() ) {
			$classes[] = 'display-header-text';
		}

		// Merge with contextual classes (call the method, don't pass the callable).
		$classes = array_merge( $classes, $this->get_context() );

		// Singular.
		if ( is_singular() ) {
			// Page layout.
			$layout = get_post_meta( get_the_ID(), '_revolux_page_layout', true );
			if ( $layout ) {
				$classes[] = 'layout-' . sanitize_html_class( $layout );
			}

			// Post format.
			$post = get_queried_object();
			if ( $post && current_theme_supports( 'post-formats' ) && post_type_supports( $post->post_type, 'post-formats' ) ) {
				$post_format = get_post_format( get_queried_object_id() );
				$classes[]   = $post_format && ! is_wp_error( $post_format )
					? "{$post->post_type}-format-{$post_format}"
					: "{$post->post_type}-format-standard";
			}

			// Attachment mime types.
			if ( is_attachment() ) {
				foreach ( explode( '/', get_post_mime_type() ) as $type ) {
					$classes[] = "attachment-{$type}";
				}
			}
		}

		// Paged views.
		if ( is_paged() ) {
			$classes[] = 'paged';
			$classes[] = 'paged-' . intval( get_query_var( 'paged' ) );
		} elseif ( is_singular() && 1 < get_query_var( 'page' ) ) {
			$classes[] = 'paged';
			$classes[] = 'paged-' . intval( get_query_var( 'page' ) );
		}

		// Input class if it exists.
		if ( $input_class ) {
			$input_class = is_array( $input_class ) ? $input_class : preg_split( '#\s+#', $input_class );
			$classes     = array_merge( $classes, $input_class );
		}

		// Ensure only scalars/strings hit esc_attr().
		$classes = array_filter(
			$classes,
			static fn( $v ) => is_scalar( $v ) || ( is_object( $v ) && method_exists( $v, '__toString' ) )
		);

		return array_map( 'esc_attr', $classes );
	}

	/**
	 * Filters the WordPress 'post_class'.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param array        $classes
	 * @param string|array $input_class
	 * @param int          $post_id
	 *
	 * @return array
	 */
	public function post_classes( array $classes, string|array $input_class = [], int $post_id = 0 ): array {
		if ( is_admin() ) {
			return $classes;
		}

		$_classes  = [];
		$post      = $post_id ? get_post( $post_id ) : null;
		$post_type = get_post_type( $post_id );

		$remove = [ 'hentry', 'post-password-required' ];
		if ( $post_type && post_type_supports( $post_type, 'post-formats' ) ) {
			$remove[] = 'post_format-post-format-' . get_post_format( $post_id );
		}

		// Remove classes.
		$classes = array_diff( $classes, $remove );

		// Add rev-entry and entry.
		$_classes[] = 'rev-entry';
		$_classes[] = 'entry';

		// Author.
		$_classes[] = 'author-' . sanitize_html_class( get_the_author_meta( 'user_nicename' ), get_the_author_meta( 'ID' ) );

		// Password-protected.
		if ( post_password_required( $post ) ) {
			$_classes[] = 'protected';
		}

		// Has excerpt.
		if ( $post_type && post_type_supports( $post_type, 'excerpt' ) && has_excerpt( $post_id ) ) {
			$_classes[] = 'has-excerpt';
		}

		// Has <!--more--> link.
		if ( ! is_singular( $post_type ) && $post && str_contains( (string) $post->post_content, '<!--more' ) ) {
			$_classes[] = 'has-more-link';
		}

		// Has <!--nextpage--> links.
		if ( $post && str_contains( (string) $post->post_content, '<!--nextpage' ) ) {
			$_classes[] = 'has-pages';
		}

		// Input class.
		if ( $input_class ) {
			$input_class = is_array( $input_class ) ? $input_class : preg_split( '#\s+#', $input_class );
			$classes     = array_merge( $classes, $input_class );
		}

		return array_map( 'esc_attr', array_unique( array_merge( $_classes, $classes ) ) );
	}

	/**
	 * Filter comment classes.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param array        $classes
	 * @param string|array $input_class
	 * @param int          $comment_id
	 * @param int          $post_id
	 *
	 * @return array
	 */
	public function comment_classes( array $classes, string|array $input_class = [], int $comment_id = 0, int $post_id = 0 ): array {

		$comment = $comment_id ? get_comment( $comment_id ) : null;

		// If the comment type is 'pingback' or 'trackback', add the 'ping' comment class.
		if ( $comment && in_array( $comment->comment_type, [ 'pingback', 'trackback' ], true ) ) {
			$classes[] = 'ping';
		}

		// User classes to match user role and user.
		if ( $comment && 0 < (int) $comment->user_id ) {

			// Create new user object.
			$user = new WP_User( (int) $comment->user_id );

			// Set a class with user's role(s).
			if ( is_array( $user->roles ) ) {
				foreach ( $user->roles as $role ) {
					$classes[] = sanitize_html_class( "role-{$role}" );
				}
			}
		}

		// Get comment types that are allowed to have an avatar.
		$avatar_types = apply_filters( 'revolux_get_avatar_comment_types', [ 'comment' ] );

		// If avatars are enabled and allowed, add '.has-avatar'.
		if ( get_option( 'show_avatars' ) && $comment && in_array( $comment->comment_type, $avatar_types, true ) ) {
			$classes[] = 'has-avatar';
		}

		// Input class.
		if ( $input_class ) {
			$input_class = is_array( $input_class ) ? $input_class : preg_split( '#\s+#', $input_class );
			$classes     = array_merge( $classes, $input_class );
		}

		return array_map( 'esc_attr', array_unique( $classes ) );
	}

	/**
	 * Change excerpt length.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param int $length Excerpt length.
	 *
	 * @return int
	 */
	public function excerpt_length( int $length ): int {
		if ( is_admin() ) {
			return $length;
		}

		return 25;
	}

	/**
	 * Change excerpt more string.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param string $more More string.
	 *
	 * @return string
	 */
	public function excerpt_more( string $more ): string {
		if ( is_admin() ) {
			return $more;
		}

		return '&hellip;';
	}

	/**
	 * Add custom mime types.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param array $mimes Mime types.
	 *
	 * @return array
	 */
	public function custom_mime_types( array $mimes ): array {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		$mimes['webp'] = 'image/webp';

		return $mimes;
	}

	/**
	 * Dequeue unnecessary assets for performance.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function dequeue_unnecessary_assets(): void {

		// Remove block library CSS if not using gutenberg blocks.
		if ( ! is_singular() || ! has_blocks() ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
		}

		// Remove WooCommerce block CSS if not on WooCommerce pages.
		if ( class_exists( 'WooCommerce' ) ) {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
				wp_dequeue_style( 'wc-blocks-style' );
			}
		}
	}

	/**
	 * Add resource hints for performance.
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param array  $hints         URLs to print for resource hints.
	 * @param string $relation_type The relation type the URLs are printed for.
	 *
	 * @return array
	 */
	public function resource_hints( array $hints, string $relation_type ): array {
		if ( 'dns-prefetch' === $relation_type ) {
			// Add google fonts.
			$hints[] = '//fonts.googleapis.com';
			$hints[] = '//fonts.gstatic.com';
		}

		return $hints;
	}

	/**
	 * Disable WordPress emojis.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function disable_emojis(): void {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		add_filter(
			'tiny_mce_plugins',
			function ( $plugins ) {
				return is_array( $plugins ) ? array_diff( $plugins, [ 'wpemoji' ] ) : [];
			}
		);

		add_filter(
			'wp_resource_hints',
			function ( $urls, $relation_type ) {
				if ( 'dns-prefetch' === $relation_type ) {
					$emoji_svg_url = apply_filters( 'revolux_emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
					$urls          = array_diff( $urls, [ $emoji_svg_url ] );
				}

				return $urls;
			},
			10,
			2
		);
	}

	/**
	 * Setup WooCommerce support.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function woocommerce_setup(): void {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Custom WooCommerce image sizes.
		add_theme_support(
			'woocommerce',
			[
				'thumbnail_image_width' => 300,
				'single_image_width'    => 600,
				'product_grid'          => [
					'default_rows'    => 3,
					'min_rows'        => 1,
					'max_rows'        => 6,
					'default_columns' => 4,
					'min_columns'     => 1,
					'max_columns'     => 6,
				],
			]
		);
	}

	/**
	 * Get starter content for theme.
	 *
	 * @since  0.2.0
	 * @access private
	 * @return array
	 */
	private function get_starter_content(): array {
		return [
			'posts'     => [
				'home'     => [
					'post_title' => esc_html__( 'Home', 'revolux' ),
				],
				'about'    => [
					'post_title' => esc_html__( 'About', 'revolux' ),
				],
				'services' => [
					'post_title' => esc_html__( 'Services', 'revolux' ),
				],
				'contact'  => [
					'post_title' => esc_html__( 'Contact', 'revolux' ),
				],
			],
			'nav_menus' => [
				'primary' => [
					'name'  => esc_html__( 'Primary Menu', 'revolux' ),
					'items' => [
						'page_home',
						'page_about',
						'page_services',
						'page_contact',
					],
				],
			],
		];
	}

	/**
	 * Clone prevention.
	 *
	 * @since  0.2.0
	 * @access private
	 * @return void
	 */
	private function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden.', 'revolux' ), '0.1.0' );
	}

	/**
	 * Unserialize prevention.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing is forbidden.', 'revolux' ), '0.1.0' );
	}
}
