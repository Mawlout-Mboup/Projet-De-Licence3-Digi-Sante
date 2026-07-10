<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title><?= isset($title) ? htmlspecialchars($title) . ' - ' . APP_NAME : APP_NAME ?></title>

    <meta
        name="description"
        content="Digi-Santé - Plateforme intelligente de surveillance des constantes vitales">

    <!-- CSS GLOBAL -->

    <link
        rel="stylesheet"
        href="<?= CSS_PATH ?>/style.css">

    <link
        rel="stylesheet"
        href="<?= CSS_PATH ?>/responsive.css">

    <link
        rel="stylesheet"
        href="<?= CSS_PATH ?>/auth.css">

    <link
        rel="stylesheet"
        href="<?= CSS_PATH ?>/dashboard.css">

    <!-- CSS LANDING PAGE -->

    <link
        rel="stylesheet"
        href="<?= CSS_PATH ?>/home.css">

    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?= $content ?? '' ?>

<!-- JS GLOBAL -->

<script src="<?= JS_PATH ?>/app.js"></script>

<script src="<?= JS_PATH ?>/validation.js"></script>

<script src="<?= JS_PATH ?>/alerts.js"></script>

<script src="<?= JS_PATH ?>/dashboard.js"></script>

<!-- JS LANDING PAGE -->

<script src="<?= JS_PATH ?>/home.js"></script>

</body>

</html>
