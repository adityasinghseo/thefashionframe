<?php
/**
 * The Template for displaying all single products
 * Redesigned for The Fashion Frame inspired by Libas fashion e-commerce layout.
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
		$all_image_ids      = array_values( array_filter( array_merge( array( $main_image_id ), $gallery_image_ids ) ) );
		$main_image_url     = $main_image_id ? wp_get_attachment_image_url( $main_image_id, 'full' ) : wc_placeholder_img_src( 'full' );
		$total_images       = count( $all_image_ids );
		$sku                = $product->get_sku() ?: 'TFF-' . str_pad( $product_id, 4, '0', STR_PAD_LEFT );
		$rating_count       = $product->get_rating_count();
		$review_count       = $product->get_review_count();
		$average_rating     = $product->get_average_rating();
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

		<!-- Product Detail Grid (Gallery on Left 58%, Sticky Info on Right 42%) -->
		<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product-detail-layout', $product ); ?>>
			
			<!-- LEFT COLUMN: Product Image Gallery -->
			<div class="product-gallery-col">
				
				<!-- A. Desktop 2-Column Vertical Image Grid (Visible on Desktop >= 1024px) -->
				<div class="product-gallery-desktop-grid" aria-label="<?php esc_attr_e( 'Product Images', 'the-fashion-frame' ); ?>">
					<?php
					if ( ! empty( $all_image_ids ) ) :
						foreach ( $all_image_ids as $idx => $img_id ) :
							$img_full  = wp_get_attachment_image_url( $img_id, 'full' );
							$img_large = wp_get_attachment_image_url( $img_id, 'large' ) ?: $img_full;
							$img_alt   = get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ?: get_the_title();
							?>
							<div class="gallery-grid-item" data-index="<?php echo esc_attr( $idx ); ?>" data-full-image="<?php echo esc_url( $img_full ); ?>">
								<?php if ( 0 === $idx && $product->is_on_sale() ) : ?>
									<div class="product-badge badge-sale">
										<?php
										$reg = $product->is_type( 'variable' ) ? (float) $product->get_variation_regular_price( 'min' ) : (float) $product->get_regular_price();
										$sal = $product->is_type( 'variable' ) ? (float) $product->get_variation_sale_price( 'min' ) : (float) $product->get_sale_price();
										if ( $reg > 0 && $sal > 0 && $reg > $sal ) {
											printf( '%d%% OFF', round( ( ( $reg - $sal ) / $reg ) * 100 ) );
										} else {
											esc_html_e( 'SALE', 'the-fashion-frame' );
										}
										?>
									</div>
								<?php endif; ?>
								
								<img 
									src="<?php echo esc_url( $img_large ); ?>" 
									alt="<?php echo esc_attr( $img_alt ); ?>" 
									loading="<?php echo $idx < 4 ? 'eager' : 'lazy'; ?>" 
									class="gallery-grid-img"
								/>
								<span class="gallery-zoom-hint" title="<?php esc_attr_e( 'Click to zoom', 'the-fashion-frame' ); ?>">
									<span class="material-symbols-outlined">zoom_in</span>
								</span>
							</div>
							<?php
						endforeach;
					else :
						?>
						<div class="gallery-grid-item">
							<img src="<?php echo esc_url( wc_placeholder_img_src( 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="gallery-grid-img" />
						</div>
					<?php endif; ?>
				</div>

				<!-- B. Mobile Full-Width Horizontal Slider (Visible on Mobile/Tablet < 1024px) -->
				<div class="product-gallery-mobile-slider-wrap" aria-label="<?php esc_attr_e( 'Product Images Slider', 'the-fashion-frame' ); ?>">
					<div class="product-gallery-mobile-slider" id="product-mobile-slider">
						<?php
						if ( ! empty( $all_image_ids ) ) :
							foreach ( $all_image_ids as $idx => $img_id ) :
								$img_full  = wp_get_attachment_image_url( $img_id, 'full' );
								$img_large = wp_get_attachment_image_url( $img_id, 'large' ) ?: $img_full;
								$img_alt   = get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ?: get_the_title();
								?>
								<div class="mobile-slide-item" data-index="<?php echo esc_attr( $idx ); ?>" data-full-image="<?php echo esc_url( $img_full ); ?>">
									<img 
										src="<?php echo esc_url( $img_large ); ?>" 
										alt="<?php echo esc_attr( $img_alt ); ?>" 
										loading="<?php echo 0 === $idx ? 'eager' : 'lazy'; ?>" 
										class="mobile-slide-img"
									/>
								</div>
								<?php
							endforeach;
						else :
							?>
							<div class="mobile-slide-item">
								<img src="<?php echo esc_url( wc_placeholder_img_src( 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="mobile-slide-img" />
							</div>
						<?php endif; ?>
					</div>

					<!-- Mobile Slider Floating Counter -->
					<?php if ( $total_images > 1 ) : ?>
						<div class="mobile-slider-counter" id="mobile-slider-counter">
							<span id="mobile-slide-current">1</span> / <span><?php echo esc_html( $total_images ); ?></span>
						</div>
						<!-- Mobile Slider Tap Zoom Hint -->
						<button type="button" class="mobile-slider-zoom-trigger" id="mobile-slider-zoom-trigger" aria-label="<?php esc_attr_e( 'Zoom image', 'the-fashion-frame' ); ?>">
							<span class="material-symbols-outlined">zoom_in</span>
						</button>
					<?php endif; ?>
				</div>

			</div><!-- .product-gallery-col -->

			<!-- RIGHT COLUMN: Sticky Product Information & Actions -->
			<div class="product-summary-col">
				
				<!-- 1. Category & SKU Meta Row -->
				<div class="product-meta-top-row">
					<span class="product-cat-pill"><?php echo esc_html( $category_name ); ?></span>
					<span class="product-sku-badge"><?php echo esc_html( sprintf( __( 'SKU: %s', 'the-fashion-frame' ), $sku ) ); ?></span>
				</div>

				<!-- 2. Product Title (Clean, modern sans-serif typography) -->
				<h1 class="product-detail-title"><?php the_title(); ?></h1>

				<!-- 3. Star Rating & Review Count (Only when actual review data exists) -->
				<?php if ( $rating_count > 0 || $review_count > 0 ) : ?>
					<div class="product-rating-row">
						<div class="product-star-rating">
							<span class="material-symbols-outlined star-icon filled">star</span>
							<strong class="rating-value"><?php echo esc_html( number_format( (float) $average_rating, 1 ) ); ?></strong>
							<span class="rating-sep">|</span>
							<a href="#reviews" class="rating-count-link"><?php echo esc_html( sprintf( _n( '%s Review', '%s Reviews', $review_count, 'the-fashion-frame' ), number_format_i18n( $review_count ) ) ); ?></a>
						</div>
					</div>
				<?php endif; ?>

				<!-- 4. Pricing & Dynamic Discount Block -->
				<div class="product-price-box">
					<div class="product-price-html">
						<?php echo $product->get_price_html(); ?>
					</div>
					<?php
					if ( $product->is_on_sale() ) {
						$reg = $product->is_type( 'variable' ) ? (float) $product->get_variation_regular_price( 'min' ) : (float) $product->get_regular_price();
						$sal = $product->is_type( 'variable' ) ? (float) $product->get_variation_sale_price( 'min' ) : (float) $product->get_sale_price();
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
					<span><?php esc_html_e( 'Inclusive of all taxes • Free shipping on all orders', 'the-fashion-frame' ); ?></span>
				</div>

				<!-- 5. Stock Indicator -->
				<div class="product-stock-indicator">
					<span class="stock-dot"></span>
					<?php if ( $product->is_in_stock() ) : ?>
						<span class="stock-text"><?php esc_html_e( 'In Stock • Ready to Dispatch', 'the-fashion-frame' ); ?></span>
					<?php else : ?>
						<span class="stock-text out-of-stock"><?php esc_html_e( 'Currently Out of Stock', 'the-fashion-frame' ); ?></span>
					<?php endif; ?>
				</div>

				<!-- 6. Size Selection & Purchase Box (Add to Cart, Quantity, Wishlist) -->
				<div class="product-purchase-box">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>

				<!-- 7. Delivery Pincode Checker Component -->
				<div class="pincode-checker-box">
					<div class="pincode-header">
						<span class="material-symbols-outlined pincode-icon">location_on</span>
						<span class="pincode-title"><?php esc_html_e( 'Check Delivery & COD', 'the-fashion-frame' ); ?></span>
					</div>
					<div class="pincode-input-group">
						<input 
							type="text" 
							id="pincode-input" 
							class="pincode-field" 
							placeholder="<?php esc_attr_e( 'Enter 6-digit Pincode', 'the-fashion-frame' ); ?>" 
							maxlength="6" 
							inputmode="numeric" 
							pattern="[0-9]*" 
						/>
						<button type="button" id="pincode-check-btn" class="pincode-btn"><?php esc_html_e( 'CHECK', 'the-fashion-frame' ); ?></button>
					</div>
					<div id="pincode-result" class="pincode-result-msg" style="display: none;"></div>
				</div>

				<!-- 8. Delivery, COD & Return Highlights Strip -->
				<div class="product-service-perks">
					<div class="service-perk-item">
						<span class="material-symbols-outlined">local_shipping</span>
						<div class="perk-text">
							<strong><?php esc_html_e( 'Express Dispatch', 'the-fashion-frame' ); ?></strong>
							<span><?php esc_html_e( 'Ships in 24-48 business hours', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
					<div class="service-perk-item">
						<span class="material-symbols-outlined">payments</span>
						<div class="perk-text">
							<strong><?php esc_html_e( 'Cash on Delivery', 'the-fashion-frame' ); ?></strong>
							<span><?php esc_html_e( 'Available across India', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
					<div class="service-perk-item">
						<span class="material-symbols-outlined">published_with_changes</span>
						<div class="perk-text">
							<strong><?php esc_html_e( '7-Day Easy Exchange', 'the-fashion-frame' ); ?></strong>
							<span><?php esc_html_e( 'Doorstep reverse pick-up', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
				</div>

				<!-- 9. Product Information Accordions -->
				<div class="product-accordions-group">
					
					<!-- Accordion 1: Description -->
					<details class="product-accordion">
						<summary>
							<span class="accordion-title"><?php esc_html_e( 'DESCRIPTION', 'the-fashion-frame' ); ?></span>
							<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
						</summary>
						<div class="accordion-content">
							<?php if ( has_excerpt() ) : ?>
								<div class="product-overview-lead">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>
							<div class="product-editorial-body">
								<?php the_content(); ?>
							</div>
						</div>
					</details>

					<!-- Accordion 2: Style Notes & Fit -->
					<details class="product-accordion">
						<summary>
							<span class="accordion-title"><?php esc_html_e( 'STYLE NOTES & FIT', 'the-fashion-frame' ); ?></span>
							<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
						</summary>
						<div class="accordion-content">
							<ul class="accordion-info-list">
								<li><strong><?php esc_html_e( 'Silhouette:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Comfort-fit tailored ethnic ensemble designed for celebratory & festive wear.', 'the-fashion-frame' ); ?></li>
								<li><strong><?php esc_html_e( 'Neckline & Sleeves:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Intricately embroidered neckline with finished 3/4th tailored sleeves.', 'the-fashion-frame' ); ?></li>
								<li><strong><?php esc_html_e( 'Bottom Fit:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Semi-elasticated waistband with comfort straight-cut silhouette.', 'the-fashion-frame' ); ?></li>
								<li><strong><?php esc_html_e( 'Dupatta:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Full-length designer dupatta with coordinating borders & lace detailing.', 'the-fashion-frame' ); ?></li>
							</ul>
						</div>
					</details>

					<!-- Accordion 3: Material & Care -->
					<details class="product-accordion">
						<summary>
							<span class="accordion-title"><?php esc_html_e( 'MATERIAL & CARE', 'the-fashion-frame' ); ?></span>
							<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
						</summary>
						<div class="accordion-content">
							<?php
							if ( $product->has_attributes() ) {
								do_action( 'woocommerce_product_additional_information', $product );
							} else {
								?>
								<ul class="accordion-info-list">
									<li><strong><?php esc_html_e( 'Fabric Blend:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Premium breathable festive cotton & fine silk blend, gentle on the skin.', 'the-fashion-frame' ); ?></li>
									<li><strong><?php esc_html_e( 'Weave & Texture:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Artisanal woven texture with fine sheen and structured drape.', 'the-fashion-frame' ); ?></li>
									<li><strong><?php esc_html_e( 'Wash Care:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Dry clean recommended, or gentle hand wash separately in cold water with mild detergent.', 'the-fashion-frame' ); ?></li>
									<li><strong><?php esc_html_e( 'Ironing:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'Iron on reverse side on low to medium heat setting.', 'the-fashion-frame' ); ?></li>
								</ul>
								<?php
							}
							?>
						</div>
					</details>

					<!-- Accordion 4: Specifications -->
					<details class="product-accordion">
						<summary>
							<span class="accordion-title"><?php esc_html_e( 'SPECIFICATIONS', 'the-fashion-frame' ); ?></span>
							<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
						</summary>
						<div class="accordion-content">
							<table class="specs-mini-table">
								<tbody>
									<tr>
										<th><?php esc_html_e( 'Package Contains', 'the-fashion-frame' ); ?></th>
										<td><?php esc_html_e( '1 Kurta, 1 Pant/Bottom, 1 Dupatta', 'the-fashion-frame' ); ?></td>
									</tr>
									<tr>
										<th><?php esc_html_e( 'Craftsmanship', 'the-fashion-frame' ); ?></th>
										<td><?php esc_html_e( 'Intricate Artisanal Zari, Resham & Lace Embroidered detailing', 'the-fashion-frame' ); ?></td>
									</tr>
									<tr>
										<th><?php esc_html_e( 'Occasion', 'the-fashion-frame' ); ?></th>
										<td><?php esc_html_e( 'Festive, Wedding, Evening & Cultural Celebrations', 'the-fashion-frame' ); ?></td>
									</tr>
									<tr>
										<th><?php esc_html_e( 'Country of Origin', 'the-fashion-frame' ); ?></th>
										<td><?php esc_html_e( 'India', 'the-fashion-frame' ); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</details>

					<!-- Accordion 5: Seller & Shipping Information -->
					<details class="product-accordion">
						<summary>
							<span class="accordion-title"><?php esc_html_e( 'SELLER & RETURN POLICY', 'the-fashion-frame' ); ?></span>
							<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
						</summary>
						<div class="accordion-content">
							<p><strong><?php esc_html_e( 'Sold & Marketed By:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'The Fashion Frame (Customer Support: fashionframelko@gmail.com | +91 92783 40090).', 'the-fashion-frame' ); ?></p>
							<p style="margin-top: 0.6rem;"><strong><?php esc_html_e( '7-Day Return / Exchange Policy:', 'the-fashion-frame' ); ?></strong> <?php esc_html_e( 'We offer a seamless 7-day exchange on all unworn items with original tags and packaging intact. Doorstep reverse pick-up is arranged across India.', 'the-fashion-frame' ); ?></p>
						</div>
					</details>

					<!-- Accordion 6: Reviews (when open) -->
					<?php if ( comments_open() || $product->get_review_count() > 0 ) : ?>
						<details class="product-accordion" id="reviews">
							<summary>
								<span class="accordion-title"><?php printf( esc_html__( 'CUSTOMER REVIEWS (%d)', 'the-fashion-frame' ), $product->get_review_count() ); ?></span>
								<span class="accordion-icon"><span class="material-symbols-outlined">expand_more</span></span>
							</summary>
							<div class="accordion-content">
								<?php comments_template(); ?>
							</div>
						</details>
					<?php endif; ?>

				</div><!-- .product-accordions-group -->

			</div><!-- .product-summary-col -->

		</div><!-- .product-detail-layout -->

		<!-- Related Products Section -->
		<?php
		$related_ids = wc_get_related_products( $product_id, 4 );
		if ( ! empty( $related_ids ) ) :
			?>
			<section class="related-products-section">
				<div class="section-header text-center">
					<span class="font-label-caps text-on-surface-variant uppercase tracking-widest block mb-2"><?php esc_html_e( 'Curated For You', 'the-fashion-frame' ); ?></span>
					<h2 class="font-headline-md text-primary"><?php esc_html_e( 'Related Creations', 'the-fashion-frame' ); ?></h2>
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

</div><!-- .single-product-wrapper -->

<!-- SIZE GUIDE MODAL (Accessible, Clean, Inches & CM) -->
<div id="tff-size-guide-modal" class="tff-modal" aria-hidden="true" role="dialog" aria-labelledby="size-guide-title">
	<div class="tff-modal-backdrop" id="tff-size-guide-backdrop"></div>
	<div class="tff-modal-dialog">
		<div class="tff-modal-header">
			<div class="tff-modal-title-group">
				<span class="material-symbols-outlined text-secondary">straighten</span>
				<h3 id="size-guide-title" class="tff-modal-title"><?php esc_html_e( 'Garment Size Guide', 'the-fashion-frame' ); ?></h3>
			</div>
			<button type="button" class="tff-modal-close" id="tff-size-guide-close" aria-label="<?php esc_attr_e( 'Close Size Guide', 'the-fashion-frame' ); ?>">
				<span class="material-symbols-outlined">close</span>
			</button>
		</div>
		<div class="tff-modal-body">
			<p class="size-guide-intro"><?php esc_html_e( 'All measurements given below are garment measurements in inches and centimeters. For the best fit, choose a size that is 2 inches larger than your actual body measurement.', 'the-fashion-frame' ); ?></p>
			
			<div class="size-table-responsive">
				<table class="size-guide-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Size', 'the-fashion-frame' ); ?></th>
							<th><?php esc_html_e( 'Bust (Inches / CM)', 'the-fashion-frame' ); ?></th>
							<th><?php esc_html_e( 'Waist (Inches / CM)', 'the-fashion-frame' ); ?></th>
							<th><?php esc_html_e( 'Hip (Inches / CM)', 'the-fashion-frame' ); ?></th>
							<th><?php esc_html_e( 'Shoulder', 'the-fashion-frame' ); ?></th>
							<th><?php esc_html_e( 'Length', 'the-fashion-frame' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><strong>S</strong></td>
							<td>36" (91 cm)</td>
							<td>32" (81 cm)</td>
							<td>38" (97 cm)</td>
							<td>14.5"</td>
							<td>44"</td>
						</tr>
						<tr>
							<td><strong>M</strong></td>
							<td>38" (97 cm)</td>
							<td>34" (86 cm)</td>
							<td>40" (102 cm)</td>
							<td>15.0"</td>
							<td>44"</td>
						</tr>
						<tr>
							<td><strong>L</strong></td>
							<td>40" (102 cm)</td>
							<td>36" (91 cm)</td>
							<td>42" (107 cm)</td>
							<td>15.5"</td>
							<td>45"</td>
						</tr>
						<tr>
							<td><strong>XL</strong></td>
							<td>42" (107 cm)</td>
							<td>38" (97 cm)</td>
							<td>44" (112 cm)</td>
							<td>16.0"</td>
							<td>45"</td>
						</tr>
						<tr>
							<td><strong>XXL</strong></td>
							<td>44" (112 cm)</td>
							<td>40" (102 cm)</td>
							<td>46" (117 cm)</td>
							<td>16.5"</td>
							<td>45"</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="size-guide-tips">
				<h4><?php esc_html_e( 'How to Measure Yourself', 'the-fashion-frame' ); ?></h4>
				<div class="tips-grid">
					<div class="tip-col">
						<strong><?php esc_html_e( '1. Bust:', 'the-fashion-frame' ); ?></strong>
						<span><?php esc_html_e( 'Measure around the fullest part of your chest with tape horizontal.', 'the-fashion-frame' ); ?></span>
					</div>
					<div class="tip-col">
						<strong><?php esc_html_e( '2. Waist:', 'the-fashion-frame' ); ?></strong>
						<span><?php esc_html_e( 'Measure around your natural waistline, keeping tape slightly loose.', 'the-fashion-frame' ); ?></span>
					</div>
					<div class="tip-col">
						<strong><?php esc_html_e( '3. Hips:', 'the-fashion-frame' ); ?></strong>
						<span><?php esc_html_e( 'Measure around the fullest part of your hips, standing with feet together.', 'the-fashion-frame' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- FULLSCREEN TOUCH ZOOM LIGHTBOX MODAL -->
<div id="product-zoom-modal" class="product-zoom-modal" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'Product Image Zoom', 'the-fashion-frame' ); ?>">
	<div class="product-zoom-backdrop" id="product-zoom-backdrop"></div>
	
	<div class="product-zoom-container">
		<div class="product-zoom-topbar">
			<div class="product-zoom-counter">
				<span id="product-zoom-current">1</span> / <span id="product-zoom-total"><?php echo max( 1, $total_images ); ?></span>
			</div>
			
			<div class="product-zoom-controls">
				<button type="button" class="zoom-btn zoom-btn-out" id="zoom-btn-out" aria-label="<?php esc_attr_e( 'Zoom out (-)', 'the-fashion-frame' ); ?>" title="<?php esc_attr_e( 'Zoom out (-)', 'the-fashion-frame' ); ?>">
					<span class="material-symbols-outlined">zoom_out</span>
				</button>
				<span class="zoom-level-badge" id="zoom-level-badge">100%</span>
				<button type="button" class="zoom-btn zoom-btn-in" id="zoom-btn-in" aria-label="<?php esc_attr_e( 'Zoom in (+)', 'the-fashion-frame' ); ?>" title="<?php esc_attr_e( 'Zoom in (+)', 'the-fashion-frame' ); ?>">
					<span class="material-symbols-outlined">zoom_in</span>
				</button>
				<button type="button" class="zoom-btn zoom-btn-reset" id="zoom-btn-reset" aria-label="<?php esc_attr_e( 'Reset zoom', 'the-fashion-frame' ); ?>" title="<?php esc_attr_e( 'Reset zoom', 'the-fashion-frame' ); ?>">
					<span class="material-symbols-outlined">restart_alt</span>
				</button>
				<button type="button" class="zoom-btn zoom-btn-close" id="zoom-btn-close" aria-label="<?php esc_attr_e( 'Close viewer (Esc)', 'the-fashion-frame' ); ?>" title="<?php esc_attr_e( 'Close viewer (Esc)', 'the-fashion-frame' ); ?>">
					<span class="material-symbols-outlined">close</span>
				</button>
			</div>
		</div>

		<div class="product-zoom-viewport" id="product-zoom-viewport">
			<div class="product-zoom-canvas" id="product-zoom-canvas">
				<img id="product-zoom-img" src="<?php echo esc_url( $main_image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" draggable="false" />
			</div>

			<?php if ( $total_images > 1 ) : ?>
				<button type="button" class="zoom-nav-arrow zoom-nav-prev" id="zoom-nav-prev" aria-label="<?php esc_attr_e( 'Previous Image', 'the-fashion-frame' ); ?>">
					<span class="material-symbols-outlined">chevron_left</span>
				</button>
				<button type="button" class="zoom-nav-arrow zoom-nav-next" id="zoom-nav-next" aria-label="<?php esc_attr_e( 'Next Image', 'the-fashion-frame' ); ?>">
					<span class="material-symbols-outlined">chevron_right</span>
				</button>
			<?php endif; ?>
		</div>

		<div class="product-zoom-bottombar">
			<p class="zoom-touch-hint"><?php esc_html_e( 'Pinch or use (+ / -) to zoom • Drag to explore embroidery & craftsmanship', 'the-fashion-frame' ); ?></p>
		</div>
	</div>
</div>

<!-- MOBILE FIXED BOTTOM PURCHASE BAR (Visible on Mobile/Tablet < 1024px) -->
<div class="mobile-sticky-purchase-bar" id="mobile-sticky-purchase-bar">
	<div class="mobile-sticky-bar-actions">
		<button type="button" class="mobile-bar-btn mobile-bar-add-to-cart" id="mobile-bar-add-to-cart">
			<span class="material-symbols-outlined text-[20px]">shopping_bag</span>
			<span><?php esc_html_e( 'ADD TO BAG', 'the-fashion-frame' ); ?></span>
		</button>
	</div>
</div>

<?php
get_footer( 'shop' );
