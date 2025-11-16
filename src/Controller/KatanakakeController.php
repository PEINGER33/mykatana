<?php

namespace App\Controller;

use App\Entity\Katana;
use App\Entity\Katanakake;
use App\Form\KatanakakeType;
use App\Repository\KatanakakeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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
            
            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'bien ajouté');
            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()

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
    
    #[Route('/{katanakake_id}/katana/{katana_id}', methods: ['GET'], name: 'app_katanakake_katana_show')]
        public function katanaShow( #[MapEntity(id: 'katanakake_id')] Katanakake $katanakake, #[MapEntity(id: 'katana_id')] Katana $katana ): Response
            {
        
                if(! $katanakake->getKatanas()->contains($katana)) {
                    throw $this->createNotFoundException("Couldn't find such a katana in this katanakake !");
                }
                
                // if(! $[galerie]->isPublished()) {
                //   throw $this->createAccessDeniedException("You cannot access the requested ressource!");
                //}
                
                return $this->render('katanakake/katana_show.html.twig', [
                    'katana' => $katana,
                    'katanakake' => $katanakake
                ]);
        }
    
    
    /* #[Route('/katana/{id}', name: 'app_katanakake_katana_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function katanaShow(Katana $katana, Katanakake $katanakake): Response
    {
        if (!$katana) {
            throw $this->createNotFoundException('The katana does not exist');
        }
        
        {
            return $this->render('katanakake/katana_show.html.twig',
                [ 'katana' => $katana, 'katanakake' => $katanakake ]);
        }
    } */
    
    
    /* #[Route('/katana/{id}', name: 'app_katanakake_katana_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function katanaShow(ManagerRegistry $doctrine, $id): Response
    {
        $katanaRepo = $doctrine->getRepository(Katana::class);
        $katana = $katanaRepo->find($id);
        
        if (!$katana) {
            throw $this->createNotFoundException('The katana does not exist');
        }
        
        
        {
            return $this->render('katana/show.html.twig',
                [ 'katana' => $katana ]);
        }
    } */
    
}
