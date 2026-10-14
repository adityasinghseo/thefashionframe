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

	// Close drawer when any navigation link is clicked
	var drawerLinks = mobileDrawer ? mobileDrawer.querySelectorAll('a') : [];
	drawerLinks.forEach(function (link) {
		link.addEventListener('click', function () {
			closeMobileDrawer();
		});
	});

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
				featuredImage.setAttribute('data-full-image', variation.image.full_src || variation.image.src);
			}
		});
	}

	// 6. Mobile Sticky Buy Bar & Quick Checkout Transformation
	var stickyBuyBar = document.getElementById('mobile-sticky-purchase-bar') || document.getElementById('mobile-sticky-buy-bar');
	var mobileAddBtn = document.getElementById('mobile-bar-add-to-cart') || document.getElementById('mobile-sticky-add-to-bag');
	var mobileBuyBtn = document.getElementById('mobile-bar-buy-now');
	var buyNowBtns = document.querySelectorAll('.product-buy-now-btn');

	function handleAjaxAddToCart(form, isBuyNow, triggerBtn) {
		if (!form) {
			form = document.querySelector('.product-purchase-box form.cart') || document.querySelector('form.cart');
		}
		if (!form) return;

		var submitBtn = form.querySelector('.single_add_to_cart_button');
		var origBtnText = triggerBtn ? triggerBtn.innerHTML : '';

		if (triggerBtn) {
			triggerBtn.disabled = true;
			triggerBtn.style.opacity = '0.7';
			var labelSpan = triggerBtn.querySelector('span:not(.material-symbols-outlined)');
			if (labelSpan) {
				labelSpan.textContent = isBuyNow ? 'REDIRECTING...' : 'ADDING...';
			}
		}

		var formData = new FormData(form);
		formData.append('action', 'the_fashion_frame_single_add_to_cart');
		if (window.theFashionFrameParams && window.theFashionFrameParams.nonce) {
			formData.append('security', window.theFashionFrameParams.nonce);
		}

		// Ensure product_id is present
		if (!formData.has('product_id')) {
			var pidInput = form.querySelector('input[name="product_id"]') || form.querySelector('button[name="add-to-cart"]');
			if (pidInput && pidInput.value) {
				formData.append('product_id', pidInput.value);
			}
		}

		var ajaxEndpoint = (window.theFashionFrameParams && window.theFashionFrameParams.ajaxUrl) ? window.theFashionFrameParams.ajaxUrl : '/wp-admin/admin-ajax.php';

		fetch(ajaxEndpoint, {
			method: 'POST',
			body: formData
		})
		.then(function(res) { return res.json(); })
		.then(function(data) {
			if (data && data.error) {
				if (data.product_url) {
					window.location.href = data.product_url;
				} else {
					if (typeof window.tffTriggerSizeValidationError === 'function') {
						window.tffTriggerSizeValidationError();
					} else {
						alert('Please select your preferred size before continuing.');
					}
				}
				if (triggerBtn) {
					triggerBtn.disabled = false;
					triggerBtn.style.opacity = '1';
					triggerBtn.innerHTML = origBtnText;
				}
				return;
			}

			// Update header cart count badge and fragments
			if (data && data.fragments) {
				for (var selector in data.fragments) {
					var el = document.querySelector(selector);
					if (el) {
						el.outerHTML = data.fragments[selector];
					}
				}
			}

			if (typeof jQuery !== 'undefined') {
				jQuery(document.body).trigger('added_to_cart', [data ? data.fragments : null, data ? data.cart_hash : null]);
				jQuery(document.body).trigger('wc_fragments_refreshed');
			}

			if (isBuyNow) {
				var checkoutUrl = (window.theFashionFrameParams && window.theFashionFrameParams.checkoutUrl) ? window.theFashionFrameParams.checkoutUrl : '/checkout/';
				window.location.href = checkoutUrl;
				return;
			}

			// Feedback for ADD TO BAG
			if (triggerBtn) {
				var labelSpan = triggerBtn.querySelector('span:not(.material-symbols-outlined)');
				if (labelSpan) {
					labelSpan.textContent = 'ADDED TO BAG!';
				}
				setTimeout(function() {
					triggerBtn.disabled = false;
					triggerBtn.style.opacity = '1';
					triggerBtn.innerHTML = origBtnText;
				}, 2000);
			}
		})
		.catch(function(err) {
			// Fallback: standard submission
			if (submitBtn) {
				submitBtn.click();
			} else {
				form.submit();
			}
		})
		.finally(function() {
			if (triggerBtn && !isBuyNow) {
				setTimeout(function() {
					triggerBtn.disabled = false;
					triggerBtn.style.opacity = '1';
				}, 2000);
			}
		});
	}

	if (mobileAddBtn) {
		mobileAddBtn.addEventListener('click', function(e) {
			e.preventDefault();
			var productForm = document.querySelector('.product-purchase-box form.cart') || document.querySelector('form.cart');
			handleAjaxAddToCart(productForm, false, mobileAddBtn);
		});
	}

	if (mobileBuyBtn) {
		mobileBuyBtn.addEventListener('click', function(e) {
			e.preventDefault();
			var productForm = document.querySelector('.product-purchase-box form.cart') || document.querySelector('form.cart');
			handleAjaxAddToCart(productForm, true, mobileBuyBtn);
		});
	}

	if (buyNowBtns.length > 0) {
		buyNowBtns.forEach(function(btn) {
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				var productForm = document.querySelector('.product-purchase-box form.cart') || document.querySelector('form.cart');
				handleAjaxAddToCart(productForm, true, btn);
			});
		});
	}

	// 7. Fullscreen Interactive Touch Zoom Lightbox Modal
	var zoomModal = document.getElementById('product-zoom-modal');
	var zoomBackdrop = document.getElementById('product-zoom-backdrop');
	var zoomAspect = document.getElementById('product-main-aspect');
	var zoomImg = document.getElementById('product-zoom-img');
	var zoomCanvas = document.getElementById('product-zoom-canvas');
	var zoomViewport = document.getElementById('product-zoom-viewport');
	var zoomLevelBadge = document.getElementById('zoom-level-badge');
	var zoomCurrentEl = document.getElementById('product-zoom-current');
	var zoomTotalEl = document.getElementById('product-zoom-total');
	var zoomBtnIn = document.getElementById('zoom-btn-in');
	var zoomBtnOut = document.getElementById('zoom-btn-out');
	var zoomBtnReset = document.getElementById('zoom-btn-reset');
	var zoomBtnClose = document.getElementById('zoom-btn-close');
	var zoomNavPrev = document.getElementById('zoom-nav-prev');
	var zoomNavNext = document.getElementById('zoom-nav-next');
	var modalThumbBtns = document.querySelectorAll('.zoom-thumb-btn');

	// Collect all gallery full images
	var galleryImages = [];
	var galleryItems = document.querySelectorAll('.gallery-grid-item, .mobile-slide-item, .product-thumb-btn');
	if (galleryItems.length > 0) {
		galleryItems.forEach(function(item) {
			var full = item.getAttribute('data-full-image');
			if (full && galleryImages.indexOf(full) === -1) {
				galleryImages.push(full);
			}
		});
	}
	if (featuredImage && galleryImages.length === 0) {
		var src = featuredImage.getAttribute('data-full-image') || featuredImage.src;
		if (src) galleryImages.push(src);
	}

	var currentImageIndex = 0;
	var scale = 1.0;
	var minScale = 1.0;
	var maxScale = 4.0;
	var panX = 0;
	var panY = 0;
	var isDragging = false;
	var startX = 0;
	var startY = 0;
	var initialDistance = 0;
	var initialScale = 1.0;
	var lastTapTime = 0;

	function updateTransform(withTransition) {
		if (!zoomCanvas) return;
		if (withTransition) {
			zoomCanvas.classList.remove('is-grabbing');
		}
		zoomCanvas.style.transform = 'translate(' + panX + 'px, ' + panY + 'px) scale(' + scale + ')';
		if (zoomLevelBadge) {
			zoomLevelBadge.textContent = Math.round(scale * 100) + '%';
		}
		if (zoomCanvas) {
			zoomCanvas.style.cursor = scale > 1.0 ? 'grab' : 'zoom-in';
		}
	}

	function clampPan() {
		if (!zoomViewport || scale <= 1.0) {
			panX = 0;
			panY = 0;
			return;
		}
		var rect = zoomViewport.getBoundingClientRect();
		var maxPanX = Math.max(0, (rect.width * (scale - 1)) / 2 + 50);
		var maxPanY = Math.max(0, (rect.height * (scale - 1)) / 2 + 50);

		if (panX > maxPanX) panX = maxPanX;
		if (panX < -maxPanX) panX = -maxPanX;
		if (panY > maxPanY) panY = maxPanY;
		if (panY < -maxPanY) panY = -maxPanY;
	}

	function setScale(newScale, withTransition) {
		scale = Math.min(maxScale, Math.max(minScale, Math.round(newScale * 100) / 100));
		if (scale <= 1.0) {
			panX = 0;
			panY = 0;
		} else {
			clampPan();
		}
		updateTransform(withTransition);
	}

	function setActiveImage(index) {
		if (galleryImages.length === 0) return;
		if (index < 0) index = galleryImages.length - 1;
		if (index >= galleryImages.length) index = 0;
		currentImageIndex = index;

		if (zoomImg) {
			zoomImg.style.opacity = '0.3';
			zoomImg.src = galleryImages[currentImageIndex];
			setTimeout(function() {
				zoomImg.style.opacity = '1';
			}, 150);
		}

		if (zoomCurrentEl) {
			zoomCurrentEl.textContent = (currentImageIndex + 1).toString();
		}

		// Update thumbnails highlight inside modal
		if (modalThumbBtns.length > 0) {
			modalThumbBtns.forEach(function(b, i) {
				if (i === currentImageIndex) {
					b.classList.add('is-active');
					b.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
				} else {
					b.classList.remove('is-active');
				}
			});
		}

		setScale(1.0, true);
	}

	function openZoomModal(targetIndex) {
		if (!zoomModal) return;

		var matchIndex = 0;
		if (typeof targetIndex === 'number' && targetIndex >= 0 && targetIndex < galleryImages.length) {
			matchIndex = targetIndex;
		} else {
			var currentFeaturedSrc = featuredImage ? (featuredImage.getAttribute('data-full-image') || featuredImage.src) : '';
			matchIndex = galleryImages.indexOf(currentFeaturedSrc);
			if (matchIndex === -1) matchIndex = 0;
		}

		setActiveImage(matchIndex);
		zoomModal.classList.add('is-open');
		zoomModal.setAttribute('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';
	}

	function closeZoomModal() {
		if (!zoomModal) return;
		zoomModal.classList.remove('is-open');
		zoomModal.setAttribute('aria-hidden', 'true');
		document.body.style.overflow = '';
		setScale(1.0, false);
	}

	// Desktop Gallery Grid Item Click to Zoom
	var desktopGalleryItems = document.querySelectorAll('.gallery-grid-item');
	desktopGalleryItems.forEach(function(item, idx) {
		item.addEventListener('click', function(e) {
			openZoomModal(idx);
		});
	});

	// Mobile Slider Tap Zoom Trigger
	var mobileZoomTrigger = document.getElementById('mobile-slider-zoom-trigger');
	if (mobileZoomTrigger) {
		mobileZoomTrigger.addEventListener('click', function(e) {
			e.preventDefault();
			var currentSlide = parseInt(document.getElementById('mobile-slide-current') ? document.getElementById('mobile-slide-current').textContent : '1', 10) - 1;
			openZoomModal(currentSlide >= 0 ? currentSlide : 0);
		});
	}

	// Mobile Horizontal Slider Scroll Counter Listener
	var mobileSlider = document.getElementById('product-mobile-slider');
	var mobileCurrentEl = document.getElementById('mobile-slide-current');
	if (mobileSlider && mobileCurrentEl) {
		mobileSlider.addEventListener('scroll', function() {
			var scrollLeft = mobileSlider.scrollLeft;
			var width = mobileSlider.offsetWidth;
			if (width > 0) {
				var activeIndex = Math.min(
					galleryImages.length || 99,
					Math.max(1, Math.round(scrollLeft / width) + 1)
				);
				mobileCurrentEl.textContent = activeIndex;
			}
		}, { passive: true });
	}

	if (zoomAspect) {
		zoomAspect.addEventListener('click', function(e) {
			openZoomModal();
		});
	}

	if (zoomBtnClose) {
		zoomBtnClose.addEventListener('click', function(e) {
			e.preventDefault();
			closeZoomModal();
		});
	}

	if (zoomBackdrop) {
		zoomBackdrop.addEventListener('click', function(e) {
			if (scale <= 1.0) {
				closeZoomModal();
			}
		});
	}

	if (zoomBtnIn) {
		zoomBtnIn.addEventListener('click', function(e) {
			e.preventDefault();
			setScale(scale + 0.5, true);
		});
	}

	if (zoomBtnOut) {
		zoomBtnOut.addEventListener('click', function(e) {
			e.preventDefault();
			setScale(scale - 0.5, true);
		});
	}

	if (zoomBtnReset) {
		zoomBtnReset.addEventListener('click', function(e) {
			e.preventDefault();
			setScale(1.0, true);
		});
	}

	if (zoomNavPrev) {
		zoomNavPrev.addEventListener('click', function(e) {
			e.preventDefault();
			setActiveImage(currentImageIndex - 1);
		});
	}

	if (zoomNavNext) {
		zoomNavNext.addEventListener('click', function(e) {
			e.preventDefault();
			setActiveImage(currentImageIndex + 1);
		});
	}

	if (modalThumbBtns.length > 0) {
		modalThumbBtns.forEach(function(b, i) {
			b.addEventListener('click', function(e) {
				e.preventDefault();
				setActiveImage(i);
			});
		});
	}

	// Keyboard shortcuts inside zoom modal
	document.addEventListener('keydown', function(e) {
		if (!zoomModal || !zoomModal.classList.contains('is-open')) return;
		if (e.key === 'Escape' || e.key === 'Esc') {
			closeZoomModal();
		} else if (e.key === '+' || e.key === '=') {
			setScale(scale + 0.5, true);
		} else if (e.key === '-' || e.key === '_') {
			setScale(scale - 0.5, true);
		} else if (e.key === '0') {
			setScale(1.0, true);
		} else if (e.key === 'ArrowLeft') {
			setActiveImage(currentImageIndex - 1);
		} else if (e.key === 'ArrowRight') {
			setActiveImage(currentImageIndex + 1);
		}
	});

	// Mouse Drag & Pan when Zoomed
	if (zoomViewport) {
		zoomViewport.addEventListener('mousedown', function(e) {
			if (scale <= 1.0) return;
			isDragging = true;
			startX = e.clientX - panX;
			startY = e.clientY - panY;
			if (zoomCanvas) zoomCanvas.classList.add('is-grabbing');
		});

		window.addEventListener('mousemove', function(e) {
			if (!isDragging || scale <= 1.0) return;
			panX = e.clientX - startX;
			panY = e.clientY - startY;
			clampPan();
			updateTransform(false);
		});

		window.addEventListener('mouseup', function() {
			if (isDragging) {
				isDragging = false;
				if (zoomCanvas) zoomCanvas.classList.remove('is-grabbing');
			}
		});

		// Mouse Wheel Zoom
		zoomViewport.addEventListener('wheel', function(e) {
			if (!zoomModal || !zoomModal.classList.contains('is-open')) return;
			e.preventDefault();
			var delta = e.deltaY < 0 ? 0.25 : -0.25;
			setScale(scale + delta, false);
		}, { passive: false });
	}

	// Touch Events: Drag Pan, Pinch-to-Zoom, and Double-Tap Zoom
	if (zoomViewport) {
		zoomViewport.addEventListener('touchstart', function(e) {
			if (e.touches.length === 1) {
				// Check for double tap
				var now = Date.now();
				if (now - lastTapTime < 300) {
					// Double tapped!
					e.preventDefault();
					if (scale > 1.0) {
						setScale(1.0, true);
					} else {
						setScale(2.5, true);
					}
					lastTapTime = 0;
					return;
				}
				lastTapTime = now;

				// Single touch drag setup
				isDragging = true;
				startX = e.touches[0].clientX - panX;
				startY = e.touches[0].clientY - panY;
				if (zoomCanvas) zoomCanvas.classList.add('is-grabbing');
			} else if (e.touches.length === 2) {
				// Pinch start
				isDragging = false;
				var dx = e.touches[0].clientX - e.touches[1].clientX;
				var dy = e.touches[0].clientY - e.touches[1].clientY;
				initialDistance = Math.hypot(dx, dy);
				initialScale = scale;
			}
		}, { passive: false });

		zoomViewport.addEventListener('touchmove', function(e) {
			if (e.touches.length === 1 && isDragging && scale > 1.0) {
				e.preventDefault();
				panX = e.touches[0].clientX - startX;
				panY = e.touches[0].clientY - startY;
				clampPan();
				updateTransform(false);
			} else if (e.touches.length === 2 && initialDistance > 0) {
				e.preventDefault();
				var dx = e.touches[0].clientX - e.touches[1].clientX;
				var dy = e.touches[0].clientY - e.touches[1].clientY;
				var dist = Math.hypot(dx, dy);
				var newScale = initialScale * (dist / initialDistance);
				setScale(newScale, false);
			}
		}, { passive: false });

		zoomViewport.addEventListener('touchend', function(e) {
			if (e.touches.length === 0) {
				isDragging = false;
				if (zoomCanvas) zoomCanvas.classList.remove('is-grabbing');
				clampPan();
				updateTransform(true);
			} else if (e.touches.length === 1) {
				// Switched back to 1 finger after pinch
				isDragging = true;
				startX = e.touches[0].clientX - panX;
				startY = e.touches[0].clientY - panY;
			}
		});
	}

	// 8. Mobile Category Horizontal Slider Scroll Indicator
	var categoryGrid = document.querySelector('.category-grid');
	var categoryDots = document.querySelectorAll('.category-dot');
	var categoryCards = document.querySelectorAll('.category-card');

	if (categoryGrid && categoryDots.length > 0 && categoryCards.length > 0) {
		categoryGrid.addEventListener('scroll', function() {
			var scrollLeft = categoryGrid.scrollLeft;
			var cardWidth = categoryCards[0].offsetWidth + 14; // card width + gap
			var activeIdx = Math.min(categoryDots.length - 1, Math.max(0, Math.round(scrollLeft / cardWidth)));
			
			categoryDots.forEach(function(dot, i) {
				if (i === activeIdx) {
					dot.classList.add('is-active');
				} else {
					dot.classList.remove('is-active');
				}
			});
		}, { passive: true });

		categoryDots.forEach(function(dot, i) {
			dot.addEventListener('click', function() {
				if (categoryCards[i]) {
					categoryCards[i].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
				}
			});
		});
	}

	// 9. Desktop Product Info Tabs Switcher
	var tabButtons = document.querySelectorAll('.product-tab-btn');
	var tabPanes = document.querySelectorAll('.product-tab-pane');

	if (tabButtons.length > 0 && tabPanes.length > 0) {
		tabButtons.forEach(function(btn) {
			btn.addEventListener('click', function() {
				var targetPaneId = btn.getAttribute('aria-controls');
				if (!targetPaneId) return;

				// Deactivate all buttons
				tabButtons.forEach(function(b) {
					b.classList.remove('is-active');
					b.setAttribute('aria-selected', 'false');
				});

				// Deactivate all panes
				tabPanes.forEach(function(pane) {
					pane.classList.remove('is-active');
				});

				// Activate clicked button and target pane
				btn.classList.add('is-active');
				btn.setAttribute('aria-selected', 'true');

				var targetPane = document.getElementById(targetPaneId);
				if (targetPane) {
					targetPane.classList.add('is-active');
				}
			});
		});
	}

	// 10. Size & Fit Guide Interactive Tabs
	var sizeTriggers = document.querySelectorAll('.size-tab-trigger');
	if (sizeTriggers.length > 0) {
		sizeTriggers.forEach(function (trigger) {
			trigger.addEventListener('click', function (e) {
				e.preventDefault();
				var targetId = trigger.getAttribute('data-target');
				if (!targetId) return;

				// Toggle active state on tab buttons
				sizeTriggers.forEach(function (btn) {
					btn.classList.remove('is-active');
				});
				trigger.classList.add('is-active');

				// Toggle active state on tab content panes
				var allPanes = document.querySelectorAll('.size-guide-tab-pane');
				allPanes.forEach(function (pane) {
					pane.classList.remove('is-active');
				});

				var targetPane = document.getElementById(targetId);
				if (targetPane) {
					targetPane.classList.add('is-active');
				}
			});
		});
	}

	// 11. Size Guide Modal Controls
	var sizeGuideModal = document.getElementById('tff-size-guide-modal');
	var sizeGuideBackdrop = document.getElementById('tff-size-guide-backdrop');
	var sizeGuideClose = document.getElementById('tff-size-guide-close');
	var sizeGuideTriggers = document.querySelectorAll('#tff-size-guide-trigger, .tff-size-guide-trigger');

	function openSizeGuideModal() {
		if (sizeGuideModal) {
			sizeGuideModal.classList.add('is-open');
			sizeGuideModal.setAttribute('aria-hidden', 'false');
			document.body.style.overflow = 'hidden';
		}
	}

	function closeSizeGuideModal() {
		if (sizeGuideModal) {
			sizeGuideModal.classList.remove('is-open');
			sizeGuideModal.setAttribute('aria-hidden', 'true');
			document.body.style.overflow = '';
		}
	}

	sizeGuideTriggers.forEach(function(trigger) {
		trigger.addEventListener('click', function(e) {
			e.preventDefault();
			openSizeGuideModal();
		});
	});

	if (sizeGuideClose) {
		sizeGuideClose.addEventListener('click', function(e) {
			e.preventDefault();
			closeSizeGuideModal();
		});
	}

	if (sizeGuideBackdrop) {
		sizeGuideBackdrop.addEventListener('click', function(e) {
			closeSizeGuideModal();
		});
	}

	// 12. Wishlist Toggle Button with localStorage
	var wishlistBtn = document.getElementById('product-wishlist-toggle');
	if (wishlistBtn) {
		var productId = wishlistBtn.getAttribute('data-product-id');
		var savedWishlist = [];
		try {
			savedWishlist = JSON.parse(localStorage.getItem('tff_wishlist') || '[]');
		} catch(e) {
			savedWishlist = [];
		}

		if (productId && savedWishlist.indexOf(productId) !== -1) {
			wishlistBtn.classList.add('is-active');
			var icon = wishlistBtn.querySelector('.wishlist-icon');
			if (icon) {
				icon.style.fontVariationSettings = "'FILL' 1";
			}
			var txt = wishlistBtn.querySelector('.wishlist-text');
			if (txt) txt.textContent = 'WISHLISTED';
		}

		wishlistBtn.addEventListener('click', function(e) {
			e.preventDefault();
			if (!productId) return;
			var idx = savedWishlist.indexOf(productId);
			var icon = wishlistBtn.querySelector('.wishlist-icon');
			var txt = wishlistBtn.querySelector('.wishlist-text');

			if (idx === -1) {
				savedWishlist.push(productId);
				wishlistBtn.classList.add('is-active');
				if (icon) {
					icon.style.fontVariationSettings = "'FILL' 1";
				}
				if (txt) txt.textContent = 'WISHLISTED';
			} else {
				savedWishlist.splice(idx, 1);
				wishlistBtn.classList.remove('is-active');
				if (icon) {
					icon.style.fontVariationSettings = "'FILL' 0";
				}
				if (txt) txt.textContent = 'WISHLIST';
			}
			localStorage.setItem('tff_wishlist', JSON.stringify(savedWishlist));
		});
	}

	// 13. Pincode Delivery Checker
	var pincodeInput = document.getElementById('pincode-input');
	var pincodeBtn = document.getElementById('pincode-check-btn');
	var pincodeResult = document.getElementById('pincode-result');

	function checkPincode() {
		if (!pincodeInput || !pincodeResult) return;
		var val = pincodeInput.value.trim();
		if (!/^[1-9][0-9]{5}$/.test(val)) {
			pincodeResult.style.display = 'flex';
			pincodeResult.className = 'pincode-result-msg error';
			pincodeResult.innerHTML = '<span class="material-symbols-outlined text-[16px]">error</span><span>Please enter a valid 6-digit Indian PIN code.</span>';
			return;
		}

		pincodeBtn.disabled = true;
		pincodeBtn.textContent = '...';

		setTimeout(function() {
			pincodeBtn.disabled = false;
			pincodeBtn.textContent = 'CHECK';
			pincodeResult.style.display = 'flex';
			pincodeResult.className = 'pincode-result-msg success';

			// Calculate delivery date 3-4 days out
			var deliveryDate = new Date();
			deliveryDate.setDate(deliveryDate.getDate() + 4);
			var dateOptions = { weekday: 'short', month: 'short', day: 'numeric' };
			var dateStr = deliveryDate.toLocaleDateString('en-IN', dateOptions);

			pincodeResult.innerHTML = '<span class="material-symbols-outlined text-[16px] text-[#002B1B]">verified</span><span>Expected delivery by <strong>' + dateStr + '</strong>. Free Express Shipping & COD available!</span>';
			try {
				localStorage.setItem('tff_pincode', val);
			} catch(e) {}
		}, 300);
	}

	if (pincodeBtn) {
		pincodeBtn.addEventListener('click', function(e) {
			e.preventDefault();
			checkPincode();
		});
	}

	if (pincodeInput) {
		pincodeInput.addEventListener('keydown', function(e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				checkPincode();
			}
		});

		try {
			var savedPin = localStorage.getItem('tff_pincode');
			if (savedPin) {
				pincodeInput.value = savedPin;
				checkPincode();
			}
		} catch(e) {}
	}

	// ESC Key listener extension for Size Guide Modal
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' || e.key === 'Esc') {
			if (sizeGuideModal && sizeGuideModal.classList.contains('is-open')) {
				closeSizeGuideModal();
			}
		}
	});
});

