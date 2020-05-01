<?php

namespace App\Repository;

use App\Entity\FoldingTeam;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class FoldingTeamRepository extends EntityRepository
{
    /**
     * @return FoldingTeam|null
     *
     * @throws NonUniqueResultException
     */
    public function searchByFoldingTeamId(int $foldingTeamId)
    {
        return $this->createQueryBuilder('t')
            ->where('t.foldingId = :id')
            ->setParameter('id', $foldingTeamId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return FoldingTeam[]|array|null
     */
    public function getAllTeamsSortedByName()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
