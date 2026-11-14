<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #primary and #page div and all content after.
 *
 * @package The_Fashion_Frame
 */

?>
	</main><!-- #primary -->

	<!-- Luxury Global Footer -->
	<footer id="colophon" class="site-footer">
		<div class="footer-container">
			<div class="footer-grid">
				
				<!-- Column 1: Brand Heritage & Store Info -->
				<div class="footer-col footer-col-brand">
					<div class="footer-brand-wrap">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="footer-brand-logo-link" aria-label="<?php bloginfo( 'name' ); ?>">
							<img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/11/Golden-TF-Monogram-in-Hexagon.webp' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="footer-brand-logo-img" width="56" height="56" loading="lazy" />
						</a>
						<div class="footer-brand-text-wrap">
							<h3 class="footer-brand-name"><?php esc_html_e( 'The Fashion Frame', 'the-fashion-frame' ); ?></h3>
							<span class="footer-brand-tagline"><?php esc_html_e( 'Luxury Designer Readymade Couture', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
					<p class="footer-brand-desc">
						<?php esc_html_e( "Premier fashion house for curated readymade Women's Suits, Handcrafted Kurta Sets, and Kids' Festive Ensembles.", 'the-fashion-frame' ); ?>
					</p>
					
					<div class="footer-contact-info">
						<div class="footer-contact-item">
							<span class="material-symbols-outlined" aria-hidden="true">call</span>
							<a href="tel:+919278340090">+91 92783 40090</a>
						</div>
						<div class="footer-contact-item">
							<span class="material-symbols-outlined" aria-hidden="true">mail</span>
							<a href="mailto:fashionframelko@gmail.com">fashionframelko@gmail.com</a>
						</div>
					</div>

					<div class="footer-social-links">
						<a href="https://www.instagram.com/thefashionframe.official/" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="footer-social-btn">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
						</a>
						<a href="https://www.facebook.com/thefashionframe.official/" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="footer-social-btn">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
						</a>
						<a href="https://wa.me/919278340090" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="footer-social-btn">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 448 512" fill="currentColor" aria-hidden="true"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
						</a>
					</div>
				</div>

				<!-- Column 2: Shop Categories -->
				<div class="footer-col footer-col-shop">
					<h4 class="footer-heading"><?php esc_html_e( 'Shop Collections', 'the-fashion-frame' ); ?></h4>
					<?php
					if ( has_nav_menu( 'footer_shop' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer_shop',
								'container'      => false,
								'menu_class'     => 'footer-links',
							)
						);
					} else {
						?>
						<ul class="footer-links">
							<li><a href="<?php echo esc_url( home_url( '/womens-suits/' ) ); ?>"><?php esc_html_e( "Women's Suits", 'the-fashion-frame' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/kids-wear/' ) ); ?>"><?php esc_html_e( 'Kids Wear', 'the-fashion-frame' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/new-arrivals/' ) ); ?>"><?php esc_html_e( 'New Arrivals', 'the-fashion-frame' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/collections/' ) ); ?>"><?php esc_html_e( 'Festive & Bridal Edit', 'the-fashion-frame' ); ?></a></li>
						</ul>
						<?php
					}
					?>
				</div>

				<!-- Column 3: Customer Care / Support -->
				<div class="footer-col footer-col-support">
					<h4 class="footer-heading"><?php esc_html_e( 'Customer Care', 'the-fashion-frame' ); ?></h4>
					<?php
					if ( has_nav_menu( 'footer_support' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer_support',
								'container'      => false,
								'menu_class'     => 'footer-links',
							)
						);
					} else {
						?>
						<ul class="footer-links">
							<li><a href="<?php echo esc_url( home_url( '/shipping-returns/' ) ); ?>"><?php esc_html_e( 'Shipping & Delivery', 'the-fashion-frame' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/shipping-returns/#returns' ) ); ?>"><?php esc_html_e( 'Returns & Exchanges', 'the-fashion-frame' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/size-guide/' ) ); ?>"><?php esc_html_e( 'Size & Fit Guide', 'the-fashion-frame' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'the-fashion-frame' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'the-fashion-frame' ); ?></a></li>
						</ul>
						<?php
					}
					?>
				</div>

				<!-- Column 4: About & Contact -->
				<div class="footer-col footer-col-about">
					<h4 class="footer-heading"><?php esc_html_e( 'About & Contact', 'the-fashion-frame' ); ?></h4>
					<ul class="footer-links">
						<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About Us', 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Flagship Boutique Experience', 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Complimentary Alterations', 'the-fashion-frame' ); ?></a></li>
					</ul>
					<div class="footer-store-timing" style="margin-top: 1.15rem;">
						<span class="timing-title"><?php esc_html_e( 'Flagship Store Hours:', 'the-fashion-frame' ); ?></span>
						<span class="timing-desc"><?php esc_html_e( 'Mon – Sun: 11:00 AM – 9:30 PM IST', 'the-fashion-frame' ); ?></span>
					</div>
				</div>

			</div><!-- .footer-grid -->

			<!-- Bottom Copyright & Trust Badges Bar -->
			<div class="footer-bottom">
				<div class="footer-bottom-left">
					<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( "Luxury Women's & Kids' Designer Clothing Store. All rights reserved.", 'the-fashion-frame' ); ?></p>
				</div>
				<div class="footer-bottom-right">
					<span class="footer-badge"><?php esc_html_e( '✨ Premium Quality Fabric', 'the-fashion-frame' ); ?></span>
					<span class="footer-badge-dot">•</span>
					<span class="footer-badge"><?php esc_html_e( '🔒 100% Secure Shopping', 'the-fashion-frame' ); ?></span>
					<span class="footer-badge-dot">•</span>
					<span class="footer-badge"><?php esc_html_e( '📦 Pan-India Delivery', 'the-fashion-frame' ); ?></span>
				</div>
			</div>

		</div><!-- .footer-container -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<!-- Floating WhatsApp Chat Support Widget -->
<a href="https://wa.me/919278340090?text=<?php echo rawurlencode( 'Hello The Fashion Frame, I would like to chat with support.' ); ?>" class="whatsapp-float-btn" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Chat with us on WhatsApp', 'the-fashion-frame' ); ?>" title="<?php esc_attr_e( 'Chat with us on WhatsApp', 'the-fashion-frame' ); ?>">
	<span class="whatsapp-float-pulse"></span>
	<svg class="whatsapp-float-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="28" height="28" fill="currentColor">
		<path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
	</svg>
	<span class="whatsapp-float-text"><?php esc_html_e( 'Chat Support', 'the-fashion-frame' ); ?></span>
</a>

<?php wp_footer(); ?>

</body>
</html>
