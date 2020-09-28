<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments", name="admin_comment_index")
     */
    public function index(CommentRepository $repo)
    {

        return $this->render('admin/comment/index.html.twig', [
            'comments' => $repo->findAll()
        ]);
    }

    /**
     * affiche le formulaire d'edition
     * 
     * @Route("/admin/comments/{id}/edit", name="admin_comment_edit")
     *
     * @param Comment $comment
     * @return Response
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminCommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire Numero {$comment->getId()} bien ete modifier."
            );
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView()
        ]);
    }


    /**
     * Supprimer un commentaire
     * 
     * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Comment $comment, EntityManagerInterface $manager)
    {


        $manager->remove($comment);
        $manager->flush();
        $this->addFlash(
            'success',
            "le commentaire de {$comment->getAuthor()->getFullName()} a ete supprime."
        );

        return $this->redirectToRoute('admin_comment_index');
    }
}
