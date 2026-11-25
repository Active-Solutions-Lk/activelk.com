/**
 * Enhanced 3D Card Tilt with Parallax Depth Layer
 */
export function init3DTilt() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
  if (!window.gsap) return;

  const tiltElements = document.querySelectorAll('.as-3d-card, .standard-card, .as-3d-hero');

  tiltElements.forEach((el) => {
    let rect = null;

    const onMouseEnter = () => {
      rect = el.getBoundingClientRect();
    };

    const onMouseMove = (e) => {
      if (!rect) rect = el.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const xCenter = rect.width / 2;
      const yCenter = rect.height / 2;

      // Card tilt rotation: -8 to 8 deg
      const rotateX = ((y - yCenter) / yCenter) * -8;
      const rotateY = ((x - xCenter) / xCenter) * 8;

      gsap.to(el, {
        rotateX,
        rotateY,
        transformPerspective: 1000,
        duration: 0.3,
        ease: 'power2.out',
        overwrite: 'auto',
      });

      // Subtle parallax on card contents if exists
      const inner = el.querySelector('.card-inner, .card-content');
      if (inner) {
        gsap.to(inner, {
          x: ((x - xCenter) / xCenter) * 8,
          y: ((y - yCenter) / yCenter) * 8,
          duration: 0.3,
          ease: 'power2.out',
          overwrite: 'auto',
        });
      }
    };

    const onMouseLeave = () => {
      rect = null;
      gsap.to(el, {
        rotateX: 0,
        rotateY: 0,
        duration: 0.6,
        ease: 'power2.out',
        overwrite: 'auto',
      });

      const inner = el.querySelector('.card-inner, .card-content');
      if (inner) {
        gsap.to(inner, {
          x: 0,
          y: 0,
          duration: 0.6,
          ease: 'power2.out',
          overwrite: 'auto',
        });
      }
    };

    el.addEventListener('mouseenter', onMouseEnter);
    el.addEventListener('mousemove', onMouseMove);
    el.addEventListener('mouseleave', onMouseLeave);
  });

  window.addEventListener('blur', () => {
    tiltElements.forEach((el) => {
      gsap.to(el, { rotateX: 0, rotateY: 0, duration: 0.4 });
    });
  });
}
