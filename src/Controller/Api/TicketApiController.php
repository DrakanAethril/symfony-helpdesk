<?php

namespace App\Controller\Api;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/tickets', format: 'json')]
#[IsGranted('IS_AUTHENTICATED', statusCode: 401)]
#[IsGranted('ROLE_RESPONSABLE', statusCode: 403)]
final class TicketApiController extends AbstractController
{
    #[Route('', name: 'api_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $tickets): JsonResponse
    {
        return $this->json($tickets->findAll(), context: [
            'groups' => ['ticket:liste'],
        ]);
    }

    #[Route('/{id}', name: 'api_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): JsonResponse
    {
        return $this->json($ticket, context: [
            'groups' => ['ticket:detail'],
        ]);
    }
}
