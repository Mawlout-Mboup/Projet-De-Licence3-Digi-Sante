<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Rapport;

class RapportController extends Controller
{
    private Rapport $rapport;

    public function __construct()
    {
        $this->rapport = new Rapport();

        $this->requireRole([1, 2]);
    }

    public function index(): void
    {
        $this->view('rapport/index', [

            'title' => 'Rapports',

            'rapports' => $this->rapport->all()

        ]);
    }

    public function show(): void
    {
        $id = (int) $this->input('id');

        $rapport = $this->rapport->findById($id);

        $this->view('rapport/show', [

            'title' => 'Rapport',

            'rapport' => $rapport

        ]);
    }

    public function create(): void
    {
        $this->view('rapport/create', [

            'title' => 'Nouveau Rapport'

        ]);
    }

    public function store(): void
    {
        if (!$this->isPost()) {

            $this->redirect('rapports');

        }

        $this->rapport->creer($_POST);

        $this->redirect('rapports');
    }

    public function edit(): void
    {
        $id = (int) $this->input('id');

        $this->view('rapport/edit', [

            'title' => 'Modifier Rapport',

            'rapport' => $this->rapport->findById($id)

        ]);
    }

    public function update(): void
    {
        $id = (int) $this->input('id');

        $this->rapport->modifier($id, $_POST);

        $this->redirect('rapports');
    }

    public function delete(): void
    {
        $id = (int) $this->input('id');

        $this->rapport->supprimer($id);

        $this->redirect('rapports');
    }
}