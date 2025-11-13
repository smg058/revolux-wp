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
 * @filesource  blog.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/4/2025 at 10:23 AM.
 */

defined( 'ABSPATH' ) || exit;

return [
	'panels' => [
		'blog' => [
			'title'    => esc_html__( 'Blog', 'revolux' ),
			'priority' => 60,
		],
	],

	'sections' => [
		'blog_archive' => [
			'title'    => esc_html__( 'Blog Archive', 'revolux' ),
			'panel'    => 'blog',
			'priority' => 10,
		],
		'blog_single'  => [
			'title'    => esc_html__( 'Single Post', 'revolux' ),
			'panel'    => 'blog',
			'priority' => 20,
		],
	],
	'fields'   => [
		'blog_layout'            => [
			'type'     => 'radio-image',
			'label'    => esc_html__( 'Blog Layout', 'revolux' ),
			'section'  => 'blog_archive',
			'default'  => 'grid',
			'priority' => 10,
			'choices'  => [
				'list'    => REVOLUX_ASSETS_URI . 'images/admin/blog-list.png',
				'grid'    => REVOLUX_ASSETS_URI . 'images/admin/blog-grid.png',
				'masonry' => REVOLUX_ASSETS_URI . 'images/admin/blog-masonry.png',
			],
		],
		'blog_columns'           => [
			'type'            => 'radio-buttonset',
			'label'           => esc_html__( 'Columns', 'revolux' ),
			'section'         => 'blog_archive',
			'default'         => '2',
			'priority'        => 20,
			'choices'         => [
				'2' => '2',
				'3' => '3',
				'4' => '4',
			],
			'active_callback' => [
				[
					'setting'  => 'blog_layout',
					'operator' => 'in',
					'value'    => [ 'grid', 'masonry' ],
				],
			],
		],
		'blog_sidebar'           => [
			'type'     => 'radio-buttonset',
			'label'    => esc_html__( 'Sidebar Position', 'revolux' ),
			'section'  => 'blog_archive',
			'default'  => 'right',
			'priority' => 30,
			'choices'  => [
				'none'  => esc_html__( 'No Sidebar', 'revolux' ),
				'left'  => esc_html__( 'Left', 'revolux' ),
				'right' => esc_html__( 'Right', 'revolux' ),
			],
		],
		'blog_excerpt_length'    => [
			'type'     => 'number',
			'label'    => esc_html__( 'Excerpt Length', 'revolux' ),
			'section'  => 'blog_archive',
			'default'  => 30,
			'priority' => 40,
			'choices'  => [
				'min'  => 10,
				'max'  => 100,
				'step' => 5,
			],
		],
		'blog_show_author'       => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Author', 'revolux' ),
			'section'  => 'blog_archive',
			'default'  => true,
			'priority' => 50,
		],
		'blog_show_date'         => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Date', 'revolux' ),
			'section'  => 'blog_archive',
			'default'  => true,
			'priority' => 60,
		],
		'blog_show_categories'   => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Categories', 'revolux' ),
			'section'  => 'blog_archive',
			'default'  => true,
			'priority' => 70,
		],
		'blog_show_excerpt'      => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Excerpt', 'revolux' ),
			'section'  => 'blog_archive',
			'default'  => true,
			'priority' => 80,
		],
		'blog_read_more_text'    => [
			'type'     => 'text',
			'label'    => esc_html__( 'Read More Text', 'revolux' ),
			'section'  => 'blog_archive',
			'default'  => esc_html__( 'Read More', 'revolux' ),
			'priority' => 90,
		],

		// Single post settings.
		'single_sidebar'         => [
			'type'     => 'radio-buttonset',
			'label'    => esc_html__( 'Sidebar Position', 'revolux' ),
			'section'  => 'blog_single',
			'default'  => 'right',
			'priority' => 10,
			'choices'  => [
				'none'  => esc_html__( 'No Sidebar', 'revolux' ),
				'left'  => esc_html__( 'Left', 'revolux' ),
				'right' => esc_html__( 'Right', 'revolux' ),
			],
		],
		'single_show_author_box' => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Author Box', 'revolux' ),
			'section'  => 'blog_single',
			'default'  => true,
			'priority' => 20,
		],
		'single_show_tags'       => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Tags', 'revolux' ),
			'section'  => 'blog_single',
			'default'  => true,
			'priority' => 30,
		],
		'single_show_share'      => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Social Share', 'revolux' ),
			'section'  => 'blog_single',
			'default'  => true,
			'priority' => 40,
		],
		'single_show_related'    => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Related Posts', 'revolux' ),
			'section'  => 'blog_single',
			'default'  => true,
			'priority' => 50,
		],
		'single_related_count'   => [
			'type'            => 'number',
			'label'           => esc_html__( 'Related Posts Count', 'revolux' ),
			'section'         => 'blog_single',
			'default'         => 3,
			'priority'        => 60,
			'choices'         => [
				'min'  => 2,
				'max'  => 12,
				'step' => 1,
			],
			'active_callback' => [
				[
					'setting'  => 'single_show_related',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'single_post_navigation' => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Post Navigation', 'revolux' ),
			'section'  => 'blog_single',
			'default'  => true,
			'priority' => 70,
		],
	],
];
