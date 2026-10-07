<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController extends AbstractController
{
    #[Route('/tickets', name: 'ticket_index', methods: ['GET'])]
    public function index(TicketRepository $repo): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $repo->findAvecRelations(),
        ]);
    }

    #[Route('/tickets/{id}', name: 'ticket_show',
        requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }
}
