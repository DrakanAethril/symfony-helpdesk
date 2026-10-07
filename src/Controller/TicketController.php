<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController extends AbstractController
{
    private const TICKETS = [
        1 => [
            'id' => 1,
            'titre' => 'Imprimante du 2e étage hors ligne',
            'description' => 'L’imprimante du 2e étage n’apparaît plus sur le réseau depuis ce matin.',
            'priorite' => 'haute',
            'statut' => 'en_cours',
            'creeLe' => '2026-10-05 08:42',
        ],
        2 => [
            'id' => 2,
            'titre' => 'Mot de passe expiré',
            'description' => 'Impossible d’ouvrir une session : le mot de passe a expiré pendant les congés.',
            'priorite' => 'normale',
            'statut' => 'resolu',
            'creeLe' => '2026-10-05 09:15',
        ],
        3 => [
            'id' => 3,
            'titre' => 'Wi-Fi coupé en salle de réunion',
            'description' => 'Plus aucun accès Wi-Fi dans la salle de réunion, une visioconférence commence à 10 h.',
            'priorite' => 'critique',
            'statut' => 'nouveau',
            'creeLe' => '2026-10-06 07:58',
        ],
        4 => [
            'id' => 4,
            'titre' => 'Excel plante à l’ouverture',
            'description' => 'Excel se ferme dès l’ouverture du fichier des congés partagé.',
            'priorite' => 'basse',
            'statut' => 'nouveau',
            'creeLe' => '2026-10-06 11:20',
        ],
    ];

    #[Route('/tickets', name: 'ticket_index', methods: ['GET'])]
    public function index(): Response
    {
        $html = '<html><head><title>Tickets</title></head>';
        $html .= '<body><h1>Les tickets</h1><ul>';
        foreach (self::TICKETS as $id => $ticket) {
            $url = $this->generateUrl('ticket_show', ['id' => $id]);
            $titre = htmlspecialchars($ticket['titre']);
            $html .= '<li><a href="'.$url.'">'.$titre.'</a></li>';
        }

        return new Response($html.'</ul></body></html>');
    }

    #[Route('/tickets/{id}', name: 'ticket_show',
        methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        if (!isset(self::TICKETS[$id])) {
            throw $this->createNotFoundException();
        }
        $ticket = self::TICKETS[$id];

        return new Response('<h1>'.htmlspecialchars($ticket['titre']).'</h1>');
    }
}
