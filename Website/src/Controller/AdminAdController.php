<?php

namespace App\Controller;

use App\Entity\Requ;
use App\Form\RequType;
use App\Entity\Activity;
use App\Form\AddRequType;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/activity", name="admin_activity_index")
     */
    public function index(ActivityRepository $repo)
    {
        return $this->render('admin/activity/index.html.twig', [
            'activities' => $repo->findAll()
        ]);
    }


    /**
     * Permet de creer une activitee
     * 
     * @Route("/admin/activity/new", name="admin_activity_create")
     * 
     * @return Response
     */

    public function create(Request $request, EntityManagerInterface $manager)
    {

        $activity = new Activity();

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);


        // Fromulaire ajout activitee

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($activity->getImages() as $image) {
                $image->setActivity($activity);
                $manager->persist($image);
            }


            foreach ($activity->getIncls() as $incl) {
                $incl->addActivity($activity);
                $manager->persist($incl);
            }

            foreach ($activity->getRequs() as $requ) {
                $requ->addActivity($activity);
                $manager->persist($requ);
            }

            $manager->persist($activity);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'activitee {$activity->getTitle()} a ete cree"
            );

            return $this->redirectToRoute('admin_activity_index', [
                'slug' => $activity->getSlug()
            ]);
        }

        return $this->render('admin/activity/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * affiche le formulaire d'edition
     * 
     * @Route("/admin/activities/{id}/edit", name="admin_activity_edit")
     *
     * @param Activity $activity
     * @return Response
     */
    public function edit(Activity $activity, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($activity->getIncls() as $incl) {
                $incl->addActivity($activity);
                $manager->persist($incl);
            }


            foreach ($activity->getRequs() as $requ) {
                $requ->addActivity($activity);
                $manager->persist($requ);
            }

            $manager->persist($activity);
            $manager->flush();



            $this->addFlash(
                'success',
                "L'activitee {$activity->getTitle()} a bien ete modifier."
            );
        }

        return $this->render('admin/activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form->createView()
        ]);
    }


    /**
     * Supprimer une activitee
     * 
     * @Route("/admin/activity/{id}/delete", name="admin_activity_delete")
     *
     * @param Activity $activity
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Activity $activity, EntityManagerInterface $manager)
    {
        if (count($activity->getBookings()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimmer une activite qui a des reservations."
            );
        } else {

            $manager->remove($activity);
            $manager->flush();
            $this->addFlash(
                'success',
                "l'annonce {$activity->getTitle()} a ete supprime."
            );
        }
        return $this->redirectToRoute('admin_activity_index');
    }
}
