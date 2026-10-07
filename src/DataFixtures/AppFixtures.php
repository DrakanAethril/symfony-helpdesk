<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Materiel;
use App\Entity\Ticket;
use App\Entity\Utilisateur;
use App\Enum\Priorite;
use App\Enum\Statut;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {}

    public function load(ObjectManager $manager): void
    {
        // tous les comptes de démonstration ont le mot de passe « helpdesk »
        $utilisateurs = [];
        foreach ([
            ['lea.martin@norbelle.example', 'Léa', 'Martin', []],
            ['karim.benali@norbelle.example', 'Karim', 'Benali', ['ROLE_TECHNICIEN']],
            ['sophie.durand@norbelle.example', 'Sophie', 'Durand', ['ROLE_RESPONSABLE']],
            ['hugo.petit@norbelle.example', 'Hugo', 'Petit', []],
        ] as [$email, $prenom, $nom, $roles]) {
            $utilisateur = (new Utilisateur())
                ->setEmail($email)
                ->setPrenom($prenom)->setNom($nom)
                ->setRoles($roles);
            $utilisateur->setPassword($this->hasher
                ->hashPassword($utilisateur, 'helpdesk'));
            $manager->persist($utilisateur);
            $utilisateurs[$prenom] = $utilisateur;
        }

        $categories = [];
        foreach (['Matériel', 'Logiciel', 'Réseau', 'Comptes et accès'] as $nom) {
            $categories[$nom] = (new Categorie())->setNom($nom);
            $manager->persist($categories[$nom]);
        }

        $materiels = [];
        foreach ([
            ['PC-0042', 'Poste fixe', 'Limoges'],
            ['IMP-0007', 'Imprimante', 'Limoges'],
            ['PC-0108', 'Portable', 'Brive'],
            ['TEL-0015', 'Téléphone', 'Brive'],
        ] as [$numero, $type, $site]) {
            $materiels[$numero] = (new Materiel())->setNumeroInventaire($numero)
                ->setType($type)->setSite($site);
            $manager->persist($materiels[$numero]);
        }

        $exemples = [
            ['Imprimante du 2e étage hors ligne', 'L\'imprimante du 2e étage n\'apparaît plus sur le réseau depuis ce matin.', Priorite::Haute, Statut::EnCours, '2026-10-05 08:42', 'Matériel', ['IMP-0007', 'PC-0042'], 'Léa', 'Karim'],
            ['Mot de passe expiré', 'Impossible d\'ouvrir une session : le mot de passe a expiré pendant les congés.', Priorite::Normale, Statut::Resolu, '2026-10-05 09:15', 'Comptes et accès', [], 'Hugo', 'Karim'],
            ['Wi-Fi coupé en salle de réunion', 'Plus aucun accès Wi-Fi dans la salle de réunion, une visioconférence commence à 10 h.', Priorite::Critique, Statut::Nouveau, '2026-10-06 07:58', 'Réseau', ['PC-0108'], 'Hugo', null],
            ['Excel plante à l\'ouverture', 'Excel se ferme dès l\'ouverture du fichier des congés partagé.', Priorite::Basse, Statut::Nouveau, '2026-10-06 11:20', 'Logiciel', ['PC-0042'], 'Léa', null],
        ];
        foreach ($exemples as [$titre, $description, $priorite, $statut, $creeLe, $categorie, $numeros, $auteur, $technicien]) {
            $ticket = (new Ticket())->setTitre($titre)
                ->setDescription($description)
                ->setPriorite($priorite)->setStatut($statut)
                ->setCreeLe(new \DateTimeImmutable($creeLe))
                ->setCategorie($categories[$categorie])
                ->setAuteur($utilisateurs[$auteur])
                ->setTechnicien($technicien ? $utilisateurs[$technicien] : null);
            if (Statut::Resolu === $statut) {
                $ticket->setResoluLe($ticket->getCreeLe()->modify('+47 minutes'));
            }
            foreach ($numeros as $numero) {
                $ticket->addMateriel($materiels[$numero]);
            }
            $manager->persist($ticket);
        }
        $manager->flush();
    }
}
