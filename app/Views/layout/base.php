<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? config('content.site.title', 'Active Solutions')) ?></title>
  <meta name="description" content="<?= e($description ?? config('content.site.description', '')) ?>">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Core Styles -->
  <link rel="stylesheet" href="<?= asset('assets/css/app.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/animations.css') ?>">
  
  <!-- GSAP 3, Lenis & Three.js for Modern Smooth 3D Interactions -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js" defer></script>

  <?php if (!empty($headExtra)) echo $headExtra; ?>
</head>
<body class="<?= e($bodyClass ?? '') ?>">
  <div id="page-overlay" aria-hidden="true"></div>
  <a class="skip" href="#contact">Skip to contact</a>

  <?php require dirname(__DIR__) . '/layout/header.php'; ?>

  <?= $content ?? '' ?>

  <?php require dirname(__DIR__) . '/layout/footer.php'; ?>

  <!-- Modular App FX Engine -->
  <script type="module" src="<?= asset('assets/js/app.js') ?>"></script>
  <?php if (!empty($scriptsExtra)) echo $scriptsExtra; ?>
</body>
</html>
