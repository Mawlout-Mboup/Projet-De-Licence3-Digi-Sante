<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\Utilisateur;
use App\Models\Diagnostic;
use App\Models\Alerte;

class AdminController extends Controller
{
    public function index(): void
    {
        $this->requireRole(1);

        $patient = new Patient();

        $medecin = new Medecin();

        $utilisateur = new Utilisateur();

        $diagnostic = new Diagnostic();

        $alerte = new Alerte();

        $this->view('admin/index', [

            'title' => 'Administration',

            'patients' => $patient->total(),

            'medecins' => $medecin->total(),

            'utilisateurs' => $utilisateur->count(),

            'diagnostics' => $diagnostic->total(),

            'alertes' => $alerte->total()

        ]);
    }
}