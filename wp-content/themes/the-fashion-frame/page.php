<?php
/**
 * The template for displaying all pages
 *
 * @package The_Fashion_Frame
 */

get_header();
?>

<div class="site-container page-container" style="padding-top: 3rem; padding-bottom: 5rem; min-height: 60vh;">
	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>
			<?php if ( ! is_front_page() ) : ?>
				<header class="page-header text-center mb-8">
					<h1 class="font-headline-lg text-primary">
						<?php
						if ( function_exists( 'is_cart' ) && is_cart() ) {
							esc_html_e( 'Cart', 'the-fashion-frame' );
						} elseif ( function_exists( 'is_checkout' ) && is_checkout() ) {
							esc_html_e( 'Checkout', 'the-fashion-frame' );
						} else {
							the_title();
						}
						?>
					</h1>
					<div class="gold-divider" style="width: 60px; height: 2px; background: var(--color-secondary-fixed); margin: 0.75rem auto 0;"></div>
				</header>
			<?php endif; ?>

			<div class="page-entry-body">
				<?php
				if ( function_exists( 'woocommerce_output_all_notices' ) ) {
					woocommerce_output_all_notices();
				}
				the_content();
				?>
			</div>
		</article>

		<?php
	endwhile;
	?>
</div>

<?php
get_footer();
