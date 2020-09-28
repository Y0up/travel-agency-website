<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * 
     * Page d'accueil
     * 
     * @Route("/", name="homepage")
     */

    public function home()
    {
        // ..

        return $this->render(
            'home.html.twig',
            ['title' => "My Colombian Tour",]

        );
    }
}
