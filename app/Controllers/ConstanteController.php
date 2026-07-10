<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ConstanteVitale;

class ConstanteController extends Controller
{
    private ConstanteVitale $constante;

    public function __construct()
    {
        $this->constante = new ConstanteVitale();

        $this->requireAuth();
    }

    public function index(): void
    {
        $user = $this->user() ?? [];

        if ((int) ($user['role_id'] ?? 0) === 3) {
            $this->view('constante/index', [
                'title' => 'Mes constantes vitales',
                'constantes' => $this->constante->getByPatient((int) ($user['id'] ?? 0))
            ]);

            return;
        }

        $this->requireRole([1, 2]);

        $this->view('constante/index', [
            'title' => 'Constantes Vitales',
            'constantes' => $this->constante->getAll()
        ]);
    }

    public function show(): void
    {
        $id = (int) $this->input('id');

        $constante = $this->constante->findById($id);

        if (
            $this->roleId() === 3 &&
            $constante &&
            (int) ($constante['patient_id'] ?? 0) !== (int) ($this->user()['id'] ?? 0)
        ) {
            $this->redirect('constantes');
        }

        $this->view('constante/show', [
            'title' => 'Détail des constantes',
            'constante' => $constante
        ]);
    }

    public function create(): void
    {
        $this->view('constante/create', [
            'title' => 'Nouvelle constante'
        ]);
    }

    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('constantes');
        }

        if ($this->roleId() === 3) {
            $_POST['patient_id'] = (int) ($this->user()['id'] ?? 0);
            $_POST['medecin_id'] = null;
        }

        $this->constante->createConstante($_POST);

        $this->redirect('constantes');
    }

    public function edit(): void
    {
        $this->requireRole([1, 2]);

        $id = (int) $this->input('id');

        $constante = $this->constante->findById($id);

        $this->view('constante/edit', [
            'title' => 'Modifier constante',
            'constante' => $constante
        ]);
    }

    public function update(): void
    {
        $this->requireRole([1, 2]);

        if (!$this->isPost()) {
            $this->redirect('constantes');
        }

        $id = (int) $this->input('id');

        $this->constante->updateConstante($id, $_POST);

        $this->redirect('constantes');
    }

    public function delete(): void
    {
        $this->requireRole([1, 2]);

        $id = (int) $this->input('id');

        $this->constante->deleteConstante($id);

        $this->redirect('constantes');
    }

    public function patient(): void
    {
        $this->requireRole([1, 2]);

        $patient = (int) $this->input('patient');

        $this->view('constante/index', [
            'title' => 'Constantes du patient',
            'constantes' => $this->constante->rechercherPatient($patient)
        ]);
    }

    public function critiques(): void
    {
        $this->requireRole([1, 2]);

        $this->view('constante/index', [
            'title' => 'Constantes critiques',
            'constantes' => $this->constante->critiques()
        ]);
    }

    public function dashboard(): void
    {
        $this->requireRole([1, 2]);

        $this->json(
            $this->constante->dashboard()
        );
    }
}