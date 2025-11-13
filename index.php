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

	<div class="entry-content rev-entry-content">
		<div class="container">
			<div class="row">
				<div id="primary" class="content-area rev-content-area">
					<main id="site-main" class="rev-main" role="main">

						<?php
						if ( have_posts() ) :

							while ( have_posts() ) :
								the_post();

								/**
								 * Include post-type specific template for the content.
								 */
								get_template_part( 'template-parts/content', get_post_type() );

							endwhile;

							the_posts_navigation();

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
						?>

					</main><!-- (end) #site-main -->
				</div><!-- (end) #primary -->

				<?php get_sidebar(); ?>
			</div><!-- (end) .row -->
		</div><!-- (end) .container -->
	</div><!-- (end) .rev-entry-content -->

<?php
get_footer();
