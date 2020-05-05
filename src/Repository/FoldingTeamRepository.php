<?php

namespace App\Repository;

use App\Entity\FoldingTeam;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

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
    public function getAllTeamsSortedByName(string $orderBy)
    {
        return $this->getAllTeamsSortedByAttributeAndOrder('name', $orderBy)->getQuery()->getResult();
    }

    /**
     * @return FoldingTeam[]|array|null
     */
    public function getAllTeamsSortedByRank(string $orderBy)
    {
        return $this->getAllTeamsSortedByAttributeAndOrder('rank', $orderBy)->getQuery()->getResult();
    }

    /**
     * @return FoldingTeam[]|array|null
     */
    public function getAllTeamsSortedByWu(string $orderBy)
    {
        return $this->getAllTeamsSortedByAttributeAndOrder('wus', $orderBy)->getQuery()->getResult();
    }

    /**
     * @return FoldingTeam[]|array|null
     */
    public function getAllTeamsSortedByScore(string $orderBy)
    {
        return $this->getAllTeamsSortedByAttributeAndOrder('score', $orderBy)->getQuery()->getResult();
    }

    /**
     * @return QueryBuilder
     */
    private function getAllTeamsSortedByAttributeAndOrder(string $attribute, string $order = 'ASC')
    {
        return $this->createQueryBuilder('t')->orderBy('t.'.$attribute, $order);
    }
}
