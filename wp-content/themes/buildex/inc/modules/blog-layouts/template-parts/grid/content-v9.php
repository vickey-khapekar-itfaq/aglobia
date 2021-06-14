<?php
/**
 * Template part for displaying style-v9 posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package buildex
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item grid-item invert-item' ); ?>>
	<div class="grid-item-inner">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="grid-item__thumbnail" <?php buildex_post_overlay_thumbnail( 'buildex-thumb-l' );?>></div>
		<?php endif; ?>
		<div class="grid-item-inner__top"><?php
			buildex_post_comments( array(
				'prefix' => '<i class="fa fa-comment" aria-hidden="true"></i>',
				'class'  => 'comments-button'
			) );
		?></div>
		<div class="grid-item-wrap invert">
			<header class="entry-header">
				<div class="entry-meta">
					<?php
					buildex_posted_by();
					buildex_posted_in( array(
						'prefix' => __( 'In', 'buildex' ),
						'delimiter' => ', '
					) );
					buildex_posted_on( array(
						'prefix' => '',
					) );
					buildex_post_tags();
					?>
				</div><!-- .entry-meta -->
				<h4 class="entry-title"><?php
					buildex_sticky_label();
					the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' );
				?></h4>
			</header><!-- .entry-header -->
			<div class="grid-item-wrap__animated">
				<?php buildex_post_excerpt(); ?>

				<footer class="entry-footer">
					<div class="entry-meta">
						<?php

						$post_more_btn_enabled = strlen( buildex_theme()->customizer->get_value( 'blog_read_more_text' ) ) > 0 ? true : false;

						if( $post_more_btn_enabled ) {
							?><div class="space-between-content"><?php
							buildex_post_link();
							?></div><?php
						}
						?>
					</div>
				</footer><!-- .entry-footer -->
			</div><!-- .grid-item-wrap__animated-->
		</div><!-- .grid-item-wrap-->
	</div><!-- .grid-item-inner-->
	<?php buildex_edit_link(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
