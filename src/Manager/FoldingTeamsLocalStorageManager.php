<?php

namespace App\Manager;

use App\Entity\FoldingTeam;
use App\Entity\FoldingTeamMemberAccount;
use App\Entity\FoldingTeamMemberAccountRecord;
use App\Entity\FoldingTeamRecord;
use App\Model\FoldingTeam as FoldingTeamModel;
use App\Model\FoldingTeamMemberAccount as FoldingTeamMemberAccountModel;
use App\Repository\FoldingTeamRepository;
use App\Repository\FoldingTeamMemberAccountRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;

class FoldingTeamsLocalStorageManager
{
    private EntityManager $em;
    private FoldingTeamRepository $ftr;
    private FoldingTeamMemberAccountRepository $ftmar;

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
        $this->ftmar = $this->em->getRepository(FoldingTeamMemberAccount::class);
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
            $record = new FoldingTeamRecord();
            $record
                ->setTeam($entity)
                ->setScore($entity->getScore())
                ->setWus($entity->getWus())
                ->setRank($entity->getRank())
                ->setRecorded(new DateTimeImmutable());
            $this->em->persist($record);
            $this->em->flush();
            /** @var FoldingTeamMemberAccountModel $teamMemberAccount */
            foreach ($team->getMemberAccounts() as $teamMemberAccount) {
                $memberAccountEntity = $this->ftmar->searchByFoldingTeamId($teamMemberAccount->getId());
                if (is_null($memberAccountEntity)) {
                    // is new record
                    $memberAccountEntity = new FoldingTeamMemberAccount();
                    $memberAccountEntity->setCreated(new DateTimeImmutable());
                }
                // update values
                $memberAccountEntity
                    ->setTeam($entity)
                    ->setFoldingId($teamMemberAccount->getId())
                    ->setName($teamMemberAccount->getName())
                    ->setScore($teamMemberAccount->getScore())
                    ->setWus($teamMemberAccount->getWus())
                    ->setRank($teamMemberAccount->getRank())
                    ->setUpdated(new DateTimeImmutable());
                $this->em->persist($memberAccountEntity);
                $record = new FoldingTeamMemberAccountRecord();
                $record
                    ->setTeamMemberAccount($memberAccountEntity)
                    ->setScore($memberAccountEntity->getScore())
                    ->setWus($memberAccountEntity->getWus())
                    ->setRank($memberAccountEntity->getRank())
                    ->setRecorded(new DateTimeImmutable());
                $this->em->persist($record);
            }
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
