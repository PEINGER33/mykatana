<?php

namespace App\Controller;

use App\Entity\Katanakake;
use App\Form\KatanakakeType;
use App\Repository\KatanakakeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/katanakake')]
final class KatanakakeController extends AbstractController
{
    #[Route(name: 'app_katanakake_index', methods: ['GET'])]
    public function index(KatanakakeRepository $katanakakeRepository): Response
    {
        return $this->render('katanakake/index.html.twig', [
            'katanakakes' => $katanakakeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_katanakake_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $katanakake = new Katanakake();
        $form = $this->createForm(KatanakakeType::class, $katanakake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($katanakake);
            $entityManager->flush();

            return $this->redirectToRoute('app_katanakake_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('katanakake/new.html.twig', [
            'katanakake' => $katanakake,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_katanakake_show', methods: ['GET'])]
    public function show(Katanakake $katanakake): Response
    {
        return $this->render('katanakake/show.html.twig', [
            'katanakake' => $katanakake,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_katanakake_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Katanakake $katanakake, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(KatanakakeType::class, $katanakake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_katanakake_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('katanakake/edit.html.twig', [
            'katanakake' => $katanakake,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_katanakake_delete', methods: ['POST'])]
    public function delete(Request $request, Katanakake $katanakake, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$katanakake->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($katanakake);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_katanakake_index', [], Response::HTTP_SEE_OTHER);
    }
}
