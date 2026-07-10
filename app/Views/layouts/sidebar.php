<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';
?>
<aside class="app-sidebar">
    <a href="<?= ds_dashboard_url() ?>" class="brand-mark">
        <span class="brand-shield"><i class="fa-solid fa-shield-heart"></i></span>
        <span>Digi-Sante</span>
    </a>

    <nav class="sidebar-nav" aria-label="Navigation plateforme">
        <?php foreach (ds_nav_items() as $item): ?>
            <a class="<?= ds_active($item['needle']) ?>" href="<?= ds_e($item['url']) ?>">
                <i class="<?= ds_e($item['icon']) ?>"></i>
                <span><?= ds_e($item['label']) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
</aside>
