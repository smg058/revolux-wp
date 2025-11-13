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
 * @filesource  template-tags.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/6/2025 at 12:47 AM.
 */

declare( strict_types=1 );
defined( 'ABSPATH' ) || exit;

/**
 * Display the site logo.
 *
 * @since 0.2.0
 *
 * @param array {
 *     class?: string,
 *     link?: bool
 *     } $args Optional arguments
 *
 * @return void
 */
function revolux_site_logo( array $args = [] ): void {
	$defaults = [
		'class' => 'rev-site-logo',
		'link'  => true,
	];

	$args = wp_parse_args( $args, $defaults );

	$option = revolux_get_option( 'custom_logo' );

	$attachment_id = 0;
	$src           = '';
	$width         = 0;
	$height        = 0;

	// Normalize the option into either an attachment ID or a URL.
	if ( is_array( $option ) ) {
		// Kirki Media/Image usually returns an array.
		if ( ! empty( $option['id'] ) && is_numeric( $option['id'] ) ) {
			$attachment_id = (int) $option['id'];
		} elseif ( ! empty( $option['url'] ) && is_string( $option['url'] ) ) {
			$src = (string) $option['url'];

			$maybe_id = attachment_url_to_postid( $src );
			if ( $maybe_id ) {
				$attachment_id = (int) $maybe_id;
			}
		}
		$width  = isset( $option['width'] ) ? (int) $option['width'] : 0;
		$height = isset( $option['height'] ) ? (int) $option['height'] : 0;
	} elseif ( is_numeric( $option ) ) {
		$attachment_id = (int) $option;
	} elseif ( is_string( $option ) && '' !== $option ) {
		$src      = $option;
		$maybe_id = attachment_url_to_postid( $src );
		if ( $maybe_id ) {
			$attachment_id = (int) $maybe_id;
		}
	}

	$output = '';

	if ( $attachment_id > 0 ) {
		// Use WordPress helper to output responsive image with srcset/sizes.
		// Determine an appropriate alt: attachment alt meta or site name.
		$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		if ( '' === $alt ) {
			$alt = get_bloginfo( 'name' );
		}

		// Build attributes (class + alt).
		$img_attrs = [
			'class' => $args['class'],
			'alt'   => $alt,
		];

		if ( $width > 0 && $height > 0 ) {
			$img_attrs['width']  = (string) $width;
			$img_attrs['height'] = (string) $height;
		}

		$output = wp_get_attachment_image( $attachment_id, 'full', false, $img_attrs );
	} elseif ( '' !== $src ) {
		// We only have a URL.
		$alt_attr = esc_attr( get_bloginfo( 'name' ) );

		$dim_attr = '';
		if ( $width > 0 && $height > 0 ) {
			$dim_attr = sprintf( ' width="%d" height="%d"', $width, $height );
		}

		$output = sprintf(
			'<img src="%s" alt="%s" class="%s"%s>',
			esc_url( $src ),
			$alt_attr,
			esc_attr( $args['class'] ),
			$dim_attr
		);
	}

	if ( '' !== $output ) {
		if ( $args['link'] ) {
			$output = sprintf(
				'<a href="%s" rel="home">%s</a>',
				esc_url( home_url( '/' ) ),
				$output
			);
		}
		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		return;
	}

	// Fallback to site title when no logo is configured or resolvable.
	if ( $args['link'] ) {
		printf(
			'<a href="%s" rel="home" class="rev-site-title">%s</a>',
			esc_url( home_url( '/' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
	} else {
		printf(
			'<span class="rev-site-title">%s</span>',
			esc_html( get_bloginfo( 'name' ) )
		);
	}
}

/**
 * Display site title and description.
 *
 * @since 0.2.0
 * @return void
 */
function revolux_site_branding(): void {
	?>
	<div class="rev-site-branding">
		<?php revolux_site_logo(); ?>

		<?php if ( display_header_text() ) : ?>
			<div class="rev-site-identity">
				<h1 class="rev-site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</h1>
				<?php
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="rev-site-description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Display navigation menu.
 *
 * @since 0.2.0
 *
 * @param string $location Menu location.
 * @param array  $args     Optional menu arguments.
 *
 * @return void
 */
function revolux_nav_menu( string $location, array $args = [] ): void {
	if ( ! has_nav_menu( $location ) ) {
		return;
	}

	$defaults = [
		'theme_location' => $location,
		'container'      => 'nav',
		'menu_class'     => 'menu',
		'fallback_cb'    => false,
		'depth'          => 3,
	];

	$args = wp_parse_args( $args, $defaults );

	wp_nav_menu( $args );
}

/**
 * Display posted on date.
 *
 * @since 0.2.0
 *
 * @param bool $echo_output Whether to echo or return.
 *
 * @return string|void
 */
function revolux_posted_on( bool $echo_output = true ) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() ),
	);

	$posted_on = sprintf(
		'<span class="posted-on"><i class="ph ph-calendar"></i>%s</span>',
		$time_string,
	);

	if ( $echo_output ) {
		echo $posted_on; // phpcs:ignore
	} else {
		return $posted_on;
	}
}

/**
 * Display post author.
 *
 * @since 0.2.0
 *
 * @param bool $echo_output Whether to echo or return.
 *
 * @return string|void
 */
function revolux_posted_by( bool $echo_output = true ) {
	$byline = sprintf(
		'<span class="author vcard"><i class="ph ph-user"></i><a class="url fn n" href="%1$s">%2$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() ),
	);

	if ( $echo_output ) {
		echo $byline; // phpcs:ignore
	} else {
		return $byline;
	}
}

/**
 * Display post categories.
 *
 * @since 0.2.0
 *
 * @param bool $echo_output Whether to echo or return.
 *
 * @return string|void
 */
function revolux_posted_in( bool $echo_output = true ) {
	$categories_list = get_the_category_list( ', ' );

	if ( ! $categories_list ) {
		return;
	}

	$posted_in = sprintf(
		'<span class="cat-links"><i class="ph ph-folder"></i>%s</span>',
		$categories_list,
	);

	if ( $echo_output ) {
		echo $posted_in; // phpcs:ignore
	} else {
		return $posted_in;
	}
}

/**
 * Display post tags.
 *
 * @since 0.2.0
 *
 * @param bool $echo_output Whether to echo or return.
 *
 * @return string|void
 */
function revolux_posted_tags( bool $echo_output = true ) {
	$tags_list = get_the_tag_list( '', ', ' );

	if ( ! $tags_list ) {
		return;
	}

	$posted_tags = sprintf(
		'<span class="tags-links"><i class="ph ph-tag"></i>%s</span>',
		$tags_list,
	);

	if ( $echo_output ) {
		echo $posted_tags; // phpcs:ignore
	} else {
		return $posted_tags;
	}
}

/**
 * Display comment count.
 *
 * @since 0.2.0
 *
 * @param bool $echo_output Whether to echo or return.
 *
 * @return string|void
 */
function revolux_comments_link( bool $echo_output = true ) {
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		$comments_link = sprintf(
			'<span class="comments-link"><i class="ph ph-chat"></i>%s</span>',
			get_comments_number_text(),
		);

		if ( $echo_output ) {
			echo $comments_link; // phpcs:ignore
		} else {
			return $comments_link;
		}
	}
}

/**
 * Display entry meta (date, author, categories, comments).
 *
 * @since 0.2.0
 *
 * @param array $args Optional arguments.
 *
 * @return void
 */
function revolux_entry_meta( array $args = [] ): void {
	$defaults = [
		'date'       => true,
		'author'     => true,
		'categories' => true,
		'comments'   => true,
		'separator'  => ' ',
	];

	$args = wp_parse_args( $args, $defaults );

	echo '<div class="entry-meta">';

	if ( $args['date'] ) {
		revolux_posted_on();
		echo $args['separator']; // phpcs:ignore
	}

	if ( $args['author'] ) {
		revolux_posted_by();
		echo $args['separator']; // phpcs:ignore
	}

	if ( $args['categories'] ) {
		revolux_posted_in();
		echo $args['separator']; // phpcs:ignore
	}

	if ( $args['comments'] ) {
		revolux_comments_link();
	}

	echo '</div>';
}

/**
 * Display entry footer (tags, edit link).
 *
 * @since 0.2.0
 * @return void
 */
function revolux_entry_footer(): void {
	echo '<footer class="entry-footer">';

	// Tags.
	revolux_posted_tags();

	// Edit link.
	edit_post_link(
		sprintf(
			'<i class="icon-edit"></i>%s',
			esc_html__( 'Edit', 'revolux' )
		),
		'<span class="edit-link">',
		'</span>'
	);

	echo '</footer>';
}

/**
 * Display pagination.
 *
 * @since 0.2.0
 *
 * @param array $args Optional arguments.
 *
 * @return void
 */
function revolux_pagination( array $args = [] ): void {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$defaults = [
		'mid_size'           => 2,
		'prev_text'          => '<i class="icon-arrow-left"></i>' . esc_html__( 'Previous', 'revolux' ),
		'next_text'          => esc_html__( 'Next', 'revolux' ) . '<i class="icon-arrow-right"></i>',
		'screen_reader_text' => esc_html__( 'Posts navigation', 'revolux' ),
		'type'               => 'list',
		'class'              => 'pagination',
	];

	$args = wp_parse_args( $args, $defaults );

	// Allow filtering of arguments.
	$args = apply_filters( 'revolux_pagination_args', $args );

	$class = $args['class'];
	unset( $args['class'] );

	echo '<nav class="' . esc_attr( $class ) . '" role="navigation">';
	echo paginate_links( $args ); // phpcs:ignore
	echo '</nav>';
}

/**
 * Display post navigation (previous/next post links).
 *
 * @since 0.2.0
 * @return void
 */
function revolux_post_navigation(): void {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = get_previous_post_link(
		'<div class="nav-previous">%link</div>',
		'<i class="icon-arrow-left"></i> %title'
	);
	$next     = get_next_post_link(
		'<div class="nav-next">%link</div>',
		'%title <i class="icon-arrow-right"></i>'
	);

	// Only show the navigation if there are links to display.
	if ( $previous || $next ) {
		?>
		<nav class="post-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'revolux' ); ?></h2>
			<div class="nav-links">
				<?php
				echo $previous; // phpcs:ignore
				echo $next; // phpcs:ignore
				?>
			</div>
		</nav>
		<?php
	}
}

/**
 * Display breadcrumbs.
 *
 * @since 0.2.0
 *
 * @param array $args Optional arguments.
 *
 * @return void
 */
function revolux_breadcrumbs( array $args = [] ): void {
	// Don't show on front page.
	if ( is_front_page() ) {
		return;
	}

	$defaults = [
		'delimiter'    => '<span class="separator">/</span>',
		'home_label'   => esc_html__( 'Home', 'revolux' ),
		'show_current' => true,
		'class'        => 'breadcrumbs',
	];

	$args = wp_parse_args( $args, $defaults );

	echo '<nav class="' . esc_attr( $args['class'] ) . '" aria-label="' . esc_attr__( 'Breadcrumb', 'revolux' ) . '">';
	echo '<ol>';

	// Home link.
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $args['home_label'] ) . '</a></li>';
	echo $args['delimiter']; // phpcs:ignore

	if ( is_category() ) {
		$category = get_queried_object();
		if ( $category->parent ) {
			$parent = get_category( $category->parent );
			echo '<li><a href="' . esc_url( get_category_link( $parent->term_id ) ) . '">' . esc_html( $parent->name ) . '</a></li>';
			echo $args['delimiter']; // phpcs:ignore
		}
		echo '<li class="current">' . esc_html( $category->name ) . '</li>';

	} elseif ( is_tag() ) {
		echo '<li class="current">' . esc_html( single_tag_title( '', false ) ) . '</li>';

	} elseif ( is_single() ) {
		$post_type = get_post_type();

		if ( 'post' === $post_type ) {
			$category = get_the_category();
			if ( $category ) {
				$cat = $category[0];
				echo '<li><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
				echo $args['delimiter']; // phpcs:ignore
			}
		}

		if ( $args['show_current'] ) {
			echo '<li class="current">' . esc_html( get_the_title() ) . '</li>';
		}
	} elseif ( is_page() ) {
		if ( $post = get_post() ) { // phpcs:ignore
			if ( $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = [];

				while ( $parent_id ) {
					$page          = get_post( $parent_id );
					$breadcrumbs[] = '<li><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( get_the_title( $page->ID ) ) . '</a></li>';
					$parent_id     = $page->post_parent;
				}

				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					echo $crumb;             // phpcs:ignore
					echo $args['delimiter']; // phpcs:ignore
				}
			}

			if ( $args['show_current'] ) {
				echo '<li class="current">' . esc_html( get_the_title() ) . '</li>';
			}
		}
	}

	echo '</ol>';
	echo '</nav>';
}

/**
 * Display social links.
 *
 * @since 0.2.0
 *
 * @param string $context Context (header, footer).
 * @param array  $args    Optional arguments.
 *
 * @return void
 */
function revolux_social_links( string $context = 'footer', array $args = [] ): void {
	if ( ! revolux_is_option_enabled( "{$context}_social_enable" ) ) {
		return;
	}

	$defaults = [
		'class'  => 'social-links',
		'target' => '_blank',
	];

	$args = wp_parse_args( $args, $defaults );

	$social_links = revolux_get_social_links( $context );

	if ( empty( $social_links ) ) {
		return;
	}

	$style = revolux_get_option( "{$context}_social_style", 'rounded' );

	echo '<div class="' . esc_attr( $args['class'] . ' social-style-' . $style ) . '">';

	foreach ( $social_links as $network => $data ) {
		printf(
			'<a href="%s" target="%s" rel="noopener noreferrer" class="social-link social-%s" aria-label="%s"><i class="%s"></i></a>',
			esc_url( $data['url'] ),
			esc_attr( $args['target'] ),
			esc_attr( $network ),
			esc_attr( $data['label'] ),
			esc_attr( $data['icon'] )
		);
	}

	echo '</div>';
}

/**
 * Display copyright text.
 *
 * @since 0.2.0
 * @return void
 */
function revolux_copyright(): void {
	echo '<div class="copyright">';
	echo wp_kses_post( revolux_get_copyright() );
	echo '</div>';
}

/**
 * Display back to top button.
 *
 * @since 0.2.0
 * @return void
 */
function revolux_back_to_top(): void {
	if ( ! revolux_is_option_enabled( 'footer_back_to_top' ) ) {
		return;
	}

	echo '<a href="#top" class="back-to-top" aria-label="' . esc_attr__( 'Back to top', 'revolux' ) . '">';
	echo '<i class="icon-arrow-up"></i>';
	echo '</a>';
}

/**
 * Display preloader.
 *
 * @since 0.2.0
 * @return void
 */
function revolux_preloader(): void {
	if ( ! revolux_is_option_enabled( 'preloader_enable' ) ) {
		return;
	}

	$type = revolux_get_option( 'preloader_type', 'spinner' );

	echo '<div class="revolux-preloader" aria-label="' . esc_attr__( 'Loading', 'revolux' ) . '">';

	switch ( $type ) {
		case 'spinner':
			echo '<div class="revolux-preloader-spinner"></div>';
			break;

		case 'dots':
			echo '<div class="revolux-preloader-dots">';
			echo '<span></span><span></span><span></span>';
			echo '</div>';
			break;

		case 'custom':
			$image = revolux_get_option( 'preloader_image' );
			if ( $image ) {
				echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Loading', 'revolux' ) . '">';
			}
			break;
	}

	echo '</div>';
}

/**
 * Display post thumbnail.
 *
 * @since 0.2.0
 *
 * @param array|string $size Image size.
 * @param array        $args Optional arguments.
 *
 * @return void
 */
function revolux_post_thumbnail( array|string $size = 'post-thumbnail', array $args = [] ): void {
	if ( ! has_post_thumbnail() ) {
		return;
	}

	$defaults = [
		'link'  => true,
		'class' => 'post-thumbnail',
	];

	$args = wp_parse_args( $args, $defaults );

	echo '<div class="' . esc_attr( $args['class'] ) . '">';

	if ( $args['link'] && ! is_singular() ) {
		echo '<a href="' . esc_url( get_permalink() ) . '" aria-hidden="true" tabindex="-1">';
	}

	the_post_thumbnail( $size );

	if ( $args['link'] && ! is_singular() ) {
		echo '</a>';
	}

	echo '</div>';
}

/**
 * Display read more link.
 *
 * @since 0.2.0
 *
 * @param string $text Button text.
 *
 * @return void
 */
function revolux_read_more( string $text = '' ): void {
	if ( empty( $text ) ) {
		$text = revolux_get_option( 'blog_read_more_text', esc_html__( 'Read More', 'revolux' ) );
	}

	printf(
		'<a href="%s" class="read-more-link">%s <i class="icon-arrow-right"></i></a>',
		esc_url( get_permalink() ),
		esc_html( $text )
	);
}

/**
 * Display CTA button in header.
 *
 * @since 0.2.0
 * @return void
 */
function revolux_header_cta(): void {
	if ( ! revolux_is_option_enabled( 'header_cta_enable' ) ) {
		return;
	}

	$text  = revolux_get_option( 'header_cta_text' );
	$url   = revolux_get_option( 'header_cta_url' );
	$style = revolux_get_option( 'header_cta_style', 'primary' );

	if ( empty( $text ) || empty( $url ) ) {
		return;
	}

	printf(
		'<a href="%s" class="header-cta-button btn btn-%s">%s</a>',
		esc_url( $url ),
		esc_attr( $style ),
		esc_html( $text )
	);
}

/**
 * Display skip to content link.
 *
 * @since 0.2.0
 * @return void
 */
function revolux_skip_link(): void {
	echo '<a class="skip-link screen-reader-text" href="#content">' . esc_html__( 'Skip to content', 'revolux' ) . '</a>';
}
