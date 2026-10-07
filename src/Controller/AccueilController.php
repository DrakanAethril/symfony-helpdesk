<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        $url = $this->generateUrl('ticket_index');

        return new Response('<h1>Helpdesk de Norbelle</h1><p><a href="'.$url.'">Voir les tickets</a></p>');
    }
}
