<?php

namespace App\Service;

use App\Entity\Ticket;
use App\Enum\Priorite;
use App\Enum\Statut;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class DelaiResolution
{
    private const HEURES_HAUTE = 24;    // 1 jour
    private const HEURES_NORMALE = 72;  // 3 jours
    private const HEURES_BASSE = 120;   // 5 jours
    private const CLOS = [Statut::Resolu, Statut::Ferme];

    public function __construct(
        #[Autowire(param: 'app.delai_critique')]
        private readonly int $heuresCritique,
    ) {
    }

    public function echeance(Ticket $ticket): \DateTimeImmutable
    {
        $heures = match ($ticket->getPriorite()) {
            Priorite::Critique => $this->heuresCritique,
            Priorite::Haute => self::HEURES_HAUTE,
            Priorite::Normale => self::HEURES_NORMALE,
            Priorite::Basse => self::HEURES_BASSE,
        };

        return $ticket->getCreeLe()->modify("+{$heures} hours");
    }

    public function estEnRetard(
        Ticket $ticket,
        ?\DateTimeImmutable $maintenant = null,
    ): bool {
        if (\in_array($ticket->getStatut(), self::CLOS, true)) {
            return false;
        }
        $maintenant ??= new \DateTimeImmutable();

        return $maintenant > $this->echeance($ticket);
    }
}
