/**
 * Lenis Smooth Scroll Engine + GSAP ScrollTrigger Synchronization
 * NOTE: Lenis is DISABLED on the scroll-video hero page to avoid conflict
 * with scroll-video.js which requires native scrollY to function correctly.
 */
export function initLenis() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return null;
  if (typeof window.Lenis === 'undefined') return null;

  // Don't activate Lenis if scroll-video.js is present (hero scrub page)
  // scroll-video.js requires native scrollY; Lenis would override and break it.
  if (document.getElementById('track')) {
    return null;
  }

  const lenis = new window.Lenis({
    duration: 1.15,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smoothWheel: true,
    touchMultiplier: 1.5,
  });

  lenis.on('scroll', () => {
    if (window.ScrollTrigger) {
      ScrollTrigger.update();
    }
  });

  if (window.gsap) {
    gsap.ticker.add((time) => {
      lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);
  } else {
    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
  }

  return lenis;
}
