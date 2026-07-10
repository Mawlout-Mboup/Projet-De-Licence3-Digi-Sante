<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Patient;

class PatientController extends Controller
{
    private Patient $patient;

    public function __construct()
    {
        $this->patient = new Patient();

        $this->requireRole([1, 2]);
    }

    public function index(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->view('patient/index', [
            'title' => 'Gestion des patients',
            'patients' => $this->patient->getAll()
        ]);
    }

    public function show(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $id = (int) $this->input('id');

        $patient = $this->patient->findById($id);

        $this->view('patient/show', [
            'title' => 'Fiche patient',
            'patient' => $patient,
            'constantes' => $patient ? $this->patient->getConstantes($id) : [],
            'diagnostics' => $patient ? $this->patient->getDiagnostics($id) : [],
            'consultations' => $patient ? $this->patient->getConsultations($id) : [],
            'rapports' => $patient ? $this->patient->getRapports($id) : [],
            'contacts' => $patient ? $this->patient->getContactsUrgence($id) : [],
            'dossier' => $patient ? $this->patient->getDossierMedical($id) : false
        ]);
    }

    public function create(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->view('patient/create', [
            'title' => 'Nouveau patient'
        ]);
    }

    public function store(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        if (!$this->isPost()) {
            $this->redirect('patients');
        }

        $this->patient->createPatient($_POST);

        $this->redirect('patients');
    }

    public function edit(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $id = (int) $this->input('id');

        $patient = $this->patient->findById($id);

        $this->view('patient/edit', [
            'title' => 'Modifier patient',
            'patient' => $patient
        ]);
    }

    public function update(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        if (!$this->isPost()) {
            $this->redirect('patients');
        }

        $id = (int) $this->input('id');

        $patient = $this->patient->findById($id);

        if (!$patient) {
            $this->abort(404, 'Patient introuvable');
        }

        $this->patient->updatePatient($id, $_POST);

        $this->redirect('patients');
    }

    public function delete(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $id = (int) $this->input('id');

        $patient = $this->patient->findById($id);

        if (!$patient) {
            $this->abort(404, 'Patient introuvable');
        }

        $this->patient->deletePatient($id);

        $this->redirect('patients');
    }

    public function search(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $motCle = trim((string) $this->input('q'));

        $this->view('patient/index', [
            'title' => 'Résultat de la recherche',
            'patients' => $this->patient->rechercher($motCle)
        ]);
    }

    public function dashboard(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->json($this->patient->dashboard());
    }
}