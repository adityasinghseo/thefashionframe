<?php
/**
 * Template part for displaying a product card matching the Stitch design
 *
 * @package The_Fashion_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

// If not a WooCommerce product object, return.
if ( empty( $product ) || ! is_a( $product, 'WC_Product' ) ) {
	return;
}

$product_id   = $product->get_id();
$product_link = get_permalink( $product_id );
$title        = $product->get_name();
$is_on_sale   = $product->is_on_sale();
$is_featured  = $product->is_featured();

// Get product category or fabric term
$categories = get_the_terms( $product_id, 'product_cat' );
$category_name = ! empty( $categories ) && ! is_wp_error( $categories ) ? $categories[0]->name : __( 'Readymade', 'the-fashion-frame' );

// Calculate discount percentage if on sale
$discount_badge = '';
if ( $is_on_sale ) {
	$regular_price = (float) $product->get_regular_price();
	$sale_price    = (float) $product->get_sale_price();
	if ( $regular_price > 0 && $sale_price > 0 && $regular_price > $sale_price ) {
		$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
		$discount_badge = sprintf( '%d%% OFF', $percentage );
	} else {
		$discount_badge = __( 'SALE', 'the-fashion-frame' );
	}
}
?>

<article <?php wc_product_class( 'product-card group flex flex-col relative', $product ); ?>>
	<!-- Product Image Container -->
	<div class="product-card-media relative w-full aspect-[3/4] mb-4 bg-surface-container-low rounded-lg overflow-hidden gold-hairline isolate">
		
		<!-- Badges -->
		<?php if ( $is_on_sale && $discount_badge ) : ?>
			<div class="product-badge badge-sale">
				<?php echo esc_html( $discount_badge ); ?>
			</div>
		<?php elseif ( $is_featured ) : ?>
			<div class="product-badge badge-handcrafted">
				<span class="material-symbols-outlined text-[14px]">auto_awesome</span>
				<span><?php esc_html_e( 'Featured', 'the-fashion-frame' ); ?></span>
			</div>
		<?php endif; ?>

		<!-- Thumbnail -->
		<a href="<?php echo esc_url( $product_link ); ?>" class="block w-full h-full" tabindex="-1" aria-hidden="true">
			<?php if ( has_post_thumbnail( $product_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $product_id, 'woocommerce_thumbnail', array( 'class' => 'product-card-img object-cover w-full h-full transition-transform duration-700 group-hover:scale-105' ) ); ?>
			<?php else : ?>
				<img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="product-card-img object-cover w-full h-full transition-transform duration-700 group-hover:scale-105" />
			<?php endif; ?>
		</a>

		<!-- Quick View / Single Product Hover Action -->
		<div class="product-card-overlay">
			<a href="<?php echo esc_url( $product_link ); ?>" class="product-quickview-btn" aria-label="<?php echo esc_attr( sprintf( __( 'View %s', 'the-fashion-frame' ), $title ) ); ?>">
				<span class="material-symbols-outlined">visibility</span>
			</a>
		</div>
	</div>

	<!-- Product Info -->
	<div class="product-card-info flex flex-col gap-1 text-center">
		<span class="product-card-category font-label-caps text-on-surface-variant uppercase tracking-wider">
			<?php echo esc_html( $category_name ); ?>
		</span>
		<h2 class="product-card-title font-headline-sm text-primary line-clamp-1">
			<a href="<?php echo esc_url( $product_link ); ?>" class="hover:text-secondary transition-colors">
				<?php echo esc_html( $title ); ?>
			</a>
		</h2>
		<div class="product-card-price font-body-md flex justify-center gap-3">
			<?php echo $product->get_price_html(); ?>
		</div>
	</div>
</article>
