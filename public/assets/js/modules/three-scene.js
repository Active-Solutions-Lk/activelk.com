/**
 * Three.js WebGL Particle Sphere Background for Hero
 */
export function initThreeHero() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (typeof window.THREE === 'undefined') return;

  const canvas = document.getElementById('hero-three');
  if (!canvas) return;

  // Performance gate for low-spec / low-power mobile devices
  const isWeak =
    (navigator.deviceMemory && navigator.deviceMemory <= 4) ||
    (navigator.hardwareConcurrency && navigator.hardwareConcurrency <= 4);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000);
  camera.position.z = 240;

  const renderer = new THREE.WebGLRenderer({
    canvas,
    alpha: true,
    antialias: !isWeak,
    powerPreference: 'high-performance',
  });
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, isWeak ? 1 : 1.5));

  // Particles
  const particleCount = isWeak ? 600 : (window.innerWidth < 768 ? 1000 : 2200);
  const geometry = new THREE.BufferGeometry();
  const positions = new Float32Array(particleCount * 3);

  for (let i = 0; i < particleCount; i++) {
    const theta = THREE.MathUtils.randFloatSpread(360);
    const phi = THREE.MathUtils.randFloatSpread(360);
    const radius = 100 + Math.random() * 40;

    positions[i * 3]     = radius * Math.sin(theta) * Math.cos(phi);
    positions[i * 3 + 1] = radius * Math.sin(theta) * Math.sin(phi);
    positions[i * 3 + 2] = radius * Math.cos(theta);
  }

  geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

  const material = new THREE.PointsMaterial({
    color: 0x2a8bff,
    size: isWeak ? 2 : 2.5,
    transparent: true,
    opacity: 0.65,
    blending: THREE.AdditiveBlending,
  });

  const particleMesh = new THREE.Points(geometry, material);
  scene.add(particleMesh);

  // Mouse Parallax
  let mouseX = 0, mouseY = 0;
  let targetX = 0, targetY = 0;
  const onMouseMove = (e) => {
    mouseX = (e.clientX - window.innerWidth / 2) * 0.0008;
    mouseY = (e.clientY - window.innerHeight / 2) * 0.0008;
  };
  window.addEventListener('mousemove', onMouseMove, { passive: true });

  // Handle Resize
  const onResize = () => {
    if (!canvas.parentElement) return;
    camera.aspect = canvas.clientWidth / canvas.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  };
  window.addEventListener('resize', onResize);

  // Auto-pause when hero leaves viewport
  let isVisible = true;
  const stage = canvas.closest('.stage') || canvas.parentElement;
  if ('IntersectionObserver' in window && stage) {
    const observer = new IntersectionObserver(([entry]) => {
      isVisible = entry.isIntersecting;
    }, { threshold: 0.05 });
    observer.observe(stage);
  }

  let rafId = 0;
  function animate() {
    if (isVisible) {
      targetX += (mouseX - targetX) * 0.05;
      targetY += (mouseY - targetY) * 0.05;

      particleMesh.rotation.y += 0.0015;
      particleMesh.rotation.x += 0.0008;

      particleMesh.rotation.y += targetX;
      particleMesh.rotation.x += targetY;

      renderer.render(scene, camera);
    }
    rafId = requestAnimationFrame(animate);
  }
  animate();

  return () => {
    cancelAnimationFrame(rafId);
    window.removeEventListener('mousemove', onMouseMove);
    window.removeEventListener('resize', onResize);
    geometry.dispose();
    material.dispose();
    renderer.dispose();
  };
}
