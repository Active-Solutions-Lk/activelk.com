<?php
/** @var array $hero */
/** @var array $heroFeatures */
?>
<article class="card hero-card as-3d-hero" data-i="0">
  <!-- <h1 class="hero-headline">
    <span class="h6-line"><span class="h6-word">Your</span> <span class="h6-word text-blue">Trusted</span></span>
    <span class="h6-line"><span class="h6-word">Technology</span> <span class="h6-word">Partner</span></span>
  </h1> -->

  <!-- <div class="hero-accent-bar" aria-hidden="true"></div> -->

  <p class="hero-tag">
    <?= e($hero['tagline'] ?? 'Storage, networking and security solutions from the brands businesses trust.') ?>
  </p>
  
  <ul class="hero-features">
    <?php foreach (($hero['features'] ?? []) as $i => $f): ?>
      <?php if ($i > 0): ?>
        <li class="feat-sep" aria-hidden="true"></li>
      <?php endif; ?>
      <li class="feat">
        <span class="feat-ic"><?= icon($f[0]) ?></span>
        <span class="feat-label"><?= e($f[1]) ?><br><?= e($f[2]) ?></span>
      </li>
    <?php endforeach; ?>
  </ul>
  
  <div class="hero-cta">
    <a class="btn-primary" href="#" data-goto="<?= (int)($hero['primary'][1] ?? 1) ?>">
      <?= e($hero['primary'][0] ?? 'Explore Solutions') ?>
      <?= icon('arrow') ?>
    </a>
    <button type="button" class="btn-ghost" data-tour>
      <span class="play-arrow" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><polygon points="7 4 20 12 7 20 7 4"/></svg>
      </span>
      <?= e($hero['secondary'] ?? 'Watch Overview') ?>
    </button>
  </div>
</article>
