<?php

namespace App\Controller;

use App\Entity\Blob;
use App\Form\BlobType;
use App\Repository\BlobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blob')]
class BlobController extends AbstractController
{
    #[Route('/', name: 'app_blob_index', methods: ['GET'])]
    public function index(BlobRepository $blobRepository): Response
    {
        return $this->render('blob/index.html.twig', [
            'blobs' => $blobRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_blob_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BlobRepository $blobRepository): Response
    {
        $blob = new Blob();
        $form = $this->createForm(BlobType::class, $blob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blobRepository->save($blob, true);

            return $this->redirectToRoute('app_blob_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blob/new.html.twig', [
            'blob' => $blob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blob_show', methods: ['GET'])]
    public function show(Blob $blob): Response
    {
        return $this->render('blob/show.html.twig', [
            'blob' => $blob,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blob_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blob $blob, BlobRepository $blobRepository): Response
    {
        $form = $this->createForm(BlobType::class, $blob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blobRepository->save($blob, true);

            return $this->redirectToRoute('app_blob_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blob/edit.html.twig', [
            'blob' => $blob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blob_delete', methods: ['POST'])]
    public function delete(Request $request, Blob $blob, BlobRepository $blobRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blob->getId(), $request->request->get('_token'))) {
            $blobRepository->remove($blob, true);
        }

        return $this->redirectToRoute('app_blob_index', [], Response::HTTP_SEE_OTHER);
    }
}
