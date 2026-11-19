<?php
declare(strict_types=1);
$cfg      = require __DIR__ . '/config.php';
$sections = $cfg['sections'];
$hero     = $cfg['hero'];
$total    = 0;
foreach ($sections as $s) { $total += array_sum($s['vh']); }
$trackVh  = $total + $cfg['site']['tail_vh'];

$e   = fn(string $v): string => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
$ver = fn(string $p): string => $p . '?v=' . (is_file(__DIR__ . '/' . $p) ? filemtime(__DIR__ . '/' . $p) : '1');

$paths = [
    'home'    => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/>',
    'chevron' => '<path d="m6 9 6 6 6-6"/>',
    'arrow'   => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
    'down'    => '<path d="M12 5v14"/><path d="m19 12-7 7-7-7"/>',
    'mail'    => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
    'menu'    => '<path d="M4 6h16M4 12h16M4 18h16"/>',
    'shield'  => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
    'headset' => '<path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/>',
    'bulb'    => '<path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/>',
    'play'    => '<polygon points="7 4 20 12 7 20 7 4" fill="currentColor"/>',
];
$ic = fn(string $n): string => '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $paths[$n] . '</svg>';
$link = function (array $it) use ($e): string {
    $goto = isset($it['goto']) ? ' data-goto="' . (int)$it['goto'] . '"' : '';
    return 'href="' . $e($it['href'] ?? '#') . '"' . $goto;
};

$clientCfg = [
    'sections' => array_map(fn($s) => ['t' => $s['t'], 'vh' => $s['vh'], 'objX' => $s['objX']], $sections),
    'tailVh'   => $cfg['site']['tail_vh'],
    'src'      => ['desktop' => $cfg['video']['desktop'], 'mobile' => $cfg['video']['mobile']],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $e($cfg['site']['title']) ?></title>
  <meta name="description" content="<?= $e($cfg['site']['description']) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="preload" as="image" href="<?= $e($cfg['video']['poster']) ?>">
  <link rel="stylesheet" href="<?= $e($ver('assets/css/style.css')) ?>">
</head>
<body>
  <a class="skip" href="#contact">Skip to contact</a>

  <header class="topbar" id="topbar">
    <a class="logo" href="#" data-goto="0" aria-label="Active Solutions – home"><img src="<?= $e($ver('assets/img/logo.png')) ?>" alt="Active Solutions"></a>
    <button type="button" class="nav-toggle" aria-expanded="false" aria-controls="mainnav" aria-label="Menu"><?= $ic('menu') ?></button>
    <nav class="mainnav" id="mainnav" aria-label="Main">
      <ul>
        <?php foreach ($cfg['nav'] as $item): $kids = $item['children'] ?? []; ?>
          <li<?= $kids ? ' class="has-sub"' : '' ?>>
            <a class="navlink<?= !empty($item['active']) ? ' is-active' : '' ?>" <?= $link($item) ?>>
              <?= !empty($item['icon']) ? $ic($item['icon']) : '' ?><?= $e($item['label']) ?><?= $kids ? $ic('chevron') : '' ?>
            </a>
            <?php if ($kids): ?>
              <ul class="sub">
                <?php foreach ($kids as $k): ?><li><a class="navlink" <?= $link($k) ?>><?= $e($k['label']) ?></a></li><?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <a class="contact-btn" href="#contact"><?= $ic('mail') ?><?= $e($hero['contact']) ?><?= $ic('arrow') ?></a>
  </header>

  <nav class="dots" aria-label="Sections">
    <?php foreach ($sections as $i => $s): ?>
      <button type="button" class="dot<?= $i === 0 ? ' is-active' : '' ?>" data-i="<?= $i ?>" aria-label="<?= $e($s['label']) ?>"></button>
    <?php endforeach; ?>
  </nav>

  <main>
    <div class="track" id="track" style="--track-vh:<?= $trackVh ?>">
      <div class="stage">
        <video id="vid" muted playsinline preload="auto" poster="<?= $e($cfg['video']['poster']) ?>"
               style="object-position:<?= (int)$sections[0]['objX'] ?>% 50%"></video>

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
              <article class="card hero-card" data-i="0">
                <span class="hero-badge"><i></i><?= $e($hero['badge']) ?></span>
                <h1 class="hero-title"><span><?= $e($hero['title'][0]) ?></span><span class="grad"><?= $e($hero['title'][1]) ?></span></h1>
                <p class="hero-sub"><?= $e($hero['subtitle'][0]) ?><b><?= $e($hero['subtitle'][1]) ?></b><?= $e($hero['subtitle'][2]) ?></p>
                <p class="hero-tag"><?= $e($hero['tagline']) ?></p>
                <ul class="hero-features">
                  <?php foreach ($hero['features'] as $f): ?>
                    <li class="feat"><span class="feat-ic"><?= $ic($f[0]) ?></span><span><?= $e($f[1]) ?><br><?= $e($f[2]) ?></span></li>
                  <?php endforeach; ?>
                </ul>
                <div class="hero-cta">
                  <a class="btn-primary" href="#" data-goto="<?= (int)$hero['primary'][1] ?>"><?= $e($hero['primary'][0]) ?><?= $ic('arrow') ?></a>
                  <i class="sep"></i>
                  <button type="button" class="btn-ghost" data-tour><span class="play"><?= $ic('play') ?></span><?= $e($hero['secondary']) ?></button>
                </div>
              </article>
            </div>
          <?php else: ?>
            <div class="layer <?= $e($s['side']) ?>">
              <article class="card tone-<?= $e($s['tone']) ?>" data-i="<?= $i ?>" style="opacity:0">
                <span class="badge"><?= $e($s['badge']) ?></span>
                <h2><?= $e($s['title']) ?></h2>
                <p><?= $e($s['body']) ?></p>
                <?php if (!empty($s['cta'])): ?>
                  <a class="btn" href="<?= $e($s['cta'][1]) ?>"><?= $e($s['cta'][0]) ?></a>
                <?php endif; ?>
              </article>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>

        <a class="scroll-cue" data-hero href="#" data-goto="1" aria-label="Scroll to solutions"><?= $ic('down') ?></a>

        <div class="loader" id="loader" role="status">
          <p>Loading experience</p><div class="bar"><i></i></div>
        </div>
      </div>
    </div>
  </main>

  <footer id="contact" class="footer">
    <h2>Let’s talk about your next project</h2>
    <p>Replace this block with your contact section.</p>
    <small>© <?= date('Y') ?> Active Solutions</small>
  </footer>

  <script>window.SCROLL_CFG = <?= json_encode($clientCfg, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;</script>
  <script src="<?= $e($ver('assets/js/scroll-video.js')) ?>" defer></script>
</body>
</html>
