<?php

namespace App\Controller;

use App\Form\ArticleForm;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Stmt\TryCatch;
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

    // route "/article/{slug}/edit" menant a la modification d'un article
    #[Route('/{slug}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(string $slug, Request $request): Response
    {
        $article = $this->ar->findOneBySlug($slug); // Récupération de l'article
        $form = $this->createForm(ArticleForm::class, $article); // Mise en place du formulaire
        $form->handleRequest($request); //Traitement de la requête 

        if ($form->isSubmitted() && $form->isValid()) // Si le form est soumis et valide
        {
            try {
                $this->em->persist($article); //Enregistrement de l'article (query SQL)
                $this->em->flush($article); // Exécution de l'enregistrement en BDD
                $this->addFlash('success', 'Modification a bien prise en compte'); // Message flash
            } catch (\Throwable $th) {
                $this->addFlash('error', 'la modification a rencontré une erreur'); //Message Flash Error
            }
                // Rédirection vers l'article modifier
        return $this->redirectToRoute('article', ['slug' => $slug]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article, // Envoi de l'article à la vue
            'articleForm' => $form // Envoi du formulaire à la vue
        ]);

    
    }

    #[Route('/{slug}/delete', name: 'article_delete', methods: ['POST'])]
    public function delete(): Response
    {
        return $this->redirectToRoute('articles');
    }
}
