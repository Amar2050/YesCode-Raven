<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager){

        $faker = Factory::create("fr_FR");

        $adminRole = new Role();
        $adminRole->setTitle("ROLE_ADMIN");
        $manager->persist($adminRole);
        

        $adminUser = new User();
        $adminUser->setFirstname("Amar")
                  ->setLastname("Admin")
                  ->setEmail("admin@admin.com")
                  ->setHash($this->encoder->hashPassword($adminUser,"password"))
                  ->setAvatar("https://cdn.shopify.com/s/files/1/0483/5613/0972/products/product-image-1707536406.jpg?v=1617904539")
                  ->setPresentation("Moi un User pas comme les autres...fixtures")
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);



        $users = [];
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
                 ->setHash($this->encoder->hashPassword($user,"password"));
        
            $manager->persist($user);
            $users[] = $user;
      
        }

        for ($i=1; $i <= 20 ; $i++) { 

        $article= new Article();
            

        $title = $faker->sentence(2); 
        $intro = $faker->paragraph(2); 
        $content ="<p>" . implode("</p><p>",$faker->paragraphs(5)) . "<p>" ; 
        $image = "https://picsum.photos/400/300";
        $author = $users[mt_rand(0, count($users) -1 )];
        // $createdAt = $faker->dateTimeBetween('-2 months');

           
            $article->setTitle($title);
            $article->setIntro( $intro);
            $article->setContent( $content);
            $article->setImage($image);
            $article->setAuthor($author);


            $manager->persist($article);
        }

       


        $manager->flush();
    }
}
