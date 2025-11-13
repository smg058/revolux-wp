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
 * @filesource  layout.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/4/2025 at 10:07 AM.
 */

defined( 'ABSPATH' ) || exit;

return [
	'panels' => [],

	'sections' => [
		'layout' => [
			'title'       => esc_html__( 'Layout', 'revolux' ),
			'description' => esc_html__( 'Control the overall site layout and container widths.', 'revolux' ),
			'priority'    => 35,
		],
	],

	'fields' => [
		'container_width' => [
			'type'      => 'slider',
			'label'     => esc_html__( 'Container Width', 'revolux' ),
			'section'   => 'layout',
			'default'   => 1320,
			'priority'  => 10,
			'choices'   => [
				'min'  => 960,
				'max'  => 1920,
				'step' => 10,
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element'       => '.container',
					'property'      => 'max-width',
					'value-pattern' => '$px',
				],
			],
		],
		'container_type'  => [
			'type'     => 'radio-buttonset',
			'label'    => esc_html__( 'Container Type', 'revolux' ),
			'section'  => 'layout',
			'default'  => 'standard',
			'priority' => 20,
			'choices'  => [
				'boxed'    => esc_html__( 'Boxed', 'revolux' ),
				'standard' => esc_html__( 'Standard', 'revolux' ),
				'wide'     => esc_html__( 'Wide', 'revolux' ),
			],
		],
		'content_padding' => [
			'type'      => 'dimensions',
			'label'     => esc_html__( 'Content Padding', 'revolux' ),
			'section'   => 'layout',
			'default'   => [
				'top'    => '80px',
				'bottom' => '80px',
			],
			'priority'  => 30,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => '.rev-main',
					'property' => 'padding',
				],
			],
		],
		'sidebar_width'   => [
			'type'      => 'slider',
			'label'     => esc_html__( 'Sidebar Width', 'revolux' ),
			'section'   => 'layout',
			'default'   => 30,
			'priority'  => 40,
			'choices'   => [
				'min'  => 20,
				'max'  => 40,
				'step' => 1,
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element'       => '.rev-sidebar',
					'property'      => 'width',
					'value_pattern' => '$%',
				],
			],
		],
		'sidebar_gap'     => [
			'type'      => 'slider',
			'label'     => esc_html__( 'Sidebar Gap', 'revolux' ),
			'section'   => 'layout',
			'default'   => 40,
			'priority'  => 50,
			'choices'   => [
				'min'  => 20,
				'max'  => 80,
				'step' => 5,
			],
			'transport' => 'auto',
			'output'    => [
				[
					'element'       => '.rev-content-area.has-sidebar',
					'property'      => 'gap',
					'value_pattern' => '$px',
				],
			],
		],
		'mobile_sidebar'  => [
			'type'     => 'radio-buttonset',
			'label'    => esc_html__( 'Mobile Sidebar Position', 'revolux' ),
			'section'  => 'layout',
			'default'  => 'bottom',
			'priority' => 60,
			'choices'  => [
				'top'    => esc_html__( 'Top', 'revolux' ),
				'bottom' => esc_html__( 'Bottom', 'revolux' ),
				'hidden' => esc_html__( 'Hidden', 'revolux' ),
			],
		],
	],
];
