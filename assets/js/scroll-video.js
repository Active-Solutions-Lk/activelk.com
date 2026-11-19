(() => {
  const cfg = window.SCROLL_CFG;
  const $ = (s) => document.querySelector(s), $$ = (s) => [...document.querySelectorAll(s)];
  const vid = $('#vid'), track = $('#track'), loader = $('#loader'), topbar = $('#topbar');
  const cards = []; $$('.card[data-i]').forEach((el) => { cards[+el.dataset.i] = el; });
  const follow = $$('[data-hero]');
  const dots = $$('.dot');
  const clamp = (n, a = 0, b = 1) => Math.min(b, Math.max(a, n));
  const isStatic = matchMedia('(prefers-reduced-motion: reduce)').matches;

  // scroll (vh) -> video time (s) map + per-section scroll spans
  const pts = [], spans = [];
  let u = 0;
  const push = (x, t) => {
    const l = pts[pts.length - 1];
    if (l && Math.abs(l.u - x) < 1e-6) l.t = t; else pts.push({ u: x, t });
  };
  cfg.sections.forEach((s) => {
    const [a, b, c, d] = s.t, [pre, hold, post] = s.vh;
    const h0 = u + pre, h1 = h0 + hold, u1 = h1 + post;
    push(u, a); push(h0, b); push(h1, c); push(u1, d);
    spans.push({ u0: u, h0, h1, u1 });
    u = u1;
  });
  const total = u, lastIdx = spans.length - 1;
  const interp = (x) => {
    for (let i = 0; i < pts.length - 1; i++) {
      const a = pts[i], b = pts[i + 1];
      if (x <= b.u) return a.t + ((x - a.u) / (b.u - a.u || 1)) * (b.t - a.t);
    }
    return pts[pts.length - 1].t;
  };

  // ---- navigation: section jumps, menu, auto-tour ----
  const trackTop = () => track.getBoundingClientRect().top + scrollY;
  const goTo = (i) => {
    if (isStatic) { const l = $$('.layer')[i]; if (l) l.scrollIntoView({ behavior: 'smooth' }); return; }
    const sp = spans[i];
    const x = i === 0 ? 0 : sp.h0 + (sp.h1 - sp.h0) * 0.35;
    scrollTo({ top: trackTop() + x * (innerHeight / 100), behavior: 'smooth' });
  };
  let tour = 0;
  const stopTour = () => { if (tour) { cancelAnimationFrame(tour); tour = 0; } };
  const startTour = () => {                       // "Watch Overview": auto-scroll through the whole experience
    stopTour();
    const y0 = scrollY, y1 = trackTop() + total * (innerHeight / 100);
    if (y1 - y0 < 10) return;
    const dur = Math.max(6000, ((y1 - y0) / (total * innerHeight / 100)) * 30000);
    const t0 = performance.now();
    const step = (now) => {
      const k = clamp((now - t0) / dur);
      scrollTo(0, y0 + (y1 - y0) * k);
      tour = k < 1 ? requestAnimationFrame(step) : 0;
    };
    tour = requestAnimationFrame(step);
  };
  ['wheel', 'touchstart', 'keydown', 'pointerdown'].forEach((ev) => addEventListener(ev, stopTour, { passive: true }));

  const toggle = $('.nav-toggle');
  toggle.addEventListener('click', () => {
    toggle.setAttribute('aria-expanded', String(topbar.classList.toggle('is-open')));
  });
  document.addEventListener('click', (e) => {
    const t = e.target.closest('[data-tour]');
    if (t) { if (!isStatic) startTour(); return; }
    const g = e.target.closest('[data-goto]');
    const c = e.target.closest('a[href="#contact"]');
    if (g || c) {
      e.preventDefault(); stopTour();
      if (g) goTo(+g.dataset.goto); else $('#contact').scrollIntoView({ behavior: 'smooth' });
      topbar.classList.remove('is-open'); toggle.setAttribute('aria-expanded', 'false');
    }
  });
  dots.forEach((d) => d.addEventListener('click', () => { stopTour(); goTo(+d.dataset.i); }));

  if (isStatic) {                                  // reduced motion: poster + stacked text, no scrubbing
    document.documentElement.classList.add('static');
    topbar.classList.add('on-light');
    return;
  }

  // ---- video: load fully into memory so seeking is instant (720p on phones / data-saver) ----
  const saveData = navigator.connection && navigator.connection.saveData;
  const weak = (navigator.deviceMemory && navigator.deviceMemory <= 4) || (navigator.hardwareConcurrency && navigator.hardwareConcurrency <= 4);
  const file = (matchMedia('(max-width: 767px)').matches || saveData || weak) ? cfg.src.mobile : cfg.src.desktop;
  fetch(file).then((r) => r.blob()).then((b) => { vid.src = URL.createObjectURL(b); })
    .catch(() => { vid.src = file; });

  let target = 0, cur = 0, last = -1, raf = 0, active = 0;

  const tick = () => {
    cur += (target - cur) * 0.15;
    if (Math.abs(target - cur) < 0.004) cur = target;
    if (Math.abs(cur - last) > 1 / 48 || (cur === target && cur !== last)) {
      vid.currentTime = Math.min(cur, (isFinite(vid.duration) ? vid.duration : Infinity) - 0.001);
      last = cur;
    }
    raf = cur !== target ? requestAnimationFrame(tick) : 0;
  };

  const onScroll = () => {
    const x = clamp((scrollY - trackTop()) / (innerHeight / 100), 0, total);
    target = interp(x);
    spans.forEach((sp, i) => {
      const fin = i === 0 ? 1 : clamp((x - (sp.h0 - 25)) / 35);
      const fout = i === lastIdx ? 1 : clamp(1 - (x - (sp.h1 - 10)) / 30);
      const o = Math.min(fin, fout), el = cards[i];
      el.style.opacity = o;
      el.style.transform = `translateY(${(1 - fin) * 24 - (1 - fout) * 16}px)`;
      el.style.pointerEvents = o > 0.5 ? 'auto' : 'none';
      if (i === 0) follow.forEach((f) => {         // hero shade / wave / scroll cue fade with the hero text
        f.style.opacity = o;
        if (f.classList.contains('scroll-cue')) f.style.pointerEvents = o > 0.5 ? 'auto' : 'none';
      });
    });
    let idx = spans.findIndex((sp) => x < sp.u1);
    if (idx === -1) idx = lastIdx;
    if (idx !== active) {
      active = idx;
      vid.style.objectPosition = cfg.sections[idx].objX + '% 50%';
      topbar.classList.toggle('on-light', idx > 0);
      dots.forEach((d, i) => { d.classList.toggle('is-active', i === idx); d.toggleAttribute('aria-current', i === idx); });
    }
    if (!raf) raf = requestAnimationFrame(tick);
  };

  // iOS Safari only allows seeking after one user-initiated play()
  const unlock = () => vid.play().then(() => { vid.pause(); last = -1; onScroll(); }).catch(() => {});
  addEventListener('pointerdown', unlock, { once: true });
  addEventListener('touchstart', unlock, { once: true, passive: true });

  vid.addEventListener('loadeddata', () => {
    loader.classList.add('is-done');
    addEventListener('scroll', onScroll, { passive: true });
    addEventListener('resize', onScroll);
    onScroll();
  }, { once: true });
})();
