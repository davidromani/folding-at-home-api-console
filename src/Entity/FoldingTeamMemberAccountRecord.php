<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_member_account_records")
 */
class FoldingTeamMemberAccountRecord extends AbstractBaseFoldingTeamRecord
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FoldingTeamMemberAccount")
     */
    private ?FoldingTeamMemberAccount $teamMemberAccount;

    /**
     * Methods
     */

    /**
     * @return FoldingTeamMemberAccount|null
     */
    public function getTeamMemberAccount(): ?FoldingTeamMemberAccount
    {
        return $this->teamMemberAccount;
    }

    /**
     * @param FoldingTeamMemberAccount|null $teamMemberAccount
     *
     * @return $this
     */
    public function setTeamMemberAccount(?FoldingTeamMemberAccount $teamMemberAccount): FoldingTeamMemberAccountRecord
    {
        $this->teamMemberAccount = $teamMemberAccount;

        return $this;
    }
}
