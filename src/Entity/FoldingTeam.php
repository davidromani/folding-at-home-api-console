<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="teams")
 */
class FoldingTeam extends AbstractBase
{
    /**
     * @ORM\Column(type="integer")
     */
    private int $foldingId;

    private string $name;
    private int $score;
    private int $wus;
    private ?int $rank;


    private ?string $founder;

    private ?string $url;
    private ?string $logo;
    private ?array $memberAccounts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = 0;
        $this->memberAccounts = [];
    }

    /**
     * @return string|null
     */
    public function getFounder(): ?string
    {
        return $this->founder;
    }

    /**
     * @param string|null $founder
     *
     * @return $this
     */
    public function setFounder(?string $founder): FoldingTeam
    {
        $this->founder = $founder;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     *
     * @return $this
     */
    public function setUrl(?string $url): FoldingTeam
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     *
     * @return $this
     */
    public function setLogo(?string $logo): FoldingTeam
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getMemberAccounts(): ?array
    {
        return $this->memberAccounts;
    }

    /**
     * @param array|null $memberAccounts
     *
     * @return $this
     */
    public function setMemberAccounts(?array $memberAccounts): FoldingTeam
    {
        $this->memberAccounts = $memberAccounts;

        return $this;
    }

    /**
     * @param FoldingTeamMemberAccount $memberAccount
     *
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
