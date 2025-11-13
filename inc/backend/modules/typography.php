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
 * @filesource  typography.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/4/2025 at 10:17 AM.
 */

defined( 'ABSPATH' ) || exit;


return [
	'panels'   => [],
	'sections' => [
		'typography' => [
			'title'       => esc_html__( 'Typography', 'revolux' ),
			'description' => esc_html__( 'Customize fonts for your site.', 'revolux' ),
			'priority'    => 40,
		],
	],

	'fields' => [
		'typography_enable' => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Enable Custom Typography', 'revolux' ),
			'section'  => 'typography',
			'default'  => false,
			'priority' => 10,
		],

		'body_typography'      => [
			'type'            => 'typography',
			'label'           => esc_html__( 'Body Font', 'revolux' ),
			'section'         => 'typography',
			'default'         => [
				'font-family'    => 'Lexend',
				'variant'        => 'regular',
				'font-size'      => '16px',
				'line-height'    => '1.75',
				'letter-spacing' => '0',
				'color'          => '#4a5568',
				'text-transform' => 'none',
			],
			'priority'        => 20,
			'transport'       => 'auto',
			'output'          => [
				[
					'element' => 'body, p',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'typography_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		// Heading 1.
		'heading_1_typography' => [
			'type'            => 'typography',
			'label'           => esc_html__( 'Heading 1 (H1)', 'revolux' ),
			'section'         => 'typography',
			'default'         => [
				'font-family'    => 'Outfit',
				'variant'        => '600',
				'font-size'      => '48px',
				'line-height'    => '1.2',
				'letter-spacing' => '-0.02em',
				'color'          => '#1a202c',
				'text-transform' => 'none',
			],
			'priority'        => 30,
			'transport'       => 'auto',
			'output'          => [
				[
					'element' => 'h1, .h1, .elementor-widget-heading h1.elementor-heading-title',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'typography_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		// Heading 2.
		'heading_2_typography' => [
			'type'            => 'typography',
			'label'           => esc_html__( 'Heading 2 (H2)', 'revolux' ),
			'section'         => 'typography',
			'default'         => [
				'font-family'    => 'Outfit',
				'variant'        => '600',
				'font-size'      => '40px',
				'line-height'    => '1.3',
				'letter-spacing' => '-0.01em',
				'color'          => '#1a202c',
				'text-transform' => 'none',
			],
			'priority'        => 40,
			'transport'       => 'auto',
			'output'          => [
				[
					'element' => 'h2, .h2, .elementor-widget-heading h2.elementor-heading-title',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'typography_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		// Heading 3.
		'heading_3_typography' => [
			'type'            => 'typography',
			'label'           => esc_html__( 'Heading 3 (H3)', 'revolux' ),
			'section'         => 'typography',
			'default'         => [
				'font-family'    => 'Outfit',
				'variant'        => '600',
				'font-size'      => '32px',
				'line-height'    => '1.4',
				'letter-spacing' => '0',
				'color'          => '#1a202c',
				'text-transform' => 'none',
			],
			'priority'        => 50,
			'transport'       => 'auto',
			'output'          => [
				[
					'element' => 'h3, .h3, .elementor-widget-heading h3.elementor-heading-title',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'typography_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		// Heading 4.
		'heading_4_typography' => [
			'type'            => 'typography',
			'label'           => esc_html__( 'Heading 4 (H4)', 'revolux' ),
			'section'         => 'typography',
			'default'         => [
				'font-family'    => 'Outfit',
				'variant'        => '500',
				'font-size'      => '24px',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#1a202c',
				'text-transform' => 'none',
			],
			'priority'        => 60,
			'transport'       => 'auto',
			'output'          => [
				[
					'element' => 'h4, .h4, .elementor-widget-heading h4.elementor-heading-title',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'typography_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		// Heading 5.
		'heading_5_typography' => [
			'type'            => 'typography',
			'label'           => esc_html__( 'Heading 5 (H5)', 'revolux' ),
			'section'         => 'typography',
			'default'         => [
				'font-family'    => 'Outfit',
				'variant'        => '500',
				'font-size'      => '20px',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#1a202c',
				'text-transform' => 'none',
			],
			'priority'        => 70,
			'transport'       => 'auto',
			'output'          => [
				[
					'element' => 'h5, .h5, .elementor-widget-heading h5.elementor-heading-title',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'typography_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		// Heading 6.
		'heading_6_typography' => [
			'type'            => 'typography',
			'label'           => esc_html__( 'Heading 6 (H6)', 'revolux' ),
			'section'         => 'typography',
			'default'         => [
				'font-family'    => 'Outfit',
				'variant'        => '500',
				'font-size'      => '16px',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#1a202c',
				'text-transform' => 'none',
			],
			'priority'        => 80,
			'transport'       => 'auto',
			'output'          => [
				[
					'element' => 'h6, .h6, .elementor-widget-heading h6.elementor-heading-title',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'typography_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
	],
];
