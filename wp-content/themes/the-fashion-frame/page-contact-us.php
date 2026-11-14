<?php
/**
 * Template Name: Contact Us
 *
 * The template for displaying the Contact Us page.
 *
 * @package The_Fashion_Frame
 */

get_header();
?>

<div class="site-container contact-page-container" style="padding-top: 2.5rem; padding-bottom: 5rem;">
	
	<!-- Breadcrumb / Pre-title -->
	<div class="contact-header-wrap text-center mb-10">
		<span class="policy-badge inline-flex items-center gap-2 mb-3">
			<span class="material-symbols-outlined text-[18px]">support_agent</span>
			<span><?php esc_html_e( 'Customer Concierge &amp; Boutique Assistance', 'the-fashion-frame' ); ?></span>
		</span>
		<h1 class="font-headline-lg text-primary text-3xl md:text-4xl font-semibold tracking-tight">
			<?php esc_html_e( 'Contact The Fashion Frame', 'the-fashion-frame' ); ?>
		</h1>
		<div class="gold-divider" style="width: 70px; height: 2px; background: var(--color-secondary); margin: 1rem auto 1.25rem;"></div>
		<p class="contact-hero-lead max-w-2xl mx-auto text-on-surface-variant text-base md:text-lg">
			<?php esc_html_e( 'Have questions regarding our readymade collections, size guidance, alterations, or custom festive orders? Our dedicated concierge team is here to assist you.', 'the-fashion-frame' ); ?>
		</p>
	</div>

	<!-- 3 Highlighted Contact Channels -->
	<div class="contact-channels-grid mb-12">
		
		<!-- WhatsApp Chat Support (Primary Highlight) -->
		<div class="contact-channel-card contact-card-highlight">
			<div class="contact-card-badge">
				<span class="pulse-dot"></span>
				<span><?php esc_html_e( 'Fastest Response • ~5 Mins', 'the-fashion-frame' ); ?></span>
			</div>
			<div class="contact-card-icon whatsapp-icon-bg">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="28" height="28" fill="#ffffff">
					<path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
				</svg>
			</div>
			<h3 class="contact-channel-title"><?php esc_html_e( 'WhatsApp Chat Support', 'the-fashion-frame' ); ?></h3>
			<p class="contact-channel-desc"><?php esc_html_e( 'Instant assistance for sizing, real product photos, video styling, and order updates.', 'the-fashion-frame' ); ?></p>
			<div class="contact-channel-detail">
				<a href="https://wa.me/919278340090?text=<?php echo rawurlencode( 'Hello The Fashion Frame, I would like to chat with support.' ); ?>" target="_blank" rel="noopener noreferrer" class="contact-value-link font-semibold">
					+91 92783 40090
				</a>
			</div>
			<a href="https://wa.me/919278340090?text=<?php echo rawurlencode( 'Hello The Fashion Frame, I would like to chat with support.' ); ?>" target="_blank" rel="noopener noreferrer" class="contact-btn contact-btn-whatsapp">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="18" height="18" fill="currentColor">
					<path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
				</svg>
				<span><?php esc_html_e( 'Chat on WhatsApp', 'the-fashion-frame' ); ?></span>
			</a>
		</div>

		<!-- Direct Phone / Call Concierge -->
		<div class="contact-channel-card">
			<div class="contact-card-icon phone-icon-bg">
				<span class="material-symbols-outlined">call</span>
			</div>
			<h3 class="contact-channel-title"><?php esc_html_e( 'Phone Support', 'the-fashion-frame' ); ?></h3>
			<p class="contact-channel-desc"><?php esc_html_e( 'Speak directly with our boutique styling team for inquiries, orders, and appointments.', 'the-fashion-frame' ); ?></p>
			<div class="contact-channel-detail">
				<a href="tel:+919278340090" class="contact-value-link font-semibold">
					+91 92783 40090
				</a>
				<span class="contact-subdetail"><?php esc_html_e( 'Mon – Sun: 11:00 AM – 9:30 PM IST', 'the-fashion-frame' ); ?></span>
			</div>
			<a href="tel:+919278340090" class="contact-btn contact-btn-primary">
				<span class="material-symbols-outlined text-[18px]">phone_in_talk</span>
				<span><?php esc_html_e( 'Call Now', 'the-fashion-frame' ); ?></span>
			</a>
		</div>

		<!-- Email Care -->
		<div class="contact-channel-card">
			<div class="contact-card-icon email-icon-bg">
				<span class="material-symbols-outlined">mail</span>
			</div>
			<h3 class="contact-channel-title"><?php esc_html_e( 'Email Concierge', 'the-fashion-frame' ); ?></h3>
			<p class="contact-channel-desc"><?php esc_html_e( 'Send detailed queries, bulk bridal inquiries, feedback, or returns documentation.', 'the-fashion-frame' ); ?></p>
			<div class="contact-channel-detail">
				<a href="mailto:fashionframelko@gmail.com" class="contact-value-link font-semibold">
					fashionframelko@gmail.com
				</a>
				<span class="contact-subdetail"><?php esc_html_e( 'Guaranteed reply within 24 hours', 'the-fashion-frame' ); ?></span>
			</div>
			<a href="mailto:fashionframelko@gmail.com" class="contact-btn contact-btn-outline">
				<span class="material-symbols-outlined text-[18px]">send</span>
				<span><?php esc_html_e( 'Write Email', 'the-fashion-frame' ); ?></span>
			</a>
		</div>

	</div>

	<!-- Main Grid: Boutique Location & Interactive Message Form -->
	<div class="contact-main-grid mb-14">
		
		<!-- Left: Flagship Store & Boutique Information -->
		<div class="contact-boutique-info">
			<div class="boutique-info-card">
				<h2 class="boutique-info-heading font-headline-md text-primary mb-4">
					<?php esc_html_e( 'Flagship Boutique Experience', 'the-fashion-frame' ); ?>
				</h2>
				<p class="text-on-surface-variant text-sm leading-relaxed mb-6">
					<?php esc_html_e( 'Experience our curated collection of readymade Women’s Suits, Handcrafted Kurta Sets, and Kids’ Festive Ensembles. Walk in for personalised fittings, styling, and ready-to-wear alterations.', 'the-fashion-frame' ); ?>
				</p>

				<div class="boutique-detail-list space-y-4 mb-6">
					<div class="boutique-detail-item flex items-start gap-3">
						<span class="material-symbols-outlined text-secondary-fixed-dim mt-0.5">location_on</span>
						<div>
							<strong class="text-primary block text-sm"><?php esc_html_e( 'Store Address', 'the-fashion-frame' ); ?></strong>
							<span class="text-on-surface-variant text-sm"><?php esc_html_e( 'UGF, B-1/2, Vikrant Khand-1, Vikrant Khand, Gomti Nagar, Lucknow, Uttar Pradesh – 226010, India', 'the-fashion-frame' ); ?></span>
						</div>
					</div>

					<div class="boutique-detail-item flex items-start gap-3">
						<span class="material-symbols-outlined text-secondary-fixed-dim mt-0.5">schedule</span>
						<div>
							<strong class="text-primary block text-sm"><?php esc_html_e( 'Opening Hours', 'the-fashion-frame' ); ?></strong>
							<span class="text-on-surface-variant text-sm"><?php esc_html_e( 'Monday to Sunday: 11:00 AM – 9:30 PM IST', 'the-fashion-frame' ); ?></span>
						</div>
					</div>

					<div class="boutique-detail-item flex items-start gap-3">
						<span class="material-symbols-outlined text-secondary-fixed-dim mt-0.5">verified</span>
						<div>
							<strong class="text-primary block text-sm"><?php esc_html_e( 'In-Store Services', 'the-fashion-frame' ); ?></strong>
							<span class="text-on-surface-variant text-sm"><?php esc_html_e( 'Complimentary Garment Trials, Alterations & Festive Consultations', 'the-fashion-frame' ); ?></span>
						</div>
					</div>
				</div>

				<!-- Quick WhatsApp Alteration Callout -->
				<div class="boutique-alteration-callout mt-6">
					<div class="callout-icon">
						<span class="material-symbols-outlined">chat</span>
					</div>
					<div>
						<h4><?php esc_html_e( 'Need Immediate Assistance?', 'the-fashion-frame' ); ?></h4>
						<p><?php esc_html_e( 'Our stylist is online on WhatsApp right now at +91 92783 40090 to answer sizing or order queries.', 'the-fashion-frame' ); ?></p>
						<a href="https://wa.me/919278340090?text=<?php echo rawurlencode( 'Hello The Fashion Frame, I need assistance with an order or product.' ); ?>" target="_blank" rel="noopener noreferrer" class="callout-wa-btn">
							<span><?php esc_html_e( 'Chat on WhatsApp', 'the-fashion-frame' ); ?></span>
							<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
						</a>
					</div>
				</div>

				<!-- Follow & Connect on Social Media -->
				<div class="boutique-social-connect mt-6 pt-5" style="border-top: 1px solid rgba(0, 43, 27, 0.12);">
					<h4 class="text-xs font-semibold uppercase tracking-wider text-primary mb-3" style="letter-spacing: 0.08em; font-family: var(--font-label);"><?php esc_html_e( 'Connect & Follow On Social Media', 'the-fashion-frame' ); ?></h4>
					<div class="contact-social-buttons-wrap">
						<a href="https://www.instagram.com/thefashionframe.official/" target="_blank" rel="noopener noreferrer" class="contact-social-link-btn" aria-label="<?php esc_attr_e( 'Follow us on Instagram', 'the-fashion-frame' ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
							<span>@thefashionframe.official</span>
						</a>
						<a href="https://www.facebook.com/thefashionframe.official/" target="_blank" rel="noopener noreferrer" class="contact-social-link-btn" aria-label="<?php esc_attr_e( 'Follow us on Facebook', 'the-fashion-frame' ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
							<span>Facebook</span>
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Right: Send Us a Message Form -->
		<div class="contact-form-wrap">
			<div class="contact-form-card">
				<h2 class="contact-form-heading font-headline-md text-primary mb-2">
					<?php esc_html_e( 'Send Us a Message', 'the-fashion-frame' ); ?>
				</h2>
				<p class="text-on-surface-variant text-sm mb-6">
					<?php esc_html_e( 'Fill in your details below and our customer support team will get in touch with you shortly.', 'the-fashion-frame' ); ?>
				</p>

				<form id="tff-contact-form" class="space-y-4" onsubmit="handleContactSubmit(event)">
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div class="form-group">
							<label for="contact-name" class="form-label"><?php esc_html_e( 'Full Name *', 'the-fashion-frame' ); ?></label>
							<input type="text" id="contact-name" name="name" required class="form-input" placeholder="<?php esc_attr_e( 'Your name', 'the-fashion-frame' ); ?>" />
						</div>
						<div class="form-group">
							<label for="contact-phone" class="form-label"><?php esc_html_e( 'Phone / WhatsApp *', 'the-fashion-frame' ); ?></label>
							<input type="tel" id="contact-phone" name="phone" required class="form-input" placeholder="<?php esc_attr_e( '+91 9XXXXXXXXX', 'the-fashion-frame' ); ?>" />
						</div>
					</div>

					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div class="form-group">
							<label for="contact-email" class="form-label"><?php esc_html_e( 'Email Address', 'the-fashion-frame' ); ?></label>
							<input type="email" id="contact-email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'yourname@example.com', 'the-fashion-frame' ); ?>" />
						</div>
						<div class="form-group">
							<label for="contact-subject" class="form-label"><?php esc_html_e( 'Subject / Order #', 'the-fashion-frame' ); ?></label>
							<select id="contact-subject" name="subject" class="form-input">
								<option value="Product Sizing Guidance"><?php esc_html_e( 'Product Sizing Guidance', 'the-fashion-frame' ); ?></option>
								<option value="Order Status & Delivery"><?php esc_html_e( 'Order Status & Delivery', 'the-fashion-frame' ); ?></option>
								<option value="Exchange or Return Request"><?php esc_html_e( 'Exchange or Return Request', 'the-fashion-frame' ); ?></option>
								<option value="Boutique Trial & Alterations"><?php esc_html_e( 'Boutique Trial & Alterations', 'the-fashion-frame' ); ?></option>
								<option value="General Inquiry"><?php esc_html_e( 'General Inquiry', 'the-fashion-frame' ); ?></option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="contact-message" class="form-label"><?php esc_html_e( 'Your Message *', 'the-fashion-frame' ); ?></label>
						<textarea id="contact-message" name="message" rows="4" required class="form-input form-textarea" placeholder="<?php esc_attr_e( 'Tell us how we can help you...', 'the-fashion-frame' ); ?>"></textarea>
					</div>

					<div class="form-actions flex flex-wrap items-center gap-3 pt-2">
						<button type="submit" id="contact-submit-btn" class="submit-btn-gold">
							<span class="material-symbols-outlined text-[18px]">send</span>
							<span><?php esc_html_e( 'Send Message via WhatsApp', 'the-fashion-frame' ); ?></span>
						</button>
						<a href="tel:+919278340090" class="support-btn support-btn-outline">
							<span class="material-symbols-outlined text-[18px]">call</span>
							<span><?php esc_html_e( 'Or Call +91 92783 40090', 'the-fashion-frame' ); ?></span>
						</a>
					</div>
					
					<div id="contact-form-notice" class="contact-notice" style="display: none;"></div>
				</form>
			</div>
		</div>

	</div>

	<!-- FAQ Section for Instant Answers -->
	<div class="contact-faq-section pt-8 border-t border-[rgba(201,162,39,0.2)]">
		<div class="text-center mb-8">
			<h2 class="font-headline-md text-primary text-2xl font-semibold mb-2">
				<?php esc_html_e( 'Frequently Asked Questions', 'the-fashion-frame' ); ?>
			</h2>
			<p class="text-on-surface-variant text-sm"><?php esc_html_e( 'Quick answers to common questions about our store and orders.', 'the-fashion-frame' ); ?></p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
			<div class="faq-card">
				<h4 class="faq-question flex items-center gap-2">
					<span class="material-symbols-outlined text-secondary text-[20px]">help</span>
					<span><?php esc_html_e( 'How do I check size fit before ordering?', 'the-fashion-frame' ); ?></span>
				</h4>
				<p class="faq-answer">
					<?php esc_html_e( 'You can message us directly on WhatsApp at +91 92783 40090 with your measurements or product link. Our team will verify the fit and send exact garment dimensions.', 'the-fashion-frame' ); ?>
				</p>
			</div>

			<div class="faq-card">
				<h4 class="faq-question flex items-center gap-2">
					<span class="material-symbols-outlined text-secondary text-[20px]">local_shipping</span>
					<span><?php esc_html_e( 'How long does delivery take?', 'the-fashion-frame' ); ?></span>
				</h4>
				<p class="faq-answer">
					<?php esc_html_e( 'We dispatch all ready-to-wear orders within 24-48 hours. Express delivery arrives within 3 to 5 business days across major Indian cities.', 'the-fashion-frame' ); ?>
				</p>
			</div>

			<div class="faq-card">
				<h4 class="faq-question flex items-center gap-2">
					<span class="material-symbols-outlined text-secondary text-[20px]">sync</span>
					<span><?php esc_html_e( 'What is your exchange policy?', 'the-fashion-frame' ); ?></span>
				</h4>
				<p class="faq-answer">
					<?php esc_html_e( 'We offer a hassle-free 7-day exchange window for sizing and fit. Simply reach out via WhatsApp at +91 92783 40090 or email fashionframelko@gmail.com to initiate an exchange.', 'the-fashion-frame' ); ?>
				</p>
			</div>

			<div class="faq-card">
				<h4 class="faq-question flex items-center gap-2">
					<span class="material-symbols-outlined text-secondary text-[20px]">storefront</span>
					<span><?php esc_html_e( 'Can I visit the boutique for personal trials?', 'the-fashion-frame' ); ?></span>
				</h4>
				<p class="faq-answer">
					<?php esc_html_e( 'Yes! Our flagship boutique is open Monday to Sunday from 11:00 AM to 9:30 PM IST. You are welcome to try on outfits in person.', 'the-fashion-frame' ); ?>
				</p>
			</div>
		</div>
	</div>

</div>

<script>
function handleContactSubmit(event) {
	event.preventDefault();
	var name = document.getElementById('contact-name').value.trim();
	var phone = document.getElementById('contact-phone').value.trim();
	var email = document.getElementById('contact-email').value.trim();
	var subject = document.getElementById('contact-subject').value;
	var message = document.getElementById('contact-message').value.trim();

	var text = "Hello The Fashion Frame,\n\n" +
		"Name: " + name + "\n" +
		"Phone: " + phone + "\n" +
		(email ? "Email: " + email + "\n" : "") +
		"Topic: " + subject + "\n" +
		"Message: " + message;

	var waUrl = "https://wa.me/919278340090?text=" + encodeURIComponent(text);
	window.open(waUrl, '_blank');

	var notice = document.getElementById('contact-form-notice');
	if (notice) {
		notice.style.display = 'block';
		notice.className = 'contact-notice success';
		notice.innerHTML = '<span class="material-symbols-outlined text-[16px]">check_circle</span><span>Opening WhatsApp to send your inquiry to +91 92783 40090...</span>';
	}
}
</script>

<?php
get_footer();
