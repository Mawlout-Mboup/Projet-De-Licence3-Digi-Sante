<?php

declare(strict_types=1);

$roles = $roles ?? [
    1 => ['slug' => 'admin', 'label' => 'Admin', 'title' => 'Administrateur'],
    2 => ['slug' => 'medecin', 'label' => 'Medecin', 'title' => 'Medecin'],
    3 => ['slug' => 'patient', 'label' => 'Patient', 'title' => 'Patient']
];
$selectedRole = (int) ($selectedRole ?? 2);
?>

<section class="auth-page">
    <div class="auth-wrap">
        <a href="<?= BASE_URL ?>" class="auth-brand">
            <span class="brand-shield"><i class="fa-solid fa-shield-heart"></i></span>
            <span>
                <strong>Digi-Sante</strong>
                <small>Senegal / Sante numerique</small>
            </span>
        </a>

        <div class="auth-card">
            <header>
                <h1>Connexion <?= htmlspecialchars($roles[$selectedRole]['label']) ?></h1>
                <p>Accedez a votre espace <?= htmlspecialchars(strtolower($roles[$selectedRole]['title'])) ?></p>
            </header>

            <form class="auth-form" action="<?= BASE_URL ?>/login" method="POST">
                <fieldset class="auth-fieldset">
                    <legend>Role</legend>
                    <input type="hidden" name="role_id" value="<?= $selectedRole ?>">
                    <div class="role-pills role-links" aria-label="Role utilisateur">
                        <?php foreach ($roles as $id => $role): ?>
                            <a class="<?= $id === $selectedRole ? 'is-active' : '' ?>" href="<?= BASE_URL ?>/login/<?= htmlspecialchars($role['slug']) ?>">
                                <?= htmlspecialchars($role['label']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <label>
                    Email ou telephone
                    <span class="input-control">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="text" name="identifiant" placeholder="email@exemple.com ou 77 000 00 00" autocomplete="username" required>
                    </span>
                </label>

                <label>
                    Mot de passe
                    <span class="input-control">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="mot_de_passe" placeholder="••••••••" required>
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </label>

                <div class="auth-options">
                    <label class="remember-line">
                        <input type="checkbox" name="remember">
                        <span>Se souvenir</span>
                    </label>
                    <a href="<?= BASE_URL ?>/forgot-password">Mot de passe oublie ?</a>
                </div>

                <button type="submit" class="btn-primary auth-submit">
                    Se connecter
                </button>
            </form>

            <p class="auth-switch">
                Pas encore de compte ?
                <a class="auth-link" href="<?= BASE_URL ?>/register/<?= htmlspecialchars($roles[$selectedRole]['slug']) ?>">Creer un compte</a>
            </p>
        </div>

        <a class="auth-back" href="<?= BASE_URL ?>">
            <i class="fa-solid fa-arrow-left"></i>
            Retour a l'accueil
        </a>
    </div>
</section>
