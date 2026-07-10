<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class PlatformController extends Controller
{
    public function notifications(): void
    {
        $this->requireAuth();

        $this->view('platform/notifications', [
            'title' => 'Notifications'
        ]);
    }

    public function profil(): void
    {
        $this->requireAuth();

        $this->view('platform/profil', [
            'title' => 'Mon profil',
            'user' => $this->user()
        ]);
    }

    public function parametres(): void
    {
        $this->requireRole(1);

        $this->view('platform/parametres', [
            'title' => 'Parametres'
        ]);
    }

    public function statistiques(): void
    {
        $this->requireRole([1, 2]);

        $this->view('platform/statistiques', [
            'title' => 'Statistiques'
        ]);
    }
}