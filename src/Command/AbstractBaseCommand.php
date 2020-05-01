<?php

namespace App\Command;

use App\Manager\FoldingTeamsApiManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;

abstract class AbstractBaseCommand extends Command
{
    public const EXIT_COMMAND_SUCCESS = 0;
    public const EXIT_COMMAND_FAILURE = 1;

    protected ?FoldingTeamsApiManager $fcm;
    protected ?EntityManager          $em;

    /**
     * Constructor
     *
     * @param FoldingTeamsApiManager|null $fcm
     * @param EntityManager|null          $em
     */
    public function __construct(FoldingTeamsApiManager $fcm = null, ?EntityManager $em = null)
    {
        parent::__construct();
        $this->fcm = $fcm;
        $this->em = $em;
    }
}
