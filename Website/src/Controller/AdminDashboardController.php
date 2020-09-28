<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(EntityManagerInterface $manager)
    {
        $users = $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        $activity = $manager->createQuery('SELECT COUNT(a) FROM App\Entity\Activity a')->getSingleScalarResult();
        $bookings = $manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking b')->getSingleScalarResult();
        $comments = $manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();

        $bestActivity = $manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id
            FROM App\Entity\Comment c
            JOIN c.activity a
            GROUP BY a
            ORDER BY note DESC'
        )->setMaxResults(5)
            ->getResult();

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('users', 'activity', 'bookings', 'comments'),
            'bestActivity' => $bestActivity
        ]);
    }
}
