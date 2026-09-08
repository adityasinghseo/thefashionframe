<?php
/**
 * The Template for displaying all single products with Luxury Heritage Design
 *
 * @package The_Fashion_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header( 'shop' );

// Remove default WooCommerce sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
?>

<div class="single-product-wrapper site-container">

	<?php
	while ( have_posts() ) :
		the_post();
		global $product;

		if ( empty( $product ) || ! is_a( $product, 'WC_Product' ) ) {
			$product = wc_get_product( get_the_ID() );
		}

		$product_id         = $product->get_id();
		$categories         = get_the_terms( $product_id, 'product_cat' );
		$primary_cat        = ! empty( $categories ) && ! is_wp_error( $categories ) ? $categories[0] : null;
		$category_name      = $primary_cat ? $primary_cat->name : __( 'Artisanal Collection', 'the-fashion-frame' );
		$category_link      = $primary_cat ? get_term_link( $primary_cat, 'product_cat' ) : home_url( '/collections/' );
		
		// Image Gallery IDs
		$main_image_id      = $product->get_image_id();
		$gallery_image_ids  = $product->get_gallery_image_ids();
		$all_image_ids      = array_filter( array_merge( array( $main_image_id ), $gallery_image_ids ) );
		$main_image_url     = $main_image_id ? wp_get_attachment_image_url( $main_image_id, 'full' ) : wc_placeholder_img_src( 'full' );
		?>

		<!-- Luxury Breadcrumbs -->
		<nav class="product-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'the-fashion-frame' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'the-fashion-frame' ); ?></a>
			<span class="bc-sep">/</span>
			<?php if ( $primary_cat ) : ?>
				<a href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category_name ); ?></a>
				<span class="bc-sep">/</span>
			<?php endif; ?>
			<span class="bc-current"><?php the_title(); ?></span>
		</nav>

		<?php
		/**
		 * Output WooCommerce Notices (e.g. "Product added to cart", errors, etc.)
		 */
		woocommerce_output_all_notices();
		?>

		<!-- Product Detail Grid (Gallery on Left, Info & Purchase on Right) -->
		<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product-detail-layout', $product ); ?>>
			
			<!-- Left: Image Gallery -->
			<div class="product-gallery-col">
				
				<!-- Main Image Card -->
				<div class="product-main-card">
					<?php if ( $product->is_on_sale() ) : ?>
						<div class="product-badge badge-sale">
							<?php
							$reg = (float) $product->get_regular_price();
							$sal = (float) $product->get_sale_price();
							if ( $reg > 0 && $sal > 0 && $reg > $sal ) {
								printf( '%d%% OFF', round( ( ( $reg - $sal ) / $reg ) * 100 ) );
							} else {
								esc_html_e( 'SALE', 'the-fashion-frame' );
							}
							?>
						</div>
					<?php elseif ( $product->is_featured() ) : ?>
						<div class="product-badge badge-handcrafted">
							<span class="material-symbols-outlined text-[14px]">auto_awesome</span>
							<span><?php esc_html_e( 'Handcrafted', 'the-fashion-frame' ); ?></span>
						</div>
					<?php endif; ?>

					<div class="product-image-aspect">
						<img id="product-featured-image" src="<?php echo esc_url( $main_image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="product-zoomable-img" />
					</div>
				</div>

				<!-- Thumbnails (Vertical on Desktop, Horizontal on Mobile) -->
				<?php if ( count( $all_image_ids ) > 1 ) : ?>
					<div class="product-thumbnails-tray">
						<?php
						$thumb_index = 0;
						foreach ( $all_image_ids as $img_id ) :
							$img_full_url = wp_get_attachment_image_url( $img_id, 'full' );
							$img_thumb    = wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' );
							$is_active    = ( 0 === $thumb_index );
							?>
							<button type="button" class="product-thumb-btn <?php echo $is_active ? 'is-active' : ''; ?>" data-full-image="<?php echo esc_url( $img_full_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View image %d', 'the-fashion-frame' ), $thumb_index + 1 ) ); ?>">
								<img src="<?php echo esc_url( $img_thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
							</button>
							<?php
							$thumb_index++;
						endforeach;
						?>
					</div>
				<?php endif; ?>

			</div>

			<!-- Right: Product Info & Purchase Column -->
			<div class="product-summary-col">
				
				<!-- Category Pill & Title -->
				<div class="product-header-group">
					<span class="product-cat-pill"><?php echo esc_html( $category_name ); ?></span>
					<h1 class="product-detail-title"><?php the_title(); ?></h1>
					
					<!-- Pricing & Discount -->
					<div class="product-price-box">
						<div class="product-price-html">
							<?php echo $product->get_price_html(); ?>
						</div>
						<?php
						if ( $product->is_on_sale() ) {
							$reg = (float) $product->get_regular_price();
							$sal = (float) $product->get_sale_price();
							if ( $reg > 0 && $sal > 0 && $reg > $sal ) {
								$save_amount = $reg - $sal;
								$discount_pct = round( ( $save_amount / $reg ) * 100 );
								?>
								<span class="product-save-tag">
									<?php echo esc_html( sprintf( __( 'SAVE %d%%', 'the-fashion-frame' ), $discount_pct ) ); ?>
								</span>
								<?php
							}
						}
						?>
					</div>
					<div class="product-tax-note">
						<span><?php esc_html_e( 'Inclusive of all taxes • Complimentary boutique shipping', 'the-fashion-frame' ); ?></span>
					</div>
				</div>

				<!-- Stock Status Badge -->
				<div class="product-stock-indicator">
					<span class="stock-dot"></span>
					<?php if ( $product->is_in_stock() ) : ?>
						<span class="stock-text"><?php esc_html_e( 'In Stock • Handcrafted & Ready to Dispatch', 'the-fashion-frame' ); ?></span>
					<?php else : ?>
						<span class="stock-text out-of-stock"><?php esc_html_e( 'Currently Out of Stock', 'the-fashion-frame' ); ?></span>
					<?php endif; ?>
				</div>

				<!-- Short Description -->
				<?php if ( has_excerpt() ) : ?>
					<div class="product-short-desc">
						<?php the_excerpt(); ?>
					</div>
				<?php endif; ?>

				<!-- Purchase Box: Add to Cart, Quantity & Actions -->
				<div class="product-purchase-box">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>

				<!-- Luxury Trust Perks -->
				<div class="product-perks-strip">
					<div class="perk-item">
						<span class="material-symbols-outlined perk-icon">auto_awesome</span>
						<div class="perk-info">
							<strong><?php esc_html_e( 'Authentic Heritage', 'the-fashion-frame' ); ?></strong>
							<span><?php esc_html_e( 'Handcrafted Lucknowi needlework', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
					<div class="perk-item">
						<span class="material-symbols-outlined perk-icon">local_shipping</span>
						<div class="perk-info">
							<strong><?php esc_html_e( 'Express Delivery', 'the-fashion-frame' ); ?></strong>
							<span><?php esc_html_e( 'Dispatched within 24-48 hours', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
					<div class="perk-item">
						<span class="material-symbols-outlined perk-icon">verified</span>
						<div class="perk-info">
							<strong><?php esc_html_e( 'Boutique Guarantee', 'the-fashion-frame' ); ?></strong>
							<span><?php esc_html_e( '14-day seamless exchange', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
				</div>

				<!-- Modern Accordion Sections -->
				<div class="product-accordions-group">
					
					<!-- 1. Description Accordion -->
					<details class="product-accordion" open>
						<summary>
							<span class="accordion-title"><?php esc_html_e( 'Description & Artisanship', 'the-fashion-frame' ); ?></span>
							<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
						</summary>
						<div class="accordion-content">
							<?php the_content(); ?>
						</div>
					</details>

					<!-- 2. Details & Fabric Care Accordion -->
					<details class="product-accordion">
						<summary>
							<span class="accordion-title"><?php esc_html_e( 'Fabric, Threadwork & Care', 'the-fashion-frame' ); ?></span>
							<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
						</summary>
						<div class="accordion-content">
							<?php
							if ( $product->has_attributes() ) {
								do_action( 'woocommerce_product_additional_information', $product );
							} else {
								?>
								<ul class="luxury-care-list">
									<li><strong><?php esc_html_e( 'Embroidery:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Fine artisanal Lucknowi Chikankari & delicate border detailing.', 'the-fashion-frame' ); ?></li>
									<li><strong><?php esc_html_e( 'Fabric:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Premium breathable festive cotton / silk blend, gentle on skin.', 'the-fashion-frame' ); ?></li>
									<li><strong><?php esc_html_e( 'Fit:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Comfort tailored silhouette designed for effortless elegance.', 'the-fashion-frame' ); ?></li>
									<li><strong><?php esc_html_e( 'Wash Care:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Dry clean or gentle hand wash separately in cold water.', 'the-fashion-frame' ); ?></li>
								</ul>
								<?php
							}
							?>
						</div>
					</details>

					<!-- 3. Delivery & Returns Accordion -->
					<details class="product-accordion">
						<summary>
							<span class="accordion-title"><?php esc_html_e( 'Shipping & Boutique Returns', 'the-fashion-frame' ); ?></span>
							<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
						</summary>
						<div class="accordion-content">
							<p><?php esc_html_e( 'Each order is individually inspected and dispatched in signature luxury packaging. Orders are fulfilled within 24-48 business hours with express tracked courier delivery.', 'the-fashion-frame' ); ?></p>
							<p style="margin-top: 0.75rem;"><?php esc_html_e( 'We offer an easy 14-day exchange and return policy on all unworn garments with original tags attached.', 'the-fashion-frame' ); ?></p>
						</div>
					</details>

					<!-- 4. Reviews Accordion -->
					<?php if ( comments_open() || $product->get_review_count() > 0 ) : ?>
						<details class="product-accordion">
							<summary>
								<span class="accordion-title"><?php printf( esc_html__( 'Customer Reviews (%d)', 'the-fashion-frame' ), $product->get_review_count() ); ?></span>
								<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
							</summary>
							<div class="accordion-content">
								<?php
								if ( comments_open() ) {
									comments_template();
								}
								?>
							</div>
						</details>
					<?php endif; ?>

				</div>

			</div>

		</div>

		<!-- Mobile Sticky Bottom Buy Bar -->
		<div class="mobile-sticky-buy-bar">
			<div class="mobile-sticky-inner">
				<div class="mobile-sticky-product">
					<img src="<?php echo esc_url( $main_image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
					<div class="mobile-sticky-info">
						<span class="mobile-sticky-title"><?php the_title(); ?></span>
						<span class="mobile-sticky-price"><?php echo $product->get_price_html(); ?></span>
					</div>
				</div>
				<button type="button" class="mobile-sticky-btn" onclick="document.querySelector('.product-purchase-box .single_add_to_cart_button').click();">
					<span class="material-symbols-outlined text-[18px]">shopping_bag</span>
					<span><?php esc_html_e( 'ADD TO BAG', 'the-fashion-frame' ); ?></span>
				</button>
			</div>
		</div>

		<!-- Related Products Section -->
		<?php
		$related_ids = wc_get_related_products( $product_id, 4 );
		if ( ! empty( $related_ids ) ) :
			?>
			<section class="related-products-section">
				<div class="section-header text-center">
					<span class="font-label-caps text-on-surface-variant uppercase tracking-widest block mb-2"><?php esc_html_e( 'Curated For You', 'the-fashion-frame' ); ?></span>
					<h2 class="font-headline-lg text-primary"><?php esc_html_e( 'Related Creations', 'the-fashion-frame' ); ?></h2>
					<div class="gold-divider"></div>
				</div>

				<div class="products-grid grid-4-col">
					<?php
					global $post;
					foreach ( $related_ids as $rel_id ) :
						$post = get_post( $rel_id );
						setup_postdata( $post );
						get_template_part( 'template-parts/product-card' );
					endforeach;
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php
	endwhile;
	?>

</div>

<?php
get_footer( 'shop' );
