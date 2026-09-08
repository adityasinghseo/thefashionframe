<?php
/**
 * The Template for displaying product archives, including the main shop page and category archives.
 *
 * @package The_Fashion_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

$category_title = '';
$category_desc  = '';

if ( is_product_category() ) {
	$current_term   = get_queried_object();
	$category_title = single_term_title( '', false );
	$category_desc  = term_description();
} elseif ( is_shop() ) {
	$category_title = function_exists( 'woocommerce_page_title' ) ? woocommerce_page_title( false ) : __( 'All Collections', 'the-fashion-frame' );
	$category_desc  = __( 'Explore our handcrafted Lucknowi creations, blending timeless artistry with contemporary elegance.', 'the-fashion-frame' );
} else {
	$category_title = function_exists( 'woocommerce_page_title' ) ? woocommerce_page_title( false ) : get_the_title();
}
?>

<div class="archive-container site-container" style="padding-top: var(--section-gap-sm); padding-bottom: var(--section-gap-lg);">
	
	<!-- Category Archive Header -->
	<header class="archive-header text-center mb-16 relative" style="margin-bottom: 4rem;">
		<span class="font-label-caps text-on-surface-variant uppercase tracking-widest block mb-2">
			<?php esc_html_e( 'Heritage Boutique', 'the-fashion-frame' ); ?>
		</span>
		<h1 class="font-display-lg text-primary mb-4">
			<?php echo esc_html( $category_title ); ?>
		</h1>
		<?php if ( ! empty( $category_desc ) ) : ?>
			<div class="font-body-lg text-on-surface-variant max-w-2xl mx-auto" style="max-width: 650px; margin: 0 auto;">
				<?php echo wp_kses_post( $category_desc ); ?>
			</div>
		<?php endif; ?>
		<div style="width: 48px; height: 1px; background: var(--color-secondary-fixed-dim); margin: 1.5rem auto 0;"></div>
	</header>

	<?php if ( woocommerce_product_loop() ) : ?>

		<!-- Archive Controls (Count & Sorting) -->
		<div class="archive-controls flex justify-between items-center mb-8" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--color-surface-container-high); padding-bottom: 1rem;">
			<div class="archive-count font-body-md text-on-surface-variant">
				<?php woocommerce_result_count(); ?>
			</div>
			<div class="archive-ordering font-body-md">
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</div>

		<!-- Product Grid (4 Columns matching homepage Stitch cards) -->
		<div class="products-grid grid-4-col">
			<?php
			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/product-card' );
				}
			}
			?>
		</div>

		<!-- Pagination -->
		<div class="archive-pagination" style="margin-top: 4rem; text-align: center;">
			<?php woocommerce_pagination(); ?>
		</div>

	<?php else : ?>

		<div class="no-products-found text-center" style="padding: 4rem 0;">
			<h2 class="font-headline-md text-primary mb-4"><?php esc_html_e( 'No products found', 'the-fashion-frame' ); ?></h2>
			<p class="font-body-md text-on-surface-variant mb-8">
				<?php esc_html_e( 'There are no products in this category at the moment. Please explore our other collections.', 'the-fashion-frame' ); ?>
			</p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary">
				<?php esc_html_e( 'RETURN TO HOME', 'the-fashion-frame' ); ?>
			</a>
		</div>

	<?php endif; ?>

</div>

<?php
get_footer( 'shop' );
