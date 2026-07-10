
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