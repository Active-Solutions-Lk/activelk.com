<?php
/** @var array $cfg */
/** @var array $sections */
/** @var array $hero */

$total = 0;
foreach ($sections as $s) {
    $total += array_sum($s['vh']);
}
$trackVh = $total + $cfg['site']['tail_vh'];

$clientCfg = [
    'sections' => array_map(fn($s) => ['t' => $s['t'], 'vh' => $s['vh'], 'objX' => $s['objX']], $sections),
    'tailVh'   => $cfg['site']['tail_vh'],
    'src'      => ['desktop' => asset($cfg['video']['desktop']), 'mobile' => asset($cfg['video']['mobile'])],
];

ob_start();
?>
  <!-- Navigation Dots for the Scroll Experience -->
  <nav class="dots" aria-label="Sections">
    <?php foreach ($sections as $i => $s): ?>
      <button type="button" class="dot<?= $i === 0 ? ' is-active' : '' ?>" data-i="<?= $i ?>" aria-label="<?= e($s['label']) ?>"></button>
    <?php endforeach; ?>
  </nav>

  <main>
    <div class="track" id="track" style="--track-vh:<?= $trackVh ?>">
      <div class="stage">
        <canvas id="hero-three"></canvas>
        <video id="vid" muted playsinline preload="auto" poster="<?= asset($cfg['video']['poster']) ?>"
               style="object-position:<?= (int)$sections[0]['objX'] ?>% 50%"></video>

        <div class="hero-corner-tl" data-hero aria-hidden="true"></div>
        <div class="hero-corner-br" data-hero aria-hidden="true"></div>

        <div class="hero-fx" data-hero aria-hidden="true">
          <svg viewBox="0 0 1000 200" preserveAspectRatio="none">
            <defs><linearGradient id="wv" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#0a4bd6" stop-opacity=".85"/><stop offset="1" stop-color="#0a4bd6" stop-opacity="0"/></linearGradient></defs>
            <path d="M0 200V95C170 120 330 175 640 200Z" fill="url(#wv)"/>
            <path d="M0 78C190 105 360 170 700 200" fill="none" stroke="#2a8bff" stroke-opacity=".7" stroke-width="2"/>
          </svg>
        </div>

        <?php foreach ($sections as $i => $s): ?>
          <?php if ($i === 0): ?>
            <div class="layer hero-layer left">
              <?php component('hero', ['hero' => $hero]); ?>
            </div>
          <?php else: ?>
            <div class="layer <?= e($s['side']) ?>">
              <?php component('card', ['card' => array_merge($s, ['i' => $i])]); ?>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>

        <!-- Bottom-Left Section Progress Indicator (Matching snapshot: dots + slider track) -->
        <div class="hero-counter-slider" data-hero aria-hidden="true">
          <div class="hc-dots">
            <span class="hc-dot is-active"></span>
            <span class="hc-dot"></span>
            <span class="hc-dot"></span>
          </div>
          <div class="hc-track"><div class="hc-fill" id="hc-fill"></div></div>
        </div>

        <!-- Scroll Cue with Mouse Icon and Text -->
        <a class="scroll-cue" data-hero href="#" data-goto="1" aria-label="Scroll to solutions">
          <span class="mouse-icon"><i class="mouse-wheel"></i></span>
          <span class="cue-label">Scroll Down</span>
        </a>

        <div class="loader" id="loader" role="status">
          <p>Loading experience</p><div class="bar"><i></i></div>
        </div>
      </div>
    </div>
  </main>
<?php
$content = ob_get_clean();

$scriptsExtra = '
<script>window.SCROLL_CFG = ' . json_encode($clientCfg, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) . ';</script>
<script src="' . asset('assets/js/scroll-video.js') . '" defer></script>
';

require dirname(__DIR__) . '/layout/base.php';
