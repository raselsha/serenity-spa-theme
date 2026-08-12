/* Serenity theme — mobile nav, sticky header shadow, scroll-reveal.
   Plain vanilla JS (no build step) — the wc-service-booking plugin's own
   frontend scripts (booking modal, service cards) still use jQuery
   independently and are untouched by this file. */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        initMobileNav();
        initHeaderScrollState();
        initScrollReveal();
    });

    function initMobileNav() {
        var toggle = document.getElementById('serenity-nav-toggle');
        var nav = document.getElementById('serenity-nav');
        if (!toggle || !nav) return;

        toggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });

        // Close the menu after tapping a link — otherwise it stays open
        // underneath the page that just navigated to (visible on back/forward).
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                nav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });
    }

    function initHeaderScrollState() {
        var header = document.getElementById('serenity-header');
        if (!header) return;

        function update() {
            if (window.scrollY > 12) {
                header.classList.add('is-scrolled');
            } else {
                header.classList.remove('is-scrolled');
            }
        }
        update();
        window.addEventListener('scroll', update, { passive: true });
    }

    function initScrollReveal() {
        var selectors = '.serenity-feature-card, .serenity-step-card, .serenity-testimonial-card, .serenity-location-card, .serenity-branch-card, .serenity-post-card';
        var els = document.querySelectorAll(selectors);
        if (!els.length) return;

        if (!('IntersectionObserver' in window)) {
            els.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }

        els.forEach(function (el, i) {
            el.classList.add('serenity-reveal');
            el.style.transitionDelay = (Math.min(i % 4, 3) * 0.08) + 's';
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

        els.forEach(function (el) { observer.observe(el); });
    }
})();
