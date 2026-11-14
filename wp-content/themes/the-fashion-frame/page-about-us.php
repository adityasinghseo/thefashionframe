<?php
/**
 * Template Name: About Us
 * Description: Dedicated luxury About Us brand story page for The Fashion Frame.
 *
 * @package The_Fashion_Frame
 */

get_header();
?>

<div class="site-container about-us-page-wrap py-12 md:py-16">

	<!-- Hero Header -->
	<header class="about-hero text-center max-w-3xl mx-auto mb-14">
		<div class="about-crest inline-block mb-4">
			<img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/11/Golden-TF-Monogram-in-Hexagon.webp' ) ); ?>" 
				 alt="<?php echo esc_attr__( 'The Fashion Frame Royal Monogram', 'the-fashion-frame' ); ?>" 
				 class="mx-auto" 
				 width="72" 
				 height="72" 
				 loading="eager" />
		</div>
		<span class="text-xs font-semibold uppercase tracking-[0.2em] text-secondary-fixed-dim block mb-2" style="font-family: var(--font-label);">
			<?php esc_html_e( 'The Art of Readymade Couture', 'the-fashion-frame' ); ?>
		</span>
		<h1 class="font-headline-xl text-primary mb-4" style="font-family: var(--font-headline); letter-spacing: -0.01em;">
			<?php esc_html_e( 'About The Fashion Frame', 'the-fashion-frame' ); ?>
		</h1>
		<div class="gold-divider w-16 h-0.5 mx-auto mb-6" style="background: var(--color-secondary-fixed, #ffe08e);"></div>
		<p class="text-on-surface-variant text-base md:text-lg leading-relaxed">
			<?php esc_html_e( "The Fashion Frame is a premier fashion house specializing in curated readymade Women's Suits, Handcrafted Kurta Sets, and Festive Ensembles. We celebrate the timeless poise of Indian silhouettes, crafted with pure fabrics, meticulous embellishments, and flawless ready-to-wear tailoring.", 'the-fashion-frame' ); ?>
		</p>
	</header>

	<!-- Brand Story Grid: 2 Columns -->
	<div class="about-story-grid grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-16 max-w-5xl mx-auto">
		<div class="about-story-content space-y-5">
			<span class="text-xs font-semibold uppercase tracking-wider text-secondary-fixed-dim" style="font-family: var(--font-label);">
				<?php esc_html_e( 'Our Philosophy', 'the-fashion-frame' ); ?>
			</span>
			<h2 class="font-headline-md text-primary" style="font-family: var(--font-headline);">
				<?php esc_html_e( 'Where Regal Poise Meets Modern Ease', 'the-fashion-frame' ); ?>
			</h2>
			<p class="text-on-surface-variant text-sm md:text-base leading-relaxed">
				<?php esc_html_e( "We believe that couture elegance should never be complicated. Our collections eliminate the lengthy delays of unstitched fabrics and bespoke tailoring by offering ready-to-wear suits with impeccable drape, lining, and finish.", 'the-fashion-frame' ); ?>
			</p>
			<p class="text-on-surface-variant text-sm md:text-base leading-relaxed">
				<?php esc_html_e( "Every ensemble is thoughtfully created with authentic hand-embroidery, delicate zari, resham threadwork, and fine laces—designed for weddings, festive galas, and treasured celebrations.", 'the-fashion-frame' ); ?>
			</p>
			<div class="pt-2">
				<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="about-cta-btn inline-flex items-center gap-2 px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider" style="background: var(--color-primary); color: var(--color-secondary-fixed, #ffe08e); text-decoration: none;">
					<span><?php esc_html_e( 'Visit Our Flagship Boutique', 'the-fashion-frame' ); ?></span>
					<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
				</a>
			</div>
		</div>

		<div class="about-story-card p-8 rounded-2xl border" style="background: #fbf9f6; border-color: rgba(201, 162, 39, 0.35);">
			<h3 class="font-headline-sm text-primary mb-4" style="font-family: var(--font-headline);">
				<?php esc_html_e( 'Our 3 Quality Hallmarks', 'the-fashion-frame' ); ?>
			</h3>
			<ul class="space-y-4">
				<li class="flex items-start gap-3">
					<span class="material-symbols-outlined text-secondary-fixed-dim mt-0.5">verified</span>
					<div>
						<strong class="block text-sm text-primary"><?php esc_html_e( 'Pure Artisanal Fabrics', 'the-fashion-frame' ); ?></strong>
						<span class="text-xs text-on-surface-variant"><?php esc_html_e( 'Chanderi, organza, modal silk, and breathable fine cottons sourced for all-day royal comfort.', 'the-fashion-frame' ); ?></span>
					</div>
				</li>
				<li class="flex items-start gap-3">
					<span class="material-symbols-outlined text-secondary-fixed-dim mt-0.5">straighten</span>
					<div>
						<strong class="block text-sm text-primary"><?php esc_html_e( 'Flawless Ready-To-Wear Fit', 'the-fashion-frame' ); ?></strong>
						<span class="text-xs text-on-surface-variant"><?php esc_html_e( 'Standardized Indian size grading from S to XXL with generous seam allowances.', 'the-fashion-frame' ); ?></span>
					</div>
				</li>
				<li class="flex items-start gap-3">
					<span class="material-symbols-outlined text-secondary-fixed-dim mt-0.5">design_services</span>
					<div>
						<strong class="block text-sm text-primary"><?php esc_html_e( 'Complimentary Boutique Alterations', 'the-fashion-frame' ); ?></strong>
						<span class="text-xs text-on-surface-variant"><?php esc_html_e( 'Walk in to our flagship store for personalized master tailor adjustments.', 'the-fashion-frame' ); ?></span>
					</div>
				</li>
			</ul>
		</div>
	</div>

	<!-- Boutique Concierge CTA Strip -->
	<div class="about-concierge-strip text-center p-8 md:p-12 rounded-2xl max-w-4xl mx-auto" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-container) 100%); color: #ffffff;">
		<span class="material-symbols-outlined text-4xl mb-3" style="color: var(--color-secondary-fixed, #ffe08e);">support_agent</span>
		<h3 class="font-headline-md mb-2" style="font-family: var(--font-headline); color: var(--color-secondary-fixed, #ffe08e);">
			<?php esc_html_e( 'Dedicated Styling & Order Assistance', 'the-fashion-frame' ); ?>
		</h3>
		<p class="text-sm md:text-base max-w-xl mx-auto mb-6" style="color: rgba(255, 255, 255, 0.88);">
			<?php esc_html_e( 'Need help picking your size, viewing live garment fabric videos, or placing an order? Our concierge styling team is available 7 days a week.', 'the-fashion-frame' ); ?>
		</p>
		<div class="flex flex-wrap justify-center gap-4">
			<a href="https://wa.me/919278340090" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider" style="background: #25d366; color: #ffffff; text-decoration: none;">
				<span class="material-symbols-outlined text-[18px]">chat</span>
				<span><?php esc_html_e( 'WhatsApp +91 92783 40090', 'the-fashion-frame' ); ?></span>
			</a>
			<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider border" style="background: transparent; border-color: var(--color-secondary-fixed, #ffe08e); color: var(--color-secondary-fixed, #ffe08e); text-decoration: none;">
				<span class="material-symbols-outlined text-[18px]">location_on</span>
				<span><?php esc_html_e( 'Contact & Store Details', 'the-fashion-frame' ); ?></span>
			</a>
		</div>
	</div>

</div>

<?php
get_footer();
