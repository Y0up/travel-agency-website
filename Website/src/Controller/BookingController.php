<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/activity/{slug}/book", name="booking_create")
     */
    public function bookActivity(Activity $activity, Request $request, EntityManagerInterface $manager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $amount = $activity->getPrice();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();


            $booking->setBooker($user)
                ->setActivity($activity)
                ->setAmount($amount);

            // Si les dates ne sont pas disponibles
            if (!$booking->isBookableDates()) {
                $this->addFlash(
                    'warning',
                    "Ces dates ne sont pas disponibles."
                );
            } else {
                // Sinon enregistrement et redirection
                $manager->persist($booking);
                $manager->flush();

                return $this->redirectToRoute('booking_show', ['id' => $booking->getId()]);
            }
        }

        return $this->render('booking/bookActivity.html.twig', [
            'activity' => $activity,
            'formActivity' => $form->createView(),
        ]);
    }


    /**
     * afficher la page de reservation
     * 
     * @Route("/booking/{id}", name="booking_show")
     *
     * @param Booking $booking
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show(Booking $booking, Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setActivity($booking->getActivity())
                ->setAuthor($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre commentaire/note a ete enregistrer."
            );
        }

        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }
}
