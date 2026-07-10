<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Diagnostic;

class DiagnosticController extends Controller
{
    private Diagnostic $diagnostic;

    public function __construct()
    {
        $this->diagnostic = new Diagnostic();

        $this->requireRole([1, 2]);
    }

    public function index(): void
    {
        if (!$this->auth()) {

            $this->redirect('login');

        }

        $this->view('diagnostic/index', [

            'title' => 'Diagnostics',

            'diagnostics' => $this->diagnostic->all()

        ]);
    }

    public function show(): void
    {
        if (!$this->auth()) {

            $this->redirect('login');

        }

        $id = (int) $this->input('id');

        $diagnostic = $this->diagnostic->findById($id);

        $this->view('diagnostic/show', [

            'title' => 'Diagnostic',

            'diagnostic' => $diagnostic

        ]);
    }

    public function create(): void
    {
        if (!$this->auth()) {

            $this->redirect('login');

        }

        $this->view('diagnostic/create', [

            'title' => 'Nouveau diagnostic'

        ]);
    }

    public function store(): void
    {
        if (!$this->isPost()) {

            $this->redirect('diagnostics');

        }

        $this->diagnostic->createDiagnostic($_POST);

        $this->redirect('diagnostics');
    }

    public function edit(): void
    {
        $id = (int) $this->input('id');

        $diagnostic = $this->diagnostic->findById($id);

        $this->view('diagnostic/edit', [

            'title' => 'Modifier diagnostic',

            'diagnostic' => $diagnostic

        ]);
    }
        public function update(): void
    {
        if (!$this->isPost()) {

            $this->redirect('diagnostics');

        }

        $id = (int) $this->input('id');

        $diagnostic = $this->diagnostic->findById($id);

        if (!$diagnostic) {

            $this->abort(
                404,
                'Diagnostic introuvable'
            );

        }

        $this->diagnostic->updateDiagnostic(
            $id,
            $_POST
        );

        $this->redirect('diagnostics');
    }

    public function delete(): void
    {
        if (!$this->auth()) {

            $this->redirect('login');

        }

        $id = (int) $this->input('id');

        $diagnostic = $this->diagnostic->findById($id);

        if (!$diagnostic) {

            $this->abort(
                404,
                'Diagnostic introuvable'
            );

        }

        $this->diagnostic->deleteDiagnostic($id);

        $this->redirect('diagnostics');
    }

    public function validate(): void
    {
        if (!$this->auth()) {

            $this->redirect('login');

        }

        $id = (int) $this->input('id');

        $this->diagnostic->valider($id);

        $this->redirect('diagnostics');
    }

    public function archive(): void
    {
        if (!$this->auth()) {

            $this->redirect('login');

        }

        $id = (int) $this->input('id');

        $this->diagnostic->archiver($id);

        $this->redirect('diagnostics');
    }

    public function search(): void
    {
        if (!$this->auth()) {

            $this->redirect('login');

        }

        $motCle = trim(
            (string)$this->input('q')
        );

        $this->view('diagnostic/index', [

            'title' => 'Recherche Diagnostic',

            'diagnostics' => $this->diagnostic->rechercher($motCle)

        ]);
    }

    public function dashboard(): void
    {
        if (!$this->auth()) {

            $this->redirect('login');

        }

        $this->json(

            $this->diagnostic->dashboard()

        );
    }
}