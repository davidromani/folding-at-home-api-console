<?php

namespace App\Model;

class FoldingTeamMemberAccount extends AbstractBaseFolding
{
    private ?FoldingTeam $team;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->team = new FoldingTeam();
        $this->id = 0;
    }

    /**
     * @return FoldingTeam|null
     */
    public function getTeam(): ?FoldingTeam
    {
        return $this->team;
    }

    /**
     * @param FoldingTeam|null $team
     *
     * @return $this
     */
    public function setTeam(?FoldingTeam $team): FoldingTeamMemberAccount
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '>>  ID#'.$this->getId().' · '.$this->getName().' · SCORE:'.$this->getScore().' · WUs:'.$this->getWus().' · RANK: '.$this->getRank();
    }
}
