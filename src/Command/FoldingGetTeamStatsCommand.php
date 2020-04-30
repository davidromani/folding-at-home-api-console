<?php

namespace App\Command;

use App\Entity\FoldingTeam;
use App\Manager\FoldingTeamsApiManager;
use App\Model\AbstractBase;
use App\Model\FoldingTeamMemberAccount;
use App\Repository\FoldingTeamRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingGetTeamStatsCommand extends AbstractBaseCommand
{
    protected static $defaultName = 'folding:get:team:stats';
    private ?FoldingTeamRepository $ftr;
    private int $foldingTeamNumber;

    /**
     * Constructor
     *
     * @param FoldingTeamsApiManager     $fcm
     * @param EntityManager|null         $em
     */
    public function __construct(FoldingTeamsApiManager $fcm, ?EntityManager $em)
    {
        parent::__construct($fcm, $em);
        $this->ftr = $this->em->getRepository(FoldingTeam::class);
        $this->foldingTeamNumber = $fcm->getFoldingTeamNumber();
    }

    /**
     * Configure
     */
    protected function configure()
    {
        $this
            ->setDescription('Get team stats')
            ->setHelp('Show a detailed view of current Folding@Home team stats.')
            ->addArgument('id', InputArgument::OPTIONAL, 'The Folding@Home team number.')
            ->addOption('persist', 'p', InputOption::VALUE_NONE, 'If set, result data will be persisted into a local storage database.')
        ;
    }

    /**
     * Execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new ConsoleCustomStyle($input, $output);
        $io->title('Welcome to Folding@Home '.$this->getName().' command line tool');
        $io->section('Total current Folding@Home teams amount');
        $totalTeamsAmount = AbstractBase::getPrettyFormatValueInString($this->fcm->getCurrentTotalTeams());
        $io->text($totalTeamsAmount);
        $team = $this->fcm->getFoldingTeamById($input->getArgument('id'));
        $io->section('Team report');
        $io->table(
            ['#', 'Name', 'Members', 'Score', 'Work Units', 'Rank'],
            [
                [
                    $team->getId(),
                    $team->getName(),
                    count($team->getMemberAccounts()),
                    $team->getScoreString(),
                    $team->getWusString(),
                    $team->getRank() ? $team->getRankString().' of '.$totalTeamsAmount : 'unknown',
                ],
            ]
        );
        if (count($team->getMemberAccounts()) > 0) {
            $rows = [];
            $io->section('Team member accounts');
            /** @var FoldingTeamMemberAccount $teamMemberAccount */
            foreach ($team->getMemberAccounts() as $teamMemberAccount) {
                $rows[] = [
                    $teamMemberAccount->getId(),
                    $teamMemberAccount->getName(),
                    $teamMemberAccount->getScoreString(),
                    $teamMemberAccount->getWusString(),
                    $teamMemberAccount->getRank() ? $teamMemberAccount->getRankString().' of '.$totalTeamsAmount : 'unknown',
                ];
            }
            $io->table(
                ['#', 'Name', 'Score', 'Work Units', 'Rank'],
                $rows
            );
        }

        if ($input->hasOption('persist')) {
            $entity = $this->ftr->searchByFoldingTeamId($team->getId());
            if (is_null($entity)) {
                $entity = new FoldingTeam();
                $entity->setCreated(new DateTimeImmutable());
            }
            $entity
                ->setFoldingId($team->getId())
                ->setName($team->getName())
                ->setScore($team->getScore())
                ->setWus($team->getWus())
                ->setRank($team->getRank())
                ->setFounder($team->getFounder())
                ->setUrl($team->getUrl())
                ->setLogo($team->getLogo())
                ->setUpdated(new DateTimeImmutable())
            ;
            $this->em->persist($entity);
            $this->em->flush();
        }

        $now = new DateTimeImmutable();
        $io->success('Reported data status at '.$now->format('d/m/Y H:i'));

        return 1;
    }
}
