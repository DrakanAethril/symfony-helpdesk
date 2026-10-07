<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(TicketRepository $repo): Response
    {
        return $this->render('accueil/index.html.twig', [
            'tickets' => $repo->findOuvertsParPriorite(),
        ]);
    }
}
