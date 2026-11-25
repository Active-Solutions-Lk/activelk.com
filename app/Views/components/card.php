<?php
/** @var array $card ['title', 'body', 'badge', 'tone', 'cta', 'i', 'side'] */
$tone = $card['tone'] ?? 'light';
$i    = $card['i'] ?? 1;
?>
<article class="card tone-<?= e($tone) ?> as-3d-card" data-i="<?= (int)$i ?>" style="opacity:0">
  <?php if (!empty($card['badge'])): ?>
    <span class="badge"><?= e($card['badge']) ?></span>
  <?php endif; ?>
  
  <h2><?= e($card['title']) ?></h2>
  <p><?= e($card['body']) ?></p>
  
  <?php if (!empty($card['cta'])): ?>
    <a class="btn" href="<?= e($card['cta'][1] ?? '#') ?>">
      <span><?= e($card['cta'][0] ?? 'Explore') ?></span>
      <?= icon('arrow') ?>
    </a>
  <?php endif; ?>
</article>
