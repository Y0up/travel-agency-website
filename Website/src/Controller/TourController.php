<?php

namespace App\Controller;

use App\Repository\TourRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TourController extends AbstractController
{
    /**
     * @Route("/tour", name="tour")
     */
    public function index(TourRepository $repo)
    {
        $tours = $repo->findAll();


        return $this->render('tour/index.html.twig', [
            'tours' => $tours,
        ]);
    }
}
