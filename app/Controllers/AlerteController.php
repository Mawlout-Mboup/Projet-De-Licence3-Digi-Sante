<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Alerte;

class AlerteController extends Controller
{
    private Alerte $alerte;

    public function __construct()
    {
        $this->alerte = new Alerte();

        $this->requireRole([1, 2]);
    }

    public function index(): void
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        $this->view('alerte/index', [

            'title' => 'Alertes',

            'alertes' => $this->alerte->all()

        ]);
    }

    public function show(): void
    {
        $id = (int) $this->input('id');

        $alerte = $this->alerte->findById($id);

        $this->view('alerte/show', [

            'title' => 'Détail Alerte',

            'alerte' => $alerte

        ]);
    }

    public function create(): void
    {
        $this->view('alerte/create', [

            'title' => 'Nouvelle Alerte'

        ]);
    }

    public function store(): void
    {
        if (!$this->isPost()) {

            $this->redirect('alertes');

        }

        $this->alerte->createAlerte($_POST);

        $this->redirect('alertes');
    }

    public function edit(): void
    {
        $id = (int) $this->input('id');

        $alerte = $this->alerte->findById($id);

        $this->view('alerte/edit', [

            'title' => 'Modifier Alerte',

            'alerte' => $alerte

        ]);
    }

    public function update(): void
    {
        if (!$this->isPost()) {

            $this->redirect('alertes');

        }

        $id = (int) $this->input('id');

        $this->alerte->updateAlerte($id, $_POST);

        $this->redirect('alertes');
    }

    public function delete(): void
    {
        $id = (int) $this->input('id');

        $this->alerte->delete($id);

        $this->redirect('alertes');
    }

    public function prendreEnCharge(): void
    {
        $id = (int) $this->input('id');

        $this->alerte->prendreEnCharge(

            $id,

            (int)$this->user()['id']

        );

        $this->redirect('alertes');
    }

    public function resoudre(): void
    {
        $id = (int) $this->input('id');

        $this->alerte->resoudre($id);

        $this->redirect('alertes');
    }

    public function dashboard(): void
    {
        $this->json(

            $this->alerte->dashboard()

        );
    }
}