<?php
/**
 * Template Name: About Us
 * Description: Dedicated luxury About Us brand story page for The Fashion Frame.
 *
 * @package The_Fashion_Frame
 */

get_header();
?>

<div class="site-container about-page-container">

	<!-- 1. Hero Header Section -->
	<header class="about-hero-section">
		<div class="about-hero-crest">
			<img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/11/Golden-TF-Monogram-in-Hexagon.webp' ) ); ?>" 
				 alt="<?php echo esc_attr__( 'The Fashion Frame Royal Monogram', 'the-fashion-frame' ); ?>" 
				 width="68" 
				 height="68" 
				 loading="eager" />
		</div>
		<span class="about-hero-tag">
			<?php esc_html_e( 'The Art of Readymade Couture', 'the-fashion-frame' ); ?>
		</span>
		<h1>
			<?php esc_html_e( 'About The Fashion Frame', 'the-fashion-frame' ); ?>
		</h1>
		<div class="about-gold-ornament" aria-hidden="true">
			<span class="line"></span>
			<span class="diamond">◆</span>
			<span class="line"></span>
		</div>
		<p class="about-hero-lead">
			<?php esc_html_e( "The Fashion Frame is a premier fashion house specializing in curated readymade Women's Suits, Handcrafted Kurta Sets, and Festive Ensembles. We celebrate the timeless poise of Indian silhouettes, crafted with pure fabrics, meticulous embellishments, and flawless ready-to-wear tailoring.", 'the-fashion-frame' ); ?>
		</p>
	</header>

	<!-- 2. Brand Story Split Section (Philosophy + Quality Hallmarks) -->
	<div class="about-story-section">
		
		<!-- Left: Philosophy -->
		<div class="about-story-col">
			<span class="section-tag"><?php esc_html_e( 'Our Philosophy', 'the-fashion-frame' ); ?></span>
			<h2><?php esc_html_e( 'Where Regal Poise Meets Modern Ease', 'the-fashion-frame' ); ?></h2>
			<p>
				<?php esc_html_e( "We believe that couture elegance should never be complicated. Our collections eliminate the lengthy delays of unstitched fabrics and bespoke tailoring by offering ready-to-wear suits with impeccable drape, lining, and finish.", 'the-fashion-frame' ); ?>
			</p>
			<p>
				<?php esc_html_e( "Every ensemble is thoughtfully created with authentic hand-embroidery, delicate zari, resham threadwork, and fine laces—designed for weddings, festive galas, and treasured celebrations.", 'the-fashion-frame' ); ?>
			</p>
			<div>
				<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="about-story-btn">
					<span><?php esc_html_e( 'Visit Our Flagship Boutique', 'the-fashion-frame' ); ?></span>
					<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
				</a>
			</div>
		</div>

		<!-- Right: Hallmarks Card -->
		<div class="about-hallmarks-card">
			<h3><?php esc_html_e( 'Our 3 Quality Hallmarks', 'the-fashion-frame' ); ?></h3>
			<ul class="hallmark-list">
				<li class="hallmark-item">
					<span class="material-symbols-outlined">verified</span>
					<div>
						<strong><?php esc_html_e( 'Pure Artisanal Fabrics', 'the-fashion-frame' ); ?></strong>
						<span><?php esc_html_e( 'Chanderi, organza, modal silk, and breathable fine cottons sourced for all-day royal comfort.', 'the-fashion-frame' ); ?></span>
					</div>
				</li>
				<li class="hallmark-item">
					<span class="material-symbols-outlined">straighten</span>
					<div>
						<strong><?php esc_html_e( 'Flawless Ready-To-Wear Fit', 'the-fashion-frame' ); ?></strong>
						<span><?php esc_html_e( 'Standardized Indian size grading from S to XXL with generous seam allowances.', 'the-fashion-frame' ); ?></span>
					</div>
				</li>
				<li class="hallmark-item">
					<span class="material-symbols-outlined">design_services</span>
					<div>
						<strong><?php esc_html_e( 'Complimentary Boutique Alterations', 'the-fashion-frame' ); ?></strong>
						<span><?php esc_html_e( 'Walk in to our flagship boutique for personalized master tailor adjustments.', 'the-fashion-frame' ); ?></span>
					</div>
				</li>
			</ul>
		</div>

	</div>

	<!-- 3. Three Key Pillars Grid -->
	<div class="about-pillars-grid">
		<div class="about-pillar-card">
			<div class="about-pillar-icon">
				<span class="material-symbols-outlined">auto_awesome</span>
			</div>
			<h4><?php esc_html_e( "Women's Readymade Suits", 'the-fashion-frame' ); ?></h4>
			<p><?php esc_html_e( "Anarkalis, straight-cut salwar suits, and festive palazzo sets crafted for effortless poise at every celebration.", 'the-fashion-frame' ); ?></p>
		</div>

		<div class="about-pillar-card">
			<div class="about-pillar-icon">
				<span class="material-symbols-outlined">child_care</span>
			</div>
			<h4><?php esc_html_e( "Kids' Festive Wardrobe", 'the-fashion-frame' ); ?></h4>
			<p><?php esc_html_e( "Pure, skin-friendly cottons and breathable silks tailored for young royalty, blending comfort with festive glamour.", 'the-fashion-frame' ); ?></p>
		</div>

		<div class="about-pillar-card">
			<div class="about-pillar-icon">
				<span class="material-symbols-outlined">local_shipping</span>
			</div>
			<h4><?php esc_html_e( 'Insured Pan-India Delivery', 'the-fashion-frame' ); ?></h4>
			<p><?php esc_html_e( 'Speedy dispatch in 24-48 business hours with doorstep express delivery and Cash on Delivery support nationwide.', 'the-fashion-frame' ); ?></p>
		</div>
	</div>

	<!-- 4. Concierge Banner -->
	<div class="about-concierge-banner">
		<span class="material-symbols-outlined about-concierge-icon">support_agent</span>
		<h3><?php esc_html_e( 'Dedicated Styling & Order Assistance', 'the-fashion-frame' ); ?></h3>
		<p>
			<?php esc_html_e( 'Need help picking your size, viewing live garment fabric videos, or scheduling a fitting? Our concierge styling team is available 7 days a week.', 'the-fashion-frame' ); ?>
		</p>
		<div class="about-concierge-actions">
			<a href="https://wa.me/919278340090" target="_blank" rel="noopener noreferrer" class="concierge-wa-btn">
				<span class="material-symbols-outlined text-[18px]">chat</span>
				<span><?php esc_html_e( 'WhatsApp +91 92783 40090', 'the-fashion-frame' ); ?></span>
			</a>
			<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="concierge-boutique-btn">
				<span class="material-symbols-outlined text-[18px]">location_on</span>
				<span><?php esc_html_e( 'Contact & Boutique Details', 'the-fashion-frame' ); ?></span>
			</a>
		</div>
	</div>

</div>

<?php
get_footer();
