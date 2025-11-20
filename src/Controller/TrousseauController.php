<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Trousseau;
use Doctrine\Persistence\ManagerRegistry;

final class TrousseauController extends AbstractController
{
    #[Route('/trousseau', name: 'trousseau_index', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $trousseauRepository = $entityManager->getRepository(Trousseau::class);
        
        
        if (!$this->getUser()) {
            // si anonyme : on se redirige vers le login
            return $this->redirectToRoute('app_login');
        }
        
        if ($this->isGranted('ROLE_ADMIN')) {
            $trousseaux = $trousseauRepository->findAll();
        }
        else {
            $member = $this->getUser();
            // $trousseaux doit etre un tableau pas un objet
            $trousseaux = [$member->getTrousseau()];
        }
        
        return $this->render('trousseau/index.html.twig',
            ['trousseaux' => $trousseaux]);
    }
    
    /**
     * Show a trousseau
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/trousseau/{id}', name: 'trousseau_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id) : Response
    {
        $trousseauRepo = $doctrine->getRepository(Trousseau::class);
        $trousseau = $trousseauRepo->find($id);
        
        if (!$trousseau) {
            throw $this->createNotFoundException('The trousseau does not exist');
        }
        
        
        {
            return $this->render('trousseau/show.html.twig',
                [ 'trousseau' => $trousseau ]);
        }
    }
    
    
}
