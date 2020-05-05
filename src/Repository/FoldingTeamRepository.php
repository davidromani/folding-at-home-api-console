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
    public function getAllTeamsSortedByName()
    {
        return $this->getAllTeamsSortedByAttributeAndOrder('name')->getQuery()->getResult();
    }

    /**
     * @return FoldingTeam[]|array|null
     */
    public function getAllTeamsSortedByRank()
    {
        return $this->getAllTeamsSortedByAttributeAndOrder('rank')->getQuery()->getResult();
    }

    /**
     * @return FoldingTeam[]|array|null
     */
    public function getAllTeamsSortedByWu()
    {
        return $this->getAllTeamsSortedByAttributeAndOrder('wus')->getQuery()->getResult();
    }

    /**
     * @return FoldingTeam[]|array|null
     */
    public function getAllTeamsSortedByScore()
    {
        return $this->getAllTeamsSortedByAttributeAndOrder('score')->getQuery()->getResult();
    }

    /**
     * @return QueryBuilder
     */
    private function getAllTeamsSortedByAttributeAndOrder(string $attribute, string $order = 'ASC')
    {
        return $this->createQueryBuilder('t')->orderBy('t.'.$attribute, $order);
    }
}
