<?php
/** @var array $navItems */
/** @var array $hero */
$navItems = config('content.nav', []);
$hero     = config('content.hero', []);
$currentPath = (new \Src\Request())->path();

$isNavActive = function (array $it) use ($currentPath): bool {
    $href = $it['href'] ?? '';
    if ($href === '' || str_starts_with($href, '#')) {
        return false;
    }
    if ($href === '/') {
        return $currentPath === '/';
    }
    return $currentPath === $href || str_starts_with($currentPath, rtrim($href, '/') . '/');
};

$link = function (array $it): string {
    $goto = isset($it['goto']) ? ' data-goto="' . (int)$it['goto'] . '"' : '';
    $href = $it['href'] ?? '#';
    if (str_starts_with($href, '/')) {
        $href = url($href);
    }
    return 'href="' . e($href) . '"' . $goto;
};
?>
<header class="topbar<?= empty($isHome) ? ' on-light' : '' ?>" id="topbar">
  <a class="logo" href="<?= url('/') ?>" data-goto="0" aria-label="Active Solutions – Home">
    <img src="<?= asset('assets/img/logo.png') ?>" alt="Active Solutions">
  </a>
  
  <button type="button" class="nav-toggle" aria-expanded="false" aria-controls="mainnav" aria-label="Menu">
    <?= icon('menu') ?>
  </button>
  
  <nav class="mainnav" id="mainnav" aria-label="Main Navigation">
    <ul>
      <?php foreach ($navItems as $item): $kids = $item['children'] ?? []; ?>
        <li<?= $kids ? ' class="has-sub"' : '' ?>>
          <a class="navlink<?= $isNavActive($item) ? ' is-active' : '' ?>" <?= $link($item) ?>>
            <?= !empty($item['icon']) ? icon($item['icon']) : '' ?>
            <?= e($item['label']) ?>
            <?= $kids ? icon('chevron') : '' ?>
          </a>
          <?php if ($kids): ?>
            <ul class="sub">
              <?php foreach ($kids as $k): ?>
                <li><a class="navlink" <?= $link($k) ?>><?= e($k['label']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>

  <a class="contact-btn" href="<?= url('/reseller-register') ?>">
    <?= icon('sparkle') ?>
    <?= e($hero['contact'] ?? 'Re-Seller Register') ?>
    <?= icon('arrow') ?>
  </a>
</header>
