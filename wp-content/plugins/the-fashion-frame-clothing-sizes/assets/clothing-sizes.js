/**
 * The Fashion Frame - Clothing Size Selector Interactivity
 */

(function ($) {
	'use strict';

	$(document).ready(function () {
		initSizeSwatches();
	});

	function initSizeSwatches() {
		var $form = $('form.variations_form');
		if (!$form.length) {
			return;
		}

		var $component = $('.tff-size-selector-component');
		if (!$component.length) {
			return;
		}

		var $select = $component.find('select');
		var $buttons = $component.find('.tff-size-btn');
		var $display = $component.find('.tff-size-chosen-display');
		var $validationMsg = $component.find('.tff-size-validation-msg');
		var $btnGroup = $component.find('.tff-size-buttons-group');

		// Helper to update display label
		function updateChosenDisplay(label) {
			if (label) {
				$display.text(': ' + label);
			} else {
				$display.text('');
			}
		}

		// Initial state sync
		var currentVal = $select.val();
		if (currentVal) {
			var $activeBtn = $buttons.filter('[data-value="' + currentVal + '"]');
			if ($activeBtn.length) {
				$activeBtn.addClass('is-selected').attr('aria-checked', 'true');
				updateChosenDisplay($activeBtn.text().trim());
			}
		}

		// Click on size swatch button
		$buttons.on('click', function (e) {
			e.preventDefault();
			var $btn = $(this);

			if ($btn.is(':disabled') || $btn.hasClass('is-disabled')) {
				return;
			}

			var val = $btn.data('value');

			// If already selected, do not unselect (size is mandatory)
			if ($btn.hasClass('is-selected')) {
				return;
			}

			// Update buttons UI
			$buttons.removeClass('is-selected').attr('aria-checked', 'false');
			$btn.addClass('is-selected').attr('aria-checked', 'true');
			updateChosenDisplay($btn.text().trim());

			// Hide any validation errors
			$validationMsg.hide();
			$btnGroup.removeClass('has-error');

			// Update native select and trigger WooCommerce variation checking
			$select.val(val).trigger('change');
		});

		// Keyboard accessibility for radio group
		$buttons.on('keydown', function (e) {
			var key = e.key || e.keyCode;
			var $enabled = $buttons.not(':disabled').not('.is-disabled');
			var idx = $enabled.index(this);

			if (key === 'ArrowRight' || key === 'ArrowDown' || key === 39 || key === 40) {
				e.preventDefault();
				var nextIdx = (idx + 1) % $enabled.length;
				$enabled.eq(nextIdx).focus().trigger('click');
			} else if (key === 'ArrowLeft' || key === 'ArrowUp' || key === 37 || key === 38) {
				e.preventDefault();
				var prevIdx = (idx - 1 + $enabled.length) % $enabled.length;
				$enabled.eq(prevIdx).focus().trigger('click');
			} else if (key === 'Enter' || key === ' ' || key === 13 || key === 32) {
				e.preventDefault();
				$(this).trigger('click');
			}
		});

		// Listen to WooCommerce variation events to update disabled states
		$form.on('woocommerce_variation_has_changed update_variation_values', function () {
			$buttons.each(function () {
				var $btn = $(this);
				var val = $btn.data('value');
				var $opt = $select.find('option[value="' + val + '"]');

				if ($opt.length && $opt.prop('disabled')) {
					$btn.prop('disabled', true).addClass('is-disabled');
				} else {
					$btn.prop('disabled', false).removeClass('is-disabled');
				}
			});
		});

		// When variation is reset/cleared
		$form.on('reset_data', function () {
			var val = $select.val();
			if (!val) {
				$buttons.removeClass('is-selected').attr('aria-checked', 'false');
				updateChosenDisplay('');
			}
		});

		// Validation helper
		function isSizeSelected() {
			var val = $select.val();
			var varId = parseInt($form.find('input[name="variation_id"]').val(), 10) || 0;
			return !!(val && val.length > 0 && varId > 0);
		}

		function triggerValidationError() {
			$validationMsg.show();
			$btnGroup.addClass('has-error');

			// Scroll into view if not visible
			var compEl = $component[0];
			if (compEl && typeof compEl.scrollIntoView === 'function') {
				compEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
			}

			// Focus the first available size button
			var $firstAvail = $buttons.not(':disabled').not('.is-disabled').first();
			if ($firstAvail.length) {
				$firstAvail.focus();
			}
		}

		// Intercept Add to Cart, Buy Now, and Mobile Sticky button using capturing event listener
		// to run before any other submit or AJAX handler
		var formEl = $form[0];

		// 1. Single Add to Cart Button
		var addToCartBtn = formEl ? formEl.querySelector('.single_add_to_cart_button') : null;
		if (addToCartBtn) {
			addToCartBtn.addEventListener(
				'click',
				function (e) {
					var val = $select.val();
					if (!val) {
						e.preventDefault();
						e.stopImmediatePropagation();
						triggerValidationError();
						return false;
					}
				},
				true // Capture phase
			);
		}

		// 2. Buy Now Button(s)
		var buyNowBtns = document.querySelectorAll('.product-buy-now-btn');
		buyNowBtns.forEach(function (btn) {
			btn.addEventListener(
				'click',
				function (e) {
					var val = $select.val();
					if (!val) {
						e.preventDefault();
						e.stopImmediatePropagation();

						// Reset button state if changed
						btn.disabled = false;
						btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">bolt</span><span>BUY NOW</span>';

						triggerValidationError();
						return false;
					}
				},
				true // Capture phase
			);
		});

		// 3. Mobile Sticky Buttons Validation Interceptors
		var mobileAddBtns = [
			document.getElementById('mobile-sticky-add-to-bag'),
			document.getElementById('mobile-bar-add-to-cart')
		];

		mobileAddBtns.forEach(function (btn) {
			if (btn) {
				btn.addEventListener(
					'click',
					function (e) {
						var val = $select.val();
						if (!val) {
							e.preventDefault();
							e.stopImmediatePropagation();

							btn.disabled = false;
							btn.style.opacity = '1';
							var btnText = btn.querySelector('span:not(.material-symbols-outlined)');
							if (btnText) {
								btnText.textContent = 'ADD TO BAG';
							}

							triggerValidationError();
							return false;
						}
					},
					true // Capture phase
				);
			}
		});

		var mobileBuyBtns = [
			document.getElementById('mobile-bar-buy-now')
		];

		mobileBuyBtns.forEach(function (btn) {
			if (btn) {
				btn.addEventListener(
					'click',
					function (e) {
						var val = $select.val();
						if (!val) {
							e.preventDefault();
							e.stopImmediatePropagation();

							btn.disabled = false;
							btn.style.opacity = '1';
							var btnText = btn.querySelector('span:not(.material-symbols-outlined)');
							if (btnText) {
								btnText.textContent = 'BUY NOW';
							}

							triggerValidationError();
							return false;
						}
					},
					true // Capture phase
				);
			}
		});

		window.tffTriggerSizeValidationError = triggerValidationError;

		// Form submit event fallback
		$form.on('submit', function (e) {
			var val = $select.val();
			if (!val) {
				e.preventDefault();
				e.stopImmediatePropagation();
				triggerValidationError();
				return false;
			}
		});
	}
})(jQuery);
