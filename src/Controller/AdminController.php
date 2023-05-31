<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'dashboard')]
    public function index(UserRepository $userRepository, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
       
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'articles' => $articleRepository->findAll(),
            "categories" => $categoryRepository->findAll()
        ]);
    }


    #[Route('/admin/user', name: 'users_list')]
    public function userList(UserRepository $repo): Response
    {
        return $this->render('admin/user.html.twig', [
            'users' => $repo->findAll()
        ]);
    }

    #[Route('/admin/article', name: 'articles_list')]
    public function articleList(ArticleRepository $repo): Response
    {
        return $this->render('admin/article.html.twig', [
            'articles' => $repo->findAll()
        ]);
    }
}
