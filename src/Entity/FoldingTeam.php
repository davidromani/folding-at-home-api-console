<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FoldingTeamRepository")
 * @ORM\Table(name="teams")
 */
class FoldingTeam extends AbstractBaseFolding
{
    /**
     * @ORM\Column(type="integer", name="folding_team_id", unique=true)
     */
    protected int $foldingId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $founder;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $logo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FoldingTeamMemberAccount", mappedBy="team", indexBy="member_accounts")
     *
     * @var ArrayCollection
     */
    private $memberAccounts;

    /**
     * Methods.
     */

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->memberAccounts = new ArrayCollection();
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

    /**
     * @return ArrayCollection|array|null
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
    public function setMemberAccounts($memberAccounts): FoldingTeam
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
