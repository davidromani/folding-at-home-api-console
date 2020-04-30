<?php

namespace App\Command;

use App\Manager\FoldingTeamsApiManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;

abstract class AbstractBaseCommand extends Command
{
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
