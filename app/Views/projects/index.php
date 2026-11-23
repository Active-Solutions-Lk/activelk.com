<?php
$title = "Case Studies & Projects | Active Solutions";
ob_start();
?>
<div class="page-container">
  <div class="text-center max-w-[700px] mx-auto mb-12">
    <span class="badge inline-block mb-3">Proven Deliveries</span>
    <h1 class="text-[clamp(2rem,4vw,3.2rem)] font-bold mb-4 tracking-[-0.02em] leading-tight">
      Enterprise Projects & Case Studies
    </h1>
    <p class="text-navy-600 text-lg leading-relaxed">
      See how top enterprises, universities, and commercial financial institutions scale with our infrastructure.
    </p>
  </div>

  <div class="modern-grid">
    <?php foreach (($projects ?? []) as $p): ?>
      <div class="standard-card reveal-on-scroll">
        <div class="flex justify-between items-center">
          <span class="badge"><?= e($p['industry']) ?></span>
          <small class="text-navy-400 font-medium"><?= e($p['client']) ?></small>
        </div>
        <h2 class="text-xl my-2 font-semibold"><?= e($p['title']) ?></h2>
        <p class="text-navy-600 text-[0.95rem] leading-relaxed flex-grow"><?= e($p['summary']) ?></p>
        <div class="mt-4">
          <a class="btn w-full justify-center" href="<?= url('/contact') ?>">
            <span>Discuss Similar Project</span>
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
