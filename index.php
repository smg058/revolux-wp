<?php
/**
 *
 * Revolux
 *
 * A modern, modular, and multipurpose professional WordPress theme.
 *
 * @version     0.1.0
 * @package     revolux
 * @author      Chayson Media <dev@chayson.com>
 * @filesource  index.php
 * @copyright   2015 - 2025 Chayson Media. All rights reserved.
 * @license     LICENSE.md
 * @link        https://chayson.com/revolux/
 *
 * Created on 11/5/2025 at 11:46 PM.
 */

declare( strict_types=1 );
defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header class="page-header">
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php
			endif;

			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;

			the_posts_navigation();

		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
	</main>

<?php
get_sidebar();
get_footer();
