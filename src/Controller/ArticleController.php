<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/article')]
final class ArticleController extends AbstractController
{
    /**
     * Le constructeur permet de déclarer les dépendances une fois
     * et d'éviter la non-application du concept DRY (Don't Repeat Yourself)
     */
    public function __construct(
        private ArticleRepository $ar, // Repository de l'entité Article
        private EntityManagerInterface $em // Gestionnaire d'entités avec Doctrine
    ) {}

    // Route "/articles" menant à la liste des articles
    #[Route('s', name: 'articles', methods: ['GET'])]
    public function index(
        PaginatorInterface $paginator, // Classe pour la fonctionnalité de pagination
        Request $request // Classe pour récupérer les paramètres de la requête HTTP
    ): Response {
        $all = $this->ar->findBy(['is_published' => true, 'is_archived' => false]);
        $pagination = $paginator->paginate(
            $all,
            $request->query->getInt('page', 1),
            100
        );

        return $this->render('article/index.html.twig', [
            'controller_name' => 'INDEX',
            'articles' => $pagination
        ]);
    }

    #[Route('/{slug}', name: 'article', methods: ['GET'])]
    public function view(string $slug): Response
    {
        return $this->render('article/view.html.twig', [
            'article' => $this->ar->findOneBySlug($slug)
        ]);
    }

    #[Route('/{slug}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(): Response
    {
        return $this->render('article/edit.html.twig', [
            // 'article' => $article
        ]);
    }

    #[Route('/{slug}/delete', name: 'article_delete', methods: ['POST'])]
    public function delete(): Response
    {
        return $this->redirectToRoute('articles');
    }
}