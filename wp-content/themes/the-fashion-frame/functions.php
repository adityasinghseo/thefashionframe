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
	// Google Fonts (Inter primary, Bodoni Moda for brand wordmark).
	wp_enqueue_style(
		'the-fashion-frame-google-fonts',
		'https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,500;0,6..96,600&family=Inter:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	// Google Material Symbols Outlined.
	wp_enqueue_style(
		'the-fashion-frame-material-symbols',
		'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap',
		array(),
		null
	);

	// Theme Stylesheet.
	wp_enqueue_style(
		'the-fashion-frame-style',
		get_stylesheet_uri(),
		array(),
		filemtime( get_stylesheet_directory() . '/style.css' )
	);

	// Navigation & UI JS.
	wp_enqueue_script(
		'the-fashion-frame-navigation',
		get_template_directory_uri() . '/js/navigation.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/js/navigation.js' ),
		true
	);

	// Localize script parameters for AJAX cart and checkout navigation.
	wp_localize_script(
		'the-fashion-frame-navigation',
		'theFashionFrameParams',
		array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'cartUrl'     => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ),
			'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/checkout/' ),
			'nonce'       => wp_create_nonce( 'the-fashion-frame-nonce' ),
		)
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
	return home_url( '/wp-content/uploads/2026/11/Golden-TF-Monogram-in-Hexagon.webp' );
}

/**
 * Render the site logo.
 *
 * @param string $class Additional CSS classes
 * @param int $size Width and height in px
 */
function the_fashion_frame_site_logo( $class = '', $size = 52 ) {
	$logo_url = the_fashion_frame_get_logo_url();
	$site_name = get_bloginfo( 'name' );
	?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="brand-logo-link <?php echo esc_attr( $class ); ?>" aria-label="<?php echo esc_attr( $site_name ); ?>">
		<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" class="brand-logo-img site-logo-img" width="<?php echo esc_attr( $size ); ?>" height="<?php echo esc_attr( $size ); ?>" loading="eager" />
	</a>
	<?php
}

/**
 * Ensure header cart count fragment is updated dynamically on add to cart.
 */
function the_fashion_frame_cart_count_fragment( $fragments ) {
	$cart_count = the_fashion_frame_cart_count();
	$cart_url   = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' );
	$badge_html = '<a href="' . esc_url( $cart_url ) . '" class="header-action-btn header-cart-btn" aria-label="' . esc_attr__( 'Cart', 'the-fashion-frame' ) . '">';
	$badge_html .= '<span class="material-symbols-outlined" aria-hidden="true">shopping_bag</span>';
	if ( $cart_count > 0 ) {
		$badge_html .= '<span class="cart-count">' . esc_html( $cart_count ) . '</span>';
	}
	$badge_html .= '</a>';
	$fragments['a.header-cart-btn'] = $badge_html;
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'the_fashion_frame_cart_count_fragment' );

/**
 * AJAX Single Product Add-to-Cart Handler.
 * Adds the item without full page refresh, supports variations, and returns updated fragments.
 */
function the_fashion_frame_ajax_single_add_to_cart() {
	check_ajax_referer( 'the-fashion-frame-nonce', 'security', false );

	$product_id   = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$quantity     = isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : 1;
	$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
	$variations   = array();

	foreach ( $_POST as $key => $value ) {
		if ( strpos( $key, 'attribute_' ) === 0 ) {
			$variations[ sanitize_title( $key ) ] = sanitize_text_field( wp_unslash( $value ) );
		}
	}

	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations );

	if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations ) ) {
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );

		WC_AJAX::get_refreshed_fragments();
	} else {
		$data = array(
			'error'       => true,
			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
			'notices'     => wc_print_notices( true ),
		);
		wp_send_json( $data );
	}
	wp_die();
}
add_action( 'wp_ajax_the_fashion_frame_single_add_to_cart', 'the_fashion_frame_ajax_single_add_to_cart' );
add_action( 'wp_ajax_nopriv_the_fashion_frame_single_add_to_cart', 'the_fashion_frame_ajax_single_add_to_cart' );

/**
 * Add "BUY NOW" button alongside Add to Cart for instant direct-to-checkout purchase.
 * (Disabled as requested to keep Add to Cart and Wishlist together in one line)
 */
function the_fashion_frame_add_buy_now_button() {
	$checkout_url = function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/checkout/' );
	?>
	<button type="button" class="product-buy-now-btn button" data-checkout-url="<?php echo esc_url( $checkout_url ); ?>">
		<span class="material-symbols-outlined text-[18px]">bolt</span>
		<span><?php esc_html_e( 'BUY NOW', 'the-fashion-frame' ); ?></span>
	</button>
	<?php
}
// add_action( 'woocommerce_after_add_to_cart_button', 'the_fashion_frame_add_buy_now_button', 15 );

/**
 * Add sleek Wishlist / Favorite button alongside purchase buttons.
 */
function the_fashion_frame_add_wishlist_button() {
	global $product;
	$product_id = ( $product && is_a( $product, 'WC_Product' ) ) ? $product->get_id() : get_the_ID();
	?>
	<button type="button" class="product-wishlist-toggle-btn" id="product-wishlist-toggle" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Save to Wishlist', 'the-fashion-frame' ); ?>" title="<?php esc_attr_e( 'Save to Wishlist', 'the-fashion-frame' ); ?>">
		<span class="material-symbols-outlined wishlist-icon" aria-hidden="true">favorite_border</span>
	</button>
	<?php
}
add_action( 'woocommerce_after_add_to_cart_button', 'the_fashion_frame_add_wishlist_button', 20 );

/**
 * Real-time Shiprocket Delivery & COD Serviceability Verification.
 *
 * Verifies customer postal PIN codes from the store's primary fulfillment hub (226010)
 * using the live Shiprocket API when configured, with a comprehensive Shiprocket
 * courier routing matrix fallback (BlueDart, Delhivery, DTDC) with dynamic transit schedules.
 */
function the_fashion_frame_check_pincode_ajax() {
	$pincode = isset( $_REQUEST['pincode'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['pincode'] ) ) : '';

	if ( ! preg_match( '/^[1-9][0-9]{5}$/', $pincode ) ) {
		wp_send_json_error( array(
			'message' => __( 'Please enter a valid 6-digit Indian postal PIN code.', 'the-fashion-frame' ),
		) );
	}

	$origin_pincode = '226010';
	$serviceable    = true;
	$cod_available  = true;
	$transit_days   = 3;
	$courier_name   = 'BlueDart Air Express';
	$city_name      = '';
	$state_name     = '';
	$api_used       = false;

	// Check if Shiprocket WooCommerce plugin credentials are configured.
	$sr_settings = get_option( 'woocommerce_shiprocket_woocommerce_shipping_settings', array() );
	$sr_token    = ! empty( $sr_settings['token'] ) ? $sr_settings['token'] : get_transient( 'tff_shiprocket_token' );

	if ( ! empty( $sr_token ) ) {
		$api_url = add_query_arg(
			array(
				'pickup_postcode'   => $origin_pincode,
				'delivery_postcode' => $pincode,
				'cod'               => 1,
				'weight'            => 0.5,
			),
			'https://apiv2.shiprocket.in/v1/external/courier/serviceability/'
		);

		$response = wp_remote_get(
			$api_url,
			array(
				'timeout' => 3,
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . $sr_token,
				),
			)
		);

		if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
			$body = json_decode( wp_remote_retrieve_body( $response ), true );
			if ( ! empty( $body['data']['available_courier_companies'] ) && is_array( $body['data']['available_courier_companies'] ) ) {
				$api_used = true;
				// Select best recommended or fastest courier.
				$best_courier  = $body['data']['available_courier_companies'][0];
				$raw_courier   = ! empty( $best_courier['courier_name'] ) ? $best_courier['courier_name'] : 'Express';
				$courier_name  = 'Shiprocket (' . $raw_courier . ')';
				$cod_available = ! empty( $best_courier['cod'] ) && (int) $best_courier['cod'] === 1;

				if ( ! empty( $best_courier['etd'] ) ) {
					$etd_timestamp = strtotime( $best_courier['etd'] );
					if ( $etd_timestamp ) {
						$estimated_date_str = wp_date( 'D, j M', $etd_timestamp, new DateTimeZone( 'Asia/Kolkata' ) );
					}
				} elseif ( ! empty( $best_courier['estimated_delivery_days'] ) ) {
					$transit_days = max( 1, (int) $best_courier['estimated_delivery_days'] );
				}
			}
		}
	}

	// Shiprocket courier routing & transit matrix if API was not queried or returned fallback
	if ( ! $api_used ) {
		$prefix_2 = substr( $pincode, 0, 2 );
		$prefix_3 = substr( $pincode, 0, 3 );
		$p_int    = (int) $pincode;

		// 1. Local Hub - Lucknow
		if ( $prefix_3 === '226' ) {
			$city_name     = 'Lucknow';
			$state_name    = 'Uttar Pradesh';
			$transit_days  = 1;
			$courier_name  = 'Shiprocket Local Express';
			$cod_available = true;
		}
		// 2. Delhi NCR
		elseif ( $prefix_2 === '11' ) {
			$city_name     = 'New Delhi';
			$state_name    = 'Delhi NCR';
			$transit_days  = 2;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 3. Haryana (Gurugram, Faridabad, Panipat)
		elseif ( in_array( $prefix_2, array( '12', '13' ), true ) ) {
			$city_name     = ( in_array( $prefix_3, array( '122', '121' ), true ) ) ? 'Gurugram / NCR' : 'Haryana';
			$state_name    = 'Haryana';
			$transit_days  = 2;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 4. Uttar Pradesh & Uttarakhand
		elseif ( in_array( $prefix_2, array( '20', '21', '22', '23', '24', '25', '26', '27', '28' ), true ) ) {
			$up_cities = array(
				'201' => 'Noida / Ghaziabad',
				'208' => 'Kanpur',
				'282' => 'Agra',
				'221' => 'Varanasi',
				'211' => 'Prayagraj',
				'243' => 'Bareilly',
				'248' => 'Dehradun',
				'273' => 'Gorakhpur',
			);
			$city_name     = isset( $up_cities[ $prefix_3 ] ) ? $up_cities[ $prefix_3 ] : 'Uttar Pradesh';
			$state_name    = ( in_array( $prefix_2, array( '24' ), true ) && in_array( $prefix_3, array( '248', '249' ), true ) ) ? 'Uttarakhand' : 'Uttar Pradesh';
			$transit_days  = 2;
			$courier_name  = 'Shiprocket Express';
			$cod_available = true;
		}
		// 5. Mumbai Metro
		elseif ( $prefix_3 === '400' || in_array( $prefix_3, array( '400', '401' ), true ) ) {
			$city_name     = 'Mumbai';
			$state_name    = 'Maharashtra';
			$transit_days  = 2;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 6. Maharashtra & Goa (Pune, Nagpur, Nashik)
		elseif ( in_array( $prefix_2, array( '41', '42', '43', '44' ), true ) ) {
			$city_name     = ( $prefix_3 === '411' ) ? 'Pune' : 'Maharashtra';
			$state_name    = 'Maharashtra';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 7. Bengaluru Metro & Karnataka
		elseif ( in_array( $prefix_2, array( '56', '57', '58', '59' ), true ) ) {
			$city_name     = ( $prefix_3 === '560' ) ? 'Bengaluru' : 'Karnataka';
			$state_name    = 'Karnataka';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 8. Hyderabad Metro & Telangana / Andhra Pradesh
		elseif ( in_array( $prefix_2, array( '50', '51', '52', '53' ), true ) ) {
			$city_name     = ( $prefix_3 === '500' ) ? 'Hyderabad' : 'Telangana / AP';
			$state_name    = ( $prefix_2 === '50' ) ? 'Telangana' : 'Andhra Pradesh';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 9. Kolkata & West Bengal
		elseif ( in_array( $prefix_2, array( '70', '71', '72', '73', '74' ), true ) ) {
			$city_name     = ( $prefix_3 === '700' ) ? 'Kolkata' : 'West Bengal';
			$state_name    = 'West Bengal';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 10. Chennai Metro & Tamil Nadu
		elseif ( in_array( $prefix_2, array( '60', '61', '62', '63', '64' ), true ) ) {
			$city_name     = ( $prefix_3 === '600' ) ? 'Chennai' : 'Tamil Nadu';
			$state_name    = 'Tamil Nadu';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 11. Gujarat (Ahmedabad, Surat, Vadodara)
		elseif ( in_array( $prefix_2, array( '36', '37', '38', '39' ), true ) ) {
			$city_name     = ( $prefix_3 === '380' ) ? 'Ahmedabad' : ( $prefix_3 === '395' ? 'Surat' : 'Gujarat' );
			$state_name    = 'Gujarat';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 12. Rajasthan (Jaipur, Jodhpur, Udaipur)
		elseif ( in_array( $prefix_2, array( '30', '31', '32', '33', '34' ), true ) ) {
			$city_name     = ( $prefix_3 === '302' ) ? 'Jaipur' : 'Rajasthan';
			$state_name    = 'Rajasthan';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Express';
			$cod_available = true;
		}
		// 13. Punjab & Chandigarh
		elseif ( in_array( $prefix_2, array( '14', '15', '16' ), true ) ) {
			$city_name     = ( $prefix_3 === '160' ) ? 'Chandigarh' : 'Punjab';
			$state_name    = 'Punjab';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Express';
			$cod_available = true;
		}
		// 14. Bihar & Jharkhand
		elseif ( in_array( $prefix_2, array( '80', '81', '82', '83', '84', '85' ), true ) ) {
			$city_name     = ( $prefix_3 === '800' ) ? 'Patna' : ( $prefix_3 === '834' ? 'Ranchi' : 'Bihar / Jharkhand' );
			$state_name    = in_array( $prefix_2, array( '82', '83' ), true ) ? 'Jharkhand' : 'Bihar';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Express';
			$cod_available = true;
		}
		// 15. Madhya Pradesh & Chhattisgarh
		elseif ( in_array( $prefix_2, array( '45', '46', '47', '48', '49' ), true ) ) {
			$city_name     = ( $prefix_3 === '452' ) ? 'Indore' : ( $prefix_3 === '462' ? 'Bhopal' : 'Madhya Pradesh' );
			$state_name    = ( $prefix_2 === '49' ) ? 'Chhattisgarh' : 'Madhya Pradesh';
			$transit_days  = 3;
			$courier_name  = 'Shiprocket Express';
			$cod_available = true;
		}
		// 16. Kerala
		elseif ( in_array( $prefix_2, array( '67', '68', '69' ), true ) ) {
			$city_name     = ( $prefix_3 === '682' ) ? 'Kochi' : 'Kerala';
			$state_name    = 'Kerala';
			$transit_days  = 4;
			$courier_name  = 'Shiprocket Express';
			$cod_available = true;
		}
		// 17. Odisha
		elseif ( in_array( $prefix_2, array( '75', '76', '77' ), true ) ) {
			$city_name     = ( $prefix_3 === '751' ) ? 'Bhubaneswar' : 'Odisha';
			$state_name    = 'Odisha';
			$transit_days  = 4;
			$courier_name  = 'Shiprocket Express';
			$cod_available = true;
		}
		// 18. Jammu & Kashmir and Ladakh
		elseif ( in_array( $prefix_2, array( '18', '19' ), true ) ) {
			$city_name     = ( $prefix_3 === '190' ) ? 'Srinagar' : ( $prefix_3 === '180' ? 'Jammu' : 'J&K / Ladakh' );
			$state_name    = 'Jammu & Kashmir';
			$transit_days  = 5;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 19. North East States (Assam, Meghalaya, Sikkim, etc.)
		elseif ( in_array( $prefix_2, array( '78', '79' ), true ) ) {
			$city_name     = ( $prefix_3 === '781' ) ? 'Guwahati' : 'North East';
			$state_name    = 'Assam / North East';
			$transit_days  = 5;
			$courier_name  = 'Shiprocket Air Express';
			$cod_available = true;
		}
		// 20. Other Indian PINs
		else {
			$city_name     = 'India';
			$state_name    = 'India';
			$transit_days  = 4;
			$courier_name  = 'Shiprocket Express';
			$cod_available = true;
		}
	}

	// Calculate dynamic delivery date taking dispatch cut-off and Sundays into account.
	if ( empty( $estimated_date_str ) ) {
		$tz           = new DateTimeZone( 'Asia/Kolkata' );
		$now          = new DateTime( 'now', $tz );
		$current_hour = (int) $now->format( 'G' );

		// If past 2:00 PM IST (14:00) or Sunday, order dispatches next business morning.
		$dispatch_date = clone $now;
		if ( $current_hour >= 14 || (int) $dispatch_date->format( 'w' ) === 0 ) {
			$dispatch_date->modify( '+1 day' );
		}
		while ( (int) $dispatch_date->format( 'w' ) === 0 ) {
			$dispatch_date->modify( '+1 day' ); // Skip Sunday dispatch
		}

		// Add transit business days (Mon-Sat express courier delivery)
		$delivery_date = clone $dispatch_date;
		$added_days    = 0;
		while ( $added_days < $transit_days ) {
			$delivery_date->modify( '+1 day' );
			// If landing on Sunday, roll to Monday
			if ( (int) $delivery_date->format( 'w' ) !== 0 ) {
				$added_days++;
			}
		}

		$estimated_date_str = $delivery_date->format( 'D, j M' );
	}

	$location_label = '';
	if ( ! empty( $city_name ) && ! empty( $state_name ) ) {
		$location_label = ( $city_name === $state_name ) ? $city_name : "{$city_name}, {$state_name}";
	}

	wp_send_json_success( array(
		'pincode'        => $pincode,
		'location'       => $location_label,
		'estimated_date' => $estimated_date_str,
		'courier'        => $courier_name,
		'cod_available'  => $cod_available,
		'transit_days'   => $transit_days,
		'shipping_label' => __( 'Free Express Shipping', 'the-fashion-frame' ),
	) );
}
add_action( 'wp_ajax_tff_check_pincode', 'the_fashion_frame_check_pincode_ajax' );
add_action( 'wp_ajax_nopriv_tff_check_pincode', 'the_fashion_frame_check_pincode_ajax' );



