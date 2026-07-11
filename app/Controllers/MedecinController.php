<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Medecin;

class MedecinController extends Controller
{
    private Medecin $medecin;

    public function __construct()
    {
        $this->medecin = new Medecin();

        $this->requireRole(1);
    }

    public function index(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->view('medecin/index', [
            'title' => 'Gestion des médecins',
            'medecins' => $this->medecin->getAll()
        ]);
    }

    public function show(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $id = (int)$this->input('id');

        $medecin = $this->medecin->findById($id);

        $this->view('medecin/show', [
            'title' => 'Fiche médecin',
            'medecin' => $medecin
        ]);
    }

    public function create(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->view('medecin/create', [
            'title' => 'Nouveau médecin'
        ]);
    }

    public function store(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        if (!$this->isPost()) {
            $this->redirect('medecins');
        }

        $this->medecin->createMedecin($_POST);

        $this->redirect('medecins');
    }

    public function edit(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $id = (int)$this->input('id');

        $medecin = $this->medecin->findById($id);

        $this->view('medecin/edit', [
            'title' => 'Modifier médecin',
            'medecin' => $medecin
        ]);
    }

    public function update(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        if (!$this->isPost()) {
            $this->redirect('medecins');
        }

        $id = (int)$this->input('id');

        $this->medecin->updateMedecin($id, $_POST);

        $this->redirect('medecins');
    }

    public function delete(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $id = (int)$this->input('id');

        $this->medecin->deleteMedecin($id);

        $this->redirect('medecins');
    }

    public function search(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $motCle = trim((string)$this->input('q'));

        $this->view('medecin/index', [
            'title' => 'Recherche médecin',
            'medecins' => $this->medecin->rechercher($motCle)
        ]);
    }

    public function disponibles(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->view('medecin/index', [
            'title' => 'Médecins disponibles',
            'medecins' => $this->medecin->disponibles()
        ]);
    }

    public function indisponibles(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->view('medecin/index', [
            'title' => 'Médecins indisponibles',
            'medecins' => $this->medecin->indisponibles()
        ]);
    }

    public function dashboard(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->json(
            $this->medecin->dashboard()
        );
    }
}
