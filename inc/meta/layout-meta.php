<?php
/**
 *
 * Revolux
 *
 * A modern, modular, and multipurpose professional WordPress theme.
 *
 * @version     0.3.0
 * @package     revolux
 * @author      Chayson Media <dev@chayson.com>
 * @filesource  layout-meta.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/13/2025 at 11:04 AM.
 */

declare( strict_types=1 );
defined( 'ABSPATH' ) || exit;

/**
 * Central meta schema for post/page settings.
 *
 * @since 0.3.0
 * @return array
 */
function revolux_get_meta_schema(): array {

	// Shared layout field config.
	$layout_field = [
		'key'         => 'layout',          // logical field key used in revolux_meta().
		'meta_key'    => '_revolux_layout', // actual post_meta key.
		'label'       => __( 'Layout override', 'revolux' ),
		'type'        => 'select',
		'default'     => '',
		'options'     => [
			''                => __( 'Use global setting', 'revolux' ),
			'content-sidebar' => __( 'Content / Sidebar', 'revolux' ),
			'sidebar-content' => __( 'Sidebar / Content', 'revolux' ),
			'full-width'      => __( 'Full width (no sidebar)', 'revolux' ),
		],
		'description' => __( 'Override the global layout for this entry.', 'revolux' ),
	];

	$schema = [
		'post' => [
			'box_id'   => 'revolux-post-settings',
			'title'    => __( 'Post Settings', 'revolux' ),
			'context'  => 'side',
			'priority' => 'default',
			'fields'   => [
				'layout' => $layout_field,
				// @todo Add future post-only fields here (e.g., hero style, header behavior, etc.).
			],
		],
		'page' => [
			'box_id'   => 'revolux-page-settings',
			'title'    => __( 'Page Settings', 'revolux' ),
			'context'  => 'side',
			'priority' => 'default',
			'fields'   => [
				'layout' => $layout_field,
				// @todo Add future page-only fields here.
			],
		],
	];

	/**
	 * Filter the meta schema so child themes / plugins can extend it.
	 *
	 * @param array $schema Meta schema array.
	 */
	return apply_filters( 'revolux_meta_schema', $schema );
}

/**
 * Generic getter for post meta based on the schema.
 *
 * @param string   $field_key Logical field key (e.g., 'layout')
 * @param int|null $post_id   Optional post ID. Defaults to current queried object.
 * @param mixed    $fallback  Optional explicit fallback if no value + no default.
 *
 * @return mixed
 * @example
 *      $layout = revolux_meta( 'layout' );
 *
 */
function revolux_meta( string $field_key, int|null $post_id = null, mixed $fallback = null ): mixed {

	if ( null === $post_id ) {
		$post_id = get_queried_object_id();
	}

	if ( ! $post_id ) {
		return $fallback;
	}

	$post_type = get_post_type( $post_id );
	if ( ! $post_type ) {
		return $fallback;
	}

	$schema = revolux_get_meta_schema();

	if ( ! isset( $schema[ $post_type ]['fields'][ $field_key ] ) ) {
		return $fallback;
	}

	$field    = $schema[ $post_type ]['fields'][ $field_key ];
	$meta_key = $field['meta_key'] ?? '';

	if ( '' === $meta_key ) {
		return $fallback;
	}

	$value = get_post_meta( $post_id, $meta_key, true );

	if ( '' === $value || null === $value ) {
		// Use field default if provided, else explicit fallback.
		return array_key_exists( 'default', $field ) ? $field['default'] : $fallback;
	}

	return $value;
}

/**
 * Layout helper using the new meta abstraction.
 *
 * Priority: per-entry override -> global option -> hard default.
 *
 * @since 0.1.0
 *
 * @param int|null $post_id Post ID.
 *
 * @return string
 */
function revolux_get_layout( int|null $post_id ): string {

	if ( null === $post_id ) {
		$post_id = get_queried_object_id();
	}

	$post_type = $post_id ? get_post_type( $post_id ) : null;

	// Global defaults (theme options).
	$default_blog_layout   = function_exists( 'revolux_get_option' ) ? revolux_get_option( 'blog_layout' ) : 'content-sidebar';
	$default_single_layout = function_exists( 'revolux_get_option' ) ? revolux_get_option( 'single_post_layout' ) : 'content-sidebar';

	$layout = $default_blog_layout;

	if ( is_page( $post_id ) && ! is_home() ) {
		// Per-page override via meta; empty string = use global.
		$override = revolux_meta( 'layout', $post_id, '' );
		$layout   = ( '' !== $override ) ? $override : $default_blog_layout;
	} elseif ( is_single( $post_id ) ) {
		// Per-post override.
		$override = revolux_meta( 'layout', $post_id, '' );
		$layout   = ( '' !== $override ) ? $override : $default_single_layout;
	}

	$allowed = [
		'content-sidebar',
		'sidebar-content',
		'full-width',
	];

	if ( ! in_array( $layout, $allowed, true ) ) {
		$layout = 'content-sidebar';
	}

	/**
	 * Filter the computed layout.
	 *
	 * @param string $layout  Layout slug.
	 * @param int    $post_id Post ID.
	 */
	return apply_filters( 'revolux_layout', $layout, $post_id );
}

/**
 * Bootstrap style content columns based on layout.
 *
 * Usage in templates:
 *      `<div class="<?php revolux_content_columns(); ?>">`
 *
 * @return string
 */
function revolux_get_content_columns() {
	$layout  = revolux_get_layout();
	$classes = [];

	if ( 'content-sidebar' === $layout && is_active_sidebar( 'primary' ) ) {
		$classes[] = 'col-lg-8 col-md-8 col-sm-12 col-xs-12';
	} elseif ( 'sidebar-content' === $layout && is_active_sidebar( 'primary' ) ) {
		$classes[] = 'col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right';
	} else {
		$classes[] = 'col-lg-10 col-lg-offset-1';
	}

	$classes_string = implode( ' ', $classes );

	/**
	 * Filter the content column classes.
	 *
	 * @param string $classes_string Space separated CSS classes.
	 * @param string $layout         Layout slug
	 */
	return apply_filters( 'revolux_content_columns', $classes_string, $layout );
}

/**
 * Print column classes.
 *
 * @since 0.1.0
 * @return void
 */
function revolux_content_columns(): void {
	echo esc_attr( revolux_get_content_columns() );
}


if ( ! function_exists( 'rwmb_meta' ) && ! class_exists( 'RW_Meta_Box' ) ) :

	if ( ! function_exists( 'revolux_register_native_meta_boxes' ) ) :

		/**
		 * Native WP meta boxes. (fallback if meta box plugin is not active).
		 *
		 * @since 0.1.0
		 * @return void
		 */
		function revolux_register_native_meta_boxes(): void {
			$schema = revolux_get_meta_schema();

			foreach ( $schema as $post_type => $config ) {
				if ( empty( $config['box_id'] ) || empty( $config['title'] ) ) {
					continue;
				}

				add_meta_box(
					$config['box_id'],
					$config['title'],
					'revolux_render_native_meta_box',
					$post_type,
					$config['context'] ?? 'normal',
					$config['priority'] ?? 'default',
					[ 'post_type' => $post_type ]
				);
			}
		}

		add_action( 'add_meta_boxes', 'revolux_register_native_meta_boxes' );

	endif;

	if ( ! function_exists( 'revolux_render_native_meta_box' ) ) :

		/**
		 * Generic meta box renderer using schema.
		 *
		 * @since 0.1.0
		 *
		 * @param WP_Post $post    Post object.
		 * @param array   $metabox Meta box args.
		 *
		 * @return void
		 */
		function revolux_render_native_meta_box( WP_Post $post, array $metabox ): void {

			wp_nonce_field( 'revolux_save_meta', 'revolux_meta_nonce' );

			$schema    = revolux_get_meta_schema();
			$post_type = $metabox['args']['post_type'] ?? $post->post_type;

			if ( ! isset( $schema[ $post_type ]['fields'] ) ) {
				return;
			}

			$fields = $schema[ $post_type ]['fields'];

			echo '<div class="rev-meta-box">';

			foreach ( $fields as $field_key => $field ) {
				$meta_key = $field['meta_key'] ?? '';
				if ( '' === $meta_key ) {
					continue;
				}

				$value = get_post_meta( $post->ID, $meta_key, true );
				if ( '' === $value && isset( $field['default'] ) ) {
					$value = $field['default'];
				}

				$label   = isset( $field['label'] ) ?? $field_key;
				$type    = $field['type'] ?? 'text';
				$desc    = isset( $field['description'] ) ?? '';
				$options = isset( $field['options'] ) ?? [];

				echo '<p>';
				echo '<label for="' . esc_attr( $meta_key ) . '"><strong>' . esc_html( $label ) . '</strong></label><br/>';

				switch ( $type ) :

					// Textarea.
					case 'textarea':
						echo '<textarea class="widefat" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" rows="4">';
						echo esc_textarea( $value );
						echo '</textarea>';
						break;

					// Checkbox.
					case 'checkbox':
						echo '<label>';
						echo '<input type="checkbox" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="1" ' . checked( $value, '1', false ) . ' />';
						echo ' ' . esc_html( $label );
						echo '</label>';
						break;

					// Select.
					case 'select':
						echo '<select class="widefat" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '">';
						foreach ( $options as $opt_value => $opt_label ) {
							echo '<option value="' . esc_attr( $opt_value ) . '" ' . selected( $value, $opt_value, false ) . '>';
							echo esc_html( $opt_label );
							echo '</option>';
						}
						echo '</select>';
						break;

					// Number.
					case 'number':
						echo '<input type="number" class="widefat" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $value ) . '" />';
						break;

					// Text.
					case 'text':
					default:
						echo '<input type="text" class="widefat" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $value ) . '" />';
						break;
				endswitch;

				if ( $desc ) {
					echo '<br/><span class="description">' . esc_html( $desc ) . '</span>';
				}

				echo '</p>';
			}

			echo '</div>';
		}

	endif;

	if ( ! function_exists( 'revolux_save_native_meta' ) ) :

		/**
		 * Save native meta fields.
		 *
		 * @since 0.1.0
		 *
		 * @param int $post_id Post ID.
		 *
		 * @return void
		 */
		function revolux_save_native_meta( int $post_id ): void {
			if ( isset( $_POST['revolux_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['revolux_meta_nonce'] ) ), 'revolux_save_meta' ) ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}

			$schema = revolux_get_meta_schema();

			foreach ( $schema as $post_type => $config ) {

				if ( ! isset( $config['fields'] ) ) {
					continue;
				}

				foreach ( $config['fields'] as $field ) {
					if ( empty( $field['meta_key'] ) ) {
						continue;
					}

					$meta_key = $field['meta_key'];

					if ( ! isset( $_POST[ $meta_key ] ) ) {
						// For checkboxes, absence means "off".
						if ( isset( $field['type'] ) && 'checkbox' === $field['type'] ) {
							update_post_meta( $post_id, $meta_key, '0' );
						}
						continue;
					}

					$raw_value = $_POST[ $meta_key ]; // phpcs:ignore WordPress.Security.NonceVerification.Missing

					if ( is_array( $raw_value ) ) {
						$value = array_map( 'sanitize_text_field', wp_unslash( $raw_value ) );
					} else {
						$value = sanitize_text_field( wp_unslash( $raw_value ) );
					}

					update_post_meta( $post_id, $meta_key, $value );
				}
			}
		}

		add_action( 'save_post', 'revolux_save_native_meta' );

	endif;

endif; // end native meta boxes.

/**
 * ==================================================================================
 * Meta Box (metabox.io) integration
 * ==================================================================================
 *
 * This kicks in automatically if the recommended Meta Box plugin is active.
 */

if ( ( function_exists( 'rwmb_meta' ) || class_exists( 'RW_Meta_Box' ) ) && ! function_exists( 'revolux_register_metaboxio_boxes' ) ) :

	/**
	 * Register Meta Box meta boxes based on the same schema.
	 *
	 * @param array $meta_boxes Existing meta boxes.
	 *
	 * @return array
	 */
	function revolux_register_metaboxio_boxes( array $meta_boxes ): array {
		$schema = revolux_get_meta_schema();

		foreach ( $schema as $post_type => $config ) {
			if ( empty( $config['fields'] ) ) {
				continue;
			}

			$fields = [];

			foreach ( $config['fields'] as $field ) {
				if ( empty( $field['meta_key'] ) ) {
					continue;
				}

				$type = $field['type'] ?? 'text';

				// Map our schema to Meta Box config.
				$field_config = [
					'id'   => $field['meta_key'],
					'name' => $field['label'] ?? $field['meta_key'],
					'type' => $type,
				];

				if ( isset( $field['default'] ) ) {
					$field_config['std'] = $field['default'];
				}

				if ( isset( $field['description'] ) && $field['description'] ) {
					$field_config['desc'] = $field['description'];
				}

				if ( 'select' === $type && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
					$field_config['options'] = $field['options'];
				}

				$fields[] = $field_config;
			}

			if ( empty( $fields ) ) {
				continue;
			}

			$meta_boxes[] = [
				'id'         => isset( $config['box_id'] ) ?? 'revolux-meta-' . $post_type,
				'title'      => isset( $config['title'] ) ?? __( 'Settings', 'revolux' ),
				'post_types' => [ $post_type ],
				'context'    => isset( $config['context'] ) ?? 'normal',
				'priority'   => isset( $config['priority'] ) ?? 'default',
				'autosave'   => false,
				'fields'     => $fields,
			];
		}

		return $meta_boxes;
	}

	add_filter( 'rwmb_meta_boxes', 'revolux_register_metaboxio_boxes' );

endif;
