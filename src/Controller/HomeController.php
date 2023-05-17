<?php

namespace App\Controller;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(EntityManagerInterface $manager){

        $banana = new Fruit();
        $banana->setName("Kiwi");

        $something = new Fruit();
        $something->setName("ArnOLJAyniREGINOother");

        $manager->persist($banana);
        $manager->persist($something);
        $manager->flush();

        return $this->render('home/index.html.twig', [
        
        ]);
    }

}
