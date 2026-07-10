<?php

declare(strict_types=1);
?>

<main class="auth-page">
    <section class="auth-panel">
        <a class="auth-brand" href="<?= BASE_URL ?>">
            <i class="fa-solid fa-shield-heart"></i>
            <span>Digi-Sante</span>
        </a>

        <div class="auth-heading">
            <span>Recuperation</span>
            <h1>Mot de passe oublie</h1>
            <p>Renseignez votre email ou votre numero de telephone. L'equipe administratrice vous aidera a securiser le compte.</p>
        </div>

        <?php if (!empty($message)) : ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" action="<?= BASE_URL ?>/forgot-password" method="POST">
            <label>
                Email ou telephone
                <input type="text" name="identifiant" autocomplete="username" required>
            </label>

            <button class="btn-primary" type="submit">
                <i class="fa-regular fa-paper-plane"></i>
                Envoyer la demande
            </button>
        </form>

        <p class="auth-switch">
            <a href="<?= BASE_URL ?>/login">Retour a la connexion</a>
        </p>
    </section>
</main>
