<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\Alerte;
use App\Models\Diagnostic;
use App\Models\ConstanteVitale;
use App\Models\Notification;

class DashboardController extends Controller
{
    private Patient $patient;

    private Medecin $medecin;

    private Alerte $alerte;

    private Diagnostic $diagnostic;

    private ConstanteVitale $constante;

    private Notification $notification;

    public function __construct()
    {
        $this->patient = new Patient();

        $this->medecin = new Medecin();

        $this->alerte = new Alerte();

        $this->diagnostic = new Diagnostic();

        $this->constante = new ConstanteVitale();

        $this->notification = new Notification();
    }

    public function index(): void
    {
        $this->requireAuth();

        $this->redirect($this->dashboardPathForRole());
    }

    public function admin(): void
    {
        $this->requireRole(1);

        $this->view('dashboard/admin', [

            'title' => 'Dashboard Administrateur',

            'user' => $this->user(),

            'patients' => $this->patient->total(),

            'medecins' => $this->medecin->total(),

            'alertes' => $this->alerte->dashboard(),

            'diagnostics' => $this->diagnostic->dashboard()

        ]);
    }

    public function medecin(): void
    {
        $this->requireRole(2);

        $utilisateur = $this->user();

        $notifications = $this->notification->nonLues(

            (int) $utilisateur['id']

        );

        $this->view('dashboard/medecin', [

            'title' => 'Dashboard Médecin',

            'user' => $utilisateur,

            'notifications' => $notifications,

            'alertes' => $this->alerte->critiques(),

            'constantes' => $this->constante->dernieres(10)

        ]);
    }

    public function patient(): void
    {
        $this->requireRole(3);

        $utilisateur = $this->user();

        $this->view('dashboard/patient', [

            'title' => 'Dashboard Patient',

            'user' => $utilisateur,

            'constantes' => $this->constante->getByPatient(

                (int) $utilisateur['id']

            ),

            'notifications' => $this->notification->nonLues(

                (int) $utilisateur['id']

            )

        ]);
    }
    
}