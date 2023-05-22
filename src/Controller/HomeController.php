<?php

namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(ArticleRepository $repo){

        $slugify = new Slugify();

        $article = $repo->findOneById(27);
        
        // dump($article);
        dump($slugify->slugify($article->getTitle() . time() . hash( "sha1" , $article->getIntro())));


        return $this->render('home/index.html.twig', [
            "articles" => $repo->findLastArticles(3)
        ]);
    }

}
