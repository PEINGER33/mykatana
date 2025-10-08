<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Katana;
use Doctrine\Persistence\ManagerRegistry;

final class KatanaController extends AbstractController
{
    #[Route('/katana/{id}', name: 'katana_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, $id): Response
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
    }
}
