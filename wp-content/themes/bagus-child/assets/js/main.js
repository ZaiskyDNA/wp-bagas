/**
 * BAGUS — micro-interactions
 * - IntersectionObserver for fade-up
 * - Trust-bar number counter
 * - Mini-cart badge refresh (handled by WC fragments, but we ensure visibility)
 *
 * @package bagus-child
 */
(function () {
	'use strict';

	/* === Fade-up on scroll ================================================ */
	function initFadeUp() {
		var els = document.querySelectorAll('.fade-up, .fade-up-stagger');
		if (!els.length || !('IntersectionObserver' in window)) {
			// No IO → make everything visible immediately.
			els.forEach(function (el) { el.classList.add('is-visible'); });
			return;
		}
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					io.unobserve(entry.target);
				}
			});
		}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

		els.forEach(function (el) { io.observe(el); });
	}

	/* === Trust-bar counter animation ======================================= */
	function initCounters() {
		var counters = document.querySelectorAll('[data-count-to]');
		if (!counters.length) return;

		function animateCounter(el) {
			var target = parseInt(el.getAttribute('data-count-to'), 10);
			var suffix = el.getAttribute('data-count-suffix') || '';
			if (isNaN(target)) return;
			var duration = 1600;
			var start = 0;
			var startTime = null;

			function step(ts) {
				if (!startTime) startTime = ts;
				var progress = Math.min((ts - startTime) / duration, 1);
				// Ease-out cubic
				var eased = 1 - Math.pow(1 - progress, 3);
				var current = Math.round(start + (target - start) * eased);
				el.textContent = current.toLocaleString('id-ID') + suffix;
				if (progress < 1) requestAnimationFrame(step);
			}
			requestAnimationFrame(step);
		}

		if (!('IntersectionObserver' in window)) {
			counters.forEach(animateCounter);
			return;
		}
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					animateCounter(entry.target);
					io.unobserve(entry.target);
				}
			});
		}, { threshold: 0.5 });

		counters.forEach(function (el) {
			el.textContent = '0' + (el.getAttribute('data-count-suffix') || '');
			io.observe(el);
		});
	}

	/* === Init on DOMContentLoaded ========================================= */
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

	function init() {
		// Respect reduced-motion
		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			document.querySelectorAll('.fade-up, .fade-up-stagger').forEach(function (el) {
				el.classList.add('is-visible');
			});
			return;
		}
		initFadeUp();
		initCounters();
	}
})();
