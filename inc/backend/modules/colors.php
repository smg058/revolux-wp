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
 * @filesource  colors.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/3/2025 at 5:42 PM.
 */

defined( 'ABSPATH' ) || exit;

return [
	'panels' => [],

	'sections' => [
		'colors' => [
			'title'       => esc_html__( 'Color Scheme', 'revolux' ),
			'description' => esc_html__( 'Customize the color palette for your site.', 'revolux' ),
			'priority'    => 50,
		],
	],

	'fields' => [
		// Primary color
		'primary_color'   => [
			'type'      => 'color',
			'label'     => esc_html__( 'Primary Color', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#3858e9',
			'priority'  => 10,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--rev-primary-color',
				],
				[
					'element'  => '.btn-primary, .primary-bg',
					'property' => 'background-color',
				],
				[
					'element'  => 'a:hover, .primary-color',
					'property' => 'color',
				],
			],
		],

		// Secondary color
		'secondary_color' => [
			'type'      => 'color',
			'label'     => esc_html__( 'Secondary Color', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#ffc800',
			'priority'  => 20,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--rev-secondary-color',
				],
				[
					'element'  => '.btn-secondary, .secondary-bg',
					'property' => 'background-color',
				],
				[
					'element'  => '.secondary-color',
					'property' => 'color',
				],
			],
		],

		// Accent color
		'accent_color'    => [
			'type'      => 'color',
			'label'     => esc_html__( 'Accent Color', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#e63946',
			'priority'  => 30,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--rev-accent-color',
				],
				[
					'element'  => '.accent-bg',
					'property' => 'background-color',
				],
				[
					'element'  => '.accent-color',
					'property' => 'color',
				],
			],
		],

		// Body background
		'body_bg_color'   => [
			'type'      => 'color',
			'label'     => esc_html__( 'Body Background', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#ffffff',
			'priority'  => 40,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => 'body',
					'property' => 'background-color',
				],
			],
		],

		// Text colors
		'text_color'      => [
			'type'      => 'color',
			'label'     => esc_html__( 'Text Color', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#4a5568',
			'priority'  => 50,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => 'body, p',
					'property' => 'color',
				],
			],
		],

		'heading_color' => [
			'type'      => 'color',
			'label'     => esc_html__( 'Heading Color', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#1a202c',
			'priority'  => 60,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6',
					'property' => 'color',
				],
			],
		],

		'link_color' => [
			'type'      => 'color',
			'label'     => esc_html__( 'Link Color', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#3858e9',
			'priority'  => 70,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => 'a',
					'property' => 'color',
				],
			],
		],

		'link_hover_color' => [
			'type'      => 'color',
			'label'     => esc_html__( 'Link Hover Color', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#2541c7',
			'priority'  => 80,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => 'a:hover, a:focus',
					'property' => 'color',
				],
			],
		],

		// Border color
		'border_color'     => [
			'type'      => 'color',
			'label'     => esc_html__( 'Border Color', 'revolux' ),
			'section'   => 'colors',
			'default'   => '#e2e8f0',
			'priority'  => 90,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ':root',
					'property' => '--rev-border-color',
				],
			],
		],
	],
];
