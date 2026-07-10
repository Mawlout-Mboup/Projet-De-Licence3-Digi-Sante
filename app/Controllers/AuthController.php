<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Utilisateur;

class AuthController extends Controller
{
    private Utilisateur $utilisateur;

    private array $roles = [
        1 => ['slug' => 'admin', 'label' => 'Admin', 'title' => 'Administrateur'],
        2 => ['slug' => 'medecin', 'label' => 'Medecin', 'title' => 'Medecin'],
        3 => ['slug' => 'patient', 'label' => 'Patient', 'title' => 'Patient']
    ];

    public function __construct()
    {
        $this->utilisateur = new Utilisateur();
    }

    private function telephoneValide(string $telephone): bool
    {
        $digits = preg_replace('/\D+/', '', $telephone) ?? '';

        return strlen($digits) >= 7 && strlen($digits) <= 15;
    }

    public function login(): void
    {
        $this->showLogin(2);
    }

    public function loginAdmin(): void
    {
        $this->showLogin(1);
    }

    public function loginMedecin(): void
    {
        $this->showLogin(2);
    }

    public function loginPatient(): void
    {
        $this->showLogin(3);
    }

    private function showLogin(int $roleId, string $error = ''): void
    {
        if ($this->auth()) {
            $this->redirect($this->dashboardPathForRole());
        }

        $this->view('auth/login', [

            'title' => 'Connexion ' . $this->roles[$roleId]['title'],

            'selectedRole' => $roleId,

            'roles' => $this->roles,

            'error' => $error

        ]);
    }

    public function authenticate(): void
    {
        if (!$this->isPost()) {

            $this->redirect('login');

        }

        $identifiant = trim(
            (string) $this->input(
                'identifiant',
                $this->input('email', '')
            )
        );

        $password = (string) $this->input('mot_de_passe');

        $roleId = (int) $this->input('role_id', 0);

        if ($identifiant === '' || $password === '') {

            $this->showLogin($roleId > 0 ? $roleId : 2, 'Veuillez remplir tous les champs.');

            return;

        }

        $user = $this->utilisateur->authenticate(

            $identifiant,

            $password

        );

        if (!$user) {

            $this->showLogin($roleId > 0 ? $roleId : 2, 'Email, telephone ou mot de passe incorrect.');

            return;

        }

        if ($roleId > 0 && (int) $user['role_id'] !== $roleId) {

            $this->showLogin($roleId, 'Ce compte ne correspond pas au role selectionne.');

            return;

        }

        $_SESSION['user'] = $user;

        switch ((int) $user['role_id']) {

            case 1:

                $this->redirect('dashboard/admin');

                break;

            case 2:

                $this->redirect('dashboard/medecin');

                break;

            case 3:

                $this->redirect('dashboard/patient');

                break;

            default:

                $this->redirect('dashboard');

        }
    }

    public function register(): void
    {
        $this->showRegister(2);
    }

    public function registerAdmin(): void
    {
        $this->showRegister(1);
    }

    public function registerMedecin(): void
    {
        $this->showRegister(2);
    }

    public function registerPatient(): void
    {
        $this->showRegister(3);
    }

    private function showRegister(int $roleId, string $error = ''): void
    {
        $this->view('auth/register', [

            'title' => 'Inscription ' . $this->roles[$roleId]['title'],

            'selectedRole' => $roleId,

            'roles' => $this->roles,

            'error' => $error

        ]);
    }

    public function store(): void
    {
        if (!$this->isPost()) {

            $this->redirect('register');

        }

        $nomComplet = trim((string) $this->input('nom_complet'));
        $parts = preg_split('/\s+/', $nomComplet, 2) ?: [];
        $password = (string) $this->input('mot_de_passe');
        $confirmation = (string) $this->input('mot_de_passe_confirmation');
        $roleId = (int) $this->input('role_id');

        if ($nomComplet === '' || $roleId < 1 || $roleId > 3 || $password === '') {

            $this->showRegister($roleId >= 1 && $roleId <= 3 ? $roleId : 2, 'Veuillez remplir tous les champs obligatoires.');

            return;

        }

        if ($password !== $confirmation) {

            $this->showRegister($roleId, 'Les mots de passe ne correspondent pas.');

            return;

        }

        $email = strtolower(trim((string) $this->input('email')));
        $telephone = trim((string) $this->input('telephone'));

        if ($email === '' && $telephone === '') {

            $this->showRegister($roleId, 'Renseignez un email valide ou un numero de telephone.');

            return;

        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->showRegister($roleId, 'Veuillez saisir un email valide.');

            return;

        }

        if ($telephone !== '' && !$this->telephoneValide($telephone)) {

            $this->showRegister($roleId, 'Veuillez saisir un numero de telephone valide.');

            return;

        }

        $data = [

            'role_id' => $roleId,

            'prenom' => $parts[0] ?? $nomComplet,

            'nom' => $parts[1] ?? '',

            'email' => $email !== '' ? $email : null,

            'telephone' => $telephone !== '' ? $telephone : null,

            'mot_de_passe' => $password

        ];

        if ($email !== '' && $this->utilisateur->emailExiste($email)) {

            $this->showRegister($roleId, 'Cet email existe deja.');

            return;

        }

        if ($telephone !== '' && $this->utilisateur->telephoneExiste($telephone)) {

            $this->showRegister($roleId, 'Ce numero de telephone existe deja.');

            return;

        }

        try {

            $this->utilisateur->createUser($data);

        } catch (\Throwable) {

            $this->showRegister($roleId, 'Impossible de creer le compte. Verifiez les informations et reessayez.');

            return;

        }

        $this->redirect('login/' . $this->roles[$roleId]['slug']);
    }

    public function logout(): void
    {
        $this->destroySession();

        $this->redirect('login');
    }
}