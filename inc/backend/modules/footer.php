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
 * @filesource  footer.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/4/2025 at 9:47 AM.
 */

defined( 'ABSPATH' ) || exit;

return [
	'panels' => [
		'footer' => [
			'title'    => esc_html__( 'Footer', 'revolux' ),
			'priority' => 30,
		],
	],

	'sections' => [
		'footer_layout'  => [
			'title'    => esc_html__( 'Footer Layout', 'revolux' ),
			'panel'    => 'footer',
			'priority' => 10,
		],
		'footer_widgets' => [
			'title'    => esc_html__( 'Footer Widgets', 'revolux' ),
			'panel'    => 'footer',
			'priority' => 20,
		],
		'footer_bottom'  => [
			'title'    => esc_html__( 'Bottom Bar', 'revolux' ),
			'panel'    => 'footer',
			'priority' => 30,
		],
		'footer_social'  => [
			'title'    => esc_html__( 'Social Links', 'revolux' ),
			'panel'    => 'footer',
			'priority' => 40,
		],
	],

	'fields' => [
		'footer_style'         => [
			'type'     => 'radio-image',
			'label'    => esc_html__( 'Footer Style', 'revolux' ),
			'section'  => 'footer_layout',
			'default'  => 'style-1',
			'priority' => 10,
			'choices'  => [
				'style-1' => REVOLUX_ASSETS_URI . 'images/admin/footer-1.png',
				'style-2' => REVOLUX_ASSETS_URI . 'images/admin/footer-2.png',
				'style-3' => REVOLUX_ASSETS_URI . 'images/admin/footer-3.png',
			],
		],
		'footer_bg_color'      => [
			'type'      => 'color',
			'label'     => esc_html__( 'Background Color', 'revolux' ),
			'section'   => 'footer_layout',
			'default'   => '#1a1a1a',
			'priority'  => 20,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => '.rev-footer',
					'property' => 'background-color',
				],
			],
		],
		'footer_text_color'    => [
			'type'      => 'color',
			'label'     => esc_html__( 'Text Color', 'revolux' ),
			'section'   => 'footer_layout',
			'default'   => '#ffffff',
			'priority'  => 30,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => '.rev-footer, .rev-footer p, .rev-footer a',
					'property' => 'color',
				],
			],
		],
		'footer_heading_color' => [
			'type'      => 'color',
			'label'     => esc_html__( 'Heading Color', 'revolux' ),
			'section'   => 'footer_layout',
			'default'   => '#ffffff',
			'priority'  => 40,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => '.rev-footer h1, .rev-footer h2, .rev-footer h3, .rev-footer h4, .rev-footer h5, .rev-footer h6, .rev-footer .widget-title',
					'property' => 'color',
				],
			],
		],
		'footer_padding'       => [
			'type'      => 'dimensions',
			'label'     => esc_html__( 'Footer Padding', 'revolux' ),
			'section'   => 'footer_layout',
			'default'   => [
				'top'    => '80px',
				'bottom' => '40px',
			],
			'priority'  => 50,
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => '.rev-footer-widgets',
					'property' => 'padding',
				],
			],
		],

		'footer_widgets_enable'   => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Enable Footer Widgets', 'revolux' ),
			'section'  => 'footer_widgets',
			'default'  => true,
			'priority' => 10,
		],
		'footer_widget_columns'   => [
			'type'            => 'radio-buttonset',
			'label'           => esc_html__( 'Widget Columns', 'revolux' ),
			'section'         => 'footer_widgets',
			'default'         => '4',
			'priority'        => 20,
			'choices'         => [
				'2' => '2',
				'3' => '3',
				'4' => '4',
			],
			'active_callback' => [
				[
					'setting'  => 'footer_widgets_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_bottom_enable'    => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Enable Bottom Bar', 'revolux' ),
			'section'  => 'footer_bottom',
			'default'  => true,
			'priority' => 10,
		],
		'footer_copyright'        => [
			'type'            => 'textarea',
			'label'           => esc_html__( 'Copyright Text', 'revolux' ),
			'description'     => esc_html__( 'Use {year} for current year, {site} for site name.', 'revolux' ),
			'section'         => 'footer_bottom',
			'default'         => esc_html__( 'Copyright &copy; {year} {site}. All rights reserved.', 'revolux' ),
			'priority'        => 20,
			'active_callback' => [
				[
					'setting'  => 'footer_bottom_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_bottom_bg_color'  => [
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'revolux' ),
			'section'         => 'footer_bottom',
			'default'         => '#111111',
			'priority'        => 30,
			'transport'       => 'auto',
			'output'          => [
				[
					'element'  => '.rev-footer-bottom',
					'property' => 'background-color',
				],
			],
			'active_callback' => [
				[
					'setting'  => 'footer_bottom_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_back_to_top'      => [
			'type'            => 'toggle',
			'label'           => esc_html__( 'Back to Top Button', 'revolux' ),
			'section'         => 'footer_bottom',
			'default'         => true,
			'priority'        => 40,
			'active_callback' => [
				[
					'setting'  => 'footer_bottom_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_social_enable'    => [
			'type'     => 'toggle',
			'label'    => esc_html__( 'Enable Social Links', 'revolux' ),
			'section'  => 'footer_social',
			'default'  => true,
			'priority' => 10,
		],
		'footer_social_facebook'  => [
			'type'            => 'link',
			'label'           => esc_html__( 'Facebook', 'revolux' ),
			'section'         => 'footer_social',
			'default'         => '',
			'priority'        => 20,
			'active_callback' => [
				[
					'setting'  => 'footer_social_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_social_twitter'   => [
			'type'            => 'link',
			'label'           => esc_html__( 'Twitter/X', 'revolux' ),
			'section'         => 'footer_social',
			'default'         => '',
			'priority'        => 30,
			'active_callback' => [
				[
					'setting'  => 'footer_social_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_social_linkedin'  => [
			'type'            => 'link',
			'label'           => esc_html__( 'LinkedIn', 'revolux' ),
			'section'         => 'footer_social',
			'default'         => '',
			'priority'        => 40,
			'active_callback' => [
				[
					'setting'  => 'footer_social_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_social_instagram' => [
			'type'            => 'link',
			'label'           => esc_html__( 'Instagram', 'revolux' ),
			'section'         => 'footer_social',
			'default'         => '',
			'priority'        => 50,
			'active_callback' => [
				[
					'setting'  => 'footer_social_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_social_youtube'   => [
			'type'            => 'link',
			'label'           => esc_html__( 'YouTube', 'revolux' ),
			'section'         => 'footer_social',
			'default'         => '',
			'priority'        => 60,
			'active_callback' => [
				[
					'setting'  => 'footer_social_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_social_yelp'      => [
			'type'            => 'link',
			'label'           => esc_html__( 'Yelp', 'revolux' ),
			'description'     => esc_html__( 'Important for trades businesses.', 'revolux' ),
			'section'         => 'footer_social',
			'default'         => '',
			'priority'        => 70,
			'active_callback' => [
				[
					'setting'  => 'footer_social_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
		'footer_social_style'     => [
			'type'            => 'select',
			'label'           => esc_html__( 'Social Icon Style', 'revolux' ),
			'section'         => 'footer_social',
			'default'         => 'rounded',
			'priority'        => 80,
			'choices'         => [
				'rounded' => esc_html__( 'Rounded', 'revolux' ),
				'square'  => esc_html__( 'Square', 'revolux' ),
				'circle'  => esc_html__( 'Circle', 'revolux' ),
			],
			'active_callback' => [
				[
					'setting'  => 'footer_social_enable',
					'operator' => '==',
					'value'    => true,
				],
			],
		],
	],
];
