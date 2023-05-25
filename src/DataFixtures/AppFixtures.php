<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager){

        $faker = Factory::create("sq_AL");

        for ($i=1; $i <= 20 ; $i++) { 

        $article= new Article();
            

        $title = $faker->sentence(2); 
        $intro = $faker->paragraph(2); 
        $content ="<p>" . implode("</p><p>",$faker->paragraphs(5)) . "<p>" ; 
        $image = "https://picsum.photos/400/300";

        // $createdAt = $faker->dateTimeBetween('-2 months');

           
            $article->setTitle($title);
            $article->setIntro( $intro);
            $article->setContent( $content);
            $article->setImage($image);
            $manager->persist($article);
        }

        $genres = ['male', 'female'];

        for ($i=0; $i <= 20 ; $i++) { 
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';
            
            $picture .= ($genre == 'male' ? 'men/' : 'women/').$pictureId;

            $user->setFirstname($faker->firstname($genre))
                 ->setLastname($faker->lastname)
                 ->setEmail($faker->email)
                 ->setAvatar($picture)
                 ->setPresentation($faker->sentence())
                 ->setHash("password");
        
            $manager->persist($user);
      
        }


        $manager->flush();
    }
}
