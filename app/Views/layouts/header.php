<?php

declare(strict_types=1);
?>
<header class="app-topbar">
    <div>
        <h1><?= htmlspecialchars($title ?? APP_NAME) ?></h1>
        <?php if (!empty($subtitle)): ?>
            <p><?= htmlspecialchars($subtitle) ?></p>
        <?php endif; ?>
    </div>
</header>
