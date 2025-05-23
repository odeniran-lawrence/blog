<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article')]
final class ArticleController extends AbstractController
{
    // Route "/articles" menant à la liste des articles
    #[Route('s', name: 'articles', methods: ['GET'])]
    public function index(
        ArticleRepository $ar,// Repossitory de l'entité Article
        PaginatorInterface $paginator,// Classe pour la fonctionnalité de pagination
        Request $request // Classe pour récupérer les paramètre de la requete HTTP
    ): Response {
        $all = $ar->findBy(
            ['is_published' => true,
            'is_archived' => false,
        ],
        ['title' => 'asc']);

        $pagination = $paginator->paginate(
            $all,
            $request->query->getInt('page', 1),/* page number */
            12 /* limit per page */
        );

        return $this->render('article/index.html.twig', [
            'controller_name' => 'INDEX',
            'articles' => $pagination
        ]);
    }

    //Route "/article/slug" menant a la page d'un article
    #[Route('/{slug}', name:'article', methods:['GET'])]
    public function view(): Response
    {
          return $this->render('article/index.html.twig', [
            // 'articles' => $article
        ]);
    }

    //Route "/article/slug/edit" menant a la page d'un article
    #[Route('/{slug}/edit', name:'article_edit', methods:['GET','POST'])]
    public function edit(): Response
    {
          return $this->render('article/edit.html.twig', [
            // 'articles' => $article
        ]);
    }

    // Route "/article/slug" menant a la page d'un article
    #[Route('/{slug}/delete', name:'article', methods:['POST'])]
    public function delete(): Response
    {
          return $this->redirectToRoute('articles');
    }




}

