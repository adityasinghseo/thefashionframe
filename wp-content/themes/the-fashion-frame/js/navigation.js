/**
 * The Fashion Frame - Navigation, Modals & Single Product Interactions
 */

document.addEventListener('DOMContentLoaded', function () {
	// 1. Mobile Drawer elements
	var mobileNavToggle = document.querySelector('.mobile-nav-toggle');
	var mobileDrawer = document.getElementById('mobile-drawer');
	var mobileDrawerClose = document.querySelector('.mobile-drawer-close');

	// 2. Search Modal elements
	var searchToggleBtn = document.querySelector('.search-toggle-btn');
	var searchModal = document.getElementById('search-modal');
	var searchModalClose = document.querySelector('.search-modal-close');
	var searchInput = searchModal ? searchModal.querySelector('input[type="search"]') : null;

	// Toggle Mobile Drawer
	function openMobileDrawer() {
		if (mobileDrawer) {
			mobileDrawer.classList.add('is-active');
			mobileDrawer.setAttribute('aria-hidden', 'false');
			if (mobileNavToggle) {
				mobileNavToggle.setAttribute('aria-expanded', 'true');
			}
			document.body.style.overflow = 'hidden';
		}
	}

	function closeMobileDrawer() {
		if (mobileDrawer) {
			mobileDrawer.classList.remove('is-active');
			mobileDrawer.setAttribute('aria-hidden', 'true');
			if (mobileNavToggle) {
				mobileNavToggle.setAttribute('aria-expanded', 'false');
			}
			document.body.style.overflow = '';
		}
	}

	if (mobileNavToggle) {
		mobileNavToggle.addEventListener('click', function (e) {
			e.preventDefault();
			openMobileDrawer();
		});
	}

	if (mobileDrawerClose) {
		mobileDrawerClose.addEventListener('click', function (e) {
			e.preventDefault();
			closeMobileDrawer();
		});
	}

	// Toggle Search Modal
	function openSearchModal() {
		if (searchModal) {
			searchModal.classList.add('is-open');
			searchModal.setAttribute('aria-hidden', 'false');
			if (searchToggleBtn) {
				searchToggleBtn.setAttribute('aria-expanded', 'true');
			}
			if (searchInput) {
				setTimeout(function () {
					searchInput.focus();
				}, 100);
			}
		}
	}

	function closeSearchModal() {
		if (searchModal) {
			searchModal.classList.remove('is-open');
			searchModal.setAttribute('aria-hidden', 'true');
			if (searchToggleBtn) {
				searchToggleBtn.setAttribute('aria-expanded', 'false');
			}
		}
	}

	if (searchToggleBtn) {
		searchToggleBtn.addEventListener('click', function (e) {
			e.preventDefault();
			openSearchModal();
		});
	}

	if (searchModalClose) {
		searchModalClose.addEventListener('click', function (e) {
			e.preventDefault();
			closeSearchModal();
		});
	}

	// Close on background click
	if (searchModal) {
		searchModal.addEventListener('click', function (e) {
			if (e.target === searchModal) {
				closeSearchModal();
			}
		});
	}

	// ESC Key to close drawers/modals
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' || e.key === 'Esc') {
			if (mobileDrawer && mobileDrawer.classList.contains('is-active')) {
				closeMobileDrawer();
			}
			if (searchModal && searchModal.classList.contains('is-open')) {
				closeSearchModal();
			}
		}
	});

	// 3. Single Product Gallery Thumbnail Switcher
	var featuredImage = document.getElementById('product-featured-image');
	var thumbButtons = document.querySelectorAll('.product-thumb-btn, .product-gallery-thumb-btn');

	if (featuredImage && thumbButtons.length > 0) {
		thumbButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				var fullSrc = btn.getAttribute('data-full-image');
				if (fullSrc) {
					featuredImage.style.opacity = '0.3';
					featuredImage.src = fullSrc;
					setTimeout(function () {
						featuredImage.style.opacity = '1';
					}, 150);
				}

				thumbButtons.forEach(function (b) {
					b.classList.remove('is-active', 'border-secondary-fixed', 'active');
				});

				btn.classList.add('is-active');
			});
		});
	}

	// 4. Quantity Stepper (+ / -) Enhancement
	function initQuantitySteppers() {
		var quantityWrappers = document.querySelectorAll('.product-purchase-box .quantity, .woocommerce-cart-form .quantity');
		quantityWrappers.forEach(function (wrap) {
			var input = wrap.querySelector('input.qty');
			if (input && !wrap.querySelector('.qty-btn')) {
				var minusBtn = document.createElement('button');
				minusBtn.type = 'button';
				minusBtn.className = 'qty-btn qty-minus';
				minusBtn.innerHTML = '&minus;';
				minusBtn.setAttribute('aria-label', 'Decrease quantity');

				var plusBtn = document.createElement('button');
				plusBtn.type = 'button';
				plusBtn.className = 'qty-btn qty-plus';
				plusBtn.innerHTML = '+';
				plusBtn.setAttribute('aria-label', 'Increase quantity');

				wrap.insertBefore(minusBtn, input);
				wrap.appendChild(plusBtn);

				minusBtn.addEventListener('click', function (e) {
					e.preventDefault();
					var val = parseInt(input.value, 10) || 1;
					var min = parseInt(input.getAttribute('min'), 10) || 1;
					if (val > min) {
						input.value = val - 1;
						input.dispatchEvent(new Event('change', { bubbles: true }));
						var updateBtn = document.querySelector('button[name="update_cart"]');
						if (updateBtn) {
							updateBtn.disabled = false;
							updateBtn.setAttribute('aria-disabled', 'false');
						}
					}
				});

				plusBtn.addEventListener('click', function (e) {
					e.preventDefault();
					var val = parseInt(input.value, 10) || 1;
					var max = parseInt(input.getAttribute('max'), 10) || 9999;
					if (val < max) {
						input.value = val + 1;
						input.dispatchEvent(new Event('change', { bubbles: true }));
						var updateBtn = document.querySelector('button[name="update_cart"]');
						if (updateBtn) {
							updateBtn.disabled = false;
							updateBtn.setAttribute('aria-disabled', 'false');
						}
					}
				});
			}
		});
	}

	initQuantitySteppers();

	if (typeof jQuery !== 'undefined') {
		jQuery(document.body).on('updated_cart_totals', function () {
			initQuantitySteppers();
		});
	}

	// 5. WooCommerce Variation Change Listener for Dynamic Image Update
	if (typeof jQuery !== 'undefined') {
		jQuery(document).on('found_variation', 'form.variations_form', function (event, variation) {
			if (variation && variation.image && variation.image.src && featuredImage) {
				featuredImage.src = variation.image.src;
			}
		});
	}
});

