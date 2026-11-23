<?php
$title = e($solution['title']) . " | Active Solutions";
ob_start();
?>
<div class="page-container">
  <div class="mb-8">
    <a href="<?= url('/solutions') ?>" class="inline-flex items-center gap-2 text-brand font-medium hover:underline">
      <?= icon('chevron') ?> Back to all solutions
    </a>
  </div>

  <div class="standard-card p-[clamp(2rem,5vw,4rem)] max-w-[900px] mx-auto">
    <span class="badge w-fit"><?= e($solution['badge']) ?></span>
    <h1 class="text-[clamp(2.2rem,4.5vw,3.5rem)] my-4 font-bold tracking-[-0.02em] leading-tight">
      <?= e($solution['title']) ?>
    </h1>
    <p class="text-navy-600 text-lg leading-relaxed mb-8">
      <?= e($solution['body']) ?>
    </p>

    <div class="border-t border-navy/[0.08] pt-8 flex gap-4 flex-wrap">
      <a class="btn" href="<?= url('/contact') ?>">
        <span>Request Technical Consultation</span>
        <?= icon('arrow') ?>
      </a>
      <a class="btn bg-transparent text-navy border border-navy/15 hover:bg-navy/5" href="<?= url('/') ?>">
        <span>View In Interactive Tour</span>
      </a>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require dirname(__DIR__) . '/layout/base.php';
