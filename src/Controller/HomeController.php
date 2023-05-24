<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(ArticleRepository $repo){
        
        return $this->render('home/index.html.twig', [
            "articles" => $repo->findLastArticles(3)
        ]);
    }

}
