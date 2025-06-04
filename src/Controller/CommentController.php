<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CommentController extends AbstractController
{
    #[Route('/comment/new/{ article }', name: 'comment_new', methods: ['POST'])]
    public function new(
        int $article, 
        Request $request,
        ArticleRepository $ar,
        EntityManagerInterface $em //d'interagir avec le BDD permet 
        ): Response
    {
        $articleComment = $ar->find($article);
        $user = $this->getUser(); // Récupération de l'utilisateur connecté

        if (!$articleComment) { // Vérification si l'article existe
            $this->addFlash('error', "Article n'existe pas");
            return $this->redirectToRoute('articles');
        }

        $comment = new Comment();
            $comment->setAuthor($user);
            $comment->setArticle($articleComment);
            $comment->setContent($request->request->get('content')); // Récupération du contenu du commentaire

            $em->persist($comment); // Enregistrement du commentaire
            $em->flush($comment); // Exécution de l'enregistrement en BDD

            $this->addFlash('success', "Votre commentaires est en cours de traitement");
            return $this->redirectToRoute('article', ['slug' => $articleComment->getSlug()]);

    }
}