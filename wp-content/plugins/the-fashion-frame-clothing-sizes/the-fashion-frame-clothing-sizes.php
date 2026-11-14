<?php
/**
 * Plugin Name: The Fashion Frame - Clothing Sizes & Variations
 * Plugin URI: https://thefashionframe.com
 * Description: Premium clothing size selector and variation management for The Fashion Frame.
 * Version: 1.0.0
 * Author: The Fashion Frame Team
 * Text Domain: the-fashion-frame
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * WC requires at least: 6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TFF_Clothing_Sizes {

	/**
	 * Instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get class singleton instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Enqueue scripts & styles on single product pages
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 20 );

		// Custom Size Swatches in variation dropdown
		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'render_size_swatches' ), 10, 2 );

		// Server-side validation before adding to cart
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'validate_size_selection' ), 10, 5 );

		// Display Size in cart and checkout item data
		add_filter( 'woocommerce_get_item_data', array( $this, 'add_size_to_cart_item_data' ), 10, 2 );

		// Save Size to order line item meta for order confirmation and admin order details
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'save_size_to_order_line_item' ), 10, 4 );

		// Clean up variation form table layout for swatches
		add_action( 'woocommerce_before_variations_form', array( $this, 'before_variations_form' ) );
	}

	/**
	 * Enqueue front-end styling and swatch behavior.
	 */
	public function enqueue_assets() {
		if ( ! is_product() ) {
			return;
		}

		wp_enqueue_style(
			'tff-clothing-sizes-style',
			plugin_dir_url( __FILE__ ) . 'assets/clothing-sizes.css',
			array(),
			'1.0.1'
		);

		wp_enqueue_script(
			'tff-clothing-sizes-script',
			plugin_dir_url( __FILE__ ) . 'assets/clothing-sizes.js',
			array( 'jquery', 'wc-add-to-cart-variation' ),
			'1.0.1',
			true
		);

		wp_localize_script(
			'tff-clothing-sizes-script',
			'tffSizesData',
			array(
				'selectSizeText' => __( 'Please select a size.', 'the-fashion-frame' ),
				'sizeLabel'      => __( 'SIZE', 'the-fashion-frame' ),
			)
		);
	}

	/**
	 * Render custom rectangular size swatch buttons next to the native select.
	 *
	 * @param string $html
	 * @param array  $args
	 * @return string
	 */
	public function render_size_swatches( $html, $args ) {
		$attribute = isset( $args['attribute'] ) ? $args['attribute'] : '';

		// Only modify the size attribute (pa_size or size)
		if ( 'pa_size' !== $attribute && 'size' !== $attribute ) {
			return $html;
		}

		$options   = isset( $args['options'] ) ? $args['options'] : array();
		$product   = isset( $args['product'] ) ? $args['product'] : null;
		$selected  = isset( $args['selected'] ) ? $args['selected'] : '';
		$name      = isset( $args['name'] ) ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id        = isset( $args['id'] ) ? $args['id'] : sanitize_title( $attribute );

		if ( empty( $options ) && $product ) {
			$attributes = $product->get_variation_attributes();
			$options    = isset( $attributes[ $attribute ] ) ? $attributes[ $attribute ] : array();
		}

		if ( empty( $options ) ) {
			return $html;
		}

		// Sort sizes in standard order: S, M, L, XL, XXL
		$size_order = array( 's' => 1, 'm' => 2, 'l' => 3, 'xl' => 4, 'xxl' => 5 );
		usort( $options, function( $a, $b ) use ( $size_order ) {
			$slug_a = is_object( $a ) ? strtolower( $a->slug ) : strtolower( $a );
			$slug_b = is_object( $b ) ? strtolower( $b->slug ) : strtolower( $b );
			$order_a = isset( $size_order[ $slug_a ] ) ? $size_order[ $slug_a ] : 99;
			$order_b = isset( $size_order[ $slug_b ] ) ? $size_order[ $slug_b ] : 99;
			return $order_a - $order_b;
		} );

		// Build Swatches HTML
		ob_start();
		?>
		<div class="tff-size-selector-component" data-attribute="<?php echo esc_attr( $name ); ?>">
			<!-- Accessible visually-hidden select for native WooCommerce scripts -->
			<div class="tff-native-select-wrap">
				<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<!-- Premium Size Swatches UI -->
			<div class="tff-size-swatches-container">
				<div class="tff-size-header-row">
					<div class="tff-size-title-wrap">
						<span class="tff-size-heading"><?php esc_html_e( 'SIZE', 'the-fashion-frame' ); ?></span>
						<span class="tff-size-chosen-display" aria-live="polite"></span>
					</div>
					<button type="button" class="tff-size-guide-trigger" id="tff-size-guide-trigger" aria-haspopup="dialog">
						<span class="material-symbols-outlined text-[16px]">straighten</span>
						<span><?php esc_html_e( 'Size Guide', 'the-fashion-frame' ); ?></span>
					</button>
				</div>

				<div class="tff-size-buttons-group" role="radiogroup" aria-label="<?php esc_attr_e( 'Select Size', 'the-fashion-frame' ); ?>">
					<?php
					foreach ( $options as $option ) :
						if ( is_object( $option ) ) {
							$slug = $option->slug;
							$name_label = $option->name;
						} else {
							$slug = $option;
							$term = taxonomy_exists( $attribute ) ? get_term_by( 'slug', $slug, $attribute ) : null;
							$name_label = $term && ! is_wp_error( $term ) ? $term->name : strtoupper( $slug );
						}

						$is_checked = ( strtolower( $selected ) === strtolower( $slug ) );
						?>
						<button
							type="button"
							class="tff-size-btn <?php echo $is_checked ? 'is-selected' : ''; ?>"
							data-value="<?php echo esc_attr( $slug ); ?>"
							role="radio"
							aria-checked="<?php echo $is_checked ? 'true' : 'false'; ?>"
							tabindex="0"
						>
							<?php echo esc_html( $name_label ); ?>
						</button>
					<?php endforeach; ?>
				</div>

				<!-- Validation Notice Container -->
				<div class="tff-size-validation-msg" style="display: none;" role="alert">
					<span class="material-symbols-outlined text-[16px]">info</span>
					<span><?php esc_html_e( 'Please select a size.', 'the-fashion-frame' ); ?></span>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Server-side validation to ensure a size is selected.
	 */
	public function validate_size_selection( $passed, $product_id, $quantity, $variation_id = 0, $variations = array() ) {
		$product = wc_get_product( $product_id );
		if ( $product && $product->is_type( 'variable' ) ) {
			if ( empty( $variation_id ) ) {
				wc_add_notice( __( 'Please select a size.', 'the-fashion-frame' ), 'error' );
				return false;
			}
			if ( empty( $variations ) || ! isset( $variations['attribute_pa_size'] ) || empty( $variations['attribute_pa_size'] ) ) {
				wc_add_notice( __( 'Please select a size.', 'the-fashion-frame' ), 'error' );
				return false;
			}
		}
		return $passed;
	}

	/**
	 * Display Size in cart and checkout item data.
	 *
	 * @param array $item_data
	 * @param array $cart_item
	 * @return array
	 */
	public function add_size_to_cart_item_data( $item_data, $cart_item ) {
		if ( isset( $cart_item['variation']['attribute_pa_size'] ) ) {
			$size_slug = $cart_item['variation']['attribute_pa_size'];
			$term = get_term_by( 'slug', $size_slug, 'pa_size' );
			$size_name = $term ? $term->name : strtoupper( $size_slug );

			$already_added = false;
			foreach ( $item_data as $data ) {
				if ( isset( $data['key'] ) && strtolower( $data['key'] ) === 'size' ) {
					$already_added = true;
					break;
				}
			}

			if ( ! $already_added ) {
				$item_data[] = array(
					'key'     => __( 'Size', 'the-fashion-frame' ),
					'value'   => $size_name,
					'display' => $size_name,
				);
			}
		}
		return $item_data;
	}

	/**
	 * Save Size explicitly to order line item meta for order confirmation, emails, and admin orders.
	 *
	 * @param WC_Order_Item_Product $item
	 * @param string                $cart_item_key
	 * @param array                 $values
	 * @param WC_Order              $order
	 */
	public function save_size_to_order_line_item( $item, $cart_item_key, $values, $order ) {
		if ( isset( $values['variation']['attribute_pa_size'] ) ) {
			$size_slug = $values['variation']['attribute_pa_size'];
			$term = get_term_by( 'slug', $size_slug, 'pa_size' );
			$size_name = $term ? $term->name : strtoupper( $size_slug );
			$item->add_meta_data( __( 'Size', 'the-fashion-frame' ), $size_name, true );
		}
	}

	/**
	 * Clean layout wrapper hooks.
	 */
	public function before_variations_form() {
		// Allows any additional attributes or layout tweaks if needed
	}
}

// Initialize plugin
TFF_Clothing_Sizes::get_instance();

/**
 * ============================================================================
 * The Fashion Frame - E-Commerce Manager & Complete Checkout/Order Suite
 * ============================================================================
 * Handles:
 * 1. Automatic linking of guest orders when registering or logging into My Account.
 * 2. Indian checkout validation (6-digit PIN code and 10-digit mobile number).
 * 3. Prevention of duplicate order creation from repeated button clicks.
 * 4. Courier integration metadata (Shiprocket, NimbusPost, iThink Logistics, BlueDart, Delhivery).
 * 5. Tracking display on customer order details and notification emails.
 */
class TFF_Ecommerce_Manager {

	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		// 1. Guest Order Linking to Customer Account
		add_action( 'woocommerce_created_customer', array( $this, 'link_guest_orders_on_customer_created' ), 10, 3 );
		add_action( 'user_register', array( $this, 'link_guest_orders_on_user_register' ), 10, 1 );
		add_action( 'woocommerce_before_my_account', array( $this, 'auto_link_guest_orders_on_my_account' ) );

		// 2. Checkout Validation for Indian E-Commerce
		add_action( 'woocommerce_checkout_process', array( $this, 'validate_indian_checkout_fields' ) );

		// 3. Duplicate Order Submission Prevention
		add_action( 'woocommerce_after_checkout_validation', array( $this, 'check_duplicate_order_submission' ), 10, 2 );
		add_action( 'woocommerce_checkout_order_processed', array( $this, 'clear_duplicate_order_lock' ), 10, 3 );

		// 4. Front-End Scripts for Checkout Duplicate Click Prevention & UX
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_checkout_ux_scripts' ), 30 );

		// 5. Courier & Tracking Support (Shiprocket / NimbusPost / iThink Logistics)
		add_action( 'add_meta_boxes', array( $this, 'add_courier_meta_box' ) );
		add_action( 'woocommerce_process_shop_order_meta', array( $this, 'save_courier_meta_box' ) );
		add_action( 'woocommerce_order_details_after_order_table', array( $this, 'display_courier_tracking_info' ), 10, 1 );
		add_action( 'woocommerce_email_after_order_table', array( $this, 'add_tracking_to_order_emails' ), 10, 4 );

		// 6. Ensure JSON-LD Product Schema for Search Engines & SEO
		add_action( 'woocommerce_before_single_product', array( $this, 'ensure_product_structured_data' ) );
	}

	/**
	 * Ensure WooCommerce outputs valid Google Rich Snippet JSON-LD Product Schema.
	 */
	public function ensure_product_structured_data() {
		global $product;
		if ( is_product() && is_a( $product, 'WC_Product' ) && function_exists( 'WC' ) && isset( WC()->structured_data ) ) {
			WC()->structured_data->generate_product_data( $product );
		}
	}

	/**
	 * Link all previous guest orders placed with the customer's email to their newly created account.
	 *
	 * @param int    $customer_id
	 * @param array  $new_customer_data
	 * @param string $password_generated
	 */
	public function link_guest_orders_on_customer_created( $customer_id, $new_customer_data = array(), $password_generated = '' ) {
		$user = get_userdata( $customer_id );
		if ( $user && ! empty( $user->user_email ) ) {
			$this->link_guest_orders_by_email( $customer_id, $user->user_email );
		}
	}

	/**
	 * Hook on standard WordPress user_register to catch registrations from any form.
	 *
	 * @param int $user_id
	 */
	public function link_guest_orders_on_user_register( $user_id ) {
		$user = get_userdata( $user_id );
		if ( $user && ! empty( $user->user_email ) ) {
			$this->link_guest_orders_by_email( $user_id, $user->user_email );
		}
	}

	/**
	 * Automatically link any unlinked guest orders when the customer visits My Account.
	 */
	public function auto_link_guest_orders_on_my_account() {
		if ( is_user_logged_in() ) {
			$user = wp_get_current_user();
			if ( $user && ! empty( $user->user_email ) ) {
				$this->link_guest_orders_by_email( $user->ID, $user->user_email );
			}
		}
	}

	/**
	 * Securely query and link orders where billing_email matches and customer_id is 0.
	 *
	 * @param int    $user_id
	 * @param string $email
	 */
	public function link_guest_orders_by_email( $user_id, $email ) {
		if ( empty( $user_id ) || empty( $email ) ) {
			return;
		}

		$clean_email = sanitize_email( strtolower( trim( $email ) ) );
		if ( ! is_email( $clean_email ) ) {
			return;
		}

		$guest_orders = wc_get_orders(
			array(
				'billing_email' => $clean_email,
				'customer_id'   => 0,
				'limit'         => -1,
				'return'        => 'ids',
			)
		);

		if ( ! empty( $guest_orders ) ) {
			foreach ( $guest_orders as $order_id ) {
				$order = wc_get_order( $order_id );
				if ( $order && 0 === (int) $order->get_customer_id() ) {
					$order->set_customer_id( $user_id );
					$order->save();
					$order->add_order_note(
						sprintf(
							/* translators: 1: User ID, 2: Customer Email */
							__( 'Previous guest order automatically linked to customer account #%1$d (%2$s).', 'the-fashion-frame' ),
							$user_id,
							$clean_email
						)
					);
				}
			}
		}
	}

	/**
	 * Validate Indian postal PIN code and 10-digit mobile number at checkout.
	 */
	public function validate_indian_checkout_fields() {
		$country = isset( $_POST['billing_country'] ) ? sanitize_text_field( wp_unslash( $_POST['billing_country'] ) ) : 'IN';

		// Validate for India orders
		if ( 'IN' === $country || empty( $country ) ) {
			// 1. PIN code validation (6 digits, non-zero starting)
			if ( isset( $_POST['billing_postcode'] ) ) {
				$postcode = preg_replace( '/\s+/', '', sanitize_text_field( wp_unslash( $_POST['billing_postcode'] ) ) );
				if ( ! empty( $postcode ) && ! preg_match( '/^[1-9][0-9]{5}$/', $postcode ) ) {
					wc_add_notice(
						__( 'Please enter a valid 6-digit Indian Postal PIN Code (e.g., 226010).', 'the-fashion-frame' ),
						'error'
					);
				}
			}

			// 2. Mobile number validation (10 digits starting with 6, 7, 8, or 9)
			if ( isset( $_POST['billing_phone'] ) ) {
				$raw_phone = sanitize_text_field( wp_unslash( $_POST['billing_phone'] ) );
				$clean_digits = preg_replace( '/[^0-9]/', '', $raw_phone );

				// Strip leading country code 91 or 0
				if ( 12 === strlen( $clean_digits ) && '91' === substr( $clean_digits, 0, 2 ) ) {
					$clean_digits = substr( $clean_digits, 2 );
				} elseif ( 11 === strlen( $clean_digits ) && '0' === substr( $clean_digits, 0, 1 ) ) {
					$clean_digits = substr( $clean_digits, 1 );
				}

				if ( ! empty( $clean_digits ) && ( 10 !== strlen( $clean_digits ) || ! preg_match( '/^[6-9][0-9]{9}$/', $clean_digits ) ) ) {
					wc_add_notice(
						__( 'Please enter a valid 10-digit Indian Mobile Number (starting with 6, 7, 8, or 9) for delivery tracking and SMS updates.', 'the-fashion-frame' ),
						'error'
					);
				}
			}
		}
	}

	/**
	 * Prevent duplicate orders from rapid repeated clicks or race conditions.
	 *
	 * @param array    $data
	 * @param WP_Error $errors
	 */
	public function check_duplicate_order_submission( $data, $errors ) {
		if ( ! empty( $errors->get_error_codes() ) ) {
			return; // Don't lock if there are already validation errors
		}

		$cart_hash = WC()->cart ? WC()->cart->get_cart_hash() : '';
		$user_id   = get_current_user_id();
		$ip        = WC_Geolocation::get_ip_address();
		$lock_key  = 'tff_order_lock_' . md5( $user_id . '_' . $ip . '_' . $cart_hash );

		if ( get_transient( $lock_key ) ) {
			$errors->add(
				'duplicate_order',
				__( 'Your order is currently processing. Please wait a moment and do not click multiple times.', 'the-fashion-frame' )
			);
			return;
		}

		set_transient( $lock_key, 'processing', 15 );
	}

	/**
	 * Clear the duplicate order lock once the order is processed.
	 *
	 * @param int      $order_id
	 * @param array    $posted_data
	 * @param WC_Order $order
	 */
	public function clear_duplicate_order_lock( $order_id, $posted_data, $order ) {
		$cart_hash = WC()->cart ? WC()->cart->get_cart_hash() : '';
		$user_id   = get_current_user_id();
		$ip        = WC_Geolocation::get_ip_address();
		$lock_key  = 'tff_order_lock_' . md5( $user_id . '_' . $ip . '_' . $cart_hash );
		delete_transient( $lock_key );
	}

	/**
	 * Enqueue frontend checkout UX enhancements (disable button on click, spinner, smooth error scrolling).
	 */
	public function enqueue_checkout_ux_scripts() {
		if ( ! is_checkout() ) {
			return;
		}

		$custom_js = "
		jQuery(function($){
			var submitting = false;

			// Handle Place Order button submission lock
			$('form.checkout').on('checkout_place_order', function(){
				if (submitting) {
					return false;
				}
				var \$btn = $('#place_order');
				if (\$btn.length) {
					submitting = true;
					\$btn.data('original-text', \$btn.html());
					\$btn.prop('disabled', true).css({ 'opacity': '0.7', 'cursor': 'not-allowed' });
					\$btn.html('<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Processing Order...');
				}
				return true;
			});

			// Re-enable if checkout error occurs
			$(document.body).on('checkout_error', function(){
				submitting = false;
				var \$btn = $('#place_order');
				if (\$btn.length) {
					\$btn.prop('disabled', false).css({ 'opacity': '1', 'cursor': 'pointer' });
					if (\$btn.data('original-text')) {
						\$btn.html(\$btn.data('original-text'));
					}
				}
			});
		});
		";

		wp_add_inline_script( 'woocommerce', $custom_js );
	}

	/**
	 * Add Courier & Tracking metabox to WooCommerce Admin Order page.
	 */
	public function add_courier_meta_box() {
		$screen = class_exists( '\Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController' ) &&
			wc_get_container()->get( \Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController::class )->custom_orders_table_usage_is_enabled()
			? wc_get_page_screen_id( 'shop-order' )
			: 'shop_order';

		add_meta_box(
			'tff_courier_tracking_meta_box',
			__( 'Shipment & Courier Tracking (Shiprocket / NimbusPost / iThink)', 'the-fashion-frame' ),
			array( $this, 'render_courier_meta_box' ),
			$screen,
			'side',
			'high'
		);
	}

	/**
	 * Render the Courier & Tracking metabox in admin order edit.
	 *
	 * @param WP_Post|WC_Order $post_or_order
	 */
	public function render_courier_meta_box( $post_or_order ) {
		$order = is_a( $post_or_order, 'WC_Order' ) ? $post_or_order : wc_get_order( $post_or_order->ID );
		if ( ! $order ) {
			return;
		}

		$courier_provider = $order->get_meta( '_tff_courier_provider', true );
		$tracking_number  = $order->get_meta( '_tff_tracking_number', true );
		$tracking_url     = $order->get_meta( '_tff_tracking_url', true );
		$dispatch_date    = $order->get_meta( '_tff_dispatch_date', true );

		wp_nonce_field( 'tff_save_courier_meta', 'tff_courier_meta_nonce' );
		?>
		<p>
			<label for="tff_courier_provider"><strong><?php esc_html_e( 'Courier Partner:', 'the-fashion-frame' ); ?></strong></label><br>
			<select name="tff_courier_provider" id="tff_courier_provider" style="width:100%; margin-top:4px;">
				<option value=""><?php esc_html_e( 'Select Courier...', 'the-fashion-frame' ); ?></option>
				<option value="Shiprocket" <?php selected( $courier_provider, 'Shiprocket' ); ?>>Shiprocket</option>
				<option value="NimbusPost" <?php selected( $courier_provider, 'NimbusPost' ); ?>>NimbusPost</option>
				<option value="iThink Logistics" <?php selected( $courier_provider, 'iThink Logistics' ); ?>>iThink Logistics</option>
				<option value="BlueDart" <?php selected( $courier_provider, 'BlueDart' ); ?>>BlueDart</option>
				<option value="Delhivery" <?php selected( $courier_provider, 'Delhivery' ); ?>>Delhivery</option>
				<option value="DTDC" <?php selected( $courier_provider, 'DTDC' ); ?>>DTDC</option>
				<option value="Speed Post" <?php selected( $courier_provider, 'Speed Post' ); ?>>India Post / Speed Post</option>
				<option value="Other" <?php selected( $courier_provider, 'Other' ); ?>><?php esc_html_e( 'Other Express', 'the-fashion-frame' ); ?></option>
			</select>
		</p>
		<p>
			<label for="tff_tracking_number"><strong><?php esc_html_e( 'AWB / Tracking Number:', 'the-fashion-frame' ); ?></strong></label><br>
			<input type="text" name="tff_tracking_number" id="tff_tracking_number" value="<?php echo esc_attr( $tracking_number ); ?>" style="width:100%; margin-top:4px;" placeholder="e.g. 1432567890" />
		</p>
		<p>
			<label for="tff_tracking_url"><strong><?php esc_html_e( 'Tracking URL:', 'the-fashion-frame' ); ?></strong></label><br>
			<input type="url" name="tff_tracking_url" id="tff_tracking_url" value="<?php echo esc_url( $tracking_url ); ?>" style="width:100%; margin-top:4px;" placeholder="https://shiprocket.co/tracking/..." />
		</p>
		<p>
			<label for="tff_dispatch_date"><strong><?php esc_html_e( 'Dispatch Date:', 'the-fashion-frame' ); ?></strong></label><br>
			<input type="date" name="tff_dispatch_date" id="tff_dispatch_date" value="<?php echo esc_attr( $dispatch_date ); ?>" style="width:100%; margin-top:4px;" />
		</p>
		<p class="description" style="color:#666; font-size:12px;">
			<?php esc_html_e( 'Tracking info automatically appears on Customer Order History, My Account, and completed order emails.', 'the-fashion-frame' ); ?>
		</p>
		<?php
	}

	/**
	 * Save the Courier & Tracking metadata from admin order edit.
	 *
	 * @param int $order_id
	 */
	public function save_courier_meta_box( $order_id ) {
		if ( ! isset( $_POST['tff_courier_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['tff_courier_meta_nonce'] ), 'tff_save_courier_meta' ) ) {
			return;
		}

		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}

		$courier_provider = isset( $_POST['tff_courier_provider'] ) ? sanitize_text_field( wp_unslash( $_POST['tff_courier_provider'] ) ) : '';
		$tracking_number  = isset( $_POST['tff_tracking_number'] ) ? sanitize_text_field( wp_unslash( $_POST['tff_tracking_number'] ) ) : '';
		$tracking_url     = isset( $_POST['tff_tracking_url'] ) ? esc_url_raw( wp_unslash( $_POST['tff_tracking_url'] ) ) : '';
		$dispatch_date    = isset( $_POST['tff_dispatch_date'] ) ? sanitize_text_field( wp_unslash( $_POST['tff_dispatch_date'] ) ) : '';

		// Auto-generate tracking URL if empty and courier is known
		if ( ! empty( $tracking_number ) && empty( $tracking_url ) ) {
			if ( 'Shiprocket' === $courier_provider ) {
				$tracking_url = 'https://shiprocket.co/tracking/' . rawurlencode( $tracking_number );
			} elseif ( 'NimbusPost' === $courier_provider ) {
				$tracking_url = 'https://nimbuspost.com/tracking?awb=' . rawurlencode( $tracking_number );
			} elseif ( 'Delhivery' === $courier_provider ) {
				$tracking_url = 'https://www.delhivery.com/track/package/' . rawurlencode( $tracking_number );
			} elseif ( 'BlueDart' === $courier_provider ) {
				$tracking_url = 'https://www.bluedart.com/tracking?trackNumber=' . rawurlencode( $tracking_number );
			}
		}

		$order->update_meta_data( '_tff_courier_provider', $courier_provider );
		$order->update_meta_data( '_tff_tracking_number', $tracking_number );
		$order->update_meta_data( '_tff_tracking_url', $tracking_url );
		$order->update_meta_data( '_tff_dispatch_date', $dispatch_date );

		// Also standard WooCommerce shipment fields for third-party courier plugins
		$order->update_meta_data( '_shipping_provider', $courier_provider );
		$order->update_meta_data( '_tracking_number', $tracking_number );
		$order->update_meta_data( '_tracking_url', $tracking_url );

		$order->save();
	}

	/**
	 * Display tracking info on customer Order Details page (My Account -> Orders).
	 *
	 * @param WC_Order $order
	 */
	public function display_courier_tracking_info( $order ) {
		if ( ! $order ) {
			return;
		}

		$tracking_number  = $order->get_meta( '_tff_tracking_number', true );
		$courier_provider = $order->get_meta( '_tff_courier_provider', true );
		$tracking_url     = $order->get_meta( '_tff_tracking_url', true );
		$dispatch_date    = $order->get_meta( '_tff_dispatch_date', true );

		if ( empty( $tracking_number ) ) {
			// Fallback check standard meta
			$tracking_number  = $order->get_meta( '_tracking_number', true );
			$courier_provider = $order->get_meta( '_shipping_provider', true );
			$tracking_url     = $order->get_meta( '_tracking_url', true );
		}

		if ( empty( $tracking_number ) ) {
			return;
		}
		?>
		<div class="tff-order-tracking-card" style="margin: 2rem 0; padding: 1.5rem; background: #fdfaf3; border: 1px solid rgba(201, 162, 39, 0.4); border-radius: 8px;">
			<h3 style="font-family: inherit; font-size: 1.15rem; font-weight: 600; color: #001106; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 8px;">
				<span style="font-size: 20px;">📦</span>
				<span><?php esc_html_e( 'Shipment Tracking Details', 'the-fashion-frame' ); ?></span>
			</h3>
			<p style="margin: 0 0 0.5rem; font-size: 0.95rem; color: #2b2b2b;">
				<strong><?php esc_html_e( 'Courier Partner:', 'the-fashion-frame' ); ?></strong>
				<span><?php echo esc_html( ! empty( $courier_provider ) ? $courier_provider : 'Express Courier' ); ?></span>
			</p>
			<p style="margin: 0 0 0.5rem; font-size: 0.95rem; color: #2b2b2b;">
				<strong><?php esc_html_e( 'AWB / Tracking Number:', 'the-fashion-frame' ); ?></strong>
				<code style="background: #efece5; padding: 2px 6px; border-radius: 4px; font-weight: 600;"><?php echo esc_html( $tracking_number ); ?></code>
			</p>
			<?php if ( ! empty( $dispatch_date ) ) : ?>
				<p style="margin: 0 0 0.75rem; font-size: 0.95rem; color: #2b2b2b;">
					<strong><?php esc_html_e( 'Dispatched On:', 'the-fashion-frame' ); ?></strong>
					<span><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $dispatch_date ) ) ); ?></span>
				</p>
			<?php endif; ?>
			<?php if ( ! empty( $tracking_url ) ) : ?>
				<a href="<?php echo esc_url( $tracking_url ); ?>" target="_blank" rel="noopener noreferrer" class="button" style="display: inline-block; background: #001106; color: #ffe08e; padding: 8px 18px; border-radius: 9999px; font-weight: 600; text-decoration: none; margin-top: 6px;">
					<?php esc_html_e( 'Track Package Live →', 'the-fashion-frame' ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Append courier tracking details to customer order emails.
	 *
	 * @param WC_Order $order
	 * @param bool     $sent_to_admin
	 * @param bool     $plain_text
	 * @param WC_Email $email
	 */
	public function add_tracking_to_order_emails( $order, $sent_to_admin, $plain_text, $email ) {
		if ( ! $order || $sent_to_admin ) {
			return;
		}

		$tracking_number  = $order->get_meta( '_tff_tracking_number', true );
		$courier_provider = $order->get_meta( '_tff_courier_provider', true );
		$tracking_url     = $order->get_meta( '_tff_tracking_url', true );

		if ( empty( $tracking_number ) ) {
			$tracking_number  = $order->get_meta( '_tracking_number', true );
			$courier_provider = $order->get_meta( '_shipping_provider', true );
			$tracking_url     = $order->get_meta( '_tracking_url', true );
		}

		if ( empty( $tracking_number ) ) {
			return;
		}

		if ( $plain_text ) {
			echo "\n================================\n";
			echo esc_html__( 'SHIPMENT TRACKING DETAILS', 'the-fashion-frame' ) . "\n";
			echo esc_html__( 'Courier Partner: ', 'the-fashion-frame' ) . esc_html( $courier_provider ) . "\n";
			echo esc_html__( 'Tracking Number: ', 'the-fashion-frame' ) . esc_html( $tracking_number ) . "\n";
			if ( ! empty( $tracking_url ) ) {
				echo esc_html__( 'Track Online: ', 'the-fashion-frame' ) . esc_url( $tracking_url ) . "\n";
			}
			echo "================================\n\n";
		} else {
			?>
			<div style="margin: 24px 0; padding: 16px; border: 1px solid #e0d5b8; background-color: #faf7f0; border-radius: 6px;">
				<h3 style="color: #001106; margin-top: 0; font-size: 16px;">📦 <?php esc_html_e( 'Shipment Tracking Details', 'the-fashion-frame' ); ?></h3>
				<p style="margin: 0 0 6px; font-size: 14px;"><strong><?php esc_html_e( 'Courier Partner:', 'the-fashion-frame' ); ?></strong> <?php echo esc_html( ! empty( $courier_provider ) ? $courier_provider : 'Express Courier' ); ?></p>
				<p style="margin: 0 0 10px; font-size: 14px;"><strong><?php esc_html_e( 'AWB / Tracking Number:', 'the-fashion-frame' ); ?></strong> <code style="background: #ede9de; padding: 2px 6px; border-radius: 3px;"><?php echo esc_html( $tracking_number ); ?></code></p>
				<?php if ( ! empty( $tracking_url ) ) : ?>
					<p style="margin: 10px 0 0;">
						<a href="<?php echo esc_url( $tracking_url ); ?>" target="_blank" style="display: inline-block; background: #001106; color: #ffe08e; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 13px;">
							<?php esc_html_e( 'Track Package Live →', 'the-fashion-frame' ); ?>
						</a>
					</p>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}

// Initialize E-Commerce Manager
TFF_Ecommerce_Manager::get_instance();

