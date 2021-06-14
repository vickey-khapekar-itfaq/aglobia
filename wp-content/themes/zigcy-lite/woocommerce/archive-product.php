<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<?php 
	// verify that this is a product category page
	if ( is_product_category() ){
	    global $wp_query;

	    // get the query object
	    $cat = $wp_query->get_queried_object();

	    // get the thumbnail id using the queried category term_id
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); 

	    // get the image URL
	    $image = wp_get_attachment_url( $thumbnail_id ); 

	    // print the IMG HTML
	    if($image){
	    echo "<div class='category-banner' style='background-image: url({$image});'></div>";	
	    }
	}
?>
<header class="woocommerce-products-header cat-header">

	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<div class="catpage-heading">
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
		</div>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<div class="category-listing">
	<div class="category-wrapper">
		
		<?php
			$parentid = get_queried_object_id();
			//print_r($parentid);
				$args = array(
				    'parent' => $parentid
				);
				$terms = get_terms( 'product_cat', $args );
				//print_r($terms);
				if ( $terms ) {
				        foreach ( $terms as $term ) {
				            $taxonomy = $term->taxonomy;
							$term_id = $term->term_id;
							$foto = get_field( 'cat_icon', $term_id );
							$foto = get_field( 'cat_icon', $taxonomy . '_' . $term_id );
							echo '<div class="cat-item">';            
				                //woocommerce_subcategory_thumbnail( $term );
		                    echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
		                    if( get_field('cat_icon', $taxonomy . '_' . $term_id) ) {
									echo '<div class="cat-icon"><img src="' . $foto . '"/></div>';
								}
							echo "<span class='home-press-swiper-text'>$term->name</span>";
		                    echo '</a>';                                   
				            echo '</div>';
				    	}
				    
				}
		?>
		
	</div>
</div>
   

<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
