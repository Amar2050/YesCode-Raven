<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/account', name: 'users_list')]
    public function index(UserRepository $repo): Response
    {
        return $this->render('account/index.html.twig', [
            'users' => $repo->findAll()
        ]);
    }

    #[Route('/account/new', name: 'account_create')]
    public function create(Request $request, EntityManagerInterface $manager,UserPasswordHasherInterface $encoder ) 
    {
        $user = new User();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->hashPassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 
                            "Bienvenue <strong>{$user->getFullname()}</strong> !");

            return $this->redirectToRoute('account_profil' , [
                'slug' => $user->getSlug()
            ]);
        }
        
        return $this->render('account/create.html.twig', [
            'form' => $form->createView()
        ]);
    }



    #[Route('/account/{slug}', name: 'account_profil')]
    public function show($slug , UserRepository $repo)
    {
        $user= $repo->findOneBySlug($slug);

        return $this->render('account/show.html.twig', [
            'user' => $user
        ]);
    }




    #[Route('/account/{slug}/edit', name: 'account_edit')]
    public function edit($slug , UserRepository $repo , Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder)
    {

        $user= $repo->findOneBySlug($slug);

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->hashPassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->flush();

            $this->addFlash('info', 
                            "<strong>{$user->getFirstname()}</strong> votre profil a bien été modifié");

            return $this->redirectToRoute('account_profil' , [
                'slug' => $user->getSlug()
            ]);
        }

        return $this->render('account/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }


    #[Route('/account/{slug}/delete', name: 'account_delete')]
    public function delete($slug, UserRepository $repo , EntityManagerInterface $manager)
    {
        $user= $repo->findOneBySlug($slug);
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('danger',"GoodBye !");
      
        return $this->redirectToRoute('home_page');
    }


    #[Route('/login', name: 'account_login')]
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
           'hasError'   =>  $error !== null,
           'username'   =>  $username
        ]);
    }

    #[Route('/logout', name: 'account_logout')]
    public function logout(){}

}
