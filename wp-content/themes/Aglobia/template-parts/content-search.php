<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package icarefurnishers
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			icarefurnishers_posted_on();
			icarefurnishers_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php icarefurnishers_post_thumbnail(); ?>

	<div class="entry-summary">
		<div class="container">
		<?php //the_excerpt();
		// For product search result on search page
			$content = $post->post_content; //contents saved in a variable
			echo substr(strip_tags($content), 0, 150).'....';
		 ?>

		</div>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php icarefurnishers_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
