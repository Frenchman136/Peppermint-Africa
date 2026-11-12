/*
 * Peppermint Africa front-end behaviour.
 *
 * Alpine.js ships inside Livewire, so we do NOT import it here. We only
 * register our own directives when Alpine boots.
 */

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ------------------------------------------------------------------ */
/* Preloader: shown once per session, never blocks longer than needed  */
/* ------------------------------------------------------------------ */
const MIN_PRELOADER_MS = 900;
const MAX_PRELOADER_MS = 4000;
const startedAt = performance.now();
let preloaderHidden = false;

function hidePreloader() {
    if (preloaderHidden) return;
    preloaderHidden = true;

    const el = document.getElementById('preloader');
    if (!el) return;

    const wait = prefersReducedMotion ? 0 : Math.max(0, MIN_PRELOADER_MS - (performance.now() - startedAt));

    setTimeout(() => {
        el.classList.add('is-done');
        try {
            sessionStorage.setItem('pm_seen', '1');
        } catch (e) {
            /* storage unavailable: fine, preloader will simply show again */
        }
    }, wait);
}

if (document.readyState === 'complete') {
    hidePreloader();
} else {
    window.addEventListener('load', hidePreloader);
    setTimeout(hidePreloader, MAX_PRELOADER_MS); // safety net on very slow connections
}

/* ------------------------------------------------------------------ */
/* Alpine directives                                                   */
/* ------------------------------------------------------------------ */
document.addEventListener('alpine:init', () => {
    /**
     * x-reveal="150"  -> fades and slides the element up when it scrolls
     * into view. The number is an optional delay in milliseconds, handy for
     * staggering cards. Add class="reveal" to the element in the markup so it
     * starts hidden without a flash.
     */
    Alpine.directive('reveal', (el, { expression }, { cleanup }) => {
        const delay = parseInt(expression, 10);
        if (!Number.isNaN(delay)) el.style.setProperty('--reveal-delay', `${delay}ms`);

        if (prefersReducedMotion || !('IntersectionObserver' in window)) {
            el.classList.add('is-visible');
            return;
        }

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    el.classList.add('is-visible');
                    observer.disconnect();
                }
            },
            { threshold: 0.15, rootMargin: '0px 0px -40px 0px' },
        );

        observer.observe(el);
        cleanup(() => observer.disconnect());
    });

    /**
     * x-counter="50" data-suffix="+"  -> counts up from 0 when scrolled into view.
     */
    Alpine.directive('counter', (el, { expression }, { evaluate, cleanup }) => {
        const target = Number(evaluate(expression));
        const suffix = el.dataset.suffix || '';
        const duration = 1600;

        const render = (n) => {
            el.textContent = `${Math.round(n)}${suffix}`;
        };

        if (prefersReducedMotion || !('IntersectionObserver' in window)) {
            render(target);
            return;
        }

        render(0);

        const run = () => {
            const t0 = performance.now();
            const tick = (now) => {
                const p = Math.min(1, (now - t0) / duration);
                render(target * (1 - Math.pow(1 - p, 3))); // ease-out cubic
                if (p < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        };

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    run();
                    observer.disconnect();
                }
            },
            { threshold: 0.6 },
        );

        observer.observe(el);
        cleanup(() => observer.disconnect());
    });
});

/* ------------------------------------------------------------------ */
/* Contact pop-up: any element with [data-contact] opens it            */
/* ------------------------------------------------------------------ */
window.openContact = (service = '') => {
    window.dispatchEvent(new CustomEvent('open-contact', { detail: { service } }));
};

document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-contact]');
    if (!trigger) return;

    // On the Contact page itself the normal link is fine (the form is already there)
    if (window.location.pathname.replace(/\/$/, '') === '/contact') return;

    event.preventDefault();
    window.openContact(trigger.dataset.contact || '');
});

/* ------------------------------------------------------------------ */
/* x-drag-scroll: lets a horizontal scroller be dragged with the mouse */
/* (touch screens already swipe natively)                              */
/* ------------------------------------------------------------------ */
document.addEventListener('alpine:init', () => {
    Alpine.directive('drag-scroll', (el, _value, { cleanup }) => {
        let down = false;
        let moved = false;
        let startX = 0;
        let startLeft = 0;

        const onDown = (e) => {
            if (e.pointerType !== 'mouse' || e.button !== 0) return;
            down = true;
            moved = false;
            startX = e.clientX;
            startLeft = el.scrollLeft;
            el.style.scrollSnapType = 'none';
            el.style.scrollBehavior = 'auto';
            el.classList.add('cursor-grabbing');
        };
        const onMove = (e) => {
            if (!down) return;
            const dx = e.clientX - startX;
            if (Math.abs(dx) > 4) moved = true;
            el.scrollLeft = startLeft - dx;
        };
        const onUp = () => {
            if (!down) return;
            down = false;
            el.style.scrollSnapType = '';
            el.style.scrollBehavior = '';
            el.classList.remove('cursor-grabbing');
        };
        const onClick = (e) => {
            if (moved) {
                e.preventDefault();
                e.stopPropagation();
                moved = false;
            }
        };
        const noDrag = (e) => e.preventDefault();

        el.addEventListener('pointerdown', onDown);
        window.addEventListener('pointermove', onMove);
        window.addEventListener('pointerup', onUp);
        el.addEventListener('click', onClick, true);
        el.addEventListener('dragstart', noDrag);

        cleanup(() => {
            el.removeEventListener('pointerdown', onDown);
            window.removeEventListener('pointermove', onMove);
            window.removeEventListener('pointerup', onUp);
            el.removeEventListener('click', onClick, true);
            el.removeEventListener('dragstart', noDrag);
        });
    });
});
