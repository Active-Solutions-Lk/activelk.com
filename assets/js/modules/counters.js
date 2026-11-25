/**
 * Number counters with GSAP ticker & ScrollTrigger
 */
export function initCounters() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('[data-counter]').forEach((el) => {
      el.textContent = el.dataset.counter;
    });
    return;
  }

  if (!window.gsap || !window.ScrollTrigger) return;

  const counters = document.querySelectorAll('[data-counter]');
  counters.forEach((el) => {
    const targetVal = parseFloat(el.dataset.counter) || 0;
    const decimals = (el.dataset.counter.split('.')[1] || '').length;
    const prefix = el.dataset.prefix || '';
    const suffix = el.dataset.suffix || '';

    const obj = { val: 0 };
    gsap.to(obj, {
      val: targetVal,
      duration: 2,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 85%',
        toggleActions: 'play none none none',
        once: true,
      },
      onUpdate: () => {
        el.textContent = prefix + obj.val.toFixed(decimals) + suffix;
      },
    });
  });
}
