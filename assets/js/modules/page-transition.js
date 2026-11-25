/**
 * Seamless page transitions using CSS clip-path & GSAP
 */
export function initPageTransitions() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (!window.gsap) return;

  const overlay = document.getElementById('page-overlay');
  if (!overlay) return;

  // Reveal page on load
  gsap.to(overlay, {
    scaleY: 0,
    transformOrigin: 'top center',
    duration: 0.5,
    ease: 'power3.inOut',
    onComplete: () => {
      overlay.style.pointerEvents = 'none';
    },
  });

  // Intercept local navigational links
  document.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    if (!link) return;

    const href = link.getAttribute('href');
    if (!href) return;

    // Skip hash links, mailto, javascript, external links, or downloads
    if (
      href.startsWith('#') ||
      href.startsWith('mailto:') ||
      href.startsWith('tel:') ||
      href.startsWith('javascript:') ||
      link.target === '_blank' ||
      link.hasAttribute('data-goto') ||
      link.hasAttribute('download')
    ) {
      return;
    }

    // Check same origin
    const targetUrl = new URL(link.href, window.location.origin);
    if (targetUrl.origin !== window.location.origin) return;

    // Check if it's the exact same page
    if (targetUrl.pathname === window.location.pathname && targetUrl.search === window.location.search) {
      return;
    }

    e.preventDefault();
    overlay.style.pointerEvents = 'all';

    gsap.fromTo(
      overlay,
      { scaleY: 0, transformOrigin: 'bottom center' },
      {
        scaleY: 1,
        duration: 0.45,
        ease: 'power4.inOut',
        onComplete: () => {
          window.location.href = link.href;
        },
      }
    );
  });
}
