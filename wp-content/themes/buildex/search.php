<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Buildex
 */

get_header();

	do_action( 'buildex-theme/site/site-content-before', 'search' ); ?>

	<div <?php buildex_content_class() ?>>
		<div class="row">

			<?php do_action( 'buildex-theme/site/primary-before', 'search' ); ?>

			<div id="primary" class="col-xs-12">

				<?php do_action( 'buildex-theme/site/main-before', 'search' ); ?>

				<main id="main" class="site-main"><?php
					if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title"><?php
								/* translators: %s: search query. */
								printf( esc_html__( 'Search Results for: %s', 'buildex' ), '<span>' . get_search_query() . '</span>' );
							?></h1>
						</header><!-- .page-header -->

						<?php

						buildex_theme()->do_location( 'archive', 'template-parts/search-loop' );

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
				?></main><!-- #main -->

				<?php do_action( 'buildex-theme/site/main-after', 'search' ); ?>

			</div><!-- #primary -->

			<?php do_action( 'buildex-theme/site/primary-after', 'search' ); ?>

		</div>
	</div><?php
get_footer();
