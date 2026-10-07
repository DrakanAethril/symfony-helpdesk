<?php

namespace App\Controller;

use App\Enum\Priorite;
use App\Enum\Statut;
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

    #[Route('/tableau-de-bord', name: 'tableau_bord', methods: ['GET'])]
    public function tableauBord(TicketRepository $repo): Response
    {
        $parStatut = [];
        foreach (Statut::cases() as $statut) {
            $parStatut[$statut->value] = $repo->count(['statut' => $statut]);
        }
        $parPriorite = [];
        foreach (Priorite::cases() as $priorite) {
            $parPriorite[$priorite->value] = $repo->count(['priorite' => $priorite]);
        }

        return $this->render('accueil/tableau_bord.html.twig', [
            'parStatut' => $parStatut,
            'parPriorite' => $parPriorite,
            'ouverts' => $repo->findOuvertsParPriorite(),
        ]);
    }
}
