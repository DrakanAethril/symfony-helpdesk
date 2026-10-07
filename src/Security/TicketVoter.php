<?php

namespace App\Security;

use App\Entity\Ticket;
use App\Entity\Utilisateur;
use App\Enum\Statut;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string, Ticket>
 */
final class TicketVoter extends Voter
{
    public const VIEW = 'TICKET_VIEW';
    public const EDIT = 'TICKET_EDIT';

    public function __construct(
        private readonly AccessDecisionManagerInterface $acces,
    ) {}

    protected function supports(
        string $attribute, mixed $subject,
    ): bool {
        $actions = [self::VIEW, self::EDIT];
        return \in_array($attribute, $actions, true)
            && $subject instanceof Ticket;
    }

    protected function voteOnAttribute(
        string $attribute, mixed $subject,
        TokenInterface $token, ?Vote $vote = null,
    ): bool {
        $utilisateur = $token->getUser();
        if (!$utilisateur instanceof Utilisateur) {
            return false; // anonyme
        }
        $ticket = $subject; // un Ticket, grâce à supports()

        // 1. le responsable peut tout faire
        if ($this->acces->decide($token, ['ROLE_RESPONSABLE'])) {
            return true;
        }
        // 2. le technicien voit tout ; il modifie
        //    les tickets libres et les siens
        if ($this->acces->decide($token, ['ROLE_TECHNICIEN'])) {
            return $attribute === self::VIEW
                || $ticket->getTechnicien() === null
                || $ticket->getTechnicien() === $utilisateur;
        }
        // 3. le salarié : ses tickets, modifiables
        //    tant qu’ils sont « nouveau »
        if ($ticket->getAuteur() !== $utilisateur) {
            return false;
        }
        return $attribute === self::VIEW
            || $ticket->getStatut() === Statut::Nouveau;
    }
}
