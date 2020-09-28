<?php

namespace App\Controller;

use App\Entity\Incl;
use App\Entity\Requ;
use App\Form\ImclType;
use App\Form\RequType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddRequInclController extends AbstractController
{
    /**
     * @Route("/admin/add-requ-incl", name="admin_add_requ_incl")
     */
    public function index(Request $request, EntityManagerInterface $manager)
    {
        $requ = new Requ();
        $incl = new Incl();

        $form = $this->createForm(RequType::class, $requ);
        $form->handleRequest($request);

        $form2 = $this->createForm(ImclType::class, $incl);
        $form2->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($requ);
        }

        if ($form2->isSubmitted() && $form2->isValid()) {
            $manager->persist($incl);
        }
        $manager->flush();

        return $this->render('admin/add_requ_incl/add.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }
}
