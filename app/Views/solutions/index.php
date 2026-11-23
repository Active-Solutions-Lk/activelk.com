<?php
$title = "Our Technology Solutions | Active Solutions";
ob_start();
?>
<div class="page-container">
  <div class="text-center max-w-[700px] mx-auto mb-12">
    <span class="badge inline-block mb-3">Enterprise Portfolio</span>
    <h1 class="text-[clamp(2rem,4vw,3.2rem)] font-bold mb-4 tracking-[-0.02em] leading-tight">
      Cutting-Edge Infrastructure Solutions
    </h1>
    <p class="text-navy-600 text-lg leading-relaxed">
      High-density switching, scalable storage, enterprise routing, and real-time log analytics built for demanding workloads.
    </p>
  </div>

  <div class="modern-grid">
    <?php foreach (($solutions ?? []) as $s): ?>
      <?php if (($s['id'] ?? '') === 'intro') continue; ?>
      <div class="standard-card reveal-on-scroll">
        <span class="badge w-fit"><?= e($s['badge']) ?></span>
        <h2 class="text-2xl my-2 font-semibold"><?= e($s['title']) ?></h2>
        <p class="text-navy-600 text-[0.95rem] leading-relaxed flex-grow"><?= e($s['body']) ?></p>
        <div class="mt-4">
          <a class="btn w-full justify-center" href="<?= url('/solutions/' . e($s['id'])) ?>">
            <span>Learn More</span>
            <?= icon('arrow') ?>
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php
$content = ob_get_clean();
require dirname(__DIR__) . '/layout/base.php';
