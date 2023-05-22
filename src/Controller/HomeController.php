<?php

namespace App\Controller;

use Faker;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(ArticleRepository $repo){

        $faker = Faker\Factory::create();

        $title = $faker->sentence(2); // pour titre
        $intro = $faker->paragraph(2); 
        $content ="<p>" . implode("</p><p>",$faker->paragraphs(5)) . "<p>" ; 
        $image = "https://picsum.photos/400/300";

        $createdAt = $faker->dateTimeBetween('-2 years');
        dump($createdAt);

        return $this->render('home/index.html.twig', [
            "articles" => $repo->findLastArticles(3),
            "contenu" => $content
        ]);
    }

}
