<?php

namespace App\Controller;

use App\Entity\Katana;
use App\Entity\Trousseau;
use App\Form\KatanaType;
use App\Repository\KatanaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/katana')]
final class KatanaController extends AbstractController
{
    #[Route(name: 'app_katana_index', methods: ['GET'])]
    public function index(KatanaRepository $katanaRepository): Response
    {
        
        if (!$this->getUser()) {
            // si anonyme : on se redirige vers le login
            return $this->redirectToRoute('app_login');
        }
        
        if ($this->isGranted('ROLE_ADMIN')) {
            $katanas = $katanaRepository->findAll();
        }
        else {
            $member = $this->getUser();
            $katanas = $katanaRepository->findMemberKatanas($member);
        }
        
        return $this->render('katana/index.html.twig', [
            'katanas' => $katanas,]);
        
    }

    #[Route('/new/{id}', name: 'app_katana_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Trousseau $trousseau): Response
    {
        $katana = new Katana();
        $katana->setTrousseau($trousseau);
        $form = $this->createForm(KatanaType::class, $katana);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // Change content-type according to image's
            $imagefile = $katana->getImageFile();
            if($imagefile) {
                $mimetype = $imagefile->getMimeType();
                $katana->setContentType($mimetype);
            }
            
            $entityManager->persist($katana);
            $entityManager->flush();

            return $this->redirectToRoute('trousseau_show',
                ['id' => $trousseau->getId()],
                Response::HTTP_SEE_OTHER);
        }

        return $this->render('katana/new.html.twig', [
            'katana' => $katana,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_katana_show', methods: ['GET'])]
    public function show(Katana $katana): Response
    {
        dump($katana);
        return $this->render('katana/show.html.twig', [
            'katana' => $katana,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_katana_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Katana $katana, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(KatanaType::class, $katana);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('trousseau_show', ['id' => $katana->getTrousseau()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('katana/edit.html.twig', [
            'katana' => $katana,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_katana_delete', methods: ['POST'])]
    public function delete(Request $request, Katana $katana, EntityManagerInterface $entityManager): Response
    {
        // On récupère l'id du trousseau avant de le supprimer
        $trousseauId = $katana->getTrousseau()->getId();
        
        if ($this->isCsrfTokenValid('delete'.$katana->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($katana);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trousseau_show', ['id' => $trousseauId], Response::HTTP_SEE_OTHER);
    }
}
