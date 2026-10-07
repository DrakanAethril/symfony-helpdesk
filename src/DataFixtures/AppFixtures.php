<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use App\Enum\Priorite;
use App\Enum\Statut;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $exemples = [
            ['Imprimante du 2e étage hors ligne', 'L\'imprimante du 2e étage n\'apparaît plus sur le réseau depuis ce matin.', Priorite::Haute, Statut::EnCours, '2026-10-05 08:42'],
            ['Mot de passe expiré', 'Impossible d\'ouvrir une session : le mot de passe a expiré pendant les congés.', Priorite::Normale, Statut::Resolu, '2026-10-05 09:15'],
            ['Wi-Fi coupé en salle de réunion', 'Plus aucun accès Wi-Fi dans la salle de réunion, une visioconférence commence à 10 h.', Priorite::Critique, Statut::Nouveau, '2026-10-06 07:58'],
            ['Excel plante à l\'ouverture', 'Excel se ferme dès l\'ouverture du fichier des congés partagé.', Priorite::Basse, Statut::Nouveau, '2026-10-06 11:20'],
        ];
        foreach ($exemples as [$titre, $description, $priorite, $statut, $creeLe]) {
            $ticket = (new Ticket())->setTitre($titre)
                ->setDescription($description)
                ->setPriorite($priorite)->setStatut($statut)
                ->setCreeLe(new \DateTimeImmutable($creeLe));
            if (Statut::Resolu === $statut) {
                $ticket->setResoluLe($ticket->getCreeLe()->modify('+47 minutes'));
            }
            $manager->persist($ticket);
        }
        $manager->flush();
    }
}
