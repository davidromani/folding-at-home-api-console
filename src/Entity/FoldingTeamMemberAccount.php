<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FoldingTeamMemberAccountRepository")
 * @ORM\Table(name="team_member_accounts")
 */
class FoldingTeamMemberAccount extends AbstractBaseFolding
{
    /**
     * @ORM\Column(type="integer", name="folding_team_member_account_id", unique=true)
     */
    protected int $foldingId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FoldingTeam", inversedBy="memberAccounts")
     * @ORM\JoinColumn(name="team_id")
     */
    private ?FoldingTeam $team;

    /**
     * Methods.
     */
    public function getTeam(): ?FoldingTeam
    {
        return $this->team;
    }

    /**
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
