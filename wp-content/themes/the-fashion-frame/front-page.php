<?php
/**
 * The template for displaying the homepage directly without relying on Settings -> Reading.
 *
 * (1) Hero Banner Section
 * (2) Category Feature Cards (Women's Suits & Kids Wear linking via get_term_link())
 * (3) Featured Products Grid (wc_get_products() pulling 8 products styled with Stitch cards)
 * (4) Brand Story Strip
 *
 * @package The_Fashion_Frame
 */

get_header();

// 1. Resolve Category Term Links using get_term_link()
// Women's Suits
$womens_term = get_term_by( 'slug', 'womens-suits', 'product_cat' );
if ( ! $womens_term || is_wp_error( $womens_term ) ) {
	$womens_term = get_term_by( 'name', "Women's Suits", 'product_cat' );
}
if ( ! $womens_term || is_wp_error( $womens_term ) ) {
	$womens_term = get_term_by( 'slug', 'women', 'product_cat' );
}
$womens_link = ( $womens_term && ! is_wp_error( $womens_term ) ) ? get_term_link( $womens_term, 'product_cat' ) : home_url( '/product-category/womens-suits/' );
if ( is_wp_error( $womens_link ) ) {
	$womens_link = home_url( '/product-category/womens-suits/' );
}

// Kids Wear
$kids_term = get_term_by( 'slug', 'kids-wear', 'product_cat' );
if ( ! $kids_term || is_wp_error( $kids_term ) ) {
	$kids_term = get_term_by( 'name', 'Kids Wear', 'product_cat' );
}
if ( ! $kids_term || is_wp_error( $kids_term ) ) {
	$kids_term = get_term_by( 'slug', 'kids', 'product_cat' );
}
$kids_link = ( $kids_term && ! is_wp_error( $kids_term ) ) ? get_term_link( $kids_term, 'product_cat' ) : home_url( '/product-category/kids-wear/' );
if ( is_wp_error( $kids_link ) ) {
	$kids_link = home_url( '/product-category/kids-wear/' );
}

// 2. Fetch 8 Products using wc_get_products()
$products = array();
if ( function_exists( 'wc_get_products' ) ) {
	// First attempt: fetch featured products
	$products = wc_get_products(
		array(
			'status'   => 'publish',
			'limit'    => 8,
			'featured' => true,
			'orderby'  => 'date',
			'order'    => 'DESC',
		)
	);

	// Fallback: If fewer than 8 featured products, fetch latest published products
	if ( count( $products ) < 8 ) {
		$products = wc_get_products(
			array(
				'status'  => 'publish',
				'limit'   => 8,
				'orderby' => 'date',
				'order'   => 'DESC',
			)
		);
	}
}
?>

<!-- 1. Hero Section -->
<section class="hero-section">
	<div class="hero-bg-wrapper">
		<?php $hero_img_url = get_template_directory_uri() . '/images/hero-womens-kids-collection.jpg'; ?>
		<div class="hero-bg-image" style="background-image: url('<?php echo esc_url( $hero_img_url ); ?>');"></div>
		<div class="hero-overlay"></div>
	</div>
	<div class="hero-content">
		<h1 class="font-display-lg hero-title"><?php esc_html_e( 'The Art of Lucknowi Heritage', 'the-fashion-frame' ); ?></h1>
		<p class="font-body-lg hero-subtitle">
			<?php esc_html_e( 'Discover the timeless elegance of slow fashion, where ornate craftsmanship meets modern minimalism.', 'the-fashion-frame' ); ?>
		</p>
		<a href="<?php echo esc_url( $womens_link ); ?>" class="btn-primary">
			<?php esc_html_e( 'SHOP NOW', 'the-fashion-frame' ); ?>
		</a>
	</div>
</section>

<!-- 2. Category Feature Cards Section -->
<section class="category-section">
	<div class="category-grid">
		<!-- Women's Suits Card -->
		<?php $womens_img_url = get_template_directory_uri() . '/images/category-womens-suits.jpg'; ?>
		<a href="<?php echo esc_url( $womens_link ); ?>" class="category-card group">
			<div class="category-card-bg" style="background-image: url('<?php echo esc_url( $womens_img_url ); ?>');"></div>
			<div class="category-card-gradient"></div>
			<div class="category-card-content">
				<h2 class="category-card-title"><?php esc_html_e( "Women's Suits", 'the-fashion-frame' ); ?></h2>
				<span class="category-card-cta"><?php esc_html_e( 'EXPLORE COLLECTION', 'the-fashion-frame' ); ?></span>
			</div>
		</a>

		<!-- Kids Collection Card -->
		<?php $kids_img_url = get_template_directory_uri() . '/images/category-kids-collection.jpg'; ?>
		<a href="<?php echo esc_url( $kids_link ); ?>" class="category-card group">
			<div class="category-card-bg" style="background-image: url('<?php echo esc_url( $kids_img_url ); ?>');"></div>
			<div class="category-card-gradient"></div>
			<div class="category-card-content">
				<h2 class="category-card-title"><?php esc_html_e( 'Kids Collection', 'the-fashion-frame' ); ?></h2>
				<span class="category-card-cta"><?php esc_html_e( 'EXPLORE COLLECTION', 'the-fashion-frame' ); ?></span>
			</div>
		</a>
	</div>
</section>

<!-- 3. Featured Products Grid (8 Products) -->
<section class="featured-products-section site-container" style="padding-bottom: var(--section-gap-lg);">
	<div class="section-header text-center" style="margin-bottom: 3.5rem;">
		<span class="font-label-caps text-on-surface-variant uppercase tracking-widest block mb-2"><?php esc_html_e( 'Handcrafted Elegance', 'the-fashion-frame' ); ?></span>
		<h2 class="font-headline-lg text-primary"><?php esc_html_e( 'Featured Creations', 'the-fashion-frame' ); ?></h2>
		<div style="width: 48px; height: 1px; background: var(--color-secondary-fixed-dim); margin: 1rem auto 0;"></div>
	</div>

	<?php if ( ! empty( $products ) ) : ?>
		<div class="products-grid grid-4-col">
			<?php
			global $product;
			foreach ( $products as $wc_prod ) :
				$product = $wc_prod;
				setup_postdata( $GLOBALS['post'] =& get_post( $product->get_id() ) );
				get_template_part( 'template-parts/product-card' );
			endforeach;
			wp_reset_postdata();
			?>
		</div>
	<?php else : ?>
		<!-- Sample Placeholder Grid if WooCommerce catalogue is not yet populated -->
		<div class="products-grid grid-4-col">
			<?php
			$mock_items = array(
				array(
					'cat'   => 'Georgette',
					'title' => 'Ivory Grace Anarkali',
					'price' => '$360',
					'old'   => '$450',
					'badge' => '20% OFF',
					'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBREhGxS4Iv_GNq5xbtcD2FjFUko7hEojE3QP8kXPSyJCoM5Ibooitzs0J3n1JCGgFzZTMrTs18RqU01UGMh-C2DdcO7YO-5KnmhPYw1_Q0g8nCh2hXWF8tMKhCvnPYudDPcwnaXWP1xm1Fjk0egEwKQzooCFSG_fGJm5GlR-hVgGHx-M6WUfYmNQP4PGGuoHy2kt4dLTnAzYVe8vdntUAjVIrlV2UFzGbvhumIdqyJQfggPJX9Xqs_zw',
				),
				array(
					'cat'   => 'Chanderi Silk',
					'title' => 'Sage Heritage Kurta Set',
					'price' => '$520',
					'badge' => '',
					'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCGmupDJUpO2UI6m5bGDzvdjbOdZS23oK0AdcnJ02Ofxk_5-usMN_ckKH63PmG5Rpmsx_i6fE4ggsLnwA13cR8ecR9AjrBYMwXY4vSMsSUb9t5Ctk-NIteqBKHw7Z6wuYiNn-08RAsAI4u0E0NOY19C4mvs4Q6V5aifBY7zf2669yvH-q8S-1KJaXrQ7a0WeY_BEnaqIqHNc9QhOB5SOxFV5AyglewoT-4GF38epdF4mcukYZKXiTi0Pw',
				),
				array(
					'cat'   => 'Mulmul Cotton',
					'title' => 'Midnight Noir Ensemble',
					'price' => '$290',
					'badge' => 'Handcrafted',
					'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCsF2tOaPq7HRQwT4rVH8OyzBwdylIBsGJLjDgXFoiO2MwX4JH7iH_nzVTJaIgNl2KQl_1QBUeUCB5pgRNrEgRG4w4TGuRzSkZVksBO7j19UqVLcfQh0rwuNLPk6pxYzZ5O3rkVFr380U8acDWw9OU3a-lqdzYu9k3damXl8Bzb-Raox0Z8QxWZa64tQG3dxBJhod48CW17dYJzSuDW2BqWBUwGWxoDZS_ZboPNw2njKNiH8Jz2f_XpaQ',
				),
				array(
					'cat'   => 'Organza',
					'title' => 'Dusty Rose Dupatta Set',
					'price' => '$410',
					'badge' => '',
					'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCikHTzjlGrNcMEQCAcSnRO3_6LCXhI9KANK7uTkcnQsMWYbpY8qF-N0x42-vOtrSefadoduvUQuyB_M3siurfjjnfFNYm5ocOL7VVviXxYAEuHxqSdWGyyy6F8YAyNuHRLNlNNlFa_22EBdK-j6_WtGnZzsUGbIEKfQhiC2mVA1_DpG9f5_t0TFXwfrfuk5rdZPqlJNdboRqThhIS4ie3dxdul2y1vcE_su_rP2aTXGHpdw84uXbtAfA',
				),
				array(
					'cat'   => 'Chanderi',
					'title' => 'Gulab Embroidered Angrakha',
					'price' => '$480',
					'badge' => '',
					'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCcGQsb490vesORuuNiJFfsXWSPHEZwMhwtT_4Gairp4sYv3VBEtREV0o8Pqol9P4fxfUG8C16Ows9FVL-K76xA85LZ-QA6wR_Pwfdt_kO7J4wJPk-jsGtEZAK2-6xgyQb0GvSFKYKxnk7A_0hc3y5LNr8BvhRmCluPP5Ks-8_BkhDp_qYKhFyReIUHsdHSGluk5Ds2xhTiYgM2prSa_jRHdhMUx8Q510OZGQIEE0HON5k8ou99n7TrDw',
				),
				array(
					'cat'   => 'Pure Silk',
					'title' => 'Zari Bordered Noor Suit',
					'price' => '$560',
					'old'   => '$620',
					'badge' => 'SALE',
					'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBe6E1Ja4Z7jXgGthdnhBPXEZB3zlKQ57R4PUab_avXJMZqumSynWGC9bAyGgQfMRhxndApk4f2V4ChlZnyRcwI2Ytqpvlx5cVddIDNaVPV79kM-96ZUuAX1cwKoeCmk_Qlzw7ncCuP4jSh7iGPjKmq9DTi4qeVmDHGOIa7EHRKbeLQ59I86Vk9PHSb-8o0T3BuW2Aj-f7w4V40HBhEYbitJ-Fa1VmqQ_FTOCA1XB82rAetdiP6kncBVQ',
				),
				array(
					'cat'   => 'Lawn Cotton',
					'title' => 'Parijat Pastel Suit',
					'price' => '$320',
					'badge' => 'Handcrafted',
					'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBREhGxS4Iv_GNq5xbtcD2FjFUko7hEojE3QP8kXPSyJCoM5Ibooitzs0J3n1JCGgFzZTMrTs18RqU01UGMh-C2DdcO7YO-5KnmhPYw1_Q0g8nCh2hXWF8tMKhCvnPYudDPcwnaXWP1xm1Fjk0egEwKQzooCFSG_fGJm5GlR-hVgGHx-M6WUfYmNQP4PGGuoHy2kt4dLTnAzYVe8vdntUAjVIrlV2UFzGbvhumIdqyJQfggPJX9Xqs_zw',
				),
				array(
					'cat'   => 'Chiffon',
					'title' => 'Shimmering Chandani Set',
					'price' => '$390',
					'badge' => '',
					'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCGmupDJUpO2UI6m5bGDzvdjbOdZS23oK0AdcnJ02Ofxk_5-usMN_ckKH63PmG5Rpmsx_i6fE4ggsLnwA13cR8ecR9AjrBYMwXY4vSMsSUb9t5Ctk-NIteqBKHw7Z6wuYiNn-08RAsAI4u0E0NOY19C4mvs4Q6V5aifBY7zf2669yvH-q8S-1KJaXrQ7a0WeY_BEnaqIqHNc9QhOB5SOxFV5AyglewoT-4GF38epdF4mcukYZKXiTi0Pw',
				),
			);

			foreach ( $mock_items as $item ) :
				?>
				<article class="product-card group flex flex-col relative">
					<div class="product-card-media relative w-full aspect-[3/4] mb-4 bg-surface-container-low rounded-lg overflow-hidden gold-hairline isolate">
						<?php if ( ! empty( $item['badge'] ) ) : ?>
							<?php if ( strpos( $item['badge'], 'OFF' ) !== false || $item['badge'] === 'SALE' ) : ?>
								<div class="product-badge badge-sale"><?php echo esc_html( $item['badge'] ); ?></div>
							<?php else : ?>
								<div class="product-badge badge-handcrafted">
									<span class="material-symbols-outlined text-[14px]">auto_awesome</span>
									<span><?php echo esc_html( $item['badge'] ); ?></span>
								</div>
							<?php endif; ?>
						<?php endif; ?>
						<a href="<?php echo esc_url( $womens_link ); ?>" class="block w-full h-full">
							<img src="<?php echo esc_url( $item['img'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" class="product-card-img object-cover w-full h-full transition-transform duration-700 group-hover:scale-105" />
						</a>
						<div class="product-card-overlay">
							<a href="<?php echo esc_url( $womens_link ); ?>" class="product-quickview-btn" aria-label="<?php echo esc_attr( $item['title'] ); ?>">
								<span class="material-symbols-outlined">visibility</span>
							</a>
						</div>
					</div>
					<div class="product-card-info flex flex-col gap-1 text-center">
						<span class="product-card-category font-label-caps text-on-surface-variant uppercase tracking-wider"><?php echo esc_html( $item['cat'] ); ?></span>
						<h2 class="product-card-title font-headline-sm text-primary line-clamp-1">
							<a href="<?php echo esc_url( $womens_link ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
						</h2>
						<div class="product-card-price font-body-md flex justify-center gap-3">
							<?php if ( ! empty( $item['old'] ) ) : ?>
								<span class="price-old text-on-surface-variant line-through"><?php echo esc_html( $item['old'] ); ?></span>
							<?php endif; ?>
							<span class="price-current text-secondary font-medium"><?php echo esc_html( $item['price'] ); ?></span>
						</div>
					</div>
				</article>
				<?php
			endforeach;
			?>
		</div>
	<?php endif; ?>
</section>

<!-- 4. Brand Story Strip -->
<section class="brand-story-strip">
	<div class="brand-story-motif">
		<svg class="w-full h-full" fill="currentColor" preserveAspectRatio="none" viewBox="0 0 100 100">
			<pattern id="story-motif" width="20" height="20" patternUnits="userSpaceOnUse">
				<circle cx="10" cy="10" r="2" opacity="0.5"></circle>
				<path d="M5 10 Q10 5 15 10 Q10 15 5 10" opacity="0.3"></path>
			</pattern>
			<rect width="100%" height="100%" fill="url(#story-motif)"></rect>
		</svg>
	</div>
	<div class="brand-story-inner">
		<h2 class="font-headline-lg"><?php esc_html_e( 'Rooted in Tradition, Crafted for Today.', 'the-fashion-frame' ); ?></h2>
		<p class="font-body-lg">
			<?php esc_html_e( 'Every piece is a testament to the slow, deliberate art of Lucknowi craftsmanship. We blend heritage techniques with modern editorial minimalism to frame you in timeless elegance.', 'the-fashion-frame' ); ?>
		</p>
	</div>
</section>

<?php
get_footer();
