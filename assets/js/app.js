import { initLenis } from './modules/lenis.js';
import { init3DTilt } from './modules/gsap-init.js';
import { initHeroAnimation } from './modules/hero-anim.js';
import { initMagneticButtons } from './modules/magnetic.js';
import { initPageTransitions } from './modules/page-transition.js';
import { initCounters } from './modules/counters.js';
import { initThreeHero } from './modules/three-scene.js';

document.addEventListener('DOMContentLoaded', () => {
  // 1. Lenis smooth scroll & GSAP synchronization
  initLenis();

  // 2. 3D card tilt & hover micro-interactions
  init3DTilt();

  // 3. Magnetic CTA buttons
  initMagneticButtons();

  // 4. Smooth page transitions
  initPageTransitions();

  // 5. Stat number counters
  initCounters();

  // 6. Three.js WebGL Particle background in hero
  initThreeHero();

  // 7. Hero SplitText entrance animation
  const vid = document.getElementById('vid');
  if (vid) {
    if (vid.readyState >= 2) {
      initHeroAnimation();
    } else {
      vid.addEventListener('loadeddata', initHeroAnimation, { once: true });
    }
  } else {
    initHeroAnimation();
  }
});
