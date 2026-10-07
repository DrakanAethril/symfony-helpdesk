<?php

namespace App\Repository;

use App\Entity\Ticket;
use App\Enum\Statut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    /**
     * Les tickets ni résolus ni fermés, les plus urgents d'abord.
     *
     * @return Ticket[]
     */
    public function findOuvertsParPriorite(): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect("CASE t.priorite WHEN 'critique' THEN 1
                WHEN 'haute' THEN 2 WHEN 'normale' THEN 3
                ELSE 4 END AS HIDDEN rang")
            ->andWhere('t.statut NOT IN (:clos)')
            ->setParameter('clos', [Statut::Resolu, Statut::Ferme])
            ->orderBy('rang', 'ASC')
            ->addOrderBy('t.creeLe', 'ASC')
            ->getQuery()->getResult();
    }
}
