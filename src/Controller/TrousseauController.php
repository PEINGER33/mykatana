<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Trousseau;
use Doctrine\Persistence\ManagerRegistry;

final class TrousseauController extends AbstractController
{
    #[Route('/trousseau', name: 'app_trousseau', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des trousseaux!</title>
    </head>
    <body>
        <h1>Liste des trousseaux!</h1>
        <p>Liste des trousseaux de tous les membres :</p>
        <ul>';
        
        $entityManager= $doctrine->getManager();
        $trousseaux = $entityManager->getRepository(Trousseau::class)->findAll();
        foreach($trousseaux as $trousseau) {
            $url = $this->generateUrl(
                'app_trousseau',
                ['id' => $trousseau->getId()]);
            $htmlpage .= '<li>
            <a href="'. $url .'">'. $trousseau->getDescription() .'</a></li>';
        }
        $htmlpage .= '</ul>';
        
        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
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
        
        $res = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>trousseau n° '.$trousseau->getId().' details</title>
    </head>
    <body>
        <h2>Trousseau Details :</h2>
        <ul>
        <dl>';
        
        $res .='<dt>TROUSSEAU</dt><dd>' . $trousseau->getDescription() . '</dd>';
        
        $res .= '<p/><a href="' . $this->generateUrl('app_trousseau') . '">Back</a>';
        
        return new Response('<html><body>'. $res . '</body></html>');
    }
    
    
}
