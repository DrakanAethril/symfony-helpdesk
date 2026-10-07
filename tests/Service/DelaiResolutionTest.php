<?php

namespace App\Tests\Service;

use App\Entity\Ticket;
use App\Enum\Priorite;
use App\Enum\Statut;
use App\Service\DelaiResolution;
use PHPUnit\Framework\TestCase;

final class DelaiResolutionTest extends TestCase
{
    public function testRetardCritique(): void
    {
        $delais = new DelaiResolution(4);  // sans conteneur
        $ticket = (new Ticket())
            ->setPriorite(Priorite::Critique)
            ->setCreeLe(new \DateTimeImmutable('2026-10-05 09:00'));

        $avant = new \DateTimeImmutable('2026-10-05 12:59');
        $apres = new \DateTimeImmutable('2026-10-05 13:01');
        $this->assertFalse($delais->estEnRetard($ticket, $avant));
        $this->assertTrue($delais->estEnRetard($ticket, $apres));
    }

    public function testEcheanceSelonLaPriorite(): void
    {
        $delais = new DelaiResolution(4);
        $creeLe = new \DateTimeImmutable('2026-10-05 09:00');
        $attendu = [
            'critique' => '2026-10-05 13:00',
            'haute' => '2026-10-06 09:00',
            'normale' => '2026-10-08 09:00',
            'basse' => '2026-10-10 09:00',
        ];
        foreach (Priorite::cases() as $priorite) {
            $ticket = (new Ticket())->setPriorite($priorite)->setCreeLe($creeLe);
            $this->assertSame($attendu[$priorite->value], $delais->echeance($ticket)->format('Y-m-d H:i'));
        }
    }

    public function testUnTicketClosNestJamaisEnRetard(): void
    {
        $delais = new DelaiResolution(4);
        $ticket = (new Ticket())
            ->setPriorite(Priorite::Critique)
            ->setStatut(Statut::Resolu)
            ->setCreeLe(new \DateTimeImmutable('2026-10-05 09:00'));

        $this->assertFalse($delais->estEnRetard($ticket, new \DateTimeImmutable('2026-12-31 09:00')));
    }
}
