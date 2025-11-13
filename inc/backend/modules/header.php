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
 * @filesource  header.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/4/2025 at 9:13 AM.
 */

defined( 'ABSPATH' ) || exit;

return [
	'panels' => [
		'header' => [
			'title'    => esc_html__( 'Header', 'revolux' ),
			'priority' => 20,
		],
	],

	'sections' => [
		'header_layout' => [
			'title'    => esc_html__( 'Header Layout', 'revolux' ),
			'panel'    => 'header',
			'priority' => 10,
		],
		'header_topbar' => [
			'title'    => esc_html__( 'Top Bar', 'revolux' ),
			'panel'    => 'header',
			'priority' => 20,
		],
		'header_sticky' => [
			'title'    => esc_html__( 'Sticky Header', 'revolux' ),
			'panel'    => 'header',
			'priority' => 30,
		],
		'header_cta'    => [
			'title'    => esc_html__( 'Call to Action', 'revolux' ),
			'panel'    => 'header',
			'priority' => 40,
		],
		'mobile_menu'   => [
			'title'    => esc_html__( 'Mobile Menu', 'revolux' ),
			'panel'    => 'header',
			'priority' => 50,
		],
	],

	'fields' => [
		'header_style'       => [
			'type'     => 'radio-image',
			'label'    => esc_html__( 'Header Style', 'revolux' ),
			'section'  => 'header_layout',
			'default'  => 'style-1',
			'priority' => 10,
			'choices'  => [
				'style-1' => REVOLUX_ASSETS_URI . 'images/admin/header-1.png',
				'style-2' => REVOLUX_ASSETS_URI . 'images/admin/header-2.png',
				'style-3' => REVOLUX_ASSETS_URI . 'images/admin/header-3.png',
			],
		],
		'header_transparent' => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Transparent Header', 'revolux' ),
			'section'  => 'header_layout',
			'default'  => false,
			'priority' => 20,
		],
		'header_bg_color'    => [
			'type'      => 'color',
			'label'     => esc_html__( 'Background Color', 'revolux' ),
			'section'   => 'header_layout',
			'default'   => '#ffffff',
			'priority'  => 30,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => '.rev-header',
					'property' => 'background-color',
				],
			],
		],
		'header_padding'     => [
			'type'      => 'dimensions',
			'label'     => esc_html__( 'Header Padding', 'revolux' ),
			'section'   => 'header_layout',
			'default'   => [
				'top'    => '20px',
				'bottom' => '20px',
			],
			'priority'  => 40,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => '.rev-header .rev-header-inner',
					'property' => 'padding',
				],
			],
		],

		'topbar_enable'   => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Enable Top Bar', 'revolux' ),
			'section'  => 'header_topbar',
			'default'  => false,
			'priority' => 10,
		],
		'topbar_phone'    => [
			'type'            => 'text',
			'label'           => esc_html__( 'Phone Number', 'revolux' ),
			'section'         => 'header_topbar',
			'default'         => '',
			'priority'        => 20,
			'active_callback' => [
				[
					'setting'  => 'topbar_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'topbar_email'    => [
			'type'            => 'text',
			'label'           => esc_html__( 'Email Address', 'revolux' ),
			'section'         => 'header_topbar',
			'default'         => '',
			'priority'        => 30,
			'active_callback' => [
				[
					'setting'  => 'topbar_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'topbar_hours'    => [
			'type'            => 'text',
			'label'           => esc_html__( 'Business Hours', 'revolux' ),
			'section'         => 'header_topbar',
			'default'         => '',
			'priority'        => 40,
			'active_callback' => [
				[
					'setting'  => 'topbar_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'topbar_social'   => [
			'type'            => 'toggle',
			'label'           => esc_html__( 'Show Social Icons', 'revolux' ),
			'section'         => 'header_topbar',
			'default'         => true,
			'priority'        => 50,
			'active_callback' => [
				[
					'setting'  => 'topbar_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'topbar_bg_color' => [
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'revolux' ),
			'section'         => 'header_topbar',
			'default'         => '#f8f9fa',
			'priority'        => 60,
			'transport'       => 'auto',
			'output'          => [
				[
					'element'  => '.rev-header-topbar',
					'property' => 'background-color',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'topbar_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		'sticky_header_enable' => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Enable Sticky Header', 'revolux' ),
			'section'  => 'header_sticky',
			'default'  => true,
			'priority' => 10,
		],
		'sticky_header_mobile' => [
			'type'            => 'toggle',
			'label'           => esc_html__( 'Sticky on Mobile', 'revolux' ),
			'section'         => 'header_sticky',
			'default'         => true,
			'priority'        => 20,
			'active_callback' => [
				[
					'setting'  => 'sticky_header_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'sticky_header_logo'   => [
			'type'            => 'image',
			'label'           => esc_html__( 'Sticky Header Logo', 'revolux' ),
			'description'     => esc_html__( 'Optional different logo for sticky header', 'revolux' ),
			'section'         => 'header_sticky',
			'default'         => '',
			'priority'        => 30,
			'active_callback' => [
				[
					'setting'  => 'sticky_header_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		'header_cta_enable' => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Enable CTA Button', 'revolux' ),
			'section'  => 'header_cta',
			'default'  => true,
			'priority' => 10,
		],
		'header_cta_text'   => [
			'type'            => 'text',
			'label'           => esc_html__( 'Button Text', 'revolux' ),
			'section'         => 'header_cta',
			'default'         => esc_html__( 'Get a Quote', 'revolux' ),
			'priority'        => 20,
			'active_callback' => [
				[
					'setting'  => 'header_cta_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'header_cta_url'    => [
			'type'            => 'link',
			'label'           => esc_html__( 'Button URL', 'revolux' ),
			'section'         => 'header_cta',
			'default'         => '#contact',
			'priority'        => 30,
			'active_callback' => [
				[
					'setting'  => 'header_cta_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'header_cta_style'  => [
			'type'            => 'select',
			'label'           => esc_html__( 'Button Style', 'revolux' ),
			'section'         => 'header_cta',
			'default'         => 'primary',
			'priority'        => 40,
			'choices'         => [
				'primary'   => esc_html__( 'Primary', 'revolux' ),
				'secondary' => esc_html__( 'Secondary', 'revolux' ),
				'outline'   => esc_html__( 'Outline', 'revolux' ),
			],
			'active_callback' => [
				[
					'setting'  => 'header_cta_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],

		'mobile_menu_breakpoint' => [
			'type'     => 'select',
			'label'    => esc_html__( 'Mobile Menu Breakpoint', 'revolux' ),
			'section'  => 'mobile_menu',
			'default'  => '991',
			'priority' => 10,
			'choices'  => [
				'767'  => esc_html__( '768px (Tablet)', 'revolux' ),
				'991'  => esc_html__( '992px (Desktop)', 'revolux' ),
				'1199' => esc_html__( '1200px (Large Desktop)', 'revolux' ),
			],
		],
		'mobile_menu_style'      => [
			'type'     => 'select',
			'label'    => esc_html__( 'Mobile Menu Style', 'revolux' ),
			'section'  => 'mobile_menu',
			'default'  => 'slide',
			'priority' => 20,
			'choices'  => [
				'slide'   => esc_html__( 'Slide from Left', 'revolux' ),
				'overlay' => esc_html__( 'Full Screen Overlay', 'revolux' ),
			],
		],
		'mobile_menu_logo'       => [
			'type'        => 'image',
			'label'       => esc_html__( 'Mobile Menu Logo', 'revolux' ),
			'description' => esc_html__( 'Optional different logo for mobile menu.', 'revolux' ),
			'section'     => 'mobile_menu',
			'default'     => '',
			'priority'    => 30,
		],
	],
];
