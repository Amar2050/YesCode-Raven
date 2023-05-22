<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager){


        for ($i=1; $i <= 10 ; $i++) { 

            $article= new Article();
            $article->setTitle("Titre de l'article: " . $i);
            $article->setIntro("Ceci est l'intro");
            $article->setContent("<p>Je suis du le 1er paragraphe</p>
                                  <p>Je suis du le 2eme paragraphe</p>
                                  <p>Je suis du le 3eme paragraphe</p>");
            $article->setImage("https://media.cdnws.com/_i/85346/285/2264/87/blog.jpeg");
            $article->setCreatedAt(new \DateTime());
 
            $manager->persist($article);
    
            // $manager->persist();
        }

        $manager->flush();
    }
}
