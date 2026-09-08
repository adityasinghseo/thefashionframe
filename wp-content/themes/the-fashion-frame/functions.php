<?php
/**
 * The Fashion Frame functions and definitions
 *
 * @package The_Fashion_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'the_fashion_frame_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function the_fashion_frame_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'the-fashion-frame', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register Primary Navigation Menu Location.
		register_nav_menus(
			array(
				'primary'        => esc_html__( 'Primary Navigation', 'the-fashion-frame' ),
				'footer_shop'    => esc_html__( 'Footer Shop Menu', 'the-fashion-frame' ),
				'footer_support' => esc_html__( 'Footer Support Menu', 'the-fashion-frame' ),
			)
		);

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom logo feature.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 120,
				'width'       => 120,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Enable WooCommerce theme support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
endif;
add_action( 'after_setup_theme', 'the_fashion_frame_setup' );

/**
 * Remove default WooCommerce sidebar everywhere across product and shop pages.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Enqueue scripts and styles.
 */
function the_fashion_frame_scripts() {
	// Google Fonts & Google Material Symbols Outlined.
	wp_enqueue_style(
		'the-fashion-frame-google-fonts',
		'https://fonts.googleapis.com/css2?family=Bodoni+Moda:opsz,wght@6..96,400..900&family=Plus+Jakarta+Sans:wght@400..700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
		array(),
		null
	);

	// Theme Stylesheet.
	wp_enqueue_style(
		'the-fashion-frame-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	// Navigation & UI JS.
	wp_enqueue_script(
		'the-fashion-frame-navigation',
		get_template_directory_uri() . '/js/navigation.js',
		array( 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'the_fashion_frame_scripts' );

/**
 * Fallback primary menu output matching the Stitch design order:
 * 1. Women's Suits
 * 2. Kids Wear
 * 3. New Arrivals
 * 4. Collections
 */
function the_fashion_frame_default_primary_menu() {
	$womens_url    = the_fashion_frame_get_category_url( array( 'womens-suits', 'women', 'womens', 'suits' ), '/womens-suits/' );
	$kids_url      = the_fashion_frame_get_category_url( array( 'kids-wear', 'kids', 'children' ), '/kids-wear/' );
	$new_url       = home_url( '/new-arrivals/' );
	$coll_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/collections/' );

	echo '<ul class="header-nav-list">';
	echo '<li><a class="nav-link" href="' . esc_url( $womens_url ) . '">' . esc_html__( "Women's Suits", 'the-fashion-frame' ) . '</a></li>';
	echo '<li><a class="nav-link" href="' . esc_url( $kids_url ) . '">' . esc_html__( 'Kids Wear', 'the-fashion-frame' ) . '</a></li>';
	echo '<li><a class="nav-link" href="' . esc_url( $new_url ) . '">' . esc_html__( 'New Arrivals', 'the-fashion-frame' ) . '</a></li>';
	echo '<li><a class="nav-link" href="' . esc_url( $coll_url ) . '">' . esc_html__( 'Collections', 'the-fashion-frame' ) . '</a></li>';
	echo '</ul>';
}

/**
 * Fallback mobile menu output matching the Stitch design order.
 */
function the_fashion_frame_default_mobile_menu() {
	$womens_url    = the_fashion_frame_get_category_url( array( 'womens-suits', 'women', 'womens', 'suits' ), '/womens-suits/' );
	$kids_url      = the_fashion_frame_get_category_url( array( 'kids-wear', 'kids', 'children' ), '/kids-wear/' );
	$new_url       = home_url( '/new-arrivals/' );
	$coll_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/collections/' );

	echo '<ul class="mobile-drawer-menu">';
	echo '<li><a href="' . esc_url( $womens_url ) . '">' . esc_html__( "Women's Suits", 'the-fashion-frame' ) . '</a></li>';
	echo '<li><a href="' . esc_url( $kids_url ) . '">' . esc_html__( 'Kids Wear', 'the-fashion-frame' ) . '</a></li>';
	echo '<li><a href="' . esc_url( $new_url ) . '">' . esc_html__( 'New Arrivals', 'the-fashion-frame' ) . '</a></li>';
	echo '<li><a href="' . esc_url( $coll_url ) . '">' . esc_html__( 'Collections', 'the-fashion-frame' ) . '</a></li>';
	echo '</ul>';
}

/**
 * Helper to retrieve product category term link by potential slugs/names, with fallback URL.
 *
 * @param array|string $slugs
 * @param string       $fallback_path
 * @return string
 */
function the_fashion_frame_get_category_url( $slugs, $fallback_path = '/' ) {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return esc_url( home_url( $fallback_path ) );
	}

	$slug_list = is_array( $slugs ) ? $slugs : array( $slugs );

	foreach ( $slug_list as $slug ) {
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( ! $term || is_wp_error( $term ) ) {
			$term = get_term_by( 'name', $slug, 'product_cat' );
		}
		if ( $term && ! is_wp_error( $term ) ) {
			$link = get_term_link( $term, 'product_cat' );
			if ( ! is_wp_error( $link ) ) {
				return $link;
			}
		}
	}

	return esc_url( home_url( $fallback_path ) );
}

/**
 * Helper to get cart count securely with WooCommerce compatibility.
 */
function the_fashion_frame_cart_count() {
	if ( function_exists( 'WC' ) && WC()->cart ) {
		return WC()->cart->get_cart_contents_count();
	}
	return 0;
}

/**
 * Ensure front-page.php template is loaded for the homepage even when Settings -> Reading is on "Latest Posts".
 */
function the_fashion_frame_front_page_template( $template ) {
	if ( is_front_page() || is_home() ) {
		$front_page = locate_template( array( 'front-page.php' ) );
		if ( $front_page ) {
			return $front_page;
		}
	}
	return $template;
}
add_filter( 'template_include', 'the_fashion_frame_front_page_template', 99 );

/**
 * Helper to get the site logo URL (supports custom logo or default uploaded circular logo).
 *
 * @return string
 */
function the_fashion_frame_get_logo_url() {
	if ( has_custom_logo() ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		if ( ! empty( $image[0] ) ) {
			return $image[0];
		}
	}
	return home_url( '/wp-content/uploads/2026/09/thefashion-logo.jpg' );
}

/**
 * Render the circular site logo.
 *
 * @param string $class Additional CSS classes
 * @param int $size Width and height in px
 */
function the_fashion_frame_site_logo( $class = '', $size = 52 ) {
	$logo_url = the_fashion_frame_get_logo_url();
	$site_name = get_bloginfo( 'name' );
	?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="brand-logo-link <?php echo esc_attr( $class ); ?>" aria-label="<?php echo esc_attr( $site_name ); ?>">
		<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" class="circular-logo site-logo-img" width="<?php echo esc_attr( $size ); ?>" height="<?php echo esc_attr( $size ); ?>" loading="eager" />
	</a>
	<?php
}

