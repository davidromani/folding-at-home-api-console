<?php

namespace App\Repository;

use App\Entity\FoldingTeamMemberAccount;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class FoldingTeamMemberAccountRepository extends EntityRepository
{
    /**
     * @param int $foldingTeamId
     *
     * @return FoldingTeamMemberAccount|null
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
}
