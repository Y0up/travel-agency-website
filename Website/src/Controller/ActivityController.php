<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Image;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use App\Repository\AgenciesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActivityController extends AbstractController
{
    /**
     * @Route("/activity", name="activity")
     */
    public function index(ActivityRepository $repo)
    {
        $activities = $repo->findAll();


        return $this->render('activity/index.html.twig', [
            'activities' => $activities,

        ]);
    }

    /**
     * Permet de creer une activitee
     * 
     * @Route("/activity/new", name="activity_create")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @return Response
     */

    public function create(Request $request, EntityManagerInterface $manager)
    {

        $activity = new Activity();

        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($activity->getImages() as $image) {
                $image->setActivity($activity);
                $manager->persist($image);
            }

            $manager->persist($activity);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'activitee {$activity->getTitle()} a ete cree"
            );

            return $this->redirectToRoute('activity_show', [
                'slug' => $activity->getSlug()
            ]);
        }

        return $this->render('activity/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet d'afficher le formulaire d'edition
     *
     * @Route("/activity/{slug}/edit", name="activity_edit")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @return Response
     */
    public function edit(Activity $activity, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($activity->getImages() as $image) {
                $image->setActivity($activity);
                $manager->persist($image);
            }

            $manager->persist($activity);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'activitee {$activity->getTitle()} a ete modifier"
            );

            return $this->redirectToRoute('activity_show', [
                'slug' => $activity->getSlug()
            ]);
        }

        return $this->render('activity/edit.html.twig', [
            'form' => $form->createView(),
            'activity' => $activity
        ]);
    }


    /**
     * permet d'afficher une activitee
     * 
     * @Route("/activity/{slug}", name="activity_show")
     * 
     * @return Response
     */

    public function show(Activity $activity, AgenciesRepository $repoAgencies)
    {

        $agencies = $repoAgencies->findAll();

        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
            'agencies' => $agencies,
        ]);
    }

    /**
     * Permet de supprimer une annonce
     * 
     * @Route("/activity/{slug}/delete", name="activity_delete")
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Activity $activity
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Activity $activity, EntityManagerInterface $manager)
    {
        $manager->remove($activity);
        $manager->flush();

        $this->addFlash(
            'succes',
            "l'activitee a bien ete supprimmee"
        );

        return $this->redirectToRoute("activity");
    }
}
