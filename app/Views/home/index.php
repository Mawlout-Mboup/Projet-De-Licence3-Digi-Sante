<?php

declare(strict_types=1);

$slides = [
    [
        'image' => 'hero-1.png',
        'badge' => 'SANTE NUMERIQUE',
        'tone' => 'green',
        'title' => 'Bienvenue sur',
        'accent' => 'Digi-Sante',
        'text' => "Plateforme intelligente de surveillance medicale et d'aide au diagnostic en temps reel."
    ],
    [
        'image' => 'hero-2.png',
        'badge' => 'SURVEILLANCE CONTINUE',
        'tone' => 'cyan',
        'title' => 'Suivi des constantes',
        'accent' => 'vitales en temps reel',
        'text' => 'Temperature, tension arterielle, pouls et glycemie surveilles en permanence pour chaque patient.'
    ],
    [
        'image' => 'hero-3.png',
        'badge' => 'ALERTES INTELLIGENTES',
        'tone' => 'red',
        'title' => 'Alertes medicales',
        'accent' => 'automatiques',
        'text' => "Le systeme genere des alertes instantanees des qu'une constante depasse les seuils cliniques definis."
    ],
    [
        'image' => 'hero-4.png',
        'badge' => 'DIAGNOSTICS',
        'tone' => 'blue',
        'title' => 'Diagnostic medical',
        'accent' => 'intelligent',
        'text' => 'Redigez, analysez et archivez des diagnostics complets avec evaluation du risque patient.'
    ],
    [
        'image' => 'hero-5.png',
        'badge' => 'RAPPORTS SECURISES',
        'tone' => 'green',
        'title' => 'Rapports medicaux',
        'accent' => 'securises',
        'text' => 'Generez des rapports PDF complets avec verification et suivi du dossier patient.'
    ]
];

$features = [
    ['icon' => 'fa-solid fa-heart-pulse', 'title' => 'Surveillance des constantes vitales', 'text' => 'Suivi en temps reel de la temperature, tension, pouls, glycemie, saturation et IMC.'],
    ['icon' => 'fa-regular fa-bell', 'title' => 'Alertes medicales automatiques', 'text' => 'Signalement immediat des depassements de seuils pour une reaction rapide.'],
    ['icon' => 'fa-regular fa-clipboard', 'title' => 'Tableau de bord medical', 'text' => 'Vision claire des patients suivis, alertes, diagnostics et rapports.'],
    ['icon' => 'fa-solid fa-file-medical', 'title' => 'Diagnostic intelligent', 'text' => 'Evaluation du risque et archivage des analyses cliniques.'],
    ['icon' => 'fa-regular fa-file-pdf', 'title' => 'Generation PDF securisee', 'text' => 'Rapports medicaux exportables et attaches au dossier patient.'],
    ['icon' => 'fa-solid fa-users', 'title' => 'Suivi des patients', 'text' => 'Gestion des profils, dossiers et historiques de constantes vitales.']
];

$steps = [
    ['icon' => 'fa-regular fa-user', 'title' => 'Collecter compte', 'text' => 'Le patient renseigne ses constantes depuis son espace securise.'],
    ['icon' => 'fa-solid fa-chart-line', 'title' => 'Suivi continu', 'text' => 'Le medecin visualise les tendances et les anomalies.'],
    ['icon' => 'fa-regular fa-bell', 'title' => 'Recevoir les alertes', 'text' => 'Les seuils critiques declenchent une priorite clinique.'],
    ['icon' => 'fa-regular fa-file-pdf', 'title' => 'Generer le rapport', 'text' => 'Le diagnostic est archive sous forme de rapport medical.']
];
?>

<div class="landing-page">
    <section class="hero-slider">
        <header class="landing-topbar">
            <a href="<?= BASE_URL ?>" class="brand-mark">
                <span class="brand-shield"><i class="fa-solid fa-shield-heart"></i></span>
                <span>Digi-Sante</span>
            </a>

            <nav aria-label="Navigation principale">
                <a href="#fonctionnalites">Fonctionnalites</a>
                <a href="#roles">Roles</a>
                <a href="#statistiques">Statistiques</a>
                <a href="#contact">Contact</a>
            </nav>

            <div class="landing-actions">
                <a href="<?= BASE_URL ?>/login/medecin" class="btn-secondary">Se connecter</a>
                <a href="<?= BASE_URL ?>/register/medecin" class="btn-primary">Creer un compte</a>
            </div>
        </header>

        <div class="slider">
            <?php foreach ($slides as $index => $slide): ?>
                <article class="slide <?= $index === 0 ? 'active' : '' ?>">
                    <div class="slide-background" style="background-image:url('<?= IMAGE_PATH ?>/hero/<?= $slide['image'] ?>')"></div>
                    <div class="slide-overlay"></div>
                    <div class="container hero-content">
                        <div class="hero-copy">
                            <span class="eyebrow eyebrow-<?= $slide['tone'] ?>">
                                <i class="fa-solid fa-wave-square"></i>
                                <?= htmlspecialchars($slide['badge']) ?>
                            </span>
                            <h1>
                                <?= htmlspecialchars($slide['title']) ?>
                                <strong><?= htmlspecialchars($slide['accent']) ?></strong>
                            </h1>
                            <p><?= htmlspecialchars($slide['text']) ?></p>
                            <div class="hero-buttons">
                                <?php if ($index === 0): ?>
                                    <a href="<?= BASE_URL ?>/login/medecin" class="btn-primary">Se connecter <i class="fa-solid fa-arrow-right"></i></a>
                                    <a href="<?= BASE_URL ?>/register/medecin" class="btn-secondary">Creer un compte</a>
                                    <a href="#fonctionnalites" class="btn-ghost">Decouvrir <i class="fa-solid fa-arrow-right"></i></a>
                                <?php else: ?>
                                    <a href="#fonctionnalites" class="btn-ghost">En savoir plus <i class="fa-solid fa-arrow-right"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <button id="prevSlide" class="slider-arrow prev" type="button" aria-label="Image precedente">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button id="nextSlide" class="slider-arrow next" type="button" aria-label="Image suivante">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <div class="slider-thumbnails">
            <?php foreach ($slides as $index => $slide): ?>
                <button class="thumbnail <?= $index === 0 ? 'active' : '' ?>" type="button" aria-label="Slide <?= $index + 1 ?>">
                    <img src="<?= IMAGE_PATH ?>/hero/<?= $slide['image'] ?>" alt="">
                </button>
            <?php endforeach; ?>
        </div>

        <div class="slider-indicators">
            <span class="slide-count"><strong>01</strong> / 05</span>
            <?php foreach ($slides as $index => $slide): ?>
                <span class="indicator <?= $index === 0 ? 'active' : '' ?>"></span>
            <?php endforeach; ?>
            <span class="auto-label">AUTO</span>
        </div>

        <div class="progress-wrapper">
            <div id="progressBar" class="progress-bar"></div>
        </div>
    </section>

    <section id="fonctionnalites" class="landing-section">
        <div class="container">
            <div class="section-heading">
                <span>Fonctionnalites cles</span>
                <h2>Surveillance medicale avancee</h2>
                <p>Des outils cliniques concus pour le suivi des patients, la detection des alertes et la generation de rapports.</p>
            </div>

            <div class="feature-grid-numbered">
                <?php foreach ($features as $index => $feature): ?>
                    <article class="numbered-card">
                        <span class="card-number"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                        <i class="<?= $feature['icon'] ?>"></i>
                        <h3><?= htmlspecialchars($feature['title']) ?></h3>
                        <p><?= htmlspecialchars($feature['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="landing-section muted-band">
        <div class="container">
            <div class="section-heading">
                <span>Processus</span>
                <h2>Concu pour les professionnels de sante</h2>
                <p>Une plateforme qui simplifie les operations medicales, de la saisie patient a la decision clinique.</p>
            </div>

            <div class="service-grid">
                <article class="service-card"><i class="fa-solid fa-shield-halved"></i><h3>Securite</h3><p>Sessions securisees et separation claire des roles.</p></article>
                <article class="service-card"><i class="fa-solid fa-table-cells-large"></i><h3>Dashboard</h3><p>Vue de supervision pour medecins et administrateurs.</p></article>
                <article class="service-card"><i class="fa-solid fa-mobile-screen"></i><h3>Multi-plateforme</h3><p>Experience responsive pour ordinateur, tablette et mobile.</p></article>
                <article class="service-card"><i class="fa-solid fa-database"></i><h3>Base clinique</h3><p>Historique structure des constantes et diagnostics.</p></article>
            </div>
        </div>
    </section>

    <section class="landing-section">
        <div class="container">
            <div class="section-heading">
                <span>Comment ca fonctionne</span>
                <h2>Demarrer en 4 etapes simples</h2>
            </div>

            <div class="steps-grid">
                <?php foreach ($steps as $index => $step): ?>
                    <article class="step-card">
                        <span><?= $index + 1 ?></span>
                        <i class="<?= $step['icon'] ?>"></i>
                        <h3><?= htmlspecialchars($step['title']) ?></h3>
                        <p><?= htmlspecialchars($step['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="roles" class="landing-section roles-band">
        <div class="container">
            <div class="section-heading light">
                <span>Espaces utilisateurs</span>
                <h2>Un espace dedie pour chaque acteur</h2>
                <p>Administrateur, medecin et patient disposent chacun d'un parcours clair.</p>
            </div>

            <div class="roles-grid">
                <article class="role-card">
                    <i class="fa-solid fa-user-shield"></i>
                    <h3>Administrateur</h3>
                    <ul>
                        <li>Gestion des comptes</li>
                        <li>Parametres systeme</li>
                        <li>Suivi des statistiques</li>
                    </ul>
                    <a href="<?= BASE_URL ?>/login/admin" class="btn-primary">Voir espace admin</a>
                </article>
                <article class="role-card">
                    <i class="fa-solid fa-user-doctor"></i>
                    <h3>Medecin</h3>
                    <ul>
                        <li>Surveillance patients</li>
                        <li>Gestion des alertes</li>
                        <li>Diagnostics et rapports PDF</li>
                    </ul>
                    <a href="<?= BASE_URL ?>/login/medecin" class="btn-primary">Voir espace medecin</a>
                </article>
                <article class="role-card">
                    <i class="fa-solid fa-hospital-user"></i>
                    <h3>Patient</h3>
                    <ul>
                        <li>Saisie des constantes</li>
                        <li>Historique personnel</li>
                        <li>Notifications de suivi</li>
                    </ul>
                    <a href="<?= BASE_URL ?>/login/patient" class="btn-primary">Voir espace patient</a>
                </article>
            </div>
        </div>
    </section>

    <section id="statistiques" class="stats-band">
        <div class="container stats-grid">
            <article><strong>1200+</strong><span>Patients suivis</span></article>
            <article><strong>4800+</strong><span>Diagnostics traites</span></article>
            <article><strong>98%</strong><span>Alertes resolues</span></article>
            <article><strong>24</strong><span>Heures de suivi</span></article>
        </div>
    </section>

    <section class="landing-section mission-section">
        <div class="container mission-grid">
            <article>
                <span class="section-pill">A propos de Digi-Sante</span>
                <h2>La sante numerique au service du patient</h2>
                <p>
                    Digi-Sante est une plateforme de surveillance medicale intelligente
                    concue pour centraliser les donnees de sante, faciliter le suivi
                    a distance et accelerer la reaction du personnel soignant.
                </p>
                <a href="<?= BASE_URL ?>/about" class="btn-primary">Voir fonctionnement</a>
            </article>
            <div class="mission-cards">
                <article><i class="fa-solid fa-stethoscope"></i><h3>Temps reel</h3><p>Lecture rapide des constantes.</p></article>
                <article><i class="fa-solid fa-lock"></i><h3>Securite</h3><p>Acces par role et sessions.</p></article>
                <article><i class="fa-solid fa-chart-simple"></i><h3>Analyse</h3><p>Indicateurs et priorites.</p></article>
                <article><i class="fa-solid fa-file-pdf"></i><h3>Export</h3><p>Rapports medicaux PDF.</p></article>
            </div>
        </div>
    </section>

    <section id="contact" class="landing-section contact-section">
        <div class="container">
            <div class="section-heading">
                <span>Nous contacter</span>
                <h2>Besoin d'aide ?</h2>
                <p>Notre equipe peut vous accompagner dans la prise en main de Digi-Sante.</p>
            </div>

            <div class="contact-grid">
                <aside class="contact-info">
                    <a href="mailto:contact@digi-sante.sn"><i class="fa-regular fa-envelope"></i> contact@digi-sante.sn</a>
                    <a href="tel:+221770000000"><i class="fa-solid fa-phone"></i> +221 77 000 00 00</a>
                    <span><i class="fa-solid fa-location-dot"></i> Dakar, Senegal</span>
                </aside>
                <form class="contact-form" action="<?= BASE_URL ?>/contact" method="GET">
                    <div class="form-grid">
                        <label>Nom complet<input type="text" placeholder="Votre nom"></label>
                        <label>Email<input type="email" placeholder="email@exemple.sn"></label>
                        <label class="full">Sujet<input type="text" placeholder="Demande d'information"></label>
                        <label class="full">Message<textarea placeholder="Votre message"></textarea></label>
                        <button class="btn-primary full" type="submit">Envoyer le message</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="landing-section testimonials-section">
        <div class="container">
            <div class="section-heading">
                <span>Temoignages</span>
                <h2>Ce que disent les utilisateurs</h2>
            </div>
            <div class="testimonials-grid">
                <article><strong>MED-001</strong><p>Le tableau de bord facilite le suivi des patients a risque.</p></article>
                <article><strong>PAT-002</strong><p>Je peux saisir mes constantes sans attendre ma prochaine consultation.</p></article>
                <article><strong>Admin</strong><p>Les profils et alertes sont mieux organises.</p></article>
            </div>
        </div>
    </section>

    <section class="landing-section partners-section">
        <div class="container">
            <div class="section-heading">
                <span>Partenaires et etablissements</span>
                <h2>Un ecosysteme de confiance</h2>
            </div>
            <div class="partners-row">
                <span>Clinique</span>
                <span>Hopital</span>
                <span>Urgences</span>
                <span>Cardiologie</span>
                <span>Laboratoire</span>
                <span>Telemedecine</span>
            </div>
        </div>
    </section>

    <section class="landing-section faq-section">
        <div class="container">
            <div class="section-heading">
                <span>FAQ</span>
                <h2>Questions frequentes</h2>
            </div>
            <div class="faq-list">
                <details open><summary>Qui peut utiliser Digi-Sante ?</summary><p>Les administrateurs, medecins et patients disposant d'un compte.</p></details>
                <details><summary>Comment sont gerees les alertes medicales ?</summary><p>Les constantes sont comparees aux seuils cliniques definis dans la plateforme.</p></details>
                <details><summary>Les rapports PDF sont-ils disponibles ?</summary><p>Oui, les diagnostics peuvent etre associes a des rapports medicaux.</p></details>
                <details><summary>Est-ce adapte au mobile ?</summary><p>Oui, l'interface est responsive pour ordinateur, tablette et mobile.</p></details>
            </div>
        </div>
    </section>

    <section class="landing-section landing-cta">
        <div class="container">
            <span class="section-pill">Pret a commencer ?</span>
            <h2>Rejoignez la plateforme</h2>
            <p>Une plateforme medicale intelligente concue pour transformer le suivi des patients au Senegal.</p>
            <div class="hero-buttons center">
                <a href="<?= BASE_URL ?>/register/medecin" class="btn-primary">Creer un compte</a>
                <a href="<?= BASE_URL ?>/login/medecin" class="btn-secondary">Se connecter</a>
            </div>
            <div class="price-row">
                <strong>Gratuit</strong>
                <strong>3 roles</strong>
                <strong>12+ modules</strong>
            </div>
        </div>
    </section>

    <footer class="landing-footer">
        <div class="container footer-grid">
            <div>
                <a href="<?= BASE_URL ?>" class="brand-mark">
                    <span class="brand-shield"><i class="fa-solid fa-shield-heart"></i></span>
                    <span>Digi-Sante</span>
                </a>
                <p>Plateforme intelligente de surveillance medicale et de diagnostic.</p>
            </div>
            <div><strong>Navigation</strong><a href="#fonctionnalites">Fonctionnalites</a><a href="#roles">Roles</a><a href="#contact">Contact</a></div>
            <div><strong>Espaces</strong><a href="<?= BASE_URL ?>/login/admin">Administrateur</a><a href="<?= BASE_URL ?>/login/medecin">Medecin</a><a href="<?= BASE_URL ?>/login/patient">Patient</a></div>
            <div><strong>Modules</strong><a href="<?= BASE_URL ?>/alertes">Alertes</a><a href="<?= BASE_URL ?>/diagnostics">Diagnostics</a><a href="<?= BASE_URL ?>/rapports">Rapports</a></div>
        </div>
    </footer>
</div>
