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
						<?php the_fashion_frame_site_logo( 'footer-brand-logo', 60 ); ?>
						<div>
							<h3 class="footer-brand-name"><?php bloginfo( 'name' ); ?></h3>
							<span class="footer-brand-tagline"><?php esc_html_e( 'Lucknow • Luxury Readymade Couture', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
					<p class="footer-brand-desc">
						<?php esc_html_e( "Lucknow's premier fashion house for curated readymade Women's Suits, Handcrafted Kurta Sets, and Kids' Festive Ensembles.", 'the-fashion-frame' ); ?>
					</p>
					
					<div class="footer-contact-info">
						<div class="footer-contact-item">
							<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
							<span><?php esc_html_e( 'Hazratganj / Gomti Nagar, Lucknow, UP 226001', 'the-fashion-frame' ); ?></span>
						</div>
						<div class="footer-contact-item">
							<span class="material-symbols-outlined" aria-hidden="true">call</span>
							<a href="tel:+919876543210">+91 98765 43210</a>
						</div>
						<div class="footer-contact-item">
							<span class="material-symbols-outlined" aria-hidden="true">mail</span>
							<a href="mailto:care@thefashionframe.com">care@thefashionframe.com</a>
						</div>
					</div>

					<div class="footer-social-links">
						<a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="footer-social-btn">
							<span class="material-symbols-outlined">photo_camera</span>
						</a>
						<a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="footer-social-btn">
							<span class="material-symbols-outlined">public</span>
						</a>
						<a href="https://wa.me/919876543210" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="footer-social-btn">
							<span class="material-symbols-outlined">chat</span>
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

				<!-- Column 4: Newsletter & Boutique Privilege -->
				<div class="footer-col footer-col-newsletter">
					<h4 class="footer-heading"><?php esc_html_e( 'Newsletter', 'the-fashion-frame' ); ?></h4>
					<p class="footer-newsletter-text">
						<?php esc_html_e( 'Subscribe to receive private preview invitations, seasonal style lookbooks, and exclusive boutique privileges.', 'the-fashion-frame' ); ?>
					</p>
					<form class="footer-newsletter-form" action="#" method="post">
						<div class="footer-newsletter-input-wrap">
							<input type="email" class="newsletter-input" placeholder="<?php esc_attr_e( 'Enter your email address', 'the-fashion-frame' ); ?>" required />
							<button type="submit" class="newsletter-submit-btn" aria-label="<?php esc_attr_e( 'Subscribe', 'the-fashion-frame' ); ?>">
								<span class="material-symbols-outlined">arrow_forward</span>
							</button>
						</div>
					</form>
					<div class="footer-store-timing">
						<span class="timing-title"><?php esc_html_e( 'Flagship Store Hours:', 'the-fashion-frame' ); ?></span>
						<span class="timing-desc"><?php esc_html_e( 'Mon – Sun: 11:00 AM – 9:30 PM IST', 'the-fashion-frame' ); ?></span>
					</div>
				</div>

			</div><!-- .footer-grid -->

			<!-- Bottom Copyright & Trust Badges Bar -->
			<div class="footer-bottom">
				<div class="footer-bottom-left">
					<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( "Readymade Women's & Kids' Designer Clothing Store in Lucknow. All rights reserved.", 'the-fashion-frame' ); ?></p>
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

<?php wp_footer(); ?>

</body>
</html>
