<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index', [

            'title' => 'Accueil',

            'appName' => APP_NAME,

            'version' => APP_VERSION

        ]);
    }

    public function about(): void
    {
        $this->view('home/about', [

            'title' => 'À propos'

        ]);
    }

    public function contact(): void
    {
        $this->view('home/contact', [

            'title' => 'Contact'

        ]);
    }

    public function notFound(): void
    {
        $this->abort(

            404,

            'Page introuvable'

        );
    }
}