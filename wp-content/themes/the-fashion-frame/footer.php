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

	<!-- Footer matching Stitch Design -->
	<footer id="colophon" class="site-footer">
		<div class="footer-grid">
			
			<!-- Brand Info Column -->
			<div class="footer-col footer-col-brand">
				<div class="footer-brand-wrap">
					<?php the_fashion_frame_site_logo( 'footer-brand-logo', 68 ); ?>
					<h3 class="footer-brand-name"><?php bloginfo( 'name' ); ?></h3>
				</div>
				<p class="font-body-md" style="color: rgba(255, 255, 255, 0.8); margin-bottom: 1.5rem;">
					<?php echo get_bloginfo( 'description' ) ? esc_html( get_bloginfo( 'description' ) ) : esc_html__( "Readymade Men's, Women's & Kids' Clothing Store in Lucknow.", 'the-fashion-frame' ); ?>
				</p>
				<p class="font-label-caps" style="color: rgba(255, 255, 255, 0.6);">
					&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'the-fashion-frame' ); ?>
				</p>
			</div>

			<!-- Shop Column -->
			<div class="footer-col">
				<h4 class="footer-heading"><?php esc_html_e( 'Shop', 'the-fashion-frame' ); ?></h4>
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
						<li><a href="<?php echo esc_url( home_url( '/mens-wear/' ) ); ?>"><?php esc_html_e( "Men's Wear", 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/kids-wear/' ) ); ?>"><?php esc_html_e( 'Kids Wear', 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/new-arrivals/' ) ); ?>"><?php esc_html_e( 'New Arrivals', 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/collections/' ) ); ?>"><?php esc_html_e( 'Collections', 'the-fashion-frame' ); ?></a></li>
					</ul>
					<?php
				}
				?>
			</div>

			<!-- Support Column -->
			<div class="footer-col">
				<h4 class="footer-heading"><?php esc_html_e( 'Support', 'the-fashion-frame' ); ?></h4>
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
						<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/shipping-returns/' ) ); ?>"><?php esc_html_e( 'Shipping & Returns', 'the-fashion-frame' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/size-guide/' ) ); ?>"><?php esc_html_e( 'Size Guide', 'the-fashion-frame' ); ?></a></li>
					</ul>
					<?php
				}
				?>
			</div>

			<!-- Newsletter Column -->
			<div class="footer-col">
				<h4 class="footer-heading"><?php esc_html_e( 'Newsletter', 'the-fashion-frame' ); ?></h4>
				<p class="font-body-md" style="color: rgba(255, 255, 255, 0.8); margin-bottom: 1rem;">
					<?php esc_html_e( 'Subscribe for early access to new collections.', 'the-fashion-frame' ); ?>
				</p>
				<form class="footer-newsletter-form" action="#" method="post">
					<input type="email" class="newsletter-input" placeholder="<?php esc_attr_e( 'Email Address', 'the-fashion-frame' ); ?>" required />
					<button type="submit" class="newsletter-submit"><?php esc_html_e( 'SUBSCRIBE', 'the-fashion-frame' ); ?></button>
				</form>
			</div>

		</div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
