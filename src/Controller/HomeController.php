<?php
namespace App\Controller;

use App\App\App;
use App\Router\Router;
use App\Exportation\Bdd\Bdd;

class HomeController extends AbstractController
{
    static public function home() : void
    {
        self::twig(
            'home.html',
            [
                'HTML_TITLE' => "Accueil | Pay-Able",
            ]
        );
    }
}