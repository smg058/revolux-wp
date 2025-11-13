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
 * @filesource  general.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/4/2025 at 8:46 AM.
 */

defined( 'ABSPATH' ) || exit;

return [
	'panels' => [
		'general' => [
			'title'    => esc_html__( 'General', 'revolux' ),
			'priority' => 5,
		],
	],

	'sections' => [
		'preloader'   => [
			'title'    => esc_html__( 'Preloader', 'revolux' ),
			'panel'    => 'general',
			'priority' => 10,
		],
		'performance' => [
			'title'    => esc_html__( 'Preloader', 'revolux' ),
			'panel'    => 'general',
			'priority' => 10,
		],
		'scripts'     => [
			'title'       => esc_html__( 'Custom Scripts', 'revolux' ),
			'description' => esc_html__( 'Add custom JavaScript code.', 'revolux' ),
			'panel'       => 'general',
			'priority'    => 30,
		],
	],

	'fields' => [
		'preloader_enable'   => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Enable Preloader', 'revolux' ),
			'section'  => 'preloader',
			'default'  => false,
			'priority' => 10,
		],
		'preloader_type'     => [
			'type'            => 'select',
			'label'           => esc_html__( 'Preloader Type', 'revolux' ),
			'section'         => 'preloader',
			'default'         => 'spinner',
			'priority'        => 20,
			'choices'         => [
				'spinner' => esc_html__( 'Spinner', 'revolux' ),
				'dots'    => esc_html__( 'Dots', 'revolux' ),
				'custom'  => esc_html__( 'Custom Image', 'revolux' ),
			],
			'active_callback' => [
				[
					'setting'  => 'preloader_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'preloader_color'    => [
			'type'            => 'color',
			'label'           => esc_html__( 'Preloader Color', 'revolux' ),
			'section'         => 'preloader',
			'default'         => '#3858e9',
			'priority'        => 30,
			'transport'       => 'auto',
			'output'          => [
				[
					'element'  => '.rev-preloader-spinner',
					'property' => 'border-color',
				],
				[
					'element'  => '.rev-preloader-dots span',
					'property' => 'background-color',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'preloader_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'preloader_bg_color' => [
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'revolux' ),
			'section'         => 'preloader',
			'default'         => '#ffffff',
			'priority'        => 40,
			'transport'       => 'auto',
			'output'          => [
				[
					'element'  => '.rev-preloader',
					'property' => 'background-color',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'preloader_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'preloader_image'    => [
			'type'            => 'image',
			'label'           => esc_html__( 'Custom Preloader Image', 'revolux' ),
			'section'         => 'preloader',
			'default'         => '',
			'priority'        => 50,
			'active_callback' => [
				[
					'setting'  => 'preloader_enable',
					'operator' => '==',
					'value'    => true,
				],
				[
					'setting'  => 'preloader_type',
					'operator' => '==',
					'value'    => 'custom',
				],
			],
		],

		'disable_emojis' => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Disable Emojis', 'revolux' ),
			'section'  => 'performance',
			'default'  => true,
			'priority' => 10,
		],
		'disable_embeds' => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Disable Embeds', 'revolux' ),
			'section'  => 'performance',
			'default'  => false,
			'priority' => 20,
		],
		'header_scripts' => [
			'type'        => 'code',
			'label'       => esc_html__( 'Header Scripts', 'revolux' ),
			'description' => esc_html__( 'Add scripts to `<head>` section (e.g., Google Analytics).', 'revolux' ),
			'section'     => 'scripts',
			'default'     => '',
			'priority'    => 10,
			'choices'     => [
				'language' => 'javascript',
			],
		],
		'footer_scripts' => [
			'type'        => 'code',
			'label'       => esc_html__( 'Footer Scripts', 'revolux' ),
			'description' => esc_html__( 'Add scripts before </body> tag.', 'revolux' ),
			'section'     => 'scripts',
			'default'     => '',
			'priority'    => 20,
			'choices'     => [
				'language' => 'javascript',
			],
		],
	],
];
