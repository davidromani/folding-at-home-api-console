<?php

namespace App\Manager;

use App\Entity\FoldingTeam;
use App\Model\FoldingTeam as FoldingTeamModel;
use App\Repository\FoldingTeamRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;

class FoldingTeamsLocalStorageManager
{
    private EntityManager $em;
    private FoldingTeamRepository $ftr;

    /**
     * Methods
     */

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->ftr = $this->em->getRepository(FoldingTeam::class);
    }

    /**
     * @param FoldingTeamModel $team
     *
     * @return bool
     */
    public function persistFoldingTeam(FoldingTeamModel $team)
    {
        try {
            $entity = $this->ftr->searchByFoldingTeamId($team->getId());
            if (is_null($entity)) {
                // is new record
                $entity = new FoldingTeam();
                $entity->setCreated(new DateTimeImmutable());
            }
            // update values
            $entity
                ->setFoldingId($team->getId())
                ->setName($team->getName())
                ->setScore($team->getScore())
                ->setWus($team->getWus())
                ->setRank($team->getRank())
                ->setFounder($team->getFounder())
                ->setUrl($team->getUrl())
                ->setLogo($team->getLogo())
                ->setUpdated(new DateTimeImmutable());
            $this->em->persist($entity);
            $this->em->flush();
            $result = true;
        } catch (NonUniqueResultException $e) {
            $result = false;
        } catch (ORMException $e) {
            $result = false;
        }

        return $result;
    }
}
