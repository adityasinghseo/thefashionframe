<?php
/**
 * The header for The Fashion Frame theme
 *
 * Displays all of the <head> section and everything up till <main id="primary">
 *
 * @package The_Fashion_Frame
 */

?><!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'antialiased overflow-x-hidden' ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'the-fashion-frame' ); ?></a>

	<!-- Top Sticky Navigation Bar matching Stitch Design -->
	<header id="masthead" class="site-header sticky top-0 z-50">
		<div class="header-inner">
			
			<!-- Left Navigation Menu (Desktop) -->
			<nav id="site-navigation" class="header-nav-desktop" aria-label="<?php esc_attr_e( 'Primary Menu', 'the-fashion-frame' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'menu_class'     => 'header-nav-list',
							'fallback_cb'    => 'the_fashion_frame_default_primary_menu',
						)
					);
				} else {
					the_fashion_frame_default_primary_menu();
				}
				?>
			</nav>

			<!-- Centered Brand Logo / Monogram -->
			<div class="header-brand">
				<?php the_fashion_frame_site_logo( 'header-brand-logo', 54 ); ?>
			</div>

			<!-- Right Header Actions (Search, Wishlist, Cart, Mobile Menu) -->
			<div class="header-actions">
				<!-- Search Toggle Button -->
				<button type="button" class="header-action-btn search-toggle-btn" aria-label="<?php esc_attr_e( 'Open Search', 'the-fashion-frame' ); ?>" aria-expanded="false">
					<span class="material-symbols-outlined" aria-hidden="true">search</span>
				</button>

				<!-- Wishlist / Favorites -->
				<a href="<?php echo esc_url( home_url( '/wishlist/' ) ); ?>" class="header-action-btn hidden md:flex" aria-label="<?php esc_attr_e( 'Wishlist', 'the-fashion-frame' ); ?>">
					<span class="material-symbols-outlined" aria-hidden="true">favorite</span>
				</a>

				<!-- Shopping Bag / Cart -->
				<?php
				$cart_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' );
				$cart_count = the_fashion_frame_cart_count();
				?>
				<a href="<?php echo esc_url( $cart_url ); ?>" class="header-action-btn header-cart-btn" aria-label="<?php esc_attr_e( 'Cart', 'the-fashion-frame' ); ?>">
					<span class="material-symbols-outlined" aria-hidden="true">shopping_bag</span>
					<?php if ( $cart_count > 0 ) : ?>
						<span class="cart-count"><?php echo esc_html( $cart_count ); ?></span>
					<?php endif; ?>
				</a>

				<!-- Mobile Hamburger Toggle -->
				<button type="button" class="header-action-btn mobile-nav-toggle md:hidden" aria-label="<?php esc_attr_e( 'Toggle Navigation Menu', 'the-fashion-frame' ); ?>" aria-expanded="false" aria-controls="mobile-drawer">
					<span class="material-symbols-outlined" aria-hidden="true">menu</span>
				</button>
			</div>

		</div>
	</header>

	<!-- Mobile Navigation Drawer -->
	<div id="mobile-drawer" class="mobile-drawer" aria-hidden="true">
		<div class="mobile-drawer-header">
			<div class="mobile-drawer-brand">
				<?php the_fashion_frame_site_logo( 'drawer-brand-logo', 42 ); ?>
				<span class="mobile-drawer-title"><?php bloginfo( 'name' ); ?></span>
			</div>
			<button type="button" class="mobile-drawer-close" aria-label="<?php esc_attr_e( 'Close Menu', 'the-fashion-frame' ); ?>">
				<span class="material-symbols-outlined">close</span>
			</button>
		</div>

		<nav class="mobile-drawer-nav" aria-label="<?php esc_attr_e( 'Mobile Menu', 'the-fashion-frame' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'mobile-menu',
						'container'      => false,
						'menu_class'     => 'mobile-drawer-menu',
						'fallback_cb'    => 'the_fashion_frame_default_mobile_menu',
					)
				);
			} else {
				the_fashion_frame_default_mobile_menu();
			}
			?>
		</nav>

		<div class="mobile-drawer-footer">
			<p class="font-label-caps text-secondary-fixed mb-2"><?php esc_html_e( "Readymade Men's, Women's & Kids' Clothing Store in Lucknow", 'the-fashion-frame' ); ?></p>
			<p class="font-body-md" style="color: rgba(255,255,255,0.6); font-size: 0.875rem;">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		</div>
	</div>

	<!-- Search Modal Overlay -->
	<div id="search-modal" class="search-modal" aria-hidden="true">
		<div class="search-modal-content">
			<button type="button" class="search-modal-close" aria-label="<?php esc_attr_e( 'Close Search', 'the-fashion-frame' ); ?>">
				<span class="material-symbols-outlined">close</span>
			</button>
			<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="search-form-inner">
					<input type="search" class="search-modal-input" placeholder="<?php esc_attr_e( 'Search collections, attire, fabrics...', 'the-fashion-frame' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
					<button type="submit" class="header-action-btn" aria-label="<?php esc_attr_e( 'Submit Search', 'the-fashion-frame' ); ?>" style="position: absolute; right: 0; color: var(--color-secondary-fixed);">
						<span class="material-symbols-outlined">search</span>
					</button>
				</div>
			</form>
		</div>
	</div>

	<main id="primary" class="site-main">
