/**
 * Magnetic button hover effect
 */
export function initMagneticButtons() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
  if (!window.gsap) return;

  const magneticElements = document.querySelectorAll('.btn-primary, .contact-btn, [data-magnetic]');

  magneticElements.forEach((el) => {
    let bounds = null;

    const onMouseEnter = () => {
      bounds = el.getBoundingClientRect();
    };

    const onMouseMove = (e) => {
      if (!bounds) bounds = el.getBoundingClientRect();
      const centerX = bounds.left + bounds.width / 2;
      const centerY = bounds.top + bounds.height / 2;
      const deltaX = (e.clientX - centerX) * 0.35;
      const deltaY = (e.clientY - centerY) * 0.35;

      gsap.to(el, {
        x: deltaX,
        y: deltaY,
        duration: 0.3,
        ease: 'power2.out',
        overwrite: 'auto',
      });
    };

    const onMouseLeave = () => {
      bounds = null;
      gsap.to(el, {
        x: 0,
        y: 0,
        duration: 0.7,
        ease: 'elastic.out(1.1, 0.4)',
        overwrite: 'auto',
      });
    };

    el.addEventListener('mouseenter', onMouseEnter);
    el.addEventListener('mousemove', onMouseMove);
    el.addEventListener('mouseleave', onMouseLeave);
  });
}
