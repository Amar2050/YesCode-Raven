<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'articles_index')]
    public function index(ArticleRepository $repo): Response{

        return $this->render('article/index.html.twig', [
            "articles" => $repo->findAll()
        ]);
    }

    #[Route('/articles/new', name: 'article_create')]
    public function create(Request $request, EntityManagerInterface $manager){

        $article = new Article();
        
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();

            $this->addFlash("success", 
                            "L'article <strong>{$article->getTitle()}</strong> a bien été crée");

            return $this->redirectToRoute('article_show' , 
                ['slug' => $article->getSlug()]);
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/articles/{slug}', name: 'article_show')]
    public function show($slug, ArticleRepository $repo){

        $article = $repo->findOneBySlug($slug);

        return $this->render('article/show.html.twig', [
            "article" => $article
        ]);
    }


    
}
