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
    <div class="auth-wrap auth-wrap-register">
        <a href="<?= BASE_URL ?>" class="auth-brand">
            <span class="brand-shield"><i class="fa-solid fa-shield-heart"></i></span>
            <span>
                <strong>Digi-Sante</strong>
                <small>Senegal / Sante numerique</small>
            </span>
        </a>

        <div class="auth-card">
            <header>
                <h1>Inscription <?= htmlspecialchars($roles[$selectedRole]['label']) ?></h1>
                <p>Creez votre compte <?= htmlspecialchars(strtolower($roles[$selectedRole]['title'])) ?></p>
            </header>

            <form class="auth-form" action="<?= BASE_URL ?>/register" method="POST">
                <fieldset class="auth-fieldset">
                    <legend>Type de compte</legend>
                    <input type="hidden" name="role_id" value="<?= $selectedRole ?>">
                    <div class="role-pills role-links" aria-label="Type de compte">
                        <?php foreach ($roles as $id => $role): ?>
                            <a class="<?= $id === $selectedRole ? 'is-active' : '' ?>" href="<?= BASE_URL ?>/register/<?= htmlspecialchars($role['slug']) ?>">
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
                    Nom complet
                    <span class="input-control">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" name="nom_complet" placeholder="Nom complet" required>
                    </span>
                </label>

                <label>
                    Email
                    <span class="input-control">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" placeholder="votre@email.com" autocomplete="email">
                    </span>
                </label>

                <label>
                    Telephone
                    <span class="input-control">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="telephone" placeholder="+221 7X XXX XX XX" autocomplete="tel">
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

                <label>
                    Confirmer le mot de passe
                    <span class="input-control">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="mot_de_passe_confirmation" placeholder="••••••••" required>
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </label>

                <label class="terms-line">
                    <input type="checkbox" name="conditions" required>
                    <span>J'accepte les <a href="<?= BASE_URL ?>/contact">conditions d'utilisation</a> et la <a href="<?= BASE_URL ?>/contact">politique de confidentialite</a></span>
                </label>

                <button type="submit" class="btn-primary auth-submit">
                    Creer mon compte
                </button>
            </form>
        </div>

        <a class="auth-back" href="<?= BASE_URL ?>">
            <i class="fa-solid fa-arrow-left"></i>
            Retour a l'accueil
        </a>
    </div>
</section>
