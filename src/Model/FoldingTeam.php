<?php

namespace App\Model;

class FoldingTeam extends AbstractBaseFolding
{
    private ?string $founder;
    private ?string $url;
    private ?string $logo;
    private ?array $memberAccounts;

    /**
     * Methods.
     */

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id = 0;
        $this->memberAccounts = [];
    }

    public function getFounder(): ?string
    {
        return $this->founder;
    }

    /**
     * @return $this
     */
    public function setFounder(?string $founder): FoldingTeam
    {
        $this->founder = $founder;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return $this
     */
    public function setUrl(?string $url): FoldingTeam
    {
        $this->url = $url;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @return $this
     */
    public function setLogo(?string $logo): FoldingTeam
    {
        $this->logo = $logo;

        return $this;
    }

    public function getMemberAccounts(): ?array
    {
        return $this->memberAccounts;
    }

    /**
     * @return $this
     */
    public function setMemberAccounts(?array $memberAccounts): FoldingTeam
    {
        $this->memberAccounts = $memberAccounts;

        return $this;
    }

    /**
     * @return $this
     */
    public function addMemberAccount(FoldingTeamMemberAccount $memberAccount): FoldingTeam
    {
        $this->memberAccounts[] = $memberAccount;
        $memberAccount->setTeam($this);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'ID#'.$this->getId().' · '.$this->getName().' · SCORE:'.$this->getScore().' · WUs:'.$this->getWus().' · RANK: '.$this->getRank();
    }
}
