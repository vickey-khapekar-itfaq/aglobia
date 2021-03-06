<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package icarefurnishers
 */

get_header();
?>

	<div id="primary" class="content-area">
		<div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <div class="content-wrapper">
						<main id="main" class="site-main">
						<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', get_post_type() );

								the_post_navigation();

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
							?>
						</main><!-- #main -->
					</div>
				</div>
				<div class="col-md-4 col-xs-12">
					<?php 
						get_sidebar();
					?>
				</div>
			</div><!-- row -->
		</div><!-- container -->
	</div><!-- #primary -->

<?php
get_footer();
