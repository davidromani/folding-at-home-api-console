<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_records")
 */
class FoldingTeamRecord extends AbstractBaseFoldingTeamRecord
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FoldingTeam")
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
    public function setTeam(?FoldingTeam $team): FoldingTeamRecord
    {
        $this->team = $team;

        return $this;
    }
}
