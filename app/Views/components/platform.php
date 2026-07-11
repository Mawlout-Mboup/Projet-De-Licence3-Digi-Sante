<?php

declare(strict_types=1);

if (!function_exists('ds_e')) {
    function ds_e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    function ds_asset(string $path): string
    {
        return ASSET_PATH . '/' . ltrim($path, '/');
    }

    function ds_user(): array
    {
        return $_SESSION['user'] ?? [
            'id' => 2,
            'prenom' => 'Amadou',
            'nom' => 'Fall',
            'role_id' => 2,
            'email' => 'medecin@digi-sante.sn'
        ];
    }

    function ds_role_name(int|string|null $roleId): string
    {
        return match ((int) $roleId) {
            1 => 'Administrateur',
            2 => 'Medecin',
            3 => 'Patient',
            default => 'Equipe medicale'
        };
    }

    function ds_dashboard_url(): string
    {
        $roleId = (int) (ds_user()['role_id'] ?? 2);

        return match ($roleId) {
            1 => BASE_URL . '/dashboard/admin',
            3 => BASE_URL . '/dashboard/patient',
            default => BASE_URL . '/dashboard/medecin'
        };
    }

    function ds_active(string $needle): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';

        return str_contains($uri, $needle) ? 'is-active' : '';
    }

    function ds_badge_class(string $value): string
    {
        $value = strtoupper($value);

        return match ($value) {
            'CRITIQUE', 'ELEVE', 'BLOQUE' => 'danger',
            'MOYEN', 'EN_ATTENTE', 'NOUVELLE', 'PRISE_EN_CHARGE', 'ATTENTION', 'INDISPONIBLE' => 'warning',
            'VALIDE', 'RESOLUE', 'ACTIF', 'STABLE', 'NORMAL', 'DISPONIBLE', 'ARCHIVE' => 'success',
            default => 'muted'
        };
    }

    function ds_badge(string $label): string
    {
        return '<span class="status-badge status-' .
            ds_badge_class($label) .
            '">' . ds_e($label) . '</span>';
    }

    function ds_nav_items(): array
    {
        $roleId = (int) (ds_user()['role_id'] ?? 2);

        $common = [
            ['needle' => '/notifications', 'url' => BASE_URL . '/notifications', 'icon' => 'fa-regular fa-message', 'label' => 'Notifications'],
            ['needle' => '/profil', 'url' => BASE_URL . '/profil', 'icon' => 'fa-regular fa-user', 'label' => 'Mon profil']
        ];

        $items = match ($roleId) {
            1 => [
                ['needle' => '/dashboard', 'url' => BASE_URL . '/dashboard/admin', 'icon' => 'fa-solid fa-table-cells-large', 'label' => 'Dashboard'],
                ['needle' => '/medecin', 'url' => BASE_URL . '/medecins', 'icon' => 'fa-solid fa-user-doctor', 'label' => 'Medecins'],
                ['needle' => '/patients', 'url' => BASE_URL . '/patients', 'icon' => 'fa-solid fa-users', 'label' => 'Patients'],
                ['needle' => '/alertes', 'url' => BASE_URL . '/alertes', 'icon' => 'fa-regular fa-bell', 'label' => 'Alertes', 'badge' => '4'],
                ['needle' => '/diagnostic', 'url' => BASE_URL . '/diagnostics', 'icon' => 'fa-regular fa-clipboard', 'label' => 'Diagnostics'],
                ['needle' => '/rapports', 'url' => BASE_URL . '/rapports', 'icon' => 'fa-regular fa-file-pdf', 'label' => 'Rapports PDF'],
                ['needle' => '/constante', 'url' => BASE_URL . '/constantes', 'icon' => 'fa-solid fa-heart-pulse', 'label' => 'Constantes'],
                ['needle' => '/statistiques', 'url' => BASE_URL . '/statistiques', 'icon' => 'fa-solid fa-chart-line', 'label' => 'Statistiques'],
                ['needle' => '/parametres', 'url' => BASE_URL . '/parametres', 'icon' => 'fa-solid fa-sliders', 'label' => 'Parametres']
            ],
            3 => [
                ['needle' => '/dashboard', 'url' => BASE_URL . '/dashboard/patient', 'icon' => 'fa-solid fa-table-cells-large', 'label' => 'Dashboard'],
                ['needle' => '/constante', 'url' => BASE_URL . '/constantes', 'icon' => 'fa-solid fa-heart-pulse', 'label' => 'Mes constantes']
            ],
            default => [
                ['needle' => '/dashboard', 'url' => BASE_URL . '/dashboard/medecin', 'icon' => 'fa-solid fa-table-cells-large', 'label' => 'Dashboard'],
                ['needle' => '/patients', 'url' => BASE_URL . '/patients', 'icon' => 'fa-solid fa-users', 'label' => 'Mes patients'],
                ['needle' => '/alertes', 'url' => BASE_URL . '/alertes', 'icon' => 'fa-regular fa-bell', 'label' => 'Alertes', 'badge' => '4'],
                ['needle' => '/diagnostic', 'url' => BASE_URL . '/diagnostics', 'icon' => 'fa-regular fa-clipboard', 'label' => 'Diagnostics'],
                ['needle' => '/rapports', 'url' => BASE_URL . '/rapports', 'icon' => 'fa-regular fa-file-pdf', 'label' => 'Rapports PDF'],
                ['needle' => '/constante', 'url' => BASE_URL . '/constantes', 'icon' => 'fa-solid fa-heart-pulse', 'label' => 'Constantes'],
                ['needle' => '/statistiques', 'url' => BASE_URL . '/statistiques', 'icon' => 'fa-solid fa-chart-line', 'label' => 'Statistiques']
            ]
        };

        return array_merge($items, $common);
    }

    function ds_app_start(string $title, string $subtitle = '', string $actions = ''): void
    {
        $user = ds_user();
        $role = ds_role_name($user['role_id'] ?? null);
        ?>
        <div class="app-shell">
            <aside class="app-sidebar">
                <a href="<?= BASE_URL ?>" class="brand-mark">
                    <span class="brand-shield"><i class="fa-solid fa-shield-heart"></i></span>
                    <span>Digi-Sante</span>
                </a>

                <p class="sidebar-role">Espace <?= ds_e($role) ?></p>

                <nav class="sidebar-nav" aria-label="Navigation plateforme">
                    <?php foreach (ds_nav_items() as $item): ?>
                        <a class="<?= ds_active($item['needle']) ?>" href="<?= ds_e($item['url']) ?>">
                            <i class="<?= ds_e($item['icon']) ?>"></i>
                            <span><?= ds_e($item['label']) ?></span>
                            <?php if (!empty($item['badge'])): ?>
                                <strong><?= ds_e($item['badge']) ?></strong>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <div class="sidebar-profile">
                    <span><?= ds_e(substr((string) ($user['prenom'] ?? 'D'), 0, 1)) ?><?= ds_e(substr((string) ($user['nom'] ?? 'S'), 0, 1)) ?></span>
                    <div>
                        <strong><?= ds_e(($user['prenom'] ?? 'Equipe') . ' ' . ($user['nom'] ?? 'Digi-Sante')) ?></strong>
                        <small><?= ds_e($role) ?></small>
                    </div>
                </div>

                <a class="sidebar-logout" href="<?= BASE_URL ?>/logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Deconnexion</span>
                </a>
            </aside>

            <main class="app-main">
                <header class="app-topbar">
                    <div>
                        <h1><?= ds_e($title) ?></h1>
                        <?php if ($subtitle !== ''): ?>
                            <p><?= ds_e($subtitle) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="topbar-actions">
                        <?= $actions ?>
                        <a class="icon-button" href="<?= BASE_URL ?>/notifications" aria-label="Notifications">
                            <i class="fa-regular fa-bell"></i>
                            <span></span>
                        </a>
                    </div>
                </header>
        <?php
    }

    function ds_app_end(): void
    {
        ?>
                <footer class="app-footer">
                    <strong><i class="fa-solid fa-shield-heart"></i> Digi-Sante</strong>
                    <span>Sante numerique - Senegal</span>
                    <span>2026 - Projet de fin d'etudes</span>
                </footer>
            </main>
        </div>
        <?php
    }

    function ds_stat_card(string $icon, string $label, string|int $value, string $tone = 'green', string $hint = ''): void
    {
        ?>
        <article class="metric-card metric-<?= ds_e($tone) ?>">
            <span><i class="<?= ds_e($icon) ?>"></i></span>
            <small><?= ds_e($hint) ?></small>
            <strong><?= ds_e($value) ?></strong>
            <p><?= ds_e($label) ?></p>
        </article>
        <?php
    }

    function ds_demo_patients(): array
    {
        return [
            ['utilisateur_id' => 1, 'numero_dossier' => 'PAT-0001', 'prenom' => 'Awa', 'nom' => 'Diop', 'email' => 'awa.diop@example.sn', 'telephone' => '77 100 10 01', 'sexe' => 'FEMME', 'date_naissance' => '1974-03-12', 'profession' => 'Commercante', 'adresse' => 'Dakar'],
            ['utilisateur_id' => 2, 'numero_dossier' => 'PAT-0002', 'prenom' => 'Moussa', 'nom' => 'Sarr', 'email' => 'moussa.sarr@example.sn', 'telephone' => '77 100 10 02', 'sexe' => 'HOMME', 'date_naissance' => '1954-11-08', 'profession' => 'Retraite', 'adresse' => 'Thies'],
            ['utilisateur_id' => 3, 'numero_dossier' => 'PAT-0003', 'prenom' => 'Fatou', 'nom' => 'Diop', 'email' => 'fatou.diop@example.sn', 'telephone' => '77 100 10 03', 'sexe' => 'FEMME', 'date_naissance' => '1998-05-14', 'profession' => 'Etudiante', 'adresse' => 'Dakar'],
            ['utilisateur_id' => 4, 'numero_dossier' => 'PAT-0004', 'prenom' => 'Cheikh', 'nom' => 'Ndao', 'email' => 'cheikh.ndao@example.sn', 'telephone' => '77 100 10 04', 'sexe' => 'HOMME', 'date_naissance' => '1967-12-25', 'profession' => 'Enseignant', 'adresse' => 'Saint-Louis'],
            ['utilisateur_id' => 5, 'numero_dossier' => 'PAT-0005', 'prenom' => 'Mame', 'nom' => 'Ba', 'email' => 'mame.ba@example.sn', 'telephone' => '77 100 10 05', 'sexe' => 'FEMME', 'date_naissance' => '1982-01-30', 'profession' => 'Ingenieure', 'adresse' => 'Rufisque']
        ];
    }

    function ds_demo_constantes(): array
    {
        return [
            ['id' => 1, 'patient_id' => 3, 'prenom' => 'Fatou', 'nom' => 'Diop', 'date_mesure' => '2026-06-29 08:30:00', 'temperature' => '36.8', 'tension_systolique' => '120', 'tension_diastolique' => '80', 'pouls' => '72', 'saturation' => '98', 'glycemie' => '0.98', 'imc' => '22.5', 'commentaire' => 'Mesure normale'],
            ['id' => 2, 'patient_id' => 1, 'prenom' => 'Awa', 'nom' => 'Diop', 'date_mesure' => '2026-06-29 09:15:00', 'temperature' => '39.2', 'tension_systolique' => '165', 'tension_diastolique' => '95', 'pouls' => '104', 'saturation' => '94', 'glycemie' => '1.42', 'imc' => '27.1', 'commentaire' => 'A surveiller'],
            ['id' => 3, 'patient_id' => 2, 'prenom' => 'Moussa', 'nom' => 'Sarr', 'date_mesure' => '2026-06-28 08:15:00', 'temperature' => '37.1', 'tension_systolique' => '145', 'tension_diastolique' => '88', 'pouls' => '82', 'saturation' => '96', 'glycemie' => '1.21', 'imc' => '24.7', 'commentaire' => 'Tension haute']
        ];
    }

    function ds_demo_alertes(): array
    {
        return [
            ['id' => 1, 'patient_id' => 1, 'niveau' => 'CRITIQUE', 'titre' => 'Temperature elevee', 'message' => '39.2 C detectes chez Awa Diop.', 'statut' => 'NOUVELLE', 'date_alerte' => '2026-06-29 09:20:00'],
            ['id' => 2, 'patient_id' => 2, 'niveau' => 'ELEVE', 'titre' => 'Tension arterielle', 'message' => 'Mesure 165/95 mmHg a surveiller.', 'statut' => 'PRISE_EN_CHARGE', 'date_alerte' => '2026-06-29 09:15:00'],
            ['id' => 3, 'patient_id' => 5, 'niveau' => 'MOYEN', 'titre' => 'Glycemie', 'message' => 'Valeur superieure au seuil normal.', 'statut' => 'RESOLUE', 'date_alerte' => '2026-06-28 16:30:00']
        ];
    }

    function ds_demo_diagnostics(): array
    {
        return [
            ['id' => 1, 'patient_id' => 1, 'medecin_id' => 2, 'titre' => 'Surveillance hypertension', 'description' => 'Controle de tension et suivi des constantes sur 7 jours.', 'gravite' => 'MOYEN', 'statut' => 'EN_ATTENTE', 'date_diagnostic' => '2026-06-29 10:00:00'],
            ['id' => 2, 'patient_id' => 2, 'medecin_id' => 2, 'titre' => 'Suspicion de crise glycemique', 'description' => 'Glycemie elevee avec fatigue signalee.', 'gravite' => 'ELEVE', 'statut' => 'VALIDE', 'date_diagnostic' => '2026-06-28 11:20:00'],
            ['id' => 3, 'patient_id' => 3, 'medecin_id' => 2, 'titre' => 'Bilan stable', 'description' => 'Constantes normales, poursuite du protocole.', 'gravite' => 'FAIBLE', 'statut' => 'ARCHIVE', 'date_diagnostic' => '2026-06-27 08:45:00']
        ];
    }

    function ds_demo_rapports(): array
    {
        return [
            ['id' => 1, 'patient_id' => 1, 'medecin_id' => 2, 'titre' => 'Rapport clinique - Awa Diop', 'type' => 'Diagnostic PDF', 'date_generation' => '2026-06-29 10:15:00'],
            ['id' => 2, 'patient_id' => 2, 'medecin_id' => 2, 'titre' => 'Historique des constantes', 'type' => 'Suivi patient', 'date_generation' => '2026-06-28 17:10:00'],
            ['id' => 3, 'patient_id' => 3, 'medecin_id' => 2, 'titre' => 'Synthese hebdomadaire', 'type' => 'Rapport hebdomadaire', 'date_generation' => '2026-06-27 12:00:00']
        ];
    }
}
