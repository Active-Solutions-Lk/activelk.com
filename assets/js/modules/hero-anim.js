/**
 * Hero Animations Engine (Redesigned matching Snapshot)
 * 1. Entrance Animation (on load / video ready)
 * 2. Frame-Locked Bidirectional Scroll Scrub Timeline
 */

export function initHeroAnimation() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (!window.gsap) return;

  const headline = document.querySelector('.hero-headline');
  if (!headline) return;

  const selectors = [
    '.hero-headline .hl-word',
    '.hero-accent-bar',
    '.hero-tag',
    '.hero-features .feat',
    '.hero-cta',
  ];

  const allEls = document.querySelectorAll(selectors.join(','));
  allEls.forEach((el) => { el.style.willChange = 'transform, opacity'; });

  const tl = gsap.timeline({
    delay: 0.1,
    onComplete: () => {
      allEls.forEach((el) => { el.style.willChange = ''; });
      initHeroScrollTimeline();
    },
  });

  // 1. Headline words staggered entrance
  tl.fromTo(
    '.hero-headline .hl-word',
    { y: 38, opacity: 0 },
    {
      y: 0,
      opacity: 1,
      duration: 0.65,
      stagger: 0.08,
      ease: 'power3.out',
    }
  );

  // 2. Horizontal Blue Accent Bar expands from left
  tl.fromTo(
    '.hero-accent-bar',
    { scaleX: 0, opacity: 0, transformOrigin: 'left center' },
    { scaleX: 1, opacity: 1, duration: 0.45, ease: 'power2.out' },
    '-=0.3'
  );

  // 3. Tagline description
  tl.fromTo(
    '.hero-tag',
    { y: 18, opacity: 0 },
    { y: 0, opacity: 1, duration: 0.5, ease: 'power3.out' },
    '-=0.3'
  );

  // 4. Feature items with circular glowing badges
  tl.fromTo(
    '.hero-features .feat',
    { y: 20, opacity: 0 },
    { y: 0, opacity: 1, duration: 0.5, stagger: 0.1, ease: 'back.out(1.2)' },
    '-=0.25'
  );

  // 5. CTA buttons
  tl.fromTo(
    '.hero-cta',
    { y: 16, opacity: 0 },
    { y: 0, opacity: 1, duration: 0.45, ease: 'power2.out' },
    '-=0.2'
  );

  // Safety fallback
  const fallback = setTimeout(() => {
    if (!tl.isActive()) return;
    tl.kill();
    allEls.forEach((el) => {
      gsap.set(el, { clearProps: 'all' });
    });
    initHeroScrollTimeline();
  }, 2500);

  tl.eventCallback('onComplete', () => clearTimeout(fallback));
}

/**
 * Scroll Scrubbed Master Timeline
 * Scrubbed 0.0 -> 1.0 directly by scroll-video.js
 */
export function initHeroScrollTimeline() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (!window.gsap) return;

  const card = document.querySelector('.hero-card');
  if (!card) return;

  const scrollTl = gsap.timeline({
    paused: true,
    defaults: { ease: 'power2.inOut' },
  });

  // 1. Accent Bar shrinks early
  scrollTl.to('.hero-accent-bar', {
    scaleX: 0,
    opacity: 0,
    transformOrigin: 'left center',
    duration: 0.25,
  }, 0.0);

  // 2. Feature items cascade exit
  scrollTl
    .to('.hero-features .feat:nth-child(1)', {
      x: -28,
      y: 18,
      rotateZ: -4,
      opacity: 0,
      duration: 0.32,
    }, 0.05)
    .to('.hero-features .feat:nth-child(3)', { // nth-child 3 because of divider
      y: 30,
      scale: 0.9,
      opacity: 0,
      duration: 0.32,
    }, 0.10)
    .to('.hero-features .feat:nth-child(5)', {
      x: 28,
      y: 18,
      rotateZ: 4,
      opacity: 0,
      duration: 0.32,
    }, 0.15)
    .to('.feat-sep', {
      opacity: 0,
      duration: 0.2,
    }, 0.05);

  // 3. Headline words kinetic departure
  // Line 1: "Your Trusted" lifts up with blue glow expansion
  scrollTl.to('.hero-headline .hl-line:nth-child(1) .hl-word', {
    y: -55,
    opacity: 0,
    filter: 'blur(6px)',
    stagger: 0.04,
    duration: 0.45,
  }, 0.15);

  // Line 2: "Technology Partner" slides down
  scrollTl.to('.hero-headline .hl-line:nth-child(2) .hl-word', {
    y: 40,
    opacity: 0,
    filter: 'blur(6px)',
    stagger: 0.04,
    duration: 0.45,
  }, 0.18);

  // 4. Tagline drift
  scrollTl.to('.hero-tag', {
    x: -22,
    y: 16,
    opacity: 0,
    filter: 'blur(4px)',
    duration: 0.40,
  }, 0.24);

  // 5. CTA Buttons depress & scale down
  scrollTl.to('.hero-cta', {
    y: 25,
    scale: 0.90,
    opacity: 0,
    duration: 0.40,
  }, 0.35);

  // Expose controller to window for scroll-video.js
  window.HeroScrollFX = {
    setScrollProgress(p) {
      const clamped = Math.min(1, Math.max(0, p));
      scrollTl.progress(clamped);
    },
  };
}
