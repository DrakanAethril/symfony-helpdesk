<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class TicketController extends AbstractController
{
    #[Route('/tickets', name: 'ticket_index', methods: ['GET'])]
    public function index(TicketRepository $repo): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $repo->findAvecRelations(),
        ]);
    }

    #[Route('/tickets/nouveau', name: 'ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setAuteur($this->getUser());
            $em->persist($ticket);
            $em->flush();
            $this->addFlash('success', 'Incident déclaré.');

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('ticket/new.html.twig', ['form' => $form]);
    }

    #[Route('/tickets/{id}', name: 'ticket_show',
        requirements: ['id' => '\d+'], methods: ['GET'])]
    #[IsGranted('TICKET_VIEW', 'ticket')]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/tickets/{id}/modifier', name: 'ticket_edit',
        requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('TICKET_EDIT', 'ticket')]
    public function edit(Ticket $ticket, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Ticket modifié.');

            return $this->redirectToRoute('ticket_show', ['id' => $ticket->getId()]);
        }

        return $this->render('ticket/edit.html.twig', ['form' => $form]);
    }
}
