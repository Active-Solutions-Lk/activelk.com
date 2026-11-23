<?php
$title = "404 Not Found | Active Solutions";
ob_start();
?>
<div class="page-container text-center min-h-[60vh] flex flex-col justify-center items-center">
  <span class="badge mb-4">Error 404</span>
  <h1 class="text-[clamp(2.5rem,6vw,4rem)] font-bold mb-4">Page Not Found</h1>
  <p class="text-navy-400 text-lg max-w-[500px] mb-8">
    The page or solution you requested does not exist or has been moved to a new destination.
  </p>
  <a class="btn" href="<?= url('/') ?>">
    <span>Back to Home</span>
    <?= icon('arrow') ?>
  </a>
</div>
<?php
$content = ob_get_clean();
require dirname(__DIR__) . '/layout/base.php';
